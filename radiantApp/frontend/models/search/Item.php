<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Item as ItemModel;

/**
 * Item represents the model behind the search form of `frontend\models\Item`.
 */
class Item extends ItemModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'brand_id', 'vender_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['hsn', 'uom', 'mrp', 'height', 'weight', 'dimension', 'unit', 'gst', 'location', 'file', 'link', 'created_on', 'updated_on'], 'safe'],
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
        $query = ItemModel::find()->orderBy(['name'=>SORT_ASC]);

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
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'vender_id' => $this->vender_id,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'hsn', $this->hsn])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'uom', $this->uom])
            ->andFilterWhere(['like', 'mrp', $this->mrp])
            ->andFilterWhere(['like', 'height', $this->height])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'dimension', $this->dimension])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'gst', $this->gst])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
