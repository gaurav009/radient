<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "master_country".
 *
 * @property int $cid
 * @property int $parent_id
 * @property string $code
 * @property string $dialing_code
 * @property string $name
 * @property int $sorting_order
 * @property string $is_active
 */
class CountryMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'dialing_code', 'name', 'sorting_order'], 'required'],
            [['is_active'], 'string'],
            [['code'], 'string', 'max' => 2],
            [['dialing_code'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 100],
            [['parent_id', 'name'], 'unique', 'targetAttribute' => ['parent_id', 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'parent_id' => 'Parent ID',
            'code' => 'Code',
            'dialing_code' => 'Dialing Code',
            'name' => 'Name',
            'sorting_order' => 'Sorting Order',
            'is_active' => 'Is Active',
        ];
    }

    public static function getLocation($countryId, $regionId, $cityId)
    {   
        $city = false; $country = false; $state = false;
        $country = CountryMaster::find()->where(['cid'=>$countryId, 'parent_id'=>'0'])->one();
        $state = CountryMaster::find()->where(['cid'=>$regionId, 'parent_id'=>$countryId])->one();
        if(intval($cityId)){
            $cityId = CityMaster::find()->where(['row_id'=>$cityId, 'country_id'=>$countryId, 'region_id'=>$regionId])->one();
            $city = !empty($cityId) ? $cityId->name : '';
        }else{
            $city = $cityId;
        }
       // $d = array();
        
           $d = (!$city ? '' : $city.', ')
                    .(!$state ? '' :$state->name).', '
                    .(!$country ? '' : $country->name);
           
           return trim(trim($d),',');
    }
    
    public static function getTitle($id){

        $result = self::find()->where(['cid'=>$id])->one();
        if(empty($result))
            return '';
        else
            return $result->name;

    }
}
