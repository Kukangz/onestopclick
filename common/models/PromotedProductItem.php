<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promoted_product_item".
 *
 * @property string $id
 * @property int $product
 * @property string $price
 * @property int $qty
 */
class PromotedProductItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promoted_product_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'price', 'qty'], 'required'],
            [['product', 'qty'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product' => 'Product',
            'price' => 'Price',
            'qty' => 'Qty',
        ];
    }
}
