<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 *  * @property int $brand_id
 * @property string $name
 * @property string $company
 * @property string vendor_code
 * @property int $category_id
 * @property string $address
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $postal_code
 * @property string $gst
 * @property int $aadhar_no
 * @property string $pan_no
 * @property string $email
 * @property int $mobile
 * @property int $phone
 * @property string $ac_beneficiary_name
 * @property string $ac_bank_name
 * @property int $ac_number
 * @property string $ac_type
 * @property string $ac_ifsc
 * @property string $ac_address
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property UserCompany[] $userCompanies
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gst','pan_no', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['name','vendor_code', 'company',  'country_id', 'state_id', 'city_id', 'email', 'mobile','phone', 'postal_code', 'gst', 'aadhar_no', 'pan_no', 'brand_id', 'category_id', 'address','address_1' ,'address_2' ,'address_3', 'tan_no', 'ac_beneficiary_name', 'ac_bank_name', 'ac_number', 'ac_type', 'ac_ifsc', 'ac_address', 'created_on', 'updated_on'], 'safe'],
            [['name', 'address', 'gst', 'email', 'ac_beneficiary_name', 'ac_bank_name', 'ac_type', 'ac_ifsc', 'ac_address','address_1' ,'address_1'], 'string', 'max' => 255],
            [['postal_code', 'pan_no'], 'string', 'max' => 90],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_code' => 'Vendor Code',
             'company' => 'Company',
            'name' => 'Vendor Name',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'brand_id' => 'Brand',
            'category_id' => 'Category',
            'address' => 'Address',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            
            'postal_code' => 'Pin Code',
            'gst' => 'GST',
            'aadhar_no' => 'Aadhar Number',
            'pan_no' => 'PAN',
            'tan_no' => 'TAN No',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'phone' => 'Phone',
            'ac_beneficiary_name' => 'Beneficiary Name',
            'ac_bank_name' => 'Bank Name',
            'ac_number' => 'A/c Number',
            'ac_type' => 'A/c Type',
            'ac_ifsc' => 'A/c Ifsc',
            'ac_address' => 'Bank Address',
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
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['vender_id' => 'id']);
    }

    public static function getTitle($id){
        $category = Vendor::findOne(['id'=>$id]);
        if(!empty($category)){
            return $category->name;
        }else{
            return '';
        }
    }
    
    public static function getTitles($ids){
        $categoryName = [];
        if( trim($ids) ){
            $ids = explode(',', $ids);
            
            foreach( $ids as $id){
                $category = Vendor::findOne(['id'=>$id]);
                if(!empty($category)){
                    $categoryName[] = $category->name;
                }
            }
        }
        return implode(',', $categoryName);
    }
    
}
