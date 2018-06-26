<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\activerecord\BackendFeatureGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 backend-feature-group-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->dropdownList([Category::STATUS_ACTIVE => 'Active', Category::STATUS_INACTIVE => 'Inactive']) ?>

	<?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/featuregroup/'), ['class' => 'btn btn-primary']);?>
		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
