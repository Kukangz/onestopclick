<?php
namespace frontend\components;

use Yii;
use yii\helpers\Html;
use common\models\Category;
use common\models\Subcategory;
use common\models\Brand;

class CMS {
   /**
    * [getMenu description]
    * @return [type] [description]
    */
   public function getMenu(){

   	return Category::find()->where(['status' => Category::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all();
   }


   public function getSubCategory(){
    $subcategory = Subcategory::find()->select(['sub_category.*','parent_name' => 'category.name', 'parent_slug' => 'category.slug'])->where(['category.status' => Category::STATUS_ACTIVE, 'sub_category.status' => Category::STATUS_ACTIVE])->join('left join','category','category.id=sub_category.parent')->orderBy(['category.name' => SORT_ASC,'sub_category.name' => SORT_ASC])->all();
    $return = [];
    foreach($subcategory as $item){
      $return[$item->parent_slug][] = $item;
    }
    
    return $return;
  }

  public function getBrand($category = FALSE){

    if(!$category){
      return Brand::find()->where(['status' => Category::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all();
    }
    return Brand::find()->where(['status' => Category::STATUS_ACTIVE,'category' => $category])->orderBy(['name' => SORT_ASC])->all();
  }


  public function getOtherMenu(){
    return ['Brand' => '/brand'
    // , 'Contact' => '/contact'
  ];
  }


  public function getName(){
    return Yii::$app->user->identity->name;

  }

  public function is_guest(){
    return Yii::$app->user->identity->name;

  }

/**
 * [getStatusTopup description]
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
public function getStatusTopup($var){
  switch($var){
    case -1:
    return "Rejected";
    case 0:
    return "Waiting for Payment";
    break;
    case 1:
    return "Confirmed by User";
    break;
    case 2:
    return "Confirmed by Admin";
    break;
    case 3:
    return "Confirmed by Finished";
    break;
  }
}


/**
 * [getPaymentBank description]
 * @return [type] [description]
 */
public function getPaymentBank($var){
  return (isset(paymentBank()[$var]))?paymentBank()[$var]:false;
}

/**
 * [paymentBank description]
 * @return [type] [description]
 */
public function paymentBank(){
  return [0 => 'BCA',1 => 'Mandiri'];
}

/**
 * [getTotalCart description]
 * @return [type] [description]
 */
public function getTotalCart(){
  $session = Yii::$app->session;
  $items = $session->get('cart');
  $total = 0;
  if($items){
    foreach($items as $item){
      $total += $item['price'] * $item['qty'];
    }
  }

  return number_format($total);

}

/**
 * [getCartItems description]
 * @return [type] [description]
 */
public function getCartItems(){
  $session = Yii::$app->session;
  $items = $session->get('cart');
  if($items){
   return count($items);
 }
 return 0;

}

/**
 * [getPaymentType description]
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
public function getPaymentType($var){
  return CMS::paymentType()[$var];
}

/**
 * [paymentType description]
 * @return [type] [description]
 */
public function paymentType(){
  return [1 =>'Balance', 2 => 'Paypal'];
}

/**
 * [getDownloadStatus description]
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
public function getDownloadStatus($var){
  return CMS::downloadStatus()[$var];
}

/**
 * [downloadStatus description]
 * @return [type] [description]
 */
public function downloadStatus(){
  return [0 => 'Used',1 => 'Available'];
}
}
