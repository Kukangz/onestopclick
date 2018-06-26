<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $model common\models\activerecord\Voucher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 voucher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropdownList(CMS::voucher_type()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'counter')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'discount_type')->dropdownList(CMS::voucher_type()) ?>

    <?= $form->field($model, 'discount_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(CMS::status()) ?>

    <?= $form->field($model, 'start_at')->textInput() ?>

    <?= $form->field($model, 'end_at')->textInput() ?>

    <?= $form->field($model, 'member_only')->dropdownList([1 => 'Member Only', 0 => 'Any User']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Back',Url::to('/voucher/'), ['class' => 'btn btn-primary']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
