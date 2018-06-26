<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use backend\models\activerecord\Permission;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Yii2 view file
use backend\votewidget\VoteWidget;
$fakedModel = (object)['title'=> 'A Product', 'image' => 'http://placehold.it/350x150'];
?>

<?= VoteWidget::widget() ?> 

<?php 
$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
        <p>
            <?= Html::a('Create Product', ['/product/create'], ['class' => 'btn btn-primary pull-right']) ?>
        </p> 
    <?php endif;?>
    <?php 
    echo backend\components\SearchWidget::widget(
        [
            'action'=> Url::to('/product'),
            'field' => 
            [
                'pid' => [
                   'name' => 'PID','placeholder' => 'Find PID','class' => 'form-control'
               ],'name' => [
                   'name' => 'name','placeholder' => 'Find name..','class' => 'form-control'
               ],
               'category' => ['is_widget' => true, 'clearfix' => false,'widget_content' => kartik\typeahead\Typeahead::widget([
                   'name' => 'category',
                   'value' => Yii::$app->request->get('category'),
                   'id' => 'category_dropdown',
                   'options' => ['placeholder' => 'Filter category as you type ...'],
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
                   ]])],
               'brand' => ['is_widget' => true, 'clearfix' => false,'widget_content' => kartik\typeahead\Typeahead::widget([
                   'name' => 'brand',
                   'value' => Yii::$app->request->get('brand'),
                   'id' => 'brand_dropdown',
                   'options' => ['placeholder' => 'Filter brand as you type ...'],
                   'pluginOptions' => ['highlight'=>true],
                   'dataset' => [
                       [
                           'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                           'display' => 'name',
                           'prefetch' => Url::to('/api/brand', true),
                           'remote' => [
                               'url' => Url::to('/api/brand', true). '?keyword=%QUERY',
                               'wildcard' => '%QUERY',
                               'ajax' => ['type' => "GET"]
                           ]
                       ]
                   ]])],
               
           ], 'status' => true
       ]

   );?>

   <div class="clearfix">&nbsp;</div>
   <table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Product</th>
        <th>Description</th>
        <th>Price</th>
        <th>Created at</th>
        <th>Flag Headline</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php 
        foreach($dataProvider as $item):?>
            <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo $item->name;?></td>
                <td><img src="<?php echo Url::to('@cdn/'.$item->picture_thumbnail);?>"/></td>
                <td><?php echo $item->description;?></td>
                <td><?php echo number_format($item->price);?></td>
                <td><?php echo $item->created_at;?></td>
                <?php if($item->flag_headline == 0):
                    $flag = 1;
                else:
                    $flag = 0;
                endif;?>
                <td><?php echo (!$flag)?'Headline<br>':'';?><a href="<?php echo Url::to('/product/setheadline/?id='.$item->id.'&flag='.$flag);?>" class="btn btn-info btn-xs btn-round" title="Flag Headline" rel="tooltip">
                    <i class="fas fa-toggle-on"></i>
                    <div class="ripple-container"></div>
                </a>
            </td>
            <td>

                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                    <a href="<?php echo Url::to('/product/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Product" rel="tooltip">
                        <i class="fa fa-pencil-square-o"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="<?php echo Url::to('/product/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Product" rel="tooltip">
                        <i class="fa fa-window-close"></i>
                        <div class="ripple-container"></div>
                    </a>


                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;
    ?>
</tbody>
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
