<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\components\CMS;
?>

<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<h2>Welcome, <?= (Yii::$app->user->identity)?Yii::$app->user->identity->name:''; ?></h2>
			<hr>
			<div  class="col-sm-12">
				<div class="col-xs-2">
					<!-- required for floating -->
					<!-- Nav tabs -->
					<ul class="nav nav-tabs tabs-left">
						<li class="active"><a href="#home" data-toggle="tab">Home</a></li>
						<li><a href="#balance" data-toggle="tab">Balance</a></li>
						<li><a href="#purchase" data-toggle="tab">Purchase History</a></li>
						<li><a href="#downloads" data-toggle="tab">Available Downloads</a></li>
						<li><a href="#account" data-toggle="tab">Account</a></li>
						<li><a href="<?php echo Url::to('/auth/logout');?>" >Sign out</a></li>
					</ul>
				</div>
				<div class="col-xs-10">
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="home">

							<?php if($message):?>
								<div class="product-big-title-area">
									<div class="row">
										<div class="product-bit-title text-center">
											<h2><?php echo $message;?></h2>
										</div>
									</div>
								</div>
								<div class="clearfix">&nbsp;</div>
							<?php endif;?>

							<h1>Did you know?</h1>

							<h2>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>

							<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

							<h2>Header Level 2</h2>

							<ol>
								<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
								<li>Aliquam tincidunt mauris eu risus.</li>
							</ol>

							<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

							<h3>Header Level 3</h3>

							<ul>
								<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
								<li>Aliquam tincidunt mauris eu risus.</li>
							</ul>

							<pre><code>
								#header h1 a { 
								display: block; 
								width: 300px; 
								height: 80px; 
							}
						</code></pre></div>
						<div class="tab-pane" id="balance">
							<h1>Account Balance</h1>
							<h2>Balance : <?php echo (Yii::$app->user->identity)?number_format(Yii::$app->user->identity->balance):'';?> Rupiah</h2>
							<div class="clearfix"></div>
							<div class="col-md-6">
								<?php $form = ActiveForm::begin(['action' => '/member/top-up']);?>
								<?= $form->field($topup, 'amount')->textInput(['type' => 'number']); ?>
								<button type="submit" class="btn btn-primary pull-right">Top Up</button>
								<?php Activeform::end();?>
								<img src="<?php echo Url::to('@web/image/KK_AEONCard.png');?>"/>
							</div>
							<div class="col-md-6">
								<?php $form = ActiveForm::begin(['action' => '/member/confirm']);?>
								<?= $form->field($confirm, 'code')->textInput(); ?>
								<?= $form->field($confirm, 'transaction_date')->textInput(['class' => 'form-control datepicker']); ?>
								<?= $form->field($confirm, 'payment_bank')->dropDownList(CMS::paymentBank()); ?>
								<?= $form->field($confirm, 'sender_name')->textInput(); ?>
								<button type="submit"  class="btn btn-warning pull-right">Confirm Top up</button>
								<?php Activeform::end();?>
							</div>

							<div class="clearfix">&nbsp;</div>

							<h2>Top-Up History</h2>
							<table class="shop_table cart">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Code</th>
										<th>Amount</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0;foreach($list_topup as $item): $i++?>
									<tr>
										<td><?php echo $i;?></td>
										<td><?php echo $item->created_at;?></td>
										<th><?php echo $item->transaction_code;?></th>
										<td><?php echo number_format($item->amount);?></td>
										<td><?php echo \frontend\components\CMS::getStatusTopup($item->status);?></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="purchase">
						<h1>Purchase History</h1>
						<table class="shop_table cart">
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Payment Type</th>
									<th>Detail</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 0;foreach($payment as $item): $i++;?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo date('d-m-Y H:i:s', strtotime($item->create_at));?></td>
									<th><?php echo frontend\components\CMS::getPaymentType($item->payment_type);?></th>
									<td><a href="<?php echo Url::to('/member/transaction/'.$item->id);?>" target="_blank">View detail</a></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="downloads">

					<h1>Available Downloads</h1>
					<table class="shop_table cart">
						<thead>
							<tr>
								<th>#</th>
								<th>Product</th>
								<th>Download Link</th>
								<th>Download Limit</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; foreach($user_downloads as $item):$i++;?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $item->product_name;?></td>
									<td><a target="_blank" href="<?php echo Url::to(['/downloads/product','access_token' => $item->access_token]);?>"><?php echo $item->access_token;?></a></td>
									<th><?php echo $item->counter;?></th>
									<td><?php echo CMS::getDownloadStatus($item->status);?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="account">
					<h1>Account</h1>
					<?php $form = ActiveForm::begin(['action' => '/member']);?>
					<?= $form->field($updatepassword, 'old_password')->passwordInput(['value' => '']); ?>
					<?= $form->field($updatepassword, 'password')->passwordInput(['value' => '']); ?>
					<?= $form->field($updatepassword, 'password_repeat')->passwordInput(['value' => '']); ?>
					<button type="submit" class="btn">Update Password</button>
					<?php Activeform::end();?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>
</div>
<!-- /tabs -->
</div>
</div>
</div>
