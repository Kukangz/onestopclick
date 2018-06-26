<?php 

namespace frontend\models\form;

use Yii;
use yii\base\Model;

class ConfirmForm extends Model {
	public $code;
	public $transaction_date;
	public $payment_bank;
	public $sender_name;

	public function rules()
	{
		return  [
			[['code','transaction_date','amount_transfer','payment_bank','sender_name'],'required']
		];
	}


}