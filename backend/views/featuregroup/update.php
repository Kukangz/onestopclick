<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\activerecord\BackendFeatureGroup */

$this->title = 'Feature Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Backend Feature Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="backend-feature-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
