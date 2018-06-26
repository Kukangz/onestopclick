<?php 

namespace frontend\models\form;

use yii;
use yii\base\Model;
use frontend\models\activerecord\User;
use frontend\models\activerecord\Forgetpassword;

class ForgetForm extends Model{
	public $email;
	public $user;

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return  [['email','required'],
		['email','email']];
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return [ 'email' => 'Email'];
	}

	/**
	 * [request description]
	 * @return [type] [description]
	 */
	public function request()
	{
		if($this->user = User::findByEmail($this->email)){

			if($check = Forgetpassword::findOne(['user' => $this->user->id,'status' => Forgetpassword::STATUS_AVAILABLE])){
				return false;
			}

			$forgetpassword = new Forgetpassword();
			$forgetpassword->user = $this->user->id;
			$forgetpassword->code = Yii::$app->getSecurity()->generateRandomString();
			$forgetpassword->encryption_key = Yii::$app->getSecurity()->generateRandomString();
			$forgetpassword->status = 1;
			$forgetpassword->created_at = date('Y-m-d H:i:s');
			$forgetpassword->updated_at = date('Y-m-d H:i:s');
			$forgetpassword->save();
			
			$this->__sendmail($this->user->email, $this->user->name, $forgetpassword->code);
			
			return $forgetpassword->encryption_key;
		}

		return false;
	}

	/**
	 * [checkactiverequest description]
	 * @return [type] [description]
	 */
	public function checkactiverequest(){

		if($check = Forgetpassword::findOne(['user' => $this->user->id,'status' => Forgetpassword::STATUS_AVAILABLE])){
			return $check;
		}

		return false;
	}

	/**
	 * [checkuser description]
	 * @return [type] [description]
	 */
	public function checkuser(){
		if($this->user = User::findByEmail($this->email)){
			return true;
		}
		return false;
	}

	/**
	 * [resend description]
	 * @param  boolean $key [description]
	 * @return [type]       [description]
	 */
	public function resend($key = false){
		if(!$key){
			return false;
		}

		$check = Forgetpassword::findOne(['encryption_key' => $key,'status' => Forgetpassword::STATUS_AVAILABLE]);
		if(!$check){
			return false;
		}

		$this->user = User::findIdentity($check->user);
		$check->status = Forgetpassword::STATUS_EXPIRED;
		$check->save();

		$forgetpassword = new Forgetpassword();
		$forgetpassword->user = $check->user;
		$forgetpassword->code = Yii::$app->getSecurity()->generateRandomString();
		$forgetpassword->encryption_key = Yii::$app->getSecurity()->generateRandomString();
		$forgetpassword->status = 1;
		$forgetpassword->created_at = date('Y-m-d H:i:s');
		$forgetpassword->updated_at = date('Y-m-d H:i:s');
		$forgetpassword->save();
		$this->__sendmail($this->user->email, $this->user->name, $forgetpassword->code);

		return $forgetpassword->encryption_key;
	}

	/**
	 * [__sendmail description]
	 * @param  [type] $email [description]
	 * @param  [type] $user  [description]
	 * @param  [type] $code  [description]
	 * @return [type]        [description]
	 */
	private function __sendmail($email, $user, $code){
		return Yii::$app->mailer->compose('reset-password', ['name' => $user, 'code' => $code])
		->setTo($email)
		->setFrom('no-reply@onestopclicking.com')
		->setSubject('Reset password Link')
		->send();
	}

}
