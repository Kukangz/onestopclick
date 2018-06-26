<?php 

namespace frontend\models\form;

use Yii;
use yii\base\Model;

class TopUpForm extends Model {
	public $amount;

	public function rules()
	{
		return  [
			[['amount'],'required']
		];
	}
}