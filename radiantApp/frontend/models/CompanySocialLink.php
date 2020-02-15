<?php



namespace frontend\models;



use Yii;



/**

 * This is the model class for table "company_social_link".

 *

 * @property int $id

 * @property int $company_id

 * @property string $instagram

 * @property string $facebook

 * @property string $twitter

 * @property string $linkedin

 * @property string $created_on

 * @property int $created_by

 * @property string $updated_on

 * @property int $updated_by

 *

 * @property Company $company

 */

class CompanySocialLink extends \yii\db\ActiveRecord

{

    /**

     * {@inheritdoc}

     */

    public static function tableName()

    {

        return 'company_social_link';

    }



    /**

     * {@inheritdoc}

     */

    public function rules()

    {

        return [

            [['created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],

            [['created_on', 'updated_on','instagram', 'facebook', 'twitter', 'linkedin'], 'safe'],

            [['instagram', 'facebook', 'twitter', 'linkedin'], 'string', 'max' => 255],

            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],

        ];

    }



    /**

     * {@inheritdoc}

     */

    public function attributeLabels()

    {

        return [

            'id' => 'ID',

            'company_id' => 'Company ID',

            'instagram' => 'Instagram',

            'facebook' => 'Facebook',

            'twitter' => 'Twitter',

            'linkedin' => 'Linkedin',

            'created_on' => 'Created On',

            'created_by' => 'Created By',

            'updated_on' => 'Updated On',

            'updated_by' => 'Updated By',

        ];

    }



    /**

     * @return \yii\db\ActiveQuery

     */

    public function getCompany()

    {

        return $this->hasOne(Company::className(), ['id' => 'company_id']);

    }

}

