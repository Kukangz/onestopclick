<?php 
use app\assets\SiteAsset;
use yii\helpers\Html;
use yii\helpers\Url;

?>



<div class="slider-area">
	<!-- Slider -->
	<div class="block-slider block-slider4">
		<ul class="" id="bxslider-home4">

			<?php foreach($headline as $item):?>
				<li>
					<a href="<?php echo Url::to('product/'.$item->slug);?>">
						<?php echo Html::img('@cdn/'.$item->picture_headline);?>
						<div class="caption-group">
							<h2 class="caption title">
								<?php echo $item->name;?></span>
							</h2>
							<h4 class="caption subtitle"><?php echo $item->synopsis;?></h4>
							<a class="caption button-radius" href="<?php echo Url::to('product/'.$item->slug);?>"><span class="icon"></span>Shop now</a>
						</div>
					</a>
				</li>
			<?php endforeach;?>
		</ul>
	</div>
	<!-- ./Slider -->
</div> <!-- End slider area -->

<div class="promo-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="single-promo promo1">
					<i class="fa fa-refresh"></i>
					<p>Fast Process</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="single-promo promo2">
					<i class="fa fa-download"></i>
					<p>Easy to Download</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="single-promo promo3">
					<i class="fa fa-lock"></i>
					<p>Secure Payments</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="single-promo promo4">
					<i class="fa fa-gift"></i>
					<p>New Products</p>
				</div>
			</div>
		</div>
	</div>
</div> <!-- End promo area -->

<div class="maincontent-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="latest-product">
					<h2 class="section-title">Latest Products</h2>
					<div class="product-carousel">
						<?php foreach($latest_product as $item):
							?>

							<div class="single-product">
								<div class="product-f-image">
									<?php if($item->picture_thumbnail):
										echo Html::img('@cdn/'.$item->picture_thumbnail);
									else:
										echo Html::img('@web/image/no-product-image.jpg');
									endif;?>
									<div class="product-hover">
										<a href="<?php echo Url::to('/cart/add/'.$item->id);?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
										<a href="<?php echo Url::to('/product/'.$item->slug);?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
									</div>
								</div>

								<h2><a href="<?php $item->slug;?>"><?php echo $item->name;?></a></h2>

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
</div> <!-- End main content area -->

<div class="product-widget-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="single-product-widget">
					<h2 class="product-wid-title">Top Views</h2>
					<?php foreach($top_view as $item):?>
						<div class="single-wid-product">
							<a href="<?php echo Url::to('/product/'.$item->slug);?>"> <?php echo Html::img('@cdn/'.$item->picture_thumbnail, ['class' => 'product-thumb']);?> </a>
							<h2>Viewed <?php echo $item->product_view;?> Times</h2>
							<div class="product-wid-rating">
								<h3><a href="<?php echo Url::to('/product/'.$item->slug);?>"><?php echo $item->name;?></a></h3>
								
							</div>
							<div class="product-wid-price">
								<ins><?php echo 'Rp. '. number_format($item->price);?></ins>
							</div>                            
						</div>
					<?php endforeach;?>
				</div>
			</div>
			<div class="col-md-6">
				<?php echo \frontend\components\TopdownloadWidget::widget();?>
			</div>
		</div>
	</div>
</div> <!-- End product widget area -->

