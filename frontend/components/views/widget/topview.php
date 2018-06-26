<?php use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="single-product-widget">
	<h2 class="product-wid-title">Top Downloads</h2>
	<?php foreach($data as $item):?>
		<div class="single-wid-product">
			<a href="<?php echo Url::to('/product/'.$item->slug);?>"> <?php echo Html::img('@cdn/'.$item->picture_thumbnail, ['class' => 'product-thumb']);?> </a>
			<h2>Downloaded <?php echo $item->product_view;?> Times</h2>
			<div class="product-wid-rating">
				<h3><a href="<?php echo Url::to('/product/'.$item->slug);?>"><?php echo $item->name;?></a></h3>

			</div>
			<div class="product-wid-price">
				<ins><?php echo 'Rp. '. number_format($item->price);?></ins>
			</div>                                 
		</div>
	<?php endforeach;?>
</div>