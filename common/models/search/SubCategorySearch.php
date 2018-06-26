<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Subcategory;

/**
 * SubCategorySearch represents the model behind the search form of `common\models\Subcategory`.
 */
class SubCategorySearch extends Subcategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug','parent', 'created_at', 'updated_at'], 'safe'],
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
        $query = Subcategory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->join('LEFT JOIN','category b', 'sub_category.parent = b.id'),
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['>','sub_category.status', \common\models\Category::STATUS_DELETED]);        

        // grid filtering conditions
        $query->andFilterWhere([
            'sub_category.id' => $this->id,
            'b.name' => $this->parent,
            'sub_category.status' => $this->status,
            'sub_category.created_at' => $this->created_at,
            'sub_category.created_by' => $this->created_by,
            'sub_category.updated_at' => $this->updated_at,
            'sub_category.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'sub_category.name', $this->name])
        ->andFilterWhere(['like', 'sub_category.slug', $this->slug])
        ->andFilterWhere(['like', 'b.name', $this->parent]);

        return $dataProvider;
    }
}
