<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "source".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $description
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['parent_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on', 'description',], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name', 'parent_id'], 'unique', 'targetAttribute' => ['name', 'parent_id'], 'message'=> 'Combination of Name and Parent has already been taken.'],
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
            'parent_id' => 'Parent',
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
            return 'Top Level';
        else{
            return $result->name;
        }  
    }
}
