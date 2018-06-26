<?php

use yii\helpers\Html;
use yii\widgets\activeForm;
use yii\helpers\ArrayHelper;
use common\models\Product;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = "Product ". $model->name;
?>
<div class="col-md-12">
	<div class="row">

		<h1><?= Html::encode($this->title) ?></h1>


		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<div class="col-md-4 product-form">

			<?= $form->field($model, 'PID')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'category', ['inputOptions' => [
				'class' => 'selectpicker '
			]])->dropDownList($category_items, ['prompt' => 'Select Category', 'class'=>'form-control required']); ?>

			<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'brand')->dropdownList(ArrayHelper::map($brand_items, 'id', 'name')); ?>

			<?= $form->field($model, 'status')->dropdownList([Product::STATUS_ACTIVE => 'Active', Product::STATUS_INACTIVE => 'Inactive']) ?>

			<?= Html::a('Back',Url::to('/product/'), ['class' => 'btn btn-primary']);?>
			<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
		</div>

		<div class="col-md-4 product-form">
			<div class="form-group">
				<?php echo $form->field($model, 'picture')->label('Product Image')->fileInput(['id' => 'uploadbtn']);?>
				<?=Html::img(
					($model->picture) ? Url::to('@cdn'.$model->picture) : 'http://via.placeholder.com/500x500',
					['id'=> 'picture','style' => 'width:100%;']);?>
					

				</div>
				<div class="form-group">
					<?php echo $form->field($model, 'product_download_link')->label('Product Media')->fileInput(['style' => 'top:50px; opacity: 1;']);?>
					<?php if($model->product_download_link):?>
						<br><br>
						<a target="_blank" href="<?php echo Url::to('@cdn'.$model->product_download_link);?>">Present Product Link</a>
					<?php endif;?>
				</div>
			</div>

			<div class="col-md-4 product-form">
				<?= $form->field($model, 'embed_video')->textInput(['maxlength' => true]) ?>
				<button class="btn btn-primary pull-right" id="embed_video">Check Embed Video</button>
				<div class="clearfix"></div>
				<div id="video" style="display:block; width:100%;overflow: hidden;"><?php echo $model->embed_video;?></div>
				<?= $form->field($model, 'embed_music_player')->textInput(['maxlength' => true]) ?>
				<button class="btn btn-primary pull-right" id="embed_music">Check Music Player</button>
				<div class="clearfix" ></div>
				<div id="music" style="display:block; width:100%;overflow: hidden;"><?php echo $model->embed_music_player;?></div>
				<?= $form->field($model, 'official_site')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
			</div>
			<?php ActiveForm::end(); ?>

		</div>
	</div>
