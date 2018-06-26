<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status',  'product_view', 'product_download', 'flag_headline'], 'integer'],
            [['PID', 'slug', 'name', 'synopsis', 'description', 'picture', 'picture_thumbnail', 'picture_portrait', 'embed_video', 'embed_music_player', 'picture_headline', 'official_site', 'meta_description', 'meta_keywords', 'created_at', 'updated_at', 'product_download_link','created_by', 'updated_by','category','brand'], 'safe'],
            [['price', 'price_discount'], 'number'],
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
    public function search($params, $options = false)
    {
        $query = Product::find();

        // add conditions that should always apply here
        $query->join('left join', 'category a', 'a.id=product.category')->join('left join', 'brand b', 'b.id=product.brand');

        if($options){
            $query->where(['created_by' => Yii::$app->user->identity->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
            'price' => $this->price,
            'price_discount' => $this->price_discount,
            'b.name' => $this->brand,
            'product.status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'product_view' => $this->product_view,
            'product_download' => $this->product_download,
            'flag_headline' => $this->flag_headline,
        ]);

        $query->andFilterWhere(['like', 'PID', $this->PID])
        ->andFilterWhere(['like', 'slug', $this->slug])
        ->andFilterWhere(['like', 'a.name', $this->category])
        ->andFilterWhere(['like', 'b.name', $this->brand])
        ->andFilterWhere(['like', 'product.name', $this->name])
        ->andFilterWhere(['like', 'synopsis', $this->synopsis])
        ->andFilterWhere(['like', 'description', $this->description])
        ->andFilterWhere(['like', 'picture', $this->picture])
        ->andFilterWhere(['like', 'picture_thumbnail', $this->picture_thumbnail])
        ->andFilterWhere(['like', 'picture_portrait', $this->picture_portrait])
        ->andFilterWhere(['like', 'embed_video', $this->embed_video])
        ->andFilterWhere(['like', 'embed_music_player', $this->embed_music_player])
        ->andFilterWhere(['like', 'picture_headline', $this->picture_headline])
        ->andFilterWhere(['like', 'official_site', $this->official_site])
        ->andFilterWhere(['like', 'meta_description', $this->meta_description])
        ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
        ->andFilterWhere(['like', 'product_download_link', $this->product_download_link]);

        $query->orderBy('product.id DESC');

        return $dataProvider;
    }
}
