<?php

namespace frontend\models\search;

use frontend\models\CityMaster;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CountryMaster as CountryMasterModel;

/**
 * CountryMaster represents the model behind the search form of `frontend\models\CountryMaster`.
 */
class CountryMaster extends CountryMasterModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'parent_id', 'sorting_order'], 'integer'],
            [['code', 'dialing_code', 'name', 'is_active'], 'safe'],
        ];
    }

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
        $query = CountryMasterModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'parent_id' => 0
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
    public function searchState($id)
    {
        $query = CountryMasterModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'parent_id' => $id
        ]);

        return $dataProvider;
    }
    
    public function searchCity($id)
    {
        $query = CityMaster::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'region_id' => $id
        ]);

        return $dataProvider;
    }
}
