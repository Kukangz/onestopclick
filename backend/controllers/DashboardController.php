<?php

namespace backend\controllers;

class DashboardController extends \backend\components\BaseController
{
	public function actionIndex()
	{
		$this->view->params['menu'] = 'dashboard';
		$this->view->params['submenu'] = '';
		return $this->render('index');
	}

}
