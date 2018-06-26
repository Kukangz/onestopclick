<?php

namespace frontend\controllers;
use yii;
use frontend\components\AuthController;
use common\models\User;

class MemberController extends \frontend\components\AuthController
{

	public function beforeAction($action){
		if(Yii::$app->user->isGuest){
			return $this->redirect(['/']);
		}

		return parent::beforeAction($action);
	}

	/**
	 * [actionIndex description]
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$model = new \frontend\models\form\UpdatePasswordForm();
		$mytopup = \common\models\TopUp::find()->where(['user' => Yii::$app->user->identity->id])->orderBy('created_at DESC')->all();
		$user_downloads = \common\models\UserDownloads::find()->select(['user_downloads.*', 'product_name' => 'product.name'])->where(['user' => Yii::$app->user->identity->id])->join('left join','product','product.id=user_downloads.product')->orderBy('created_at DESC')->all();
		$payment = \common\models\Payment::find()->where(['user' => Yii::$app->user->identity->id])->orderBy('create_at DESC')->all();
		$message = '';
		if(Yii::$app->request->post()){
			if ($model->load(Yii::$app->request->post()) && $model->updatepassword()) {
				$message = 'Password Successfully Changed';
			}else{
				$model->addError('old_password',"Your password doesn't match previous one");
			}
		}
		
		return $this->render('index',
			[
				'updatepassword' => $model,
				'topup' => new \frontend\models\form\TopUpForm(),
				'confirm' => new \frontend\models\form\ConfirmForm(),
				'message' => $message,
				'list_topup' => $mytopup,
				'user_downloads' => $user_downloads,
				'payment' => $payment
			]);
	}

	/**
	 * [actionTopUp description]
	 * @return [type] [description]
	 */
	public function actionTopUp(){

		$model = new \common\models\TopUp();
		if($model->find()->where(['user' => Yii::$app->user->identity->id, 'status' => 0])->one()){
			Yii::$app->session->setFlash('error','You have pending Top-up, please finish the transaction first');
		}else{
			$model = new \common\models\TopUp();
			$model->user = Yii::$app->user->identity->id;
			$model->transaction_code = Yii::$app->getSecurity()->generateRandomString(24);
			$model->amount = Yii::$app->request->post('TopUpForm')['amount'];

			if ($model->save()) {
				Yii::$app->session->setFlash('success','Update Sucessful!');
			}else{
				Yii::$app->session->setFlash('error','Update Failed!');
			}
		}
		return $this->redirect(['/member','#' => 'balance']);
	}

	/**
	 * [actionConfirm description]
	 * @return [type] [description]
	 */
	public function actionConfirm(){
		$model = new \common\models\TopUp();
		
		$topup = $model->findOne(Yii::$app->request->post('ConfirmForm')['code']);
		if($topup){

			if($topup->status == 2){
				Yii::$app->session->setFlash('error','Transaction code is used');
				return $this->redirect(['/member','#' => 'balance']);
			}
			$post = Yii::$app->request->post('ConfirmForm');
			if($topup->status == 1){
				Yii::$app->session->setFlash('error','Please wait for our team to confirm your payment.');
				return $this->redirect(['/member','#' => 'balance']);
			}

			$topup->transaction_date = $post['transaction_date'];
			$topup->payment_bank = $post['payment_bank'];
			$topup->sender_name = $post['sender_name'];
			$topup->status = 1;
			$topup->save();
			Yii::$app->session->setFlash('success','Payment confirmation saved, please wait for our team to confirm your payment.');
		}
		// $confirm = new \common\models\TopUpConfirm();
		Yii::$app->session->setFlash('tab','balance');
		return $this->redirect(['/member','#' => 'balance']);
	}

	/**
	 * [actionDownload description]
	 * @param  [type] $token [description]
	 * @return [type]        [description]
	 */
	public function actionDownload(){


		$access_token = Yii::$app->request->get('access_token');

		if(!$access_token){
			throw new yii\web\ForbiddenHttpException;
		}

		$download_link = \common\models\UserDownloads::find()
		->select(['user_downloads.*', 'product_name' => 'product.product_download_link'])
		->where(['user' => Yii::$app->user->identity->id,'user_downloads.access_token' => $access_token,])
		->join('left join','product','product.id=user_downloads.product')
		->orderBy('created_at DESC')->one();

		if($download_link->product_name){
			

			if($download_link->status > 0){
				$download_link->download_start = date('Y-m-d H:i:s');
				$download_link->download_end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));
				$download_link->status = 0;
				$download_link->save();
			}

			if(!$download_link->status && strtotime(date('Y-m-d H:i:s')) > strtotime($download_link->download_end)){
				$download_link->counter = 0;
				$download_link->save();
				throw new yii\web\ForbiddenHttpException;
			}
			
			header("Content-type: application/force-download");
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=\"".basename($download_link->product_name)."\"");
			readfile(yii\helpers\Url::to('@cdn'.$download_link->product_name));
		}else{
			throw new yii\web\ForbiddenHttpException;
		}
		
	}

	/**
	 * [actionTransaction description]
	 * @param  boolean $id [description]
	 * @return [type]      [description]
	 */
	public function actionTransaction($id = false){
		if(!$id){
			throw new yii\web\ForbiddenHttpException;
		}
		
		$payment = \common\models\Payment::find()->where(['user' => Yii::$app->user->identity->id, 'id' => $id])->orderBy('create_at DESC')->one();

		if(!$payment){
			throw new yii\web\ForbiddenHttpException;	
		}

		$payment_detail = \common\models\PaymentDetail::find()->join('left join ','payment', 'payment.id=payment_detail.payment')->where(['payment' => $payment->id])->orderBy('create_at DESC')->all();
		return $this->render('payment',
			[
				'header' => $payment,
				'detail' => $payment_detail
			]);
	}

}
