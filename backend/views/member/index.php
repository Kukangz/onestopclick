<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\CMS;
use backend\models\activerecord\Permission;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    echo backend\components\SearchWidget::widget(
        [
            'action'=> Url::to('/member'),
            'field' => 
            ['name' => [
               'name' => 'name','placeholder' => 'Find name..','class' => 'form-control'
           ],
           'address' => ['name' => 'address', 'placeholder' => 'Find address..','class' => 'form-control'],
           'email' => ['name' => 'email', 'placeholder' => 'Find email..','class' => 'form-control'],
       ], 'status' => true
   ]

);?>
<table class="table table-responsive">
    <thead>
        <th>#</th>
        <th>name</th>
        <th>address</th>
        <th>email</th>
        <th>balance</th>
        <th>Status</th> 
        <th>Action</th> 
    </thead>
    <tbody>
        <?php $i =0;foreach($dataProvider as $item):$i++;?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $item->name;?></td>
            <td><?php echo $item->address;?></td>
            <td><?php echo $item->email;?></td>
            <td><?php echo $item->balance;?></td>
            <td><?php echo CMS::getStatus($item->status);?></td>

            <td>
                <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                    <a href="<?php echo Url::to('/member/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Sub-Category" rel="tooltip">
                        <i class="fa fa-edit"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="<?php echo Url::to('/member/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Sub-Category" rel="tooltip">
                        <i class="fa fa-window-close"></i>
                        <div class="ripple-container"></div>
                    </a>
                    <?php endif;?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
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
