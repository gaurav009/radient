<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CityMaster as CityMasterModel;

/**
 * CityMaster represents the model behind the search form of `frontend\models\CityMaster`.
 */
class CityMaster extends CityMasterModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['row_id', 'country_id', 'region_id'], 'integer'],
            [['name', 'status'], 'safe'],
            [['geo_lat', 'geo_long'], 'number'],
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
        $query = CityMasterModel::find();

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
            'row_id' => $this->row_id,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'geo_lat' => $this->geo_lat,
            'geo_long' => $this->geo_long,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
