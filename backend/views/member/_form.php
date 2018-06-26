<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 user-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput() ?>
	<?= $form->field($model, 'address')->textInput() ?>
	<?= $form->field($model, 'email')->textInput() ?>
	<?= $form->field($model, 'social_media_type')->textInput() ?>
	<?= $form->field($model, 'social_media_id')->textInput() ?>
	<?= $form->field($model, 'status')->dropdownList(CMS::Status()) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/user/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
