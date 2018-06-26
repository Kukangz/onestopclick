<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\activerecord\Permission;
use yii\widgets\LinkPager;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $searchModel backend\controllers\SubcategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcategories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
        <p>
            <?= Html::a('Create Sub-Category', ['/subcategory/create'], ['class' => 'btn btn-primary pull-right']) ?>
        </p>
    <?php endif;?>

    <?php 
    echo backend\components\SearchWidget::widget(
        [
            'action'=> Url::to('/subcategory'),
            'field' => 
            ['name' => [
               'name' => 'name', 'value' => $name,'placeholder' => 'Find subcategory..','class' => 'form-control'
           ],
           'slug' => ['name' => 'slug', 'value' => $slug,'placeholder' => 'Find slug..','class' => 'form-control'],
           'parent' => ['is_widget' => true, 'clearfix' => false,'widget_content' => Typeahead::widget([
               'name' => 'parent',
               'id' => 'category_dropdown',
               'options' => ['placeholder' => 'Filter category as you type ...'],
               'value' => $parent,
               'pluginOptions' => ['highlight'=>true],
               'dataset' => [
                   [
                       'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                       'display' => 'name',
                       'prefetch' => Url::to('/subcategory/cajax', true),
                       'remote' => [
                           'url' => Url::to('/subcategory/cajax', true). '?keyword=%QUERY',
                           'wildcard' => '%QUERY',
                           'ajax' => ['type' => "GET"]
                       ]
                   ]
               ]])]
       ], 'status' => true
   ]

);?>


<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Parent Category</th>
        <th>Status</th>
        <th>Action</th>
    </thead>

    <?php 
    $i= 0;
    foreach($dataProvider as $item): $i++;?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $item->name;?></td>
            <td><?php echo $item->slug;?></td>
            <td><?php echo $item->Parent;?></td>
            <td><?php echo backend\components\CMS::getStatus($item->status);?></td>
            <td>
                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                    <a href="<?php echo Url::to('/subcategory/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Sub-Category" rel="tooltip">
                        <i class="fa fa-edit"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="<?php echo Url::to('/subcategory/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Sub-Category" rel="tooltip">
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
