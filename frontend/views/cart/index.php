<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="single-sidebar">
					<h2 class="sidebar-title">Similiar Products</h2>
					<?php foreach($product_sidebar as $item):?>
						<div class="thubmnail-recent">
							<a href="<?php echo Url::to('/product/'.$item->slug);?>"><img src="<?php echo Url::to('@cdn/'.$item->picture_thumbnail);?>" class="recent-thumb" alt="<?php echo $item->name;?>"></a>
							<h2><a href="<?php echo Url::to('/product/'.$item->slug);?>"><?php echo $item->name;?></a></h2>
							<div class="product-sidebar-price">
								<ins><?php echo number_format($item->price);?></ins>
							</div>                             
						</div>
					<?php endforeach;?>
				</div>
			</div>

			<div class="col-md-8">
				<div class="product-content-right">
					<div class="woocommerce">
						
						<table cellspacing="0" class="shop_table cart">
							<thead>
								<tr>
									<th class="product-remove">&nbsp;</th>
									<th class="product-thumbnail">&nbsp;</th>
									<th class="product-name">Product</th>
									<th class="product-price">Price</th>
									
									<th class="product-subtotal">Total</th>
								</tr>
							</thead>
							<tbody>
								<div>
									

									<?php $subtotal = 0; 
									if($cart): 
										foreach($cart as $key => $item):?>
											<tr class="cart_item">
												<td class="product-remove">
													<a title="Remove this item" class="remove" href="<?php echo Url::to('/cart/delete/'.$key);?> ">×</a> 
												</td>

												<td class="product-thumbnail">
													<a href="<?php echo Url::to('/product/'.$item['slug']);?>"><img width="145" height="145" alt="<?php echo $item['name'];?>" class="shop_thumbnail" src="<?php echo Url::to('@cdn/'.$item['image']);?>"></a>
												</td>

												<td class="product-name">
													<a href="<?php echo Url::to('/product/'.$item['slug']);?>"><?php echo $item['name'];?></a> 
												</td>

												<td class="product-price">
													<span class="amount"><?php echo number_format($item['price']);?></span> 
												</td>

												<td class="product-subtotal">
													<span class="amount"><?php echo number_format($item['price'] * $item['qty'], 2);?></span> 
												</td>
											</tr>
											<?php $subtotal+= $item['price'] * $item['qty'];?>
										<?php endforeach;?>
										<?php else:?>
											<tr><td colspan="6">Please add item to cart first</td></tr>
										<?php endif;?>
										<tr class="cart-subtotal">
											<th colspan="4">Cart Subtotal</th>
											<td><span class="amount" data-subtotal="<?php echo $subtotal;?>" id="subtotal"><?php echo number_format($subtotal,2);?></span></td>
										</tr>
										<?php $discount = 0;
										if(!YII::$app->session->get('voucher')):
											?>
											
											<td class="actions" colspan="5">

												<div class="coupon pull-right">

													<form method="post" action="<?php echo Url::to('/cart/voucher');?>">
														<label for="coupon_code">Coupon:</label>
														<input type="text" placeholder="Voucher code" value="" id="coupon_code" class="input-text" name="voucher">
														<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
														<input type="submit" value="Apply Voucher" name="apply_coupon" class="button">
													</form>
													
												</div>
												<div class="clearfix">&nbsp;</div>
												
											</td>
											<?php else:?>

												<?php 
												$voucher = YII::$app->session->get('voucher');
												?>
												
												<tr>
													<td colspan="4">Voucher Code</th>
														<td><?php echo $voucher['code'];?> <a href="<?php echo Url::to(['/cart/vouchercancel']);?>">X</a></th>
														</tr>
														<tr class="cart-discount">
															<th colspan="4">Voucher Discount</th>
															<td><span class="amount" data-subtotal="<?php echo $subtotal;?>">
																<?php if($voucher['discount_type'] == 1):
																	$discount = (($subtotal / 100) * $voucher->discount_value);
																elseif($voucher['discount_type'] == 2):
																	$discount = $subtotal - $voucher->discount_value;
																endif;?> 
																<?php echo number_format($discount,2);?></span>

															</td>
														</tr>
													<?php endif;

													$total = $subtotal - $discount;?>
												</tr>
												<tr class="order-total">
													<th colspan="4">Order Total</th>
													<td><strong><span class="amount" data-total="<?php echo $subtotal - $discount;?>" id="total"><?php echo number_format($total,2);?></span></strong> </td>
												</tr>

												<tr>
													<td colspan="5">
														<div class="coupon pull-right">
															<form action="<?php echo Url::to('/checkout');?>" method="post">
																<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
																<input type="submit" value="Checkout" name="apply_coupon" class="button">
															</form>
														</div>
													</td>
												</tr>

											</div>
										</tbody>
									</table>


								</form>


							</div>
						</div>                        
					</div>                    
				</div>
			</div>
		</div>
	</div>
	<script>
		var update_url = '<?php echo Url::to('/cart/update/', true);?>';
	</script>
