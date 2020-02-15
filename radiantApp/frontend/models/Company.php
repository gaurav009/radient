<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $phone
 * @property string $website
 * @property int $gst_no
 * @property int $state_id
 * @property int $country_id
 * @property int $city_id
 * @property string $address
 * @property int $status
 * @property int $created_on
 * @property int $created_by
 * @property int $updated_on
 * @property int $updated_by
 *
 * @property CompanySocialLink[] $companySocialLinks
 * @property Customer[] $customers
 * @property UserCompany[] $userCompanies
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            [['status','website','upload_logo','color_code','address_1', 'address_2','address_3','pin_code'], 'safe'],
            [['name', 'email', 'phone', 'gst_no', 'state_id', 'country_id', 'city_id', 'address',  'status', 'created_on', 'created_by', 'updated_on', 'updated_by','pin_code'], 'required'],
            [['name', 'email', 'website'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'phone' => 'Phone',
            'website' => 'Website',
            'gst_no' => 'GST No',
            'color_code' => 'Color code',
             'upload_logo' => 'Upload Logo',
            'state_id' => 'State',
            'country_id' => 'Country',
            'city_id' => 'City',
            'address' => 'Address',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'pin_code' => 'Pin Code',
            'status' => 'Status',
            'created_on' => 'Create On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanySocialLinks()
    {
        return $this->hasMany(CompanySocialLink::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['company_id' => 'id']);
    }

    public static function getTitle($id){
        $result = self::find()->where(['id'=>$id])->one();
        
        if(empty($result))
            return '';
        else
            return $result->name;
    }
}
