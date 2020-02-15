<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\BrandMaster as BrandMasterModel;

/**
 * BrandMaster represents the model behind the search form of `frontend\models\BrandMaster`.
 */
class BrandMaster extends BrandMasterModel
{
    
    public $searchtext;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['searchtext'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
  /*  public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'created_on', 'updated_on'], 'safe'],
        ];
    } */

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BrandMasterModel::find()->orderBy(['name'=>SORT_ASC]);
       
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 50,
        ],
           
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       // $query->andFilterWhere([
       //     'id' => $this->id,
      //      'category_id' => $this->category_id,
     //       'status' => $this->status,
     //       'created_on' => $this->created_on,
    //        'created_by' => $this->created_by,
     //       'updated_on' => $this->updated_on,
    //        'updated_by' => $this->updated_by,
   //     ]);

        $query->orFilterWhere(['like', 'brand_code', $this->searchtext])
            ->orFilterWhere(['like', 'name', $this->searchtext])
            ->orFilterWhere(['like', 'description', $this->searchtext]);

        return $dataProvider;
    }
}
