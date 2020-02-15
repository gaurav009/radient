<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "master_city".
 *
 * @property int $row_id
 * @property int $country_id
 * @property int $region_id
 * @property string $name
 * @property double $geo_lat
 * @property double $geo_long
 * @property string $status
 */
class CityMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id', 'name', 'geo_lat', 'geo_long'], 'required'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'row_id' => 'Row ID',
            'country_id' => 'Country ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
            'geo_lat' => 'Geo Lat',
            'geo_long' => 'Geo Long',
            'status' => 'Status',
        ];
    }
    
    public static function getTitle($id){

        $result = self::find()->where(['row_id'=>$id])->one();
        if(empty($result))
            return '';
        else
            return $result->name;

    }
}
