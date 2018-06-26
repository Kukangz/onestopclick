<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView; 
use backend\models\activerecord\Permission;
use backend\components\SearchWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\activerecord\FeatureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Features';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feature-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
		<p>
			<?= Html::a('Create Feature', ['/feature/create'], ['class' => 'btn btn-primary pull-right']) ?>
		</p>.
	<?php endif;
	echo SearchWidget::widget(
		['field' => 
		['feature' => 
		[
			'name' => 'keyword', 'value' => $keyword,'placeholder' => 'Find Feature','class' => 'form-control'
		],'slug' => $slug,

		//'parent' => ['source' => \common\models\Product::find()->where(['status' => 1])->all(),'class' => 'form-control','value' => $parent]
	], 'status' => backend\components\CMS::StatusWidget()
]

);
?>

<table class="table table-responsive">
	<thead>
		<th>#</th>
		<th>Name</th>
		<th>Slug</th>
		<!-- <th>Icon</th> -->
		<th>Action</th>
	</thead>

	<?php 
	foreach($dataProvider as $item):?>
		<tr>
			<td><?php echo $item->id;?></td>
			<td><?php echo $item->name;?></td>
			<td><?php echo $item->slug;?></td>
			<!-- <td><i class="material-icons"><?php echo $item->icon;?></i></td> -->
			<td>

				<?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
					<a href="<?php echo Url::to('/feature/update/?id='.$item->id);?>" class="btn btn-warning btn-xs btn-round" title="Edit Feature" rel="tooltip">
						<i class="fa fa-edit"></i>
						<div class="ripple-container"></div>
					</a>
					<a href="<?php echo Url::to('/feature/delete/?id='.$item->id);?>" class="btn btn-primary btn-xs btn-round" title="Delete Feature" rel="tooltip">
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
