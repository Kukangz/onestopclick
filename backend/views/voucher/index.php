<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView; 
use backend\models\activerecord\Permission;
use backend\components\CMS;

$this->title = 'Voucher';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voucher-index">

 <h1><?= Html::encode($this->title) ?></h1>
 <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
     <p>
        <?= Html::a('Create Voucher', ['/voucher/create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
<?php endif;?>

<?php 
echo backend\components\SearchWidget::widget(
    [
        'action'=> Url::to('/voucher'),
        'field' => 
        [
            'name' => [
               'name' => 'name','placeholder' => 'Find voucher name','class' => 'form-control'
           ],'code' => [
               'name' => 'code','placeholder' => 'Find voucher code..','class' => 'form-control'
           ],
           'type' => [
            'is_dropdown' => true,
            'name' => 'type',
            'item' => CMS::voucher_type(),
            'class' => 'form-control'
        ],
        'discount' => [
            'is_dropdown' => true,
            'name' => 'discount_type',
            'value' => Yii::$app->request->get('discount_type'),
            'placeholder' => 'Select Discount Type',
            'item' => CMS::discount_type(),
            'class' => 'form-control'
        ]
    ], 'status' => true
]
);?>

<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Type</th>
        <th>Name</th>
        <th>Voucher Detail</th>
        <th>Discount Type</th>
        <th>Code</th>
        <th>Status</th>
        <th>Action</th>
    </thead>

    <?php 
    foreach($dataProvider as $item):?>
        <tr>
            <td><?php echo $item->id;?></td>
            <th><?php echo CMS::get_voucher_type($item->type);?></th>
            <td><?php echo $item->name;?></td>
            <td>
                <?php if($item->type == CMS::VOUCHER_COUNTERBASED):?>
                    <strong>Voucher Counter : <?php echo $item->counter;?></strong><br>
                    <strong>Voucher Status : <?php echo ($item->counter < 1)?'Expired' :'Available' ;?></strong>
                    <?php elseif ($item->type == CMS::VOUCHER_ONETIMEUSAGE):?>
                        <strong>Voucher Status : <?php echo ($item->status == '1')?'Available':'Expired';?></strong>
                        <?php elseif ($item->type == CMS::VOUCHER_TIMELINE):?>
                            <strong>
                                Start : <?php echo date('Y-m-d H:i:s',strtotime($item->campaign_start));?><br>
                                End : <?php echo date('Y-m-d H:i:s',strtotime($item->campaign_end));?><br>
                                Voucher Status : <?php if(strtotime(date('Y-m-d H:i:s')) > strtotime($item->campaign_end)):?>
                                Expired
                                <?php else:?>
                                    Expired

                                    <?php endif;?></strong>
                                <?php endif;?>
                            </td>
                            <td><?php echo CMS::getDiscountType($item->discount_type);?></td>
                            <td><?php echo $item->code;?></td>
                            <td><?php echo CMS::getStatus($item->status);?></td>
                            <td>

                                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                                    <a href="<?php echo Url::to('/voucher/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Voucher" rel="tooltip">
                                        <i class="fa fa-edit"></i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    <a href="<?php echo Url::to('/voucher/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Voucher" rel="tooltip">
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