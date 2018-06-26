<?php

namespace common\models;

use Yii;
use \himiklab\yii2\recaptcha\ReCaptcha;

/**
 * This is the model class for table "product_review".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $rating
 * @property string $review
 * @property string $create_at
 * @property int $status
 */
class ProductReview extends \yii\db\ActiveRecord
{
    public $reCaptcha;
    public $product_name;

    public $name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating', 'review'], 'required'],
            [['rating', 'status'], 'integer'],
            [['review'], 'string'],
            [['create_at','status','reCaptcha'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'rating' => 'Rating',
            'review' => 'Review',
            'create_at' => 'Create At',
            'status' => 'Status',
        ];
    }
}
