<?php 
namespace frontend\controllers;
use Yii;

use common\models\Category;
use common\models\Product;
use common\models\ProductReview;


class ProductController extends \frontend\components\BaseController
{
	/**
	 * [actionIndex description]
	 * @param  boolean $slug [description]
	 * @return [type]        [description]
	 */
	public function actionIndex($slug = false)
	{
		if(!$slug){
			throw new \yii\web\NotFoundHttpException();
		}

		$product = Product::find()->select(['product.*','category.name category_name','category.slug category_slug', 'sub_category.name sub_category_name', 'sub_category.slug sub_category_slug'])->where(['`product`.slug' => $slug])
		->leftJoin('sub_category', '`sub_category`.`id` = `product`.`category`')
		->leftJoin('category','`sub_category`.`parent` = `category`.`id`')->one();
		if(!$product){
			throw new \yii\web\NotFoundHttpException();
		}

		$product->product_view += 1;
		$product->save();

		$this->view->params['menu'] = $product->category_slug;
		$related = Product::find()->where(['<', 'id', $product->id])->limit(3)->all();
		$model = new ProductReview();
		if(!$product){
			throw new \yii\web\NotFoundHttpException();
		}

		$review = ProductReview::find()->where(['product' => $product->id,'product_review.status' => 1])->select(['product_review.*','user.name'])->leftJoin('user','`product_review`.`user`=`user`.`id`')->limit(20)->orderBy('`product_review`.create_at DESC')->all();
		return $this->render('index', ['model'=> $model,'product' => $product, 'related' => $related,'review' => $review]);
	}


	public function actionReview()
	{
		$model = new ProductReview();
		
		$post = Yii::$app->request->post('ProductReview');

		// user_get_contents('https://www.google.com/recaptcha/api/siteverify')
		$params=['secret'=>'6LcY5V4UAAAAAKI47d483CAnSehJuhCY38U-h8lN', 'response'=>Yii::$app->request->post('g-recaptcha-response')];
		$defaults = array(
			CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify', 
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_RETURNTRANSFER => true
		);

		$ch = curl_init();
		curl_setopt_array($ch, $defaults);

		$result = json_decode(curl_exec($ch));

		if($result->success)
		{
			$model->product = $post['product'];
			$model->rating = $post['rating'];
			$model->review = $post['review'];
			$model->user = Yii::$app->user->identity->id;
			$model->save();
			Yii::$app->session->setFlash('success', 'Thank you for your review. The review will be reviewed by our team');
			
		}else{
			Yii::$app->session->setFlash('error', 'Please finish the recaptcha challenge');
		}

		$this->redirect(Yii::$app->request->referrer);


		
	}

}

