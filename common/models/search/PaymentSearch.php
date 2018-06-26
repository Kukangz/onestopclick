<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payment;

/**
 * PaymentSearch represents the model behind the search form of `common\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'voucher', 'payment_type', 'tax'], 'integer'],
            [['invoice', 'create_at', 'user_detail', 'voucher_detail', 'payment_code', 'payer_id', 'token'], 'safe'],
            [['tax_amount', 'total_discount'], 'number'],
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
        $query = Payment::find();

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
            'create_at' => $this->create_at,
            'user' => $this->user,
            'voucher' => $this->voucher,
            'payment_type' => $this->payment_type,
            'tax' => $this->tax,
            'tax_amount' => $this->tax_amount,
            'total_discount' => $this->total_discount,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'user_detail', $this->user_detail])
            ->andFilterWhere(['like', 'voucher_detail', $this->voucher_detail])
            ->andFilterWhere(['like', 'payment_code', $this->payment_code])
            ->andFilterWhere(['like', 'payer_id', $this->payer_id])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
