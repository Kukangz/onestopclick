<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\components\CMS;
use yii\widgets\ActiveForm;
?>
<div id="sidebar">
    <?php $form = ActiveForm::begin(['action' => '/newsletter/subscribe/'.$brand->id]);?>


    <div class="col-md-12 brand">
        <h3><i class="fas fa-tags"></i>&nbsp;Brand</h3>

        <?php foreach(CMS::getBrand() as $cats):?>
            <ul class="<?php echo ($this->params['menu'] === $cats->slug)?'active':'';?>">
                <a href="<?php echo Url::to('/brand/'.$cats->slug);?>">
                    <i class="fas fa-angle-right"></i>&nbsp;<?php echo $cats->name;?>
                </a>
            </ul>
        <?php endforeach;?>

        <hr>
    </div>

    <div class="col-md-12">
        <h3><i class="far fa-bell"></i>&nbsp;&nbsp;Subscribe</h3>
        <div class="form-group eto">

            <input type="text" name="email" class="form-control" placeholder="Subscribe">
        </div>
    </div>

    <?php ActiveForm::end();?>
</div>
<div class="single-product-area">

    <div class="zigzag-bottom"></div>
    <div class="container">
        <h1 style="text-align: center;"><?php echo $brand->name;?></h1>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
            <?php if($products):?>
                <?php foreach($products as $item):?>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <a href="<?php echo Url::to('/product/'.$item->slug);?>">
                                    <?php echo Html::img('@cdn'.$item->picture_thumbnail);?>
                                </a>
                            </div>
                            <h2><a href="<?php echo Url::to('/product/'.$item->slug);?>"><?php echo $item->name;?></a></h2>
                            <div class="product-carousel-price">
                                <ins><?php echo 'Rp. '. number_format($item->price);?></ins>
                            </div>  

                            <div class="product-option-shop">
                                <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="<?php echo URL::to('/cart/add/'.$item->id);?>">Add to cart</a>
                            </div>                       
                        </div>
                    </div>

                <?php endforeach;?>
                <?php else:?>
                    <h1 style="text-align: center;">No Product Found</h1>
                <?php endif;?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php 
    // display pagination
                    echo LinkPager::widget([
                        'pagination' => $pages,
                        'options' => [
                            'class' => 'product-pagination text-center',
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
