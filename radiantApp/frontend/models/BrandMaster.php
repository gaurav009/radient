<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "brand_master".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property CategoryMaster $category
 * @property UserCompany[] $userCompanies
 */
class BrandMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name',  'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on','category_id','brand_code', 'updated_on','description'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['category_id', 'name'], 'unique', 'targetAttribute' => ['category_id', 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_code'=>'Brand Code',
            'category_id' => 'Category Name',
            'name' => 'Brand Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryMaster::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['brand_id' => 'id']);
    }

    public static function getTitle($id){
        $result = self::find()->where(['id'=>$id])->one();
        
        if(empty($result))
            return '';
        else
            return $result->name;
    }
}
