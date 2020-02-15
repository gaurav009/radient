<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Customer as CustomerModel;

/**
 * Customer represents the model behind the search form of `frontend\models\Customer`.
 */
class Customer extends CustomerModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company', 'country_id', 'state_id', 'city_id', 'phone', 'mobile', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'pin_code', 'gst', 'aadhar_no', 'pan_no', 'email', 'created_on', 'updated_on'], 'safe'],
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
        $query = CustomerModel::find();

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
            'id' => $this->id,
            'company' => $this->company,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pin_code', $this->pin_code])
            ->andFilterWhere(['like', 'gst', $this->gst])
            ->andFilterWhere(['like', 'aadhar_no', $this->aadhar_no])
            ->andFilterWhere(['like', 'pan_no', $this->pan_no])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
