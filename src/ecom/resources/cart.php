<?php
require_once("config.php");


if(isset($_GET['add'])){
   $get_product = dbcommand("SELECT * FROM products WHERE product_id = " .escape_string($_GET['add']));
   confirm($get_product);

   while($row = fetch_array($get_product)){
      if($row['product_quantity'] != $_SESSION['item_quantity_' .$_GET['add']]){
         $_SESSION['product_id_' .$_GET['add']] = $row['product_title'];
         $_SESSION['product_price_' .$_GET['add']] = $row['product_price'];
         $_SESSION['item_quantity_' .$_GET['add']] += 1;
         $_SESSION['item_total_' .$_GET['add']] = $_SESSION['product_price_' .$_GET['add']] * $_SESSION['item_quantity_' .$_GET['add']];
         $_SESSION['order_quantity'] += 1;
         $_SESSION['order_subtotal'] = $_SESSION['order_subtotal'] + $_SESSION['product_price_' .$_GET['add']];
         $_SESSION['order_shipping'] = $_SESSION['order_subtotal'] * 0.05;
         $_SESSION['order_total'] = $_SESSION['order_subtotal'] + $_SESSION['order_shipping'];
         asort($_SESSION);

         if(isset($_GET['atbPage'])){
            set_message("<h3 class='bg-success text-center'>Item Added to Basket</h3>");
         }
      }else{
         set_message("<h3 class='bg-danger text-center'>{$row['product_quantity']} {$row['product_title']} available</h3>");
      }
      atb_page_redirect($row['product_cat_id'],$row['product_id']);
   }
}


if(isset($_GET['remove'])){
   $_SESSION['item_quantity_' .$_GET['remove']]--;
   $_SESSION['item_total_' .$_GET['remove']] = $_SESSION['product_price_' .$_GET['remove']] * $_SESSION['item_quantity_' .$_GET['remove']];
   $_SESSION['order_quantity']--;
   $_SESSION['order_subtotal'] = $_SESSION['order_subtotal'] - $_SESSION['product_price_' .$_GET['remove']];
   $_SESSION['order_shipping'] = $_SESSION['order_subtotal'] * 0.05;
   $_SESSION['order_total'] = $_SESSION['order_subtotal'] + $_SESSION['order_shipping'];

   if($_SESSION['order_quantity'] <= 0){
      unset_cart(); 
   }elseif($_SESSION['item_quantity_' .$_GET['remove']] <= 0){
      unset_cart_item("remove");
   }
   redirect("../public/checkout.php");
}


if(isset($_GET['delete'])){
   $_SESSION['order_quantity'] -= $_SESSION['item_quantity_' .$_GET['delete']];
   $_SESSION['order_subtotal'] = $_SESSION['order_subtotal'] - $_SESSION['item_total_' .$_GET['delete']];
   $_SESSION['order_shipping'] = $_SESSION['order_subtotal'] * 0.05;
   $_SESSION['order_total'] = $_SESSION['order_subtotal'] + $_SESSION['order_shipping'];

   if($_SESSION['order_quantity'] <= 0){
      unset_cart();
   }else{
      unset_cart_item("delete");
   }
   redirect("../public/checkout.php");
}


if(isset($_GET['empty'])){
   unset_cart();
   redirect("../public/checkout.php");
}


function unset_cart_item($operation){
   unset($_SESSION['product_id_' .$_GET[$operation]]);
   unset($_SESSION['product_price_' .$_GET[$operation]]);
   unset($_SESSION['item_quantity_' .$_GET[$operation]]);
   unset($_SESSION['item_total_' .$_GET[$operation]]);
}
function unset_cart(){
   foreach($_SESSION as $name => $value){
      $length = strlen($name);
      $string = substr($name, 5, $length);
      unset($_SESSION['produ' .$string]);
      unset($_SESSION['item_' .$string]);
      unset($_SESSION['order' .$string]);
   }
}


function cart(){
   $item_number = 0;
   foreach($_SESSION as $name => $value){
      if(substr($name, 0, 11) == "product_id_"){
         $length = strlen($name);
         $product_id = substr($name, 11, $length);
         
         $get_products = dbcommand("SELECT * FROM products WHERE product_id = " .escape_string($product_id));
         confirm($get_products);
         while($row = fetch_array($get_products)){
            $item_number++;
            $product_image = display_image($row['product_image']);
            $product_price = number_format($row['product_price'],2);
            $item_quantity = $_SESSION['item_quantity_' .$product_id];
            $item_total = number_format($_SESSION['item_total_' .$product_id],2);
            
            $item_row = <<<DELIMETER
            <tr>
               <td class='fontsize14'>
                  <p class='fontsize14'>{$row['product_title']}</p>
                  <img width='70' src='../resources/{$product_image}' alt=''>
               </td>
               <td class='fontsize14'>&#163;{$product_price}</td>
               <td class='fontsize14'>{$item_quantity}</td>
               <td class='fontsize14'>&#163;{$item_total}</td>

               <td class='cart-item-buttons-fix'>
                  <a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}">
                     <span class='glyphicon glyphicon-minus fontsize10'></span>
                  </a>  
                  <a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}">
                     <span class='glyphicon glyphicon-remove fontsize10'></span>
                  </a>
                  <a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}">
                     <span class='glyphicon glyphicon-plus fontsize10'></span>
                  </a>
               </td>

            </tr>
            <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
            <input type="hidden" name="item_name_{$item_number}" value="{$row['product_title']}">
            <input type="hidden" name="amount_{$item_number}" value="{$row['product_price']}">
            <input type="hidden" name="quantity_{$item_number}" value="{$item_quantity}">
            DELIMETER;

            echo $item_row;
         }
      }
   }
   if(isset($_SESSION['order_shipping'])){
      $shipping = <<<DELIMETER
      <input type="hidden" name="shipping_1" value="{$_SESSION['order_shipping']}">
      DELIMETER;
      echo $shipping;
   }
}


function show_buttons(){
   if(isset($_SESSION['order_quantity']) && $_SESSION['order_quantity'] > 0){
      $buttons = <<<DELIMETER
      <div style="float:left;">
         <input type="image" name="upload" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
      </div>
      <div style="margin-right:50px;float:right;">
         <a class="btn btn-danger" href="../resources/cart.php?empty">Empty Basket</a>
      </div>
      DELIMETER;
      
      return $buttons;
   }
}


function process_transaction(){
   //if(isset($_GET['tx'])){
   //$total = $_GET['amt'];
   //$currency = $_GET['cc'];
   //$transaction_id = $_GET['tx'];
   //$status = $_GET['st'];

   if(isset($_SESSION['order_total'])){
      $total = $_SESSION['order_total'];
      $subtotal = $_SESSION['order_subtotal'];
      $shipping = $_SESSION['order_shipping'];
      $currency = "GBP";
      $status = "Complete";
      do{
         $transaction_id = strtoupper(uniqid());
         $get_orders = dbcommand("SELECT order_transaction FROM orders WHERE order_transaction = '$transaction_id' LIMIT 1");
         confirm($get_orders);
      }while(mysqli_num_rows($get_orders) > 0);

      $add_order = dbcommand("INSERT INTO orders (order_total, order_subtotal, order_shipping, order_transaction, order_currency, order_status) VALUES ('{$total}', '{$subtotal}', '{$shipping}', '{$transaction_id}', '{$currency}', '{$status}')");
      confirm($add_order);
      $order_id = last_id();

      arsort($_SESSION);
      foreach($_SESSION as $name => $value){
         if(substr($name, 0, 11) == "product_id_"){
            $length = strlen($name);
            $product_id = substr($name, 11, $length);

            $get_product = dbcommand("SELECT * FROM products WHERE product_id = " .escape_string($product_id));
            confirm($get_product);
            while($row = fetch_array($get_product)){
               $product_title = $row['product_title'];
               $product_price = $row['product_price'];
               $item_quantity = $_SESSION['item_quantity_' .$product_id];
               $item_total = $_SESSION['item_total_' .$product_id];

               $add_report = dbcommand("INSERT INTO reports (product_id, order_id, product_title, product_price, product_quantity, product_total) VALUES ('{$product_id}', '{$order_id}', '{$product_title}', '{$product_price}', '{$item_quantity}', '{$item_total}')");
               confirm($add_report);
            }
         }
      }
      unset_cart();
   }else{
      set_message("<h3 class='bg-danger text-center'>Website transaction failed</h3>");
      redirect("checkout.php");
   }
}


function atb_page_redirect($product_cat_id,$product_id){
   if(isset($_GET['atbPage'])){
      if($_GET['atbPage'] == "index"){
         redirect("../public/index.php");
      }elseif($_GET['atbPage'] == "shop"){
         redirect("../public/shop.php");
      }elseif($_GET['atbPage'] == "category"){
         redirect("../public/category.php?id=$product_cat_id");
      }elseif($_GET['atbPage'] == "item"){
         redirect("../public/item.php?id=$product_id");
      }
   }else{
      redirect("../public/checkout.php");
   }
}


function transaction_diagnostic_paypal(){
   if(isset($_GET['tx'])){
      $amount = $_GET['amt'];
      $currency = $_GET['cc'];
      $transaction = $_GET['tx'];
      $status = $_GET['st'];

      $debug = <<<DELIMETER
      <div style="display:flex;justify-content:center;margin-top:32px;">
         <div style="width:300px;border:1px solid black;">
            <p>PayPal:</p>
            <p>tx: {$transaction}</p>
            <p>amt: {$amount}</p>
            <p>cc: {$currency}</p>
            <p>st: {$status}</p>
         </div>
      </div>
      DELIMETER;
   }else{
      $debug = <<<DELIMETER
      <div>
         <h1>Sorry - Transaction details have not be passed from the PayPal website</h1>
      </div>
      DELIMETER;
   }
   echo $debug;
}

function transaction_diagnostic_website($amount,$currency,$transaction,$status){   
   $debug = <<<DELIMETER
   <div style="display:flex;justify-content:center;">
      <div style="width:300px;border:1px solid black;">
         <p>Website:</p>
         <p>tx: {$transaction}</p>
         <p>amt: {$amount}</p>
         <p>cc: {$currency}</p>
         <p>st: {$status}</p> 
      </div>
   </div>
   DELIMETER;  
   echo $debug;
}