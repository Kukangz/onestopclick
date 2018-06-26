<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\Voucher;
use yii\web\ForbiddenHttpException;

class CartController extends \frontend\components\BaseController
{	

	public $session;

	public function init(){
		$this->session = Yii::$app->session;
	}

	public function actionIndex()
	{
		
		return $this->render('index',['cart' => $this->session->get('cart'),'product_sidebar' => Product::find()->limit(4)->all()]);
	}

	/**
	 * [actionAdd description]
	 * @param  boolean $item [description]
	 * @param  integer $qty  [description]
	 * @return [type]        [description]
	 */
	public function actionAdd($item = FALSE, $qty = 1)
	{
		

		if(!Yii::$app->request->post()){
			if(!$item){
				throw new ForbiddenHttpException;
			}
		}else{
			$item =Yii::$app->request->post('product');
			$qty =Yii::$app->request->post('qty');
			if(!$item){
				throw new ForbiddenHttpException;
			}
		}

		$product = Product::findOne($item);
		if(!$product){
			throw new ForbiddenHttpException;;
		}

		

		$cart = $this->session->get('cart');

		if($cart){
			$my_cart = $cart;
		}else{
			$my_cart = [];
		}

		if(isset($my_cart[$item])){
			Yii::$app->session->setFlash('error', 'Product already added to cart!');
			return $this->redirect(Yii::$app->request->referrer);
		}else{
			$my_cart[$item] = ['id' => $product->id,'slug' => $product->slug,'image' => $product->picture_thumbnail,'name' => $product->name,'price' => $product->price, 'qty' => $qty];
		}
		

		$this->session->set('cart', $my_cart);
		if(Yii::$app->request->post('action')){
			

			if(Yii::$app->request->post('action') == 'Add to cart'){
				return $this->redirect(Yii::$app->request->referrer);
			}

			if(Yii::$app->request->post('action') == 'Get Product'){
				return $this->redirect('/checkout');
			}
		}
		Yii::$app->session->setFlash('success', 'Product Added to cart!');
		$this->redirect(Yii::$app->request->referrer);
	}

		/**
	 * [actionCheckout description]
	 * @return [type] [description]
	 */
		public function actionVoucher(){
			
			if(Yii::$app->request->post('voucher')){
				$voucher = Voucher::find()->select(['name','code','discount_type','discount_value'])->where(['code' => Yii::$app->request->post('voucher')])->one();

				if(!$voucher){
					Yii::$app->session->setFlash('error', 'Voucher code not found!');
				}else{
					Yii::$app->session->setFlash('success', 'Voucher code for '.$voucher->name.' Applied');
					Yii::$app->session->set('voucher', $voucher);
				}
			}else{
				Yii::$app->session->setFlash('error', 'Error when applying voucher code');
			}
			
			$this->redirect(['/cart']);
		}

	/**
	 * [actionCheckout description]
	 * @return [type] [description]
	 */
	public function actionCheckout(){
		if(Yii::$app->user->isGuest){
			Yii::$app->session->setFlash('error', 'Please login first before proceed to checkout');
			return $this->redirect(['/auth']);
		}

		if(!$this->session->get('cart')){
			Yii::$app->session->setFlash('error', 'Please order something first before proceed to checkout');
			return $this->redirect(['/cart']);
		}

		return $this->render('checkout',['cart' => $this->session->get('cart')]);
	}
	
	/**
	 * [actionUpdate description]
	 * @param  [type] $item [description]
	 * @param  [type] $qty  [description]
	 * @return [type]       [description]
	 */
	public function actionUpdate($item, $qty){
		
		$cart = $this->session->get('cart');
		$cart[$item]['qty'] = $qty;
		$this->session->set('cart', $cart);
	}

	/**
	 * [actionDelete description]
	 * @param  boolean $item [description]
	 * @return [type]        [description]
	 */
	public function actionDelete($item = FALSE){
		
		$cart = $this->session->get('cart');
		unset($cart[$item]);
		$this->session->set('cart', $cart);
		Yii::$app->session->setFlash('success', 'Product removed from cart!');
		$this->redirect(Yii::$app->request->referrer);
	}

	public function actionDestroy(){
		
		$this->session->destroy();
	}


	public function actionVouchercancel(){
		Yii::$app->session->set('voucher', false);
		Yii::$app->session->setFlash('success', 'Voucher is taken off');
		$this->redirect(['/cart']);
	}

}
