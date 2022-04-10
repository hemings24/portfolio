<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container container-fix main">
   <div>
      <h1>Checkout</h1>
      <?php display_message(); ?>

      <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
         <input type="hidden" name="cmd" value="_cart">
         <input type="hidden" name="upload" value="1">
         <input type="hidden" name="business" value="sb-ktesa11691674@business.example.com">
         <input type="hidden" name="currency_code" value="GBP">
         <input type="hidden" name="return" value="http://localhost/ecom/public/thankyou.php">
         <input type="hidden" name="cancel_return" value="http://localhost/ecom/public/transacton-fail.php">

         <table class="table table-striped">
            <thead><tr>
               <th class="fontsize14">Product</th>
               <th class="fontsize14">Price</th>
               <th class="fontsize14">Quantity</th>
               <th class="fontsize14" style="padding-right:16px">Total</th>
            </tr></thead>
            <tbody>
               <?php cart(); ?>
            </tbody>
         </table>
         <?php echo show_buttons(); ?>
      </form>

      <!--***********ORDER SUMMARY*************-->  
      <div style="display:table;content:'';clear:both;"></div>
      <div class="col-xs-11 col-480-fix col-576-fix col-768-fix col-md-5 col-lg-5 pull-right" style="margin-top:30px;padding-right:50px;">
         <h3>Order Summary</h3>
         <table class="table table-bordered" cellspacing="0">
            <tr class="cart-subtotal">
               <th class="fontsize14">
                  Subtotal (<?php 
                  echo isset($_SESSION['order_quantity']) ? $_SESSION['order_quantity'] : $_SESSION['order_quantity'] = 0;
                  echo isset($_SESSION['order_quantity']) && $_SESSION['order_quantity'] == 1 ? " item" : " items";
                  ?>)
               </th>
               <td class="fontsize14">
                  <span class="pull-right">
                     &#163; <?php echo isset($_SESSION['order_subtotal']) ? number_format($_SESSION['order_subtotal'],2) : $_SESSION['order_subtotal'] = 0; ?>
                  </span>
               </td>
            </tr>
            <tr class="shipping">
               <th class="fontsize14">Shipping</th>
               <td class="fontsize14">
                  <span class="pull-right">
                     &#163; <?php echo isset($_SESSION['order_shipping']) ? number_format($_SESSION['order_shipping'],2) : $_SESSION['order_shipping'] = 0; ?>
                  </span>
               </td>
            </tr>
            <tr class="order-total">
               <th class="fontsize14">Total</th>
               <td class="fontsize14">
                  <strong><span class="amount fontsize14 pull-right">
                     &#163; <?php echo isset($_SESSION['order_total']) ? number_format($_SESSION['order_total'],2) : $_SESSION['order_total'] = 0; ?>
                  </span></strong>
               </td>
            </tr>
         </table>
      </div>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>