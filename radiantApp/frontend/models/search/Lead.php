<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Lead as LeadModel;

/**
 * Lead represents the model behind the search form of `frontend\models\Lead`.
 */
class Lead extends LeadModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_id', 'mobile', 'buy_potential', 'category_id', 'brand_id', 'company_id', 'role_id', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['lead_source', 'customer_name', 'customer_company', 'email', 'requirement', 'priority', 'call_date', 'followup_date', 'comment', 'created_on', 'updated_on'], 'safe'],
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
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchActive($params)
    {
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchClosed($params)
    {
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchAllocated($params)
    {
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchScrapped($params)
    {
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchRejected($params)
    {
        $query = LeadModel::find();

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
            'lead_id' => $this->lead_id,
            'mobile' => $this->mobile,
            'buy_potential' => $this->buy_potential,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'company_id' => $this->company_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'call_date' => $this->call_date,
            'followup_date' => $this->followup_date,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
    
}
