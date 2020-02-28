<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserCompany as UserCompanyModel;

/**
 * UserCompany represents the model behind the search form of `frontend\models\UserCompany`.
 */
class UserCompany extends UserCompanyModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company_id', 'hired_by', 'phone', 'department_id',  'reporting_level1', 'reporting_level2', 'reporting_level3', 'vender_id', 'brand_id', 'category_id', 'created_by', 'updated_by'], 'integer'],
            [['joining_date', 'cv', 'email', 'whatsapp', 'linkedin', 'twitter', 'created_on', 'updated_on'], 'safe'],
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
    public function search($params, $userId)
    {
        $query = UserCompanyModel::find()->where(['user_id'=> $userId]);

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
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'joining_date' => $this->joining_date,
            'hired_by' => $this->hired_by,
            'phone' => $this->phone,
            'department_id' => $this->department_id,
            'reporting_level1' => $this->reporting_level1,
            'reporting_level2' => $this->reporting_level2,
            'reporting_level3' => $this->reporting_level3,
            'vender_id' => $this->vender_id,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'cv', $this->cv])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'whatsapp', $this->whatsapp])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'twitter', $this->twitter]);

        return $dataProvider;
    }
}
