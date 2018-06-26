<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use backend\models\activerecord\Permission;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promoted Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promoted-product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
        <p>
            <?= Html::a('Create Promoted Product', ['/promoted-product/create'], ['class' => 'btn btn-primary pull-right']) ?>
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
 <br>
 <table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Start At</th>
        <th>End At</th>
        <th>Description</th>            
        <th>Created at</th>
        <th>Updated At</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php 
        foreach($dataProvider as $item):?>
            <tr>
                <td><?php echo $item->id;?></td>
                <th><?php echo date('d-m-Y',strtotime($item->start_date));?></th>
                <th><?php echo date('d-m-Y',strtotime($item->end_date));?></th>
                <td><?php echo $item->description;?></td>
                <td><?php echo date('d-m-Y H:i:s',strtotime($item->created_at));?></td>
                <td><?php echo date('d-m-Y H:i:s',strtotime($item->updated_at));?></td>
                <td>

                    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                        <a href="<?php echo Url::to('/promoted-product/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="" rel="tooltip" data-original-title="Edit Promoted Product">
                            <i class="fa fa-edit"></i>
                            <div class="ripple-container"></div>
                        </a>
                        <a href="<?php echo Url::to('/promoted-product/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Promoted Product" rel="tooltip">
                            <i class="fa fa-window-close"></i>
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
