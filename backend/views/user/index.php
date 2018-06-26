<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\activerecord\Permission;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BackendUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backend-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
        <p>
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
        </p>
    <?php endif;?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="<?php echo Url::to('');?>">
                    <div class="col-md-3">
                        <div class="form-group is-empty"><input type="text" name="keyword" class="form-control" placeholder="Find user..." value="" id="keyword"><span class="material-input"></span></div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12  text-right">
                        <a href="<?php echo Url::to('');?>" class="btn btn-sm btn-round btn-default" rel="tooltip" title="Reset Pencarian"><i class="fas fa-sync-alt"></i></a>
                        <button type="submit" class="btn btn-sm btn-round btn-primary" rel="tooltip" title="Cari"><i class="fas fa-search"></i></button>
                    </div>
                </form>                           
            </div> 
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <table class="table table-responsive">
        <thead>
            <th>#</th>
            <th>Email</th>
            <th>Name</th>
            <th>Action</th>
        </thead>

        <?php 
        foreach($dataProvider as $item):?>
            <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo $item->email;?></td>
                <td><?php echo $item->name;?></td>
                <td>

                    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                        <a href="<?php echo Url::to('/user/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit User" rel="tooltip">
                            <i class="fa fa-edit"></i>
                            <div class="ripple-container"></div>
                        </a>
                        <a href="<?php echo Url::to('/user/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete User" rel="tooltip">
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
