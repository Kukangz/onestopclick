<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_downloads".
 *
 * @property int $id
 * @property int $user
 * @property string $access_token
 * @property int $product
 * @property int $counter
 */
class UserDownloads extends \yii\db\ActiveRecord
{
    public $product_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_downloads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'access_token', 'product', 'counter'], 'required'],
            [['user', 'product', 'counter'], 'integer'],
            [['access_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'access_token' => 'Access Token',
            'product' => 'Product',
            'counter' => 'Counter',
        ];
    }
}
