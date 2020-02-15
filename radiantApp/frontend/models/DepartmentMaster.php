<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "department_master".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 */
class DepartmentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['description','created_on', 'updated_on'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getTitle($id){
        $result = self::find()->where(['id'=>$id])->one();
        
        if(empty($result))
            return '';
        else
            return $result->name;
    }
}
