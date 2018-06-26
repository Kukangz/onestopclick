<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\topup */

$this->title = 'Create Topup';
$this->params['breadcrumbs'][] = ['label' => 'Topups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
