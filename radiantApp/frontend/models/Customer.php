<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property int $company
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int $pin_code
 * @property string $gst
 * @property string $aadhar_no
 * @property string $pan_no
 * @property string $email
 * @property int $phone
 * @property int $mobile
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property Company $company
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // ['email', 'email'],
            [[ 'company','gst',  'status', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['name','customer_code','country_id', 'state_id', 'city_id','mobile', 'email', 'phone', 'pin_code', 'gst', 'aadhar_no', 'pan_no','address' , 'address_1','address_2','address_3', 'tan_no','created_on', 'updated_on'], 'safe'],
            [['name', 'gst', 'email'], 'string', 'max' => 255],
            [['aadhar_no'], 'string', 'max' => 200],
            [['pan_no'], 'string', 'max' => 200],
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
            'customer_code' => 'Customer Code',
            'company' => 'Company',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'gst' => 'GST No',
            'tan_no' =>'TAN No',
            'address' => 'Address',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'aadhar_no' => 'Aadhar No',
            'pan_no' => 'Pan No',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'pin_code' => 'Pin Code',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    
}
