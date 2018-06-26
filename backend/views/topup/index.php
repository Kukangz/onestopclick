<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView; 
use backend\models\activerecord\Permission;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topup-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <table class="table table-responsive">
        <thead>
            <th>Transaction Code</th>
            <th>User</th>
            <th>Payment Bank</th>
            <th>Amount</th>
            <th>Sender Name</th>
            <th>Status</th>
            <th>Action</th>
        </thead>

        <?php 
        foreach($dataProvider as $item):?>
            <tr>
                <td><?php echo $item->transaction_code;?></td>
                <td><?php echo $item->name;?></td>
                <th><?php echo CMS::getPaymentBank($item->payment_bank);?></th>
                <td><?php echo number_format($item->amount);?></td>
                <td><?php echo $item->sender_name;?></td>            
                <td><?php echo CMS::getStatusTopup($item->status);?></td>
                <td>

                    <?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
                        <?php if($item->status == 1):?>
                            <a href="<?php echo Url::to('/topup/accept/?id='.$item->transaction_code);?>" class="btn btn-warning btn-xs btn-round" title="Accept Payment" rel="tooltip">
                                <i class="fas fa-check"></i>
                                <div class="ripple-container"></div>
                            </a>
                            <a href="<?php echo Url::to('/topup/reject/?id='.$item->transaction_code);?>" class="btn btn-primary btn-xs btn-round" title="Reject Payment" rel="tooltip">
                                <i class="fa fa-window-close"></i>
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
