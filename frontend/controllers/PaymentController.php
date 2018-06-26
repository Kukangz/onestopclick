<?php

namespace frontend\controllers;
use yii;
use common\models\Product;
use yii\helpers\Url;
use common\models\Voucher;
use common\models\Payment;
use common\models\User;
use common\models\PaymentDetail;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;

use PayPal\Api\CreditCard;
use PayPal\Exception\PaypalConnectionException;

class PaymentController extends \frontend\components\BaseController
{

	public function init(){
		$this->view->params['menu'] = 'home';
	}
	public function actionIndex()
	{
		if(Yii::$app->session->get('cart')){

			foreach(Yii::$app->session->get('cart') as $item){
				$id_list[] = $item['id'];
			}
		}else{
			Yii::$app->session->setFlash('error', "You can't access this page");
			return $this->redirect('/cart');
		}


		$total = 0;
		$product_batch = [];
		$product = Product::find()->where(['in','id',$id_list])->all();
		foreach($product as $item){
			$total+= $item->price;
		}

		$voucher_compare =  false;
		if($voucher = Yii::$app->session->get('voucher')){
			$voucher_compare = Voucher::find()->where(['code' => $voucher->code, 'status' => 1])->one();
			if($voucher_compare){
				if($voucher_compare->discount_type == 1){
					$discount = ($total / 100) * $voucher_compare->discount_value;
				}elseif($voucher_compare->discount_type == 2){
					$discount = $voucher_compare->discount_value;
				}
			}else{
				Yii::$app->session->setFlash('error', 'Voucher Code is invalid or already used');
				return $this->redirect(['/cart']);
			}
		}

		$discount = 0;
		$total -= $discount;

		if(Yii::$app->request->post('payment_method') == 'paypal'){

			$var = json_decode(file_get_contents('http://free.currencyconverterapi.com/api/v5/convert?q=IDR_USD&compact=y'));
			$result = $total * $var->IDR_USD->val;

			$payer = new \PayPal\Api\Payer();
			$payer->setPaymentMethod('paypal');

			$amount = new \PayPal\Api\Amount();
			$amount->setCurrency('USD')->setTotal($result);
			
			$transaction = new \PayPal\Api\Transaction();
			$transaction->setDescription("Onestopclick Item Payment")->setAmount($amount);

			$redirectUrls = new \PayPal\Api\RedirectUrls();
			$redirectUrls
			->setReturnUrl(Url::to('/payment/payment-success', true))
			->setCancelUrl(Url::to('/payment/payment-failed', true));

			$payment = new \PayPal\Api\Payment();
			$payment->setIntent('sale')
			->setPayer($payer)
			->setTransactions(array($transaction))
			->setRedirectUrls($redirectUrls);

			try {
				$apiContext = new \PayPal\Rest\ApiContext(
					new \PayPal\Auth\OAuthTokenCredential('AUH0IjLTYVvdQI-sCj7SGlEJqsDydDRNe5bNgWnkU08wfd1zNhUcd5ZGUHqqhlM6AZkBvDayzu_R053Y', 'EHGQtUNqxdlrpthks8kNPJMyRNI9wx1XqaeonaRHDuXr1twaU3i8LLaPORjnmDHJCRHcLosxBwi8tzIA')
				);
				$payment->create($apiContext);
				// echo $payment;

				// echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
				return $this->redirect($payment->getApprovalLink());
			}catch (\PayPal\Exception\PayPalConnectionException $ex) {
				    // This will print the detailed information on the exception.
				    //REALLY HELPFUL FOR DEBUGGING
				// */echo $ex->getData();
				var_dump($ex->getData());
				die();
			}


		}else{

			$payment = new Payment();
			$payment->create_at = date('Y-m-d H:i:s');
			$payment->user = YII::$app->user->identity->id;

			$payment->user_detail = json_encode([
				'name' => YII::$app->user->identity->name,
				'address' => YII::$app->user->identity->address,
				'email' => YII::$app->user->identity->email,
				'social_media_type' => YII::$app->user->identity->social_media_type,
				'social_media_id' => YII::$app->user->identity->social_media_id]);

			if($voucher_compare){
				$payment->voucher = $voucher_compare->id;
				$payment->voucher_detail = json_encode([
					'voucher_name' => $voucher_compare->name,
					'code' => $voucher_compare->code,
					'discount_type' => $voucher_compare->discount_type,
					'discount_value' => $voucher_compare->discount_value
				]);
			}

			$payment->payment_type = 1;
			if($id = $payment->save()){

				foreach($product as $item){

					$product_batch[] = [$payment->id,$item->id, json_encode(['name' => $item->name,'pid' => $item->PID,'description' => $item->description,'thumbnail' => $item->picture_thumbnail, 'picture_real' => $item->picture]),$item->price,$item->price_discount, ($item->price - $item->price_discount)];
					$downloads_batch[] = [YII::$app->user->identity->id,YII::$app->security->generateRandomString(),$item->id, 1];
				}
				YII::$app->db->createCommand()->batchInsert('payment_detail',['payment','product','product_detail','price_sell','price_discount','price_net'],$product_batch)->execute();
				YII::$app->db->createCommand()->batchInsert('user_downloads',['user','access_token','product','counter'],$downloads_batch)->execute();
				YII::$app->session->set('cart', false);
				YII::$app->session->set('voucher', false);
				$user = User::findOne(YII::$app->user->identity->id);
				$user->balance = $user->balance - $total;
				$user->save(false);

				// $downloads = new \common\models\UserDownloads;
			}else{
				Yii::$app->session->setFlash('error', 'You have insufficient balance, please top up first');
				return $this->redirect(['/cart']);
			}
		}

		return $this->redirect(['/payment-complete']);

	}

	/**
	 * [actionPaymentSuccess description]
	 * @return [type] [description]
	 */
	public function actionPaymentSuccess(){
		if(!Yii::$app->request->get('paymentId') && !Yii::$app->request->get('token') && !Yii::$app->request->get('PayerID')){
			return $this->redirect(['/cart']);
		}

		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
                'AUH0IjLTYVvdQI-sCj7SGlEJqsDydDRNe5bNgWnkU08wfd1zNhUcd5ZGUHqqhlM6AZkBvDayzu_R053Y',     // ClientID
                'EHGQtUNqxdlrpthks8kNPJMyRNI9wx1XqaeonaRHDuXr1twaU3i8LLaPORjnmDHJCRHcLosxBwi8tzIA'      // ClientSecret
            )
		);
		// var_dump($apiContext);
		// die();
		$paymentId 	= Yii::$app->request->get('paymentId');
		$payment 	= \PayPal\Api\Payment::get($paymentId, $apiContext);

		$execution 	= new PaymentExecution();
		$execution->setPayerId(Yii::$app->request->get('PayerID'));

		try 
		{
			$result = $payment->execute($execution, $apiContext);
		} 	catch (Exception $e)
		{
			return $this->redirect(Url::to('/payment/payment-failed', true));
		}

		foreach(Yii::$app->session->get('cart') as $item){
			$id_list[] = $item['id'];
		}

		$total = 0;
		$product_batch = [];
		$product = Product::find()->where(['in','id',$id_list])->all();
		foreach($product as $item){
			$total+= $item->price;
		}

		$voucher_compare =  false;
		if($voucher = Yii::$app->session->get('voucher')){
			$voucher_compare = Voucher::find()->where(['code' => $voucher->code, 'status' => 1])->one();
			if($voucher_compare){
				if($voucher_compare->discount_type == 1){
					$discount = ($total / 100) * $voucher_compare->discount_value;
				}elseif($voucher_compare->discount_type == 2){
					$discount = $voucher_compare->discount_value;
				}
			}else{
				Yii::$app->session->setFlash('error', 'Voucher Code is invalid or already used');
				return $this->redirect(['/cart']);
			}
		}

		$discount = 0;
		$total -= $discount;


		$payment = new Payment();
		$payment->create_at = date('Y-m-d H:i:s');
		$payment->payment_code = Yii::$app->request->get('paymentId');
		$payment->payer_id = Yii::$app->request->get('PayerID');
		$payment->token = Yii::$app->request->get('token');
		$payment->user = YII::$app->user->identity->id;

		$payment->user_detail = json_encode([
			'name' => YII::$app->user->identity->name,
			'address' => YII::$app->user->identity->address,
			'email' => YII::$app->user->identity->email,
			'social_media_type' => YII::$app->user->identity->social_media_type,
			'social_media_id' => YII::$app->user->identity->social_media_id]);

		if($voucher_compare){
			$payment->voucher = $voucher_compare->id;
			$payment->voucher_detail = json_encode([
				'voucher_name' => $voucher_compare->name,
				'code' => $voucher_compare->code,
				'discount_type' => $voucher_compare->discount_type,
				'discount_value' => $voucher_compare->discount_value
			]);
		}

		$payment->payment_type = 2;
		if($id = $payment->save()){

			foreach($product as $item){

				$product_batch[] = [$payment->id,$item->id, json_encode(['name' => $item->name,'pid' => $item->PID,'description' => $item->description,'thumbnail' => $item->picture_thumbnail, 'picture_real' => $item->picture]),$item->price,$item->price_discount, ($item->price - $item->price_discount)];
				$downloads_batch[] = [YII::$app->user->identity->id,YII::$app->security->generateRandomString(),$item->id, 1];
			}
			YII::$app->db->createCommand()->batchInsert('payment_detail',['payment','product','product_detail','price_sell','price_discount','price_net'],$product_batch)->execute();
			YII::$app->db->createCommand()->batchInsert('user_downloads',['user','access_token','product','counter'],$downloads_batch)->execute();
			YII::$app->session->set('cart', false);
			YII::$app->session->set('voucher', false);
			// $user = User::findOne(YII::$app->user->identity->id);
			// $user->balance = $user->balance - $total;
			// $user->save(false);

			// $downloads = new \common\models\UserDownloads;
			Yii::$app->session->setFlash('success', "Payment Completed");
		}else{
			Yii::$app->session->setFlash('error', "You can't access this page");
		}
		return $this->redirect(['/payment-complete']);
	}


	/**
	 * [actionPaymentSuccess description]
	 * @return [type] [description]
	 */
	public function actionPaymentFailed(){
		Yii::$app->session->setFlash('error', "Please use paypal checkout properly");
		return $this->redirect(['/cart']);	
	}


	public function actionDone(){
		return $this->render('summary',[]);
	}

	public function actionError(){
		return;	
	}

}
