<?php
namespace frontend\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Product;

class TopdownloadWidget extends Widget{
	public function init(){
		parent::init();
	}

	public function run(){
		// if(!$top = Yii::$app->redis->get('topdownloadwidget')){
			$top = Product::find()->limit(3)->orderBy(['product_download' => SORT_DESC])->all();
			// Yii::$app->redis->set('topdownloadwidget', $top);
		// }

		// var_dump($top);
		// die();
		return $this->render('widget\topdownload', [
			'data' => $top,
			'id' => 'topdownloadwidget'
		]);
	}
}
?>