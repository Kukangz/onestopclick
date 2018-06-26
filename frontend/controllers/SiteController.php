<?php

namespace frontend\controllers;
use Yii;
use common\models\Category;
use common\models\Product;

class SiteController extends \frontend\components\BaseController
{

	private $navmenu;

	public function init(){
		$this->navmenu = Category::find()->orderBy(['name' => SORT_ASC])->all();
		
	}

	// public function behaviors()
	// {
	// 	return [
	// 		[
	// 			'class' => 'yii\filters\PageCache',
	// 			'only' => ['index'],
	// 			'duration' => 1,
	// 			'variations' => [
	// 				\Yii::$app->language,
	// 			],
	// 		],
	// 	];
	// }

	public function actions()
	{
		// return [
		// 	'error' => [
		// 		'class' => 'yii\web\ErrorAction',
		// 	],
		// ];
	}


	public function actionIndex()
	{
		$this->view->params['menu'] = 'home';
		$latest_product = Product::find()->limit(6)->orderBy(['created_at' => SORT_DESC])->all();		
		return $this->render('index', ['menu' => $this->navmenu, 'latest_product'=> $latest_product,
			'top_view' => Product::find()->limit(3)->orderBy(['product_view' => SORT_DESC])->all(),
			'top_download' => Product::find()->limit(3)->orderBy(['product_download' => SORT_DESC])->all(),
			'headline' => Product::find()->limit(4)->where(['flag_headline' => 1])->orderBy(['updated_at' => SORT_DESC])->all()
		]);
	}

	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}



}
