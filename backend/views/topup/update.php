<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\topup */

$this->title = 'Update Topup: ' . $model->transaction_code;
$this->params['breadcrumbs'][] = ['label' => 'Topups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transaction_code, 'url' => ['view', 'id' => $model->transaction_code]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="topup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
