<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category_master".
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
class CategoryMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on','description'], 'safe'],
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
            'name' => 'Category Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getTitle($id){
        $category = CategoryMaster::findOne(['id'=>$id]);
        if(!empty($category)){
            return $category->name;
        }else{
            return '';
        }
    }
}
