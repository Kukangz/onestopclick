<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\components\CMS;
use yii\widgets\ActiveForm;
?>
<div id="sidebar">
    <?php $form = ActiveForm::begin();?>
    <div class="col-md-12">
        <div class="form-group eto">

            <input type="text" class="form-control" placeholder="Search Product Here">
            <i class="fa fa-search"></i>
        </div>
    </div>
    <div class="col-md-12">
        <h3><i class="fas fa-tags"></i>&nbsp;Category</h3>
        <?php $sub = CMS::getSubCategory(); ?>
        
        <?php foreach(CMS::getMenu() as $cats):?>
            <ul class="<?php echo ($this->params['menu'] === $cats->slug)?'active':'';?>">
                <a href="<?php echo Url::to('/category/'.$cats->slug);?>">
                    <i class="fas fa-angle-right"></i>&nbsp;<?php echo $cats->name;?>
                </a>
                <?php if(isset($sub[$cats->slug])):?>
                    <?php foreach($sub[$cats->slug] as $item):?>
                        <li>
                            <a href="<?php echo Url::to('/category/'.$cats->slug.'/'.$item->slug);?>">
                                <i class="fas fa-angle-right"></i>&nbsp;<?php echo $item->name;?>
                            </a>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>
            </ul>
        <?php endforeach;?>
        <hr>
    </div>

    <div class="col-md-12 brand">
        <h3><i class="fas fa-tags"></i>&nbsp;Brand</h3>
        <?php foreach(CMS::getBrand($category->id) as $cats):?>
            <input type="checkbox"/>&nbsp;<?php echo $cats->name;?>
            <br>
        <?php endforeach;?>
        <!-- <hr> -->
    </div>

   <!--  <div class="col-md-12 brand">
        <h3><i class="fas fa-money-bill-alt"></i>&nbsp;Price</h3>
        <div data-role="main" class="ui-content">
            <div data-role="rangeslider">
                <p>
                  <label for="amount">Price range:</label>
                  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
              </p>

              <div id="slider-range"></div>
          </div>
      </div>
  </div> -->

  <?php ActiveForm::end();?>
</div>
<div class="single-product-area" style="min-height: 600px;">

    <div class="zigzag-bottom"></div>
    <div class="container">

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
