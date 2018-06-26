<?php 

namespace frontend\components;

use Yii;
use yii\web\ForbiddenHttpException;

class BaseController extends \yii\web\Controller
{

	public $_menu;

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init()
	{
		
		
		
	}

	/**
	 * [beforeAction description]
	 * @param  [type] $action [description]
	 * @return [type]         [description]
	 */
	public function beforeAction($action){

		if (!Yii::$app->user->isGuest) {
			// var_dump(YII::$app->user->identity->name);
			// die();
		}
		$this->view->params['menu'] = false;

		$session = Yii::$app->session;

		// if session is not open, open session
		if ( !$session->isActive) { $session->open(); }

		return parent::beforeAction($action);
	}
}