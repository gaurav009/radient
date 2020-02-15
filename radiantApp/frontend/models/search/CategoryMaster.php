<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CategoryMaster as CategoryMasterModel;

/**
 * CategoryMaster represents the model behind the search form of `frontend\models\CategoryMaster`.
 */
class CategoryMaster extends CategoryMasterModel
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
        $query = CategoryMasterModel::find()->orderBy(['name'=>SORT_ASC]);

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
     //   $query->andFilterWhere([
     //       'id' => $this->id,
     //       'status' => $this->status,
     //       'created_on' => $this->created_on,
     //       'created_by' => $this->created_by,
     //       'updated_on' => $this->updated_on,
     //       'updated_by' => $this->updated_by,
     //   ]);

       $query->orFilterWhere(['like', 'name', $this->searchtext])
            ->orFilterWhere(['like', 'description', $this->searchtext]);

       

        return $dataProvider;
    }
}
