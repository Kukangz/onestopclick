<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductReview;

/**
 * ReviewSearch represents the model behind the search form of `common\models\ProductReview`.
 */
class ReviewSearch extends ProductReview
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rating', 'status'], 'integer'],
            [['review', 'create_at', 'user', 'product'], 'safe'],
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
        $query = ProductReview::find()
        ->select(['product_review.*','user.name','product_name' => 'product.name'])
        ->leftJoin('user','product_review.user = user.id')
        ->leftJoin('product','product_review.product = product.id')->orderBy([new \yii\db\Expression('FIELD(product_review.status,0,1,-9)')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product.name' => $this->product,
            'rating' => $this->rating,
            'create_at' => $this->create_at,
            'review' => $this->review,
            'product_review.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->user]);

        return $dataProvider;
    }
}
