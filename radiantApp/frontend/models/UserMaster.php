<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $auth_key
 * @property string $role
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $agree_tc
 * @property int $is_reporting_manager
 * @property int $phone_home
 * @property int $phone_emergency
 * @property string $address
 * @property int $status
 * @property int $is_admin
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property string $verification_token
 *
 * @property UserCompany[] $userCompanies
 */
class UserMaster extends \yii\db\ActiveRecord
{
    public $password;
    public $cpassword;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['first_name', 'username', 'auth_key', 'password_hash', 'country_id', 'state_id', 'city_id', 'pin_code', 'is_admin', 'role'], 'required'],
            [['role', 'agree_tc','last_name',  'is_reporting_manager', 'phone_home','address_1','address_2','address_3', 'phone_emergency', 'status', 'is_admin', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['first_name', 'last_name', 'username', 'password_hash', 'password_reset_token', 'email', 'address', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],

            [['username'], 'unique'],
            
            // ['email', 'required'],
            // ['email', 'trim'],
            // [['email'], 'unique'],
            // ['email', 'unique', 'targetClass' => '\frontend\models\UserMaster', 'message' => 'This email address has already been taken.'],

            [['password_reset_token'], 'unique'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['cpassword', 'required'],
            ['cpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'role' => 'Role',
            'username' => 'Employee Code',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'agree_tc' => 'I Agree the terms and conditions.',
            'is_reporting_manager' => 'Authorized to be a Reporting Manager',
            'phone_home' => 'Phone Home',
            'phone_emergency' => 'Phone Emergency',
            'address' => 'Address',
            'pin_code'=> 'Pin Code',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'status' => 'Status',
            'is_admin' => 'Is Admin',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'verification_token' => 'Verification Token',
            'password'=> 'Password',
            'cpassword' => 'Confirm Password'
        ];
    }

    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['user_id' => 'id']);
    }

    public static function getUserOwnCompanies() {
        $compArray = [];

        $company = UserCompany::find()->where(['user_id'=>Yii::$app->user->id])->all();
        if ( !empty($company) ) {
            foreach ( $company as $c ){
                
                $compDetail = Company::find()->where(['id'=>$c->company_id])->one();
                if (!empty($compDetail)) {
                    $compArray[$compDetail->id] = $compDetail->name;
                }
                
            }
        }
        
        return $compArray;
    }
}
