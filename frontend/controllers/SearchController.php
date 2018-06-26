<?php

namespace frontend\controllers;
use Yii;

use yii\data\Pagination;
use common\models\Category;
use common\models\Product;


class SearchController extends \frontend\components\BaseController
{


	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex()
	{

		$this->view->params['menu'] = false;
		if(!$key = Yii::$app->request->get('q', false)){
			throw new \yii\web\NotFoundHttpException();
		}
		$search_categories = Category::find()->where(['like','name', $key])->all();
		$product = Product::find()->where(['like','name', $key])->all();

		$pages = new Pagination(['totalCount' => count($product)]);

		return $this->render('index',
			['products' => $product,
			'category' => $search_categories,
			'pages' => $pages,
			'key' => $key
		]);
	}

	

}
