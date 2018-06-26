<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Product;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\topup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 topup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transaction_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
