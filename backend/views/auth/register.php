<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\activerecord\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="card-content signup-padding">
    <h4 class="card-title">Register</h4>
    <?php 
    $form = ActiveForm::begin(['action' => ['/auth/register']]); ?>

        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'repeat_password')->passwordInput() ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'address') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- auth -->
