<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "lead_followup".
 *
 * @property int $id
 * @property int $lead_id
 * @property string $date
 * @property string $comment
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 * @property int $status
 */
class LeadFollowup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_followup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'date', 'comment', 'created_on', 'created_by', 'updated_on', 'updated_by', 'status'], 'required'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['date', 'created_on', 'updated_on'], 'safe'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'date' => 'Date',
            'comment' => 'Comment',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
