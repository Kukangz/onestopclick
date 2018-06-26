    <?php 
    use yii\widgets\ActiveForm;?>

    <div class="single-product-area">
      <div class="zigzag-bottom"></div>
      <div class="container">
        <div class="row">
          <h3 id="order_review_heading">Your order</h3>

          <div id="order_review" style="position: relative;">
            <table class="shop_table">
              <thead>
                <tr>
                  <th class="product-name">Product</th>
                  <th class="product-total">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $subtotal = 0;
                if($cart): ?>
                  <?php foreach($cart as $key => $item):?>
                    <tr class="cart_item">
                      <td class="product-name">
                        <?php echo $item['name'];?></td>
                        <td class="product-total">
                          <?php echo number_format($item['price'],2);?>
                        </td>
                      </tr>

                      <?php $subtotal +=$item['price']; endforeach;?>
                    <?php endif;?>
                  </tbody>
                  <tfoot>

                    <tr class="cart-subtotal">
                      <th>Cart Subtotal</th>
                      <td><span class="amount"><?php echo number_format($subtotal,2);?></span>
                      </td>
                    </tr>

                    <tr class="shipping">
                      <th>Discount / Voucher</th>
                      <td>
                        <?php $discount = 0;
                        if(YII::$app->session->get('voucher')):
                          $voucher = YII::$app->session->get('voucher');
                          if($voucher['discount_type'] == 1):
                            $discount = (($subtotal / 100) * $voucher->discount_value);
                          elseif($voucher['discount_type'] == 2):
                            $discount = $subtotal - $voucher->discount_value;
                          endif;?> 
                          <?php echo number_format($discount,2);?>
                          <?php else:?>
                            <?php echo number_format(0,2);?>
                          <?php endif;?>
                        </td>
                      </tr>

                      <?php $total = $subtotal - $discount;?>
                      <tr class="order-total">
                        <th>Order Total</th>
                        <td><strong><span class="amount"><?php echo number_format($total,2);?></span></strong> </td>
                      </tr>

                    </tfoot>
                  </table>

                  <?php ActiveForm::begin(['action' => '/payment','method' => 'post']);?>
                  <div id="payment">
                    <ul class="payment_methods methods">
                      <li class="payment_method_bacs">
                        <input type="radio" data-order_button_text="" checked="checked" value="bacs" name="payment_method" class="input-radio" id="payment_method_bacs">
                        <label for="payment_method_bacs">Account Balance </label>
                        <div class="payment_box payment_method_bacs">
                          <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                        </div>
                      </li>
                      <li class="payment_method_paypal">
                        <input type="radio" data-order_button_text="Proceed to PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal">
                        <label for="payment_method_paypal">PayPal <img alt="PayPal Acceptance Mark" src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"><a title="What is PayPal?" onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" class="about_paypal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup">What is PayPal?</a>
                        </label>
                        <div style="display:none;" class="payment_box payment_method_paypal">
                          <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                        </div>
                      </li>
                    </ul>

                    <div class="form-row place-order">
                      
                      <input type="submit" data-value="Place order" value="Place order" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
                      
                    </div>
                    <?php ActiveForm::end();?>
                    <div class="clear"></div>

                  </div>
                </div>
              </form>

            </div>                       
          </div>                      
        </div>
      </div>
    </div>
  </div>
