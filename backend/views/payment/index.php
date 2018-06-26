<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView; 
use backend\models\activerecord\Permission;
use backend\components\SearchWidget;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\jui\AutoComplete;
use kartik\typeahead\Typeahead;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\activerecord\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php 
	echo SearchWidget::widget(
		['field' => 
		[
			'range' => ['is_widget' => true,'clearfix' => true,'widget_content' => '<div class="input-group col-md-12"><div class="row"><label class="form-label">Payment Date Range</label>'.
			DateRangePicker::widget([
				'name'=>'date_range',
				'id' => 'rangepicker',
			// 'placeholder' => 'Select Payment Date Range',
			// 'value'=>'01-Jan-14 to 20-Feb-14',
				'convertFormat'=>true,
				'useWithAddon'=>true,
				'presetDropdown'=>true,
				'pluginOptions'=>[
					'locale'=>[
						'format'=>'Y-m-d',
						'separator'=>' to ',
					],
					'opens'=>'left'
				]
			]).'</div></div>'], 
			// 'payment' => ['is_widget' => true, 'widget_content' => backend\components\CMS::paymentWidget()],
			// 'autocomplete' => ['is_widget' => true, 'clearfix' => true,'widget_content' => Typeahead::widget([
			// 	'name' => 'product',
			// 	'id' => 'autocompleted',
			// 	'options' => ['placeholder' => 'Filter as you type ...'],
			// 	'pluginOptions' => ['highlight'=>true],
			// 	'dataset' => [
			// 		[
			// 			'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
			// 			'display' => 'name',
			// 			'prefetch' => Url::to('/payment/ajaxp', true),
			// 			'remote' => [
			// 				'url' => Url::to('/payment/ajaxp', true). '?keyword=%QUERY',
			// 				'wildcard' => '%QUERY',
			// 				'ajax' => ['type' => "POST"]
			// 			]
			// 		]
			// 	]])]
		// 	'news' => 
		// 	[
		// 		'name' => 'keyword', 'value' => '','placeholder' => 'Find News','class' => 'form-control'
		// 	],
		// 	'parent' => ['source' => \common\models\Product::find()->where(['status' => 1])->all(),'class' => 'form-control','value' => '']
		// ], 'status' => backend\components\CMS::StatusWidget()
		]]

	);

	$gridColumns = [
		['class' => 'kartik\grid\SerialColumn'],
		'id',
		'create_at',
		'user_detail',
		'voucher_detail',
		'payment_type',
		'payment_code',
		'payer_id',
		'token',
	];?>

	<?php if($dataProvider):?>
		<div class="pull-right">
			<?php echo kartik\export\ExportMenu::widget([
				'dataProvider' => $export,
				'columns' => $gridColumns,
				'fontAwesome' => true,
			]);
			?>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>





		<?php 
		$labels = $data = [];
		foreach($chartdata as $item):?>
			<?php $labels[] = date('d-m-Y', strtotime($item->create_at));?>
			<?php $data[] = $item->counter;?>
		<?php endforeach;?>
		<div class="col-md-4 col-sm-12">
			<?= ChartJs::widget([
				'type' => 'line',
				'id' => 'chart',
				'options' => [
					'height' => 400,
					'width' => 400
				],
				'data' => [
					'labels' => $labels,
					'datasets' => [
						[
							'label' => "Selling",
							'backgroundColor' => "rgba(179,181,198,0.2)",
							'borderColor' => "rgba(179,181,198,1)",
							'pointBackgroundColor' => "rgba(179,181,198,1)",
							'pointBorderColor' => "#fff",
							'pointHoverBackgroundColor' => "#fff",
							'pointHoverBorderColor' => "rgba(179,181,198,1)",
							'data' => $data
						],
					]
				]
			]);
			?>
		</div>
		<div class="col-md-8">
			<table class="table table-responsive">
				<thead>
					<th>#</th>
					<th>Create At</th>
					<th>Buyer</th>
					<th>Voucher Used</th>
					<th>Transaction Type</th>
					<th>Action</th>
				</thead>

				<?php 
				foreach($dataProvider as $item):?>
					<tr>
						<td><?php echo $item->id;?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($item->create_at));?></td>
						<td><?php echo var_dump(json_decode($item->user_detail));?></td>
						<td><?php echo var_dump(json_decode($item->voucher_detail));?></td>
						<td><?php echo backend\components\CMS::getPaymentType($item->payment_type);?></td>
						<td>
							<?php if(YII::$app->cms->check_permission(Permission::FULL_ACCESS)):?>
								<a href="#" class="btn btn-warning btn-xs btn-round viewpayment" data-toggle="modal" data-target="#w0" data-id="<?php echo $item->id;?>" title="View Payment" rel="tooltip">
									<i class="fa fa-edit"></i>
									<div class="ripple-container"></div>
								</a>
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach;
				?>
			</table>
		</div>

	<?php endif;?>
	<?php 

	Modal::begin([
		'header' => '<h2>Hello world</h2>',
	]);

	echo 'Say hello...';

	Modal::end();

	if($dataProvider):
    // display pagination
		echo yii\widgets\LinkPager::widget([
			'pagination' => $pages,
			'options' => [
				'class' => 'pagination pull-right',
			],
		]);

	endif;

	$script = "$('.viewpayment').on('click', function(e) {send_ajax($(this).data('id'));});";
	$this->registerJs($script);

	?>
	<script>
		function send_ajax(id){
			$.ajax({
				url: "<?php echo \Yii::$app->getUrlManager()->createUrl('payment/ajaxpay') ?>",
				data: {data: id},
				method: 'post',
				success: function(data) {
				// alert(data)
			}
		});
		}
	</script>

</div>
