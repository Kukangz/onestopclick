<?php 

namespace backend\components;

use Yii;
use yii\web\ForbiddenHttpException;
use backend\models\activerecord\Permission;

class BaseController extends \yii\web\Controller
{
	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init()
	{
		// $session = Yii::$app->session;
		// $this->_menu = $session['menu'];
		
		// var_dump(Yii::$app->urlManager->parseRequest(Yii::$app->request)[0]);
		// die();
		

		
	}

	/**
	 * [beforeAction description]
	 * @param  [type] $action [description]
	 * @return [type]         [description]
	 */
	public function beforeAction($action){

		if (Yii::$app->user->isGuest) {
			return $this->redirect('/');
		}


		$session = Yii::$app->session;

		$current = strtolower(Yii::$app->controller->id);
		$exclude = ['dashboard', 'signout'];

		if(in_array($current, $exclude)){
			return parent::beforeAction($action);
		}

		if(!isset($session['menu']['list'][$current])){
			throw new ForbiddenHttpException;
		}

		switch($session['menu']['list'][$current]['access']){
			case Permission::NO_ACCESS:
			throw new ForbiddenHttpException;
			break;
			case Permission::READONLY:
			if(Yii::$app->controller->action->id == 'update' ||  Yii::$app->controller->action->id == 'delete' || Yii::$app->controller->action->id == 'create'){
				throw new ForbiddenHttpException;
			}
			break;
			case Permission::FULL_ACCESS:

			break;

			default: 
			throw new ForbiddenHttpException;
			break;
		}

		return parent::beforeAction($action);
	}


	public function __init_var($array){
		
	}
}