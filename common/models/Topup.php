<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topup".
 *
 * @property int $id
 * @property int $user
 * @property string $amount
 * @property string $transaction_code
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Topup extends \yii\db\ActiveRecord
{

    public $name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'amount', 'transaction_code'], 'required'],
            [['user', 'status'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at','status'], 'safe'],
            [['transaction_code'], 'string', 'max' => 256],
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
            'amount' => 'Amount',
            'transaction_code' => 'Transaction Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
