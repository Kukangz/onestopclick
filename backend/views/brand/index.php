<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\activerecord\Permission;
use yii\widgets\LinkPager;
use backend\components\SearchWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">
 <h1><?= Html::encode($this->title) ?></h1>
 <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
    <p>
       <?= Html::a('Create Brand', ['/brand/create'], ['class' => 'btn btn-primary pull-right']) ?>
   </p>
<?php endif;?>
<?php 
echo SearchWidget::widget(
    [
        'action'=> Url::to('/brand'),
        'field' => 
        ['name' => [
           'name' => 'name', 'value' => $name,'placeholder' => 'Find brand..','class' => 'form-control'
       ],
       'slug' => ['name' => 'slug', 'value' => $slug,'placeholder' => 'Find slug..','class' => 'form-control'],
       'category' => ['is_widget' => true, 'clearfix' => false,'widget_content' => \kartik\typeahead\Typeahead::widget([
           'name' => 'category',
           'id' => 'category_dropdown',
           'options' => ['placeholder' => 'Filter category as you type ...'],
           'value' => $category,
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
<div class="clearfix">&nbsp;</div>
<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Description</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
    </thead>

    <?php 
    foreach($dataProvider as $item):?>
        <tr>
            <td><?php echo $item->id;?></td>
            <td><?php echo $item->name;?></td>
            <td><?php echo $item->slug;?></td>
            <td><?php echo $item->description;?></td>
            <td><?php echo $item->category_name;?></td>
            <td><?php echo \backend\components\CMS::getStatus($item->status);?></td>
            <td>
                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                    <a href="<?php echo Url::to('/brand/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Brand" rel="tooltip">
                        <i class="fa fa-edit"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="<?php echo Url::to('/brand/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Brand" rel="tooltip">
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
echo yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'options' => [
        'class' => 'pagination pull-right',
    ],
]);
?>
</div>
