<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 brand-form">

    <?php $form = ActiveForm::begin(); ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropdownList(ArrayHelper::map(Category::find()->where(['status' => 1])->all(),'id','name')); ?>

    <?= $form->field($model, 'status')->dropdownList([Category::STATUS_ACTIVE => 'Active', Category::STATUS_INACTIVE => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/brand/'), ['class' => 'btn btn-primary']);?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
