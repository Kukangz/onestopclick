<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\activerecord\Permission;
use yii\widgets\LinkPager;
use backend\components\SearchWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
        <p>
         <?= Html::a('Create Category', ['/category/create'], ['class' => 'btn btn-primary pull-right']) ?>
     </p>
 <?php endif;?>

 <?php 
 echo SearchWidget::widget(
    [
        'action'=> Url::to('/category'),
        'field' => 
        ['name' => [
         'name' => 'name', 'value' => $name,'placeholder' => 'Find category..','class' => 'form-control'
     ],
     'slug' => ['name' => 'slug', 'value' => $slug,'placeholder' => 'Find slug..','class' => 'form-control']
 ], 'status' => true
]

);?>

<div class="clearfix">&nbsp;</div>
<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Description</th>
        <th>Action</th>
    </thead>

    <?php 
    foreach($dataProvider as $item):?>
        <tr>
            <td><?php echo $item->id;?></td>
            <td><?php echo $item->name;?></td>
            <td><?php echo $item->slug;?></td>
            <td><?php echo $item->description;?></td>
            <td>
                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                    <a href="<?php echo Url::to('/category/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Category" rel="tooltip">
                        <i class="fa fa-edit"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="<?php echo Url::to('/category/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Category" rel="tooltip">
                        <i class="fa fa-window-close"></i>
                        <div class="ripple-container"></div>
                    </a>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;
    ?>
</table>

<?php 
    // display pagination
echo LinkPager::widget([
    'pagination' => $pages,
    'options' => [
        'class' => 'pagination pull-right',
    ],
]);
?>
</div>
