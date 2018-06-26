<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
 * PaymentSearch represents the model behind the search form of `common\models\Payment`.
 */
class CategorySearch extends Category
{

    /**
     * [rules description]
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','name', 'slug', 'description','status'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
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
        $query = Category::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->where(['status' => Category::STATUS_ACTIVE]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->where(['status' => Category::STATUS_ACTIVE]);

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'created_at' => $this->created_at,
        //     'name' => $this->name,
        //     'slug' => $this->slug,
        //     'created_by' => $this->created_by,
        //     'status' => $this->status,
        // ]);

        $query->andFilterWhere(['like', 'id', $this->id])
        // ->andFilterWhere(['like', 'created_at', $this->created_at])
        ->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'slug', $this->slug])
        // ->andFilterWhere(['like', 'created_by', $this->created_by])
        ->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }
}
