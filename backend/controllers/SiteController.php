<?php

namespace backend\controllers;

class SiteController extends \yii\web\Controller
{

	/**
	 * [actions description]
	 * @return [type] [description]
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}


	/**
	 * [actionError description]
	 * @return [type] [description]
	 */
	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}



}
