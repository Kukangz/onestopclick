<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Brand;

/**
 * BrandSearch represents the model behind the search form of `common\models\Brand`.
 */
class BrandSearch extends Brand
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description','category', 'slug', 'created_at', 'updated_at'], 'safe'],
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
        $query = Brand::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
            ->join('left join', 'category b','b.id=brand.category')
            ->select('brand.*, b.name category_name'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'brand.id' => $this->id,
            'brand.status' => $this->status,
            'brand.created_at' => $this->created_at,
            'brand.created_by' => $this->created_by,
            'brand.updated_at' => $this->updated_at,
            'brand.updated_by' => $this->updated_by,
        ]);


        $query->andFilterWhere(['like', 'brand.name', $this->name])
        // ->andFilterWhere(['like', 'description', $this->description])
        ->andFilterWhere(['like', 'brand.slug', $this->slug])
        ->andFilterWhere(['like', 'b.name', $this->category]);

        return $dataProvider;
    }
}
