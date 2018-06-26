<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\activerecord\Permission;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    <?= '<?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>';?>
    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <?= "<?php endif;?>";?>


    <table class="table table-responsive">
        <thead>
            <?php
            $count = 0;
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    if (++$count < 6) {
                        echo "<th>".$name."</th>";
                    } else {
                        echo "//" . $name;
                    }
                }
            } else {
                foreach ($tableSchema->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    if (++$count < 6) {
                        echo "<th>".$column->name."</th>";
                    } else {
                        echo "<th>".$column->name."</th>";
                    }
                }
            }
            ?> 
        </thead>
        <tbody>
            <td>
                <?= '<?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>';?>
                <a href="#" class="btn btn-warning btn-xs btn-round" title="Edit Sub-Category" rel="tooltip">
                    <i class="fa fa-edit"></i>
                    <div class="ripple-container"></div>
                </a>
                <a href="#" class="btn btn-primary btn-xs btn-round" title="Delete Sub-Category" rel="tooltip">
                    <i class="fa fa-window-close"></i>
                    <div class="ripple-container"></div>
                </a>
                <?= "<?php endif;?>";?>
            </td>
        </tbody>
    </table>
</div>
