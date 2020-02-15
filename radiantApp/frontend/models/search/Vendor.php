<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Vendor as VendorModel;

/**
 * Vendor represents the model behind the search form of `frontend\models\Vendor`.
 */
class Vendor extends VendorModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'category_id', 'country_id', 'state_id', 'city_id', 'aadhar_no', 'mobile', 'phone', 'ac_number', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'address', 'postal_code', 'gst', 'pan_no', 'email', 'ac_beneficiary_name', 'ac_bank_name', 'ac_type', 'ac_ifsc', 'ac_address', 'created_on', 'updated_on'], 'safe'],
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
        $query = VendorModel::find();

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
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'aadhar_no' => $this->aadhar_no,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'ac_number' => $this->ac_number,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'gst', $this->gst])
            ->andFilterWhere(['like', 'pan_no', $this->pan_no])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ac_beneficiary_name', $this->ac_beneficiary_name])
            ->andFilterWhere(['like', 'ac_bank_name', $this->ac_bank_name])
            ->andFilterWhere(['like', 'ac_type', $this->ac_type])
            ->andFilterWhere(['like', 'ac_ifsc', $this->ac_ifsc])
            ->andFilterWhere(['like', 'ac_address', $this->ac_address]);

        return $dataProvider;
    }
}
