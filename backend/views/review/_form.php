<?php

use yii\helpers\Html; 
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 product-review-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'rating')->textInput() ?>

	<?= $form->field($model, 'review')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'create_at')->textInput() ?>

	<?= $form->field($model, 'status')->textInput() ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/review/'), ['class' => 'btn btn-primary']);?>
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
