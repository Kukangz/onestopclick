<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\components\CMS;
use yii\widgets\ActiveForm;
?>

<div class="single-product-area">

    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <?php if($products):?>
                <?php foreach($products as $item):?>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-shop-product">
                            <h2><a href="<?php echo Url::to('/brand/'.$item->slug);?>"><?php echo $item->name;?></a></h2>
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
