<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div  class="col-sm-12">
				<h2>Payment Detail</h2>
				<h3 class="pull-right">Payment Date : <?php echo date('d-m-Y H:i:s',strtotime($header->create_at));?></h3>
				<table class="shop_table cart">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Amount</th>							
							<th>Price</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php $discount = 0;$total = $i=0;foreach($detail as $item): $i++;?>
						<tr>
							<td><?php echo $i;?>.</td>
							<td>
								<?php $detail = json_decode($item->product_detail);?>
								<h3><?php echo $detail->name;?></h3>
								<img src="<?php echo yii\Helpers\Url::to('@cdn'.$detail->thumbnail);?>"/>
							</td>
							<td>1</td>
							<td><?php echo number_format($item->price_net);?></td>
							<td><?php echo number_format($item->price_net);?></td>
						</tr>
						<?php $total += $item->price_net;?>
					<?php endforeach;?>
					<tr>
						<td colspan="4">Subtotal</td>
						<td><?php echo  number_format($total);?></td>
					</tr>
					<tr>
						<td colspan="4">Discount</td>
						<td><?php echo  number_format(0);?></td>
					</tr>

					<tr>
						<td colspan="4">Total</td>
						<td><?php echo  number_format($total);?></td>
					</tr>
				</tbody>
			</table>


		</div>
		<div class="clearfix"></div>
	</div>
</div>
</div> 