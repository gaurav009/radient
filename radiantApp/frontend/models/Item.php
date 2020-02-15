<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int $category_id
 * @property int $brand_id
 * @property string $hsn
 * @property string $uom
 * @property string $mrp
 * @property string $height
 * @property string $weight
 * @property string $dimension
 * @property string $unit
 * @property string $gst
 * @property string $location
 * @property int $vender_id
 * @property string $file
 * @property string $link
 * @property int $status
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','category_id', 'brand_id', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on', 'vender_id', 'file','hsn', 'uom', 'status', 'mrp', 'height', 'width', 'weight', 'dimension', 'unit', 'gst' ,'gst_rate', 'part_no', 'location', 'link'], 'safe'],
            [['hsn', 'uom', 'mrp', 'height', 'weight', 'dimension', 'unit', 'gst', 'location', 'file', 'link'], 'string', 'max' => 255],
            ['item_code', 'unique', 'targetClass' => '\frontend\models\Item', 'message' => 'This item code has already been taken.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name'=>'Name',
            'category_id' => 'Category',
            'brand_id' => 'Brand',
            'hsn' => 'HSN',
            'uom' => 'UOM',
            'mrp' => 'MRP',
            'height' => 'Height',
            'width' => 'Width',
            'weight' => 'Weight',
            'dimension' => 'Enter Qty',
            'unit' => 'Unit',
            'gst' => 'GST Rate',
            'gst_rate' => 'GST Rate',
            'part_no' => 'Part No',
            'location' => 'Location',
            'vender_id' => 'Vender',
            'file' => 'File',
            'link' => 'Link',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
