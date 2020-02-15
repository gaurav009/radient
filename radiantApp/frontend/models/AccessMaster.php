<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "access_master".
 *
 * @property int $role_id
 * @property string $access_key
 * @property string $created
 */
class AccessMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'access_key', 'created'], 'required'],
            [['role_id'], 'integer'],
            [['created'], 'safe'],
            [['access_key'], 'string', 'max' => 255],
            [['role_id', 'access_key'], 'unique', 'targetAttribute' => ['role_id', 'access_key']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'access_key' => 'Access Key',
            'created' => 'Created',
        ];
    }

    public static function hasAccess($accessKey){
        $returnResponse = false;
        $role = Yii::$app->user->identity->role;
        if ( $role == 1 ) {
            $returnResponse = true;
        } else if ( $role ){
            $model = AccessMaster::find()->where(['role_id'=> $role, 'access_key'=> $accessKey])->one();
            if ( !empty($model) ) {
                $returnResponse = true;
            }
        } 
        return $returnResponse;
    }
}
