<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Subcategory;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Subcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 subcategory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->dropdownList(ArrayHelper::map(Category::find()->where(['status' => 1])->all(),'id','name')); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList([Subcategory::STATUS_ACTIVE => 'Active', Subcategory::STATUS_INACTIVE => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/subcategory/'), ['class' => 'btn btn-primary']);?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
