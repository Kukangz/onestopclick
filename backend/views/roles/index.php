<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\models\activerecord\Permission;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RolesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Roles', ['/roles/create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="<?php echo Url::to('');?>">
                    <div class="col-md-3">
                        <div class="form-group is-empty"><input type="text" name="keyword" class="form-control" placeholder="Find roles..." value="" id="keyword"><span class="material-input"></span></div>
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
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </thead>

        <?php 
        foreach($dataProvider as $item):?>
            <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo $item->name;?></td>
                <td><?php echo $item->description;?></td>
                <td>
                    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                        <a href="<?php echo Url::to('/roles/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Roles" rel="tooltip">
                            <i class="fa fa-edit"></i>
                            <div class="ripple-container"></div>
                        </a>
                        <a href="<?php echo Url::to('/roles/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Roles" rel="tooltip">
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
