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
					<h2>Your payment is complete<br> Now you can go to your <strong><a href="<?php echo Url::to(['/member','#'=>'downloads']);?>"> Download Page </a></strong>to get your content.</h2>
				</div>
			</div>
		</div>
	</div>
</div>