<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_detail".
 *
 * @property int $id
 * @property int $payment
 * @property int $product
 * @property string $price_sell
 * @property string $price_discount
 * @property string $price_net
 *
 * @property Payment $payment0
 * @property Product $product0
 */
class PaymentDetail extends \yii\db\ActiveRecord
{

    public $create_at;
    public $counter;
    public $product_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment', 'product', 'price_sell', 'price_discount', 'price_net'], 'required'],
            [['id', 'payment', 'product'], 'integer'],
            [['price_sell', 'price_discount', 'price_net'], 'number'],
            [['payment'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['payment' => 'id']],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment' => 'Payment',
            'product' => 'Product',
            'price_sell' => 'Price Sell',
            'price_discount' => 'Price Discount',
            'price_net' => 'Price Net',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment0()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product']);
    }
}
