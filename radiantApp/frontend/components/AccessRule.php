<?php
 
namespace frontend\components;
 
use common\models\User;
use Yii;

class AccessRule extends \yii\filters\AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role == '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            }elseif (!$user->getIsGuest() && $role == $user->identity->role) {
                
                return true;
            }
            
            /*elseif ($role == User::ROLE_USER) {
                if (!$user->getIsGuest()) {
                    return true;
                }
            // Check if the user is logged in, and the roles match
            } */
        }
 
        return false;
    }
}


