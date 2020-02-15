<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\mailer\smtpMailer;
use yii\helpers\Html;

class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return $this->_sendmail($user->username, $user->email, $user->password_reset_token);
    }
    
    private function _sendmail($username, $email, $resetLink)
    {
        $host='mail.cacsforms.com';
        $user='admin@cacsforms.com'; 
        $password='admin@321';
        $secrity='ssl';
        $port='465';
        
        $ml = new smtpMailer();
        $ml->setDefaultValue(
            $host,
            $user,
            $password,
            $secrity,
            $port
        );
        $ml->Subject = 'Forgot Password Request';

        $ml->SetFrom('info@cacsforms.com');

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $resetLink]);
        $link = Html::a(Html::encode($resetLink), $resetLink);
        $html = '<div class="password-reset">'.
                '<p>Hello '.Html::encode($username).',</p>'.
            
                '<p>Follow the link below to reset your password:</p>'.
            
                '<p>'. $link.'</p>'.
            '</div>';
        $ml->MsgHTML($html); //$error
        
        $ml->AddAddress($email);
        $ml->AddCC('rahulpapnoi08@gmail.com');
        $ml->AddCC('gaurav.kumar9718@gmail.com');
        $processFlag = $ml->Send();
        $ml->ClearAddresses();
        $ml->ClearAttachments();
        
        return true;
    }
}
