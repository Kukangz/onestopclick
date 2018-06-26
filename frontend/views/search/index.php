<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Search Result for : <?php echo $key;?></h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <?php if($category):?>
                <h2>Categories</h2>
                <?php foreach($category as $item):?>
                    <div class="col-md-2 col-sm-6">
                        <div class="row">
                            <h3><a href="<?php echo Url::to('/category/'.$item->slug);?>"><?php echo $item->name;?></a></h3>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="clearfix">&nbsp;</div>

        <div class="row">

            <?php if($products):?>

                <h2>Products : </h2>
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
                                <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                            </div>                       
                        </div>
                    </div>

                <?php endforeach;?>

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
