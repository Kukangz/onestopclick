<?php

namespace frontend\controllers;
use Yii;
use common\models\Brand;
use yii\data\Pagination;
use common\models\Product;

class BrandController extends \frontend\components\BaseController
{


	public function init(){
		$this->view->params['menu'] = 'brand';
	}
	

	public function behavior(){
		$this->layout = 'main';
	}
	

	public function actionIndex()
	{
		$item_list = Brand::find();
		$countQuery = clone $item_list;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $item_list->offset($pages->offset)
		->limit($pages->limit)
		->all();
		return $this->render('index',['pages' => $pages,
			'products' => $models]);
	}

	public function actionItem($slug = false)
	{
		$maincats = Brand::find()->where(['slug' => $slug])->one();

		if(!$maincats){
			throw new \yii\web\NotFoundHttpException();
		}

		
		$item_list = Product::find()
		->join('LEFT JOIN','brand','brand.id=product.brand')
		->where(['product.brand' => $maincats->id]);
		
		$countQuery = clone $item_list;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $item_list->offset($pages->offset)
		->limit($pages->limit)
		->all();

		return $this->render('items',
			['pages' => $pages,
			'brand' => $maincats,
			'products' => $models]);
	}
	
}

