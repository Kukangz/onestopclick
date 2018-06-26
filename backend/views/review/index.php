<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url; 
use backend\models\activerecord\Permission;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-review-index">

   <h1><?= Html::encode($this->title) ?></h1>
   <?php 
   echo backend\components\SearchWidget::widget(
    [
        'action'=> Url::to('/review'),
        'field' => 
        [
            'user' => [
                'name' => 'user','placeholder' => 'Find User','class' => 'form-control'
            ],
            'product' => ['is_widget' => true, 'clearfix' => false,'widget_content' => kartik\typeahead\Typeahead::widget([
                'name' => 'product',
               'value' => Yii::$app->request->get('product'),
               'id' => 'product_dropdown',
               'options' => ['placeholder' => 'Filter product as you type ...'],
               'pluginOptions' => ['highlight'=>true],
               'dataset' => [
                   [
                       'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                       'display' => 'name',
                       'prefetch' => Url::to('/api/product', true),
                       'remote' => [
                           'url' => Url::to('/api/product', true). '?keyword=%QUERY',
                           'wildcard' => '%QUERY',
                           'ajax' => ['type' => "GET"]
                       ]
                   ]
               ]])],
            'rating' => ['is_dropdown' => true, 'item' => [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5]],
        ], 'status' => true,
        'status_field' => CMS::statusReview()
    ]

);?>
<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>User</th>
        <th>Product</th>
        <th>Review</th>
        <th>Rating</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <?php 
    foreach($dataProvider as $item):?>
        <tr>
            <td><?php echo $item->id;?></td>
            <td><?php echo $item->name;?></td>
            <td><?php echo $item->product_name;?></td>
            <td><?php echo $item->review;?></td>
            <td><?php echo $item->rating;?></td>
            <td><?php echo CMS::getStatusReview($item->status);?></td>
            <td>
                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>

                    <?php if($item->status == 0):?>
                        <a href="<?php echo Url::to('/review/accept/?id='.$item->id);?>" class="btn btn-success btn-xs btn-round" title="Accept review" rel="tooltip">
                            <i class="fas fa-check"></i>
                            <div class="ripple-container"></div>
                        </a>
                        <a href="<?php echo Url::to('/review/delete/?id='.$item->id);?>" class="btn btn-danger btn-xs btn-round" title="Delete review" rel="tooltip">
                            <i class="fas fa-trash"></i>
                            <div class="ripple-container"></div>
                        </a>
                    <?php endif;?>
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
