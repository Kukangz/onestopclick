<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-content-right">


                    <div class="row">
                        <h1><?php echo $product->name;?></h1>
                        <div class="product-inner-category">
                            <p>Category: <a href="<?php echo Url::to('/category/'.$product->category_slug.'/'.$product->sub_category_slug);?>"><?php echo $product->category_name;?> &raquo; <?php echo $product->sub_category_name;?></a></p>
                        </div> 
                        <div class="col-sm-4">
                            <div class="product-images">

                                <div class="product-gallery">
                                    <?php if($product->embed_video):?>
                                        <h3>Trailer & Demo</h3>
                                        <?php echo $product->embed_video;?>
                                    <?php endif;?>

                                    <div class="clearfix">&nbsp;</div>
                                    <?php if($product->embed_music_player):?>
                                        <h3>Other Media</h3>
                                        <?php echo $product->embed_music_player;?>
                                    <?php endif;?>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="product-inner">
                                <h3>Product Detail</h3>

                                <img width="100%" src="<?php echo Url::to('@cdn'.$product->picture);?>"/>

                                <div class="clearfix">&nbsp;</div>
                                <form action="<?php echo URL::to('/cart/add');?>" class="cart pull-right" method="post">
                                    <div class="product-inner-price">
                                        Price : <ins><?php echo 'Rp. '.number_format($product->price);?></ins>
                                    </div>
                                    <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                                    <div class="quantity">
                                        <input type="hidden" size="4" class="input-text qty text" title="Qty" value="1" name="qty" min="1" step="1">
                                        <input type="hidden" name="product" value="<?php echo $product->id;?>">
                                    </div>

                                    <input type="submit" name="action" class="add_to_cart_button" value="Add to cart"></button>
                                    <input type="submit" name="action" class="add_to_cart_button" value="Get Product"></button>
                                </form>   
                                <h3>Share This Product</h3>
                                <a href="#" class="social-button" id="fb-share"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="social-button" id="tw-share"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="social-button" id="gplus-share"><i class="fa fa-google"></i></a>


                                <div class="clearfix">&nbsp;</div>

                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                                        <li role="presentation"><a href="#trailer" aria-controls="trailer" role="tab" data-toggle="tab">Additional Information</a></li>
                                        <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">Review</a></li>
                                        <?php if(!Yii::$app->user->isGuest):?>
                                            <li role="presentation"><a href="#submitreview" aria-controls="submitreview" role="tab" data-toggle="tab">Submit Review</a></li>
                                        <?php endif;?>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <h2>Product Description</h2>  
                                            <p><?php echo $product->description;?></p>

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="trailer">
                                            <h2>Official Website</h2>  
                                            <p><?php echo $product->official_site;?></p>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="review">
                                            <div class="submit-review">
                                                <?php if($review):?>
                                                    <?php foreach($review as $item):?>
                                                        <h4><strong><?php echo $item->name;?></strong></h4>
                                                        <div class="rating-wrap-post">
                                                            <?php for($i = 0; $i < $item->rating; $i++):?>
                                                                <i class="fa fa-star"></i>
                                                            <?php endfor;?>
                                                        </div>
                                                        <br>
                                                        <p><?php echo $item->review;?><p>
                                                            <hr></hr>
                                                        <?php endforeach;?>
                                                        <?php else:?>
                                                            <h2>Be the first to review this product!</h2>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                                <?php if(!Yii::$app->user->isGuest):?>
                                                    <div role="tabpanel" class="tab-pane fade" id="submitreview">
                                                        <?php $form = ActiveForm::begin(['action' => Url::to('/product/review'),'method' => 'post','id' => 'i-recaptcha']);?>
                                                      <div class="submit-review">
                                                        <div class="rating-chooser">
                                                            <p>Your rating</p>

                                                            <div class="rating-wrap-post">
                                                                <i class="fa fa-star" id="star1"></i>
                                                                <i class="fa fa-star" id="star2"></i>
                                                                <i class="fa fa-star" id="star3"></i>
                                                                <i class="fa fa-star" id="star4"></i>
                                                                <i class="fa fa-star" id="star5"></i>
                                                            </div>
                                                            <?= $form->field($model, 'rating')->hiddenInput(['value' => 5,'id' => 'star'])->label(false); ?>
                                                            <?= $form->field($model, 'product')->hiddenInput(['value' => $product->id])->label(false); ?>
                                                        </div>
                                                        <p><label for="review">Your review</label>
                                                            <?= $form->field($model, 'review')->textarea(['style' => 'resize:none;','cols'=> 30, 'rows' => 10])->label(false); ?>
                                                            <p>
                                                                <button type="submit" class="g-recaptcha" data-sitekey="6LcY5V4UAAAAAEeHvBKnlHRcm-y7-sjOlN-RETA4" data-callback="onSubmit">Submit
                                                                </button></p>
                                                        </div>
                                                        <?php ActiveForm::end();?>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="related-products-wrapper">
                                <h2 class="related-products-title">Related Products</h2>
                                <div class="related-products-carousel">
                                    <?php foreach($related as $item):?>
                                        <div class="single-product">
                                            <div class="product-f-image">
                                                <img src="<?php echo Url::to('@cdn/'.$item->picture_thumbnail);?>" alt="<?php echo $product->name;?>">
                                                <div class="product-hover">
                                                    <a href="<?php echo URL::to('/cart/add/'.$item->id);?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                    <a href="<?php echo Url::to('/product/'.$item->slug);?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                                </div>
                                            </div>

                                            <h2><a href=""><?php echo $item->name;?></a></h2>

                                            <div class="product-carousel-price">
                                                <ins><?php echo 'Rp. '. number_format($item->price);?></ins>
                                            </div> 
                                        </div>

                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <script src="https://www.google.com/recaptcha/api.js?render=6LcY5V4UAAAAAEeHvBKnlHRcm-y7-sjOlN-RETA4"></script>
        <script>
            function onSubmit(token){
                document.getElementById("i-recaptcha").submit();
            }
        </script>
        <script>
          grecaptcha.ready(function() {
            console.log('ready here');
            grecaptcha.execute('6LcY5V4UAAAAAEeHvBKnlHRcm-y7-sjOlN-RETA4', {action: 'homepage'}).then(function(token) {

            });
        });
    </script>