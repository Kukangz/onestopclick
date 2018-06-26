<?php 

namespace frontend\models\form;

use Yii;
use yii\base\Model;
use frontend\models\activerecord\User;
use frontend\models\activerecord\Forgetpassword;

class ResetPasswordForm extends Model {
	public $password;
	public $password_repeat;

	public function rules()
	{
		return  [
			['password','required'],
			['password_repeat', 'compare','compareAttribute' => 'repeat_password',  'on' => array('create', 'update')],
			['password, repeat_password', 'string','length' => 8],
		];
	}


	public function updatepassword($user){
		$model = new User();
		$current_user = $model->findOne(['id' => $user]);
		$current_user->password = md5($this->password);
		$current_user->save();
		return $current_user->name;
	}


}