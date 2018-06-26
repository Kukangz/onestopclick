<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\activerecord\PromotedProduct */

$this->title = 'Update Promoted Product: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promoted Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promoted-product-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product_item' => $product_item
    ]) ?>

</div>
