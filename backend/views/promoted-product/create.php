<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\activerecord\PromotedProduct */

$this->title = 'Create Promoted Product';
$this->params['breadcrumbs'][] = ['label' => 'Promoted Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promoted-product-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
