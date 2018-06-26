<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\activerecord\Roles;

/* @var $this yii\web\View */
/* @var $model backend\models\activerecord\BackendUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 backend-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roles')->dropdownList(ArrayHelper::map(Roles::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'status')->dropdownList([1 => 'Active', 0 => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/user/'), ['class' => 'btn btn-primary']);?>
       <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
