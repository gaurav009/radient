<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_company".
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $joining_date
 * @property int $hired_by
 * @property string $cv
 * @property int $phone
 * @property string $email
 * @property int $whatsapp
 * @property string $linkedin
 * @property string $twitter
 * @property int $department_id
 * @property int $reporting_level1
 * @property int $reporting_level2
 * @property int $reporting_level3
 * @property int $vender_id
 * @property int $brand_id
 * @property int $category_id
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property BrandMaster $brand
 * @property CategoryMaster $category
 * @property Company $company
 * @property DepartmentMaster $department
 * @property Vendor $vender
 * @property UserMaster $user
 */
class UserCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email'],
            


            [['company_id', 'joining_date', 'hired_by', 'phone', 'email', 'whatsapp', 'department_id',  'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['company_id', 'hired_by', 'department_id',  'reporting_level1', 'reporting_level2', 'reporting_level3', 'vender_id', 'brand_id', 'category_id', 'created_by', 'updated_by'], 'integer'],
            [['user_id', 'joining_date', 'created_on', 'updated_on', 'linkedin', 'twitter', 'vender_id', 'brand_id', 'category_id'], 'safe'],
            [['cv'], 'string', 'max' => 100],
            [['email', 'linkedin', 'twitter'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => BrandMaster::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartmentMaster::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['vender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vender_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'company_id' => 'Company',
            'joining_date' => 'Joining Date',
            'hired_by' => 'Hired By',
            'cv' => 'Cv',
            'phone' => 'Phone',
            'email' => 'Email',
            'whatsapp' => 'Whatsapp',
            'linkedin' => 'Linkedin',
            'twitter' => 'Twitter',
            'department_id' => 'Department',
            'reporting_level1' => 'Reporting Boss',
            'reporting_level2' => 'Second level escalation POC',
            'reporting_level3' => 'Ultimate Escalation POC',
            'vender_id' => 'Vendor',
            'brand_id' => 'Brand',
            'category_id' => 'Category',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(BrandMaster::className(), ['id' => 'brand_id']);
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(DepartmentMaster::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVender()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserMaster::className(), ['id' => 'user_id']);
    }
}
