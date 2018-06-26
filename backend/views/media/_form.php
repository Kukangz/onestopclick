<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Media */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'is_embed')->dropdownList([1 => 'Embed', 0 => 'Not Embed']) ?> 

    <?= $form->field($model, 'media_type')->dropdownList([1 => 'Image', 2 => 'Video', 3 => 'Apps']) ?>
    
    <?= $form->field($model, 'embed_tag')->textArea() ?>

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true,'id' => 'uploadbtn']) ?>

    <?= Html::img('http://via.placeholder.com/500x500',['alt' => 'Image placeholder','id' => 'picture']);?>

    <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'external_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
</div>

<div class="col-md-8 media-form">

    <?php if($model->image_thumbnail):?>

        <?= Html::img($model->image_thumbnail,['alt' => 'Image Thumbnail']);?>

    <?php endif;?>

    <?php if($model->image_portrait):?>

        <?= Html::img($model->image_portrait,['alt' => 'Image Portrait']);?>

    <?php endif;?>

    <?php if($model->image_secondary):?>

        <?= Html::img($model->image_secondary,['alt' => 'Image Secondary']);?>

    <?php endif;?>

    <?php if($model->is_embed && $model->embed_tag):?>

        <iframe src="<?= $model->embed_tag;?>"></iframe>

    <?php endif;?>







    <?php ActiveForm::end(); ?>

</div>
