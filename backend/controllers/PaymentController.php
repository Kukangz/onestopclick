<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;


class PaymentController extends \yii\web\Controller
{

	public function init(){
		$this->view->params['menu'] = 'statistic';
		$this->view->params['submenu'] = 'payment';
	}


	public function actionIndex()
	{
		$data['pages'] = 1;
		$data['dataProvider'] = [];
		if(Yii::$app->request->get('date_range')){
			$query = \common\models\Payment::find();

			$date = explode(' to ',Yii::$app->request->get('date_range'));
			if(!$this->__validateDate($date[0]) && !$this->__validateDate($date[1])){
				throw new Exception("Bad date format", 403);
				
			}

			if($date[0] === $date[1]){
				$query->where(['create_at' => $date[0]]);
			}else{
				$query->where(['between', 'create_at', $date[0], $date[1]]);
			}

			$countQuery = clone $query;

			if($date[0] === $date[1]){
				$dataset = \common\models\Payment::find()->select(['*,COUNT(*) counter'])->where(['create_at' => $date[0]])->groupBy(['date(create_at)'])->all();
			}else{
				$dataset = \common\models\Payment::find()->select(['*,COUNT(*) counter'])->where(['between', 'create_at', $date[0], $date[1]])->groupBy(['date(create_at)'])->all();
			}

			$pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
			$models = $query->offset($pages->offset)
			->limit($pages->limit)
			->orderBy('create_at DESC');
			$data['count'] = $countQuery->count();
			$data['pages'] = $pages;
			$provider = new ActiveDataProvider([
				'query' => $query,
			]);
			$data['dataProvider'] = $models->all();
			$data['export'] = $provider;
			$data['chartdata'] = $dataset;
		}


		return $this->render('index', $data);
	}

	/**
	 * [__validateDate description]
	 * @param  [type] $date   [description]
	 * @param  string $format [description]
	 * @return [type]         [description]
	 */
	private function __validateDate($date, $format = 'Y-m-d')
	{
		$d = \DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}

	/**
	 * [actionAjax description]
	 * @return [type] [description]
	 */
	public function actionAjaxp(){
		$data = Yii::$app->request->get('keyword');
		if ($data) {
			$test = \common\models\Product::find()->where(['like','name', $data])->asArray()->all();
		} else {
			$test = \common\models\Product::find()->where(['status' => 1])->limit(5)->asArray()->all();
		}
		return \yii\helpers\Json::encode($test);
	}
	
	/**
	 * [actionAjaxpay description]
	 * @return [type] [description]
	 */
	public function actionAjaxpay(){
		$data = Yii::$app->request->post('id');
		$test = [];
		if ($data) {
			$test = \common\models\Payment::find()->where(['id' => $data])->asArray()->all();
		}

		return \yii\helpers\Json::encode($test);
	}

}
