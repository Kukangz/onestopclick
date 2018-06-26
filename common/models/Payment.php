<?php

namespace common\models;

use Yii;
use common\models\Voucher;


/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $create_at
 * @property int $user
 * @property string $user_detail
 * @property string $voucher_detail
 * @property int $voucher
 * @property int $payment_type
 * @property string $payment_code
 * @property int $tax
 * @property string $tax_amount
 *
 * @property User $user0
 * @property Voucher $voucher0
 * @property PaymentDetail[] $paymentDetails
 */
class Payment extends \yii\db\ActiveRecord
{

    public $counter;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_at', 'user', 'user_detail','payment_type'], 'required'],
            [['create_at','payment_code','payer_id','token'], 'safe'],
            [['user', 'voucher', 'payment_type', 'tax'], 'integer'],
            [['user_detail', 'voucher_detail'], 'string'],
            [['tax_amount'], 'number'],
            [['payment_code'], 'string', 'max' => 64],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['voucher'], 'exist', 'skipOnError' => true, 'targetClass' => Voucher::className(), 'targetAttribute' => ['voucher' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_at' => 'Create At',
            'user' => 'User',
            'user_detail' => 'User Detail',
            'voucher_detail' => 'Voucher Detail',
            'voucher' => 'Voucher',
            'payment_type' => 'Payment Type',
            'payment_code' => 'Payment Code',
            'tax' => 'Tax',
            'tax_amount' => 'Tax Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoucher0()
    {
        return $this->hasOne(Voucher::className(), ['id' => 'voucher']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentDetails()
    {
        return $this->hasMany(PaymentDetail::className(), ['payment' => 'id']);
    }
}
