<?php 

namespace frontend\models\form;

use Yii;
use yii\base\Model;
use frontend\models\activerecord\User;
use frontend\models\activerecord\Forgetpassword;

class UpdatePasswordForm extends Model {
	public $old_password;
	public $password;
	public $password_repeat;

	public function rules()
	{
		return  [
			[['password_repeat','password','old_password'],'required'],
			['password, repeat_password', 'string','min' => 8],
			['password_repeat', 'compare','compareAttribute' => 'password',  'message'=>"Passwords don't match"],
		];
	}


	public function updatepassword(){
		$model = new User();
		$current_user = $model->find()->where(['id' => Yii::$app->user->identity->id,'password' => md5($this->old_password)])->one();
		if(!$current_user){
			return false;
		}
		$current_user->password = md5($this->password);
		$current_user->save();
		return $current_user->name;
	}

	/**
	 * [getUserPassword description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function getUserPassword($password) {
		$get = User::find(['id' => Yii::$app->user->identity->id,]);
		if($get){
			return true;
		}

		return false;
	}


}