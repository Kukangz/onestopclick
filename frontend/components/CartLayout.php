<?php 

namespace frontend\components;

use Yii;
use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii2mod\cart\Cart;



class CartLayout extends \yii2mod\cart\widgets\CartGrid
{

	public $cartColumns = ['id','qty', 'label'];
}