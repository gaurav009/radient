<?php

namespace frontend\models;

use Yii;
/**
 * This is the model class for table "lead".
 *
 * @property int $id
 * @property string $lead_source
 * @property string $customer_name
 * @property string $customer_company
 * @property string $email
 * @property int $mobile
 * @property string $requirement
 * @property string $priority
 * @property int $buy_potential
 * @property string $buy_potential_detail
 * @property int $category_id
 * @property int $brand_id
 * @property int $company_id
 * @property int $role_id
 * @property int $department_id
 * @property int $user_id
 * @property string $call_date
 * @property string $followup_date
 * @property string $comment
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property BrandMaster $brand
 * @property CategoryMaster $category
 * @property Company $company
 * @property RoleMaster $role
 * @property UserMaster $user
 */
class Lead extends \yii\db\ActiveRecord
{
    const Lead_Active = 1;
    const Lead_Closed = 2;
    const Lead_Scrapped = 3;
    const Lead_Rejected = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            [['lead_source', 'customer_name', 'customer_company', 'email', 'mobile', 'buy_potential', 'requirement', 'priority', 'category_id', 'brand_id', 'call_date', 'followup_date', 'comment', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [[ 'buy_potential', 'category_id', 'brand_id', 'company_id', 'role_id', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['requirement', 'comment'], 'string'],
            [['company_id', 'buy_potential_detail','role_id', 'department_id', 'user_id', 'call_date', 'followup_date', 'created_on', 'updated_on'], 'safe'],
            [['lead_source'], 'string', 'max' => 25],
            [['customer_name', 'customer_company', 'email'], 'string', 'max' => 255],
            [['priority'], 'string', 'max' => 20],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => BrandMaster::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleMaster::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'lead_source' => 'Lead Source',
            'customer_name' => 'Customer Name',
            'customer_company' => 'Customer Company',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'requirement' => 'Requirement',
            'priority' => 'Priority',
            'buy_potential' => 'Buy Potential',
            'category_id' => 'Category',
            'brand_id' => 'Brand',
            'company_id' => 'Select Own Company',
            'role_id' => 'Role',
            'department_id' => 'Department',
            'user_id' => 'User',
            'call_date' => 'Call Date',
            'followup_date' => 'Followup Date',
            'comment' => 'Comment',
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
    public function getRole()
    {
        return $this->hasOne(RoleMaster::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserMaster::className(), ['id' => 'user_id']);
    }
}
