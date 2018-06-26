<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Media', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'media_type',
            'image',
            'image_portrait',
            //'image_secondary',
            //'image_thumbnail',
            //'video_url:url',
            //'is_embed',
            //'create_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php 
    // display pagination
    echo yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'options' => [
            'class' => 'pagination pull-right',
        ],
    ]);
    ?>
</div>
