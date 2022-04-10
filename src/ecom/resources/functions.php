<?php

$upload_directory = "uploads";


// helper functions

function last_id(){
   global $connection;
   return mysqli_insert_id($connection);
}

function set_message($msg){
   if(!empty($msg)){
      $_SESSION['message'] = $msg;
   }else{
      $msg = "";
   }
}

function display_message(){
   if(isset($_SESSION['message'])){
      echo $_SESSION['message'];
      unset($_SESSION['message']);
   }
}

function redirect($location){
   return header("Location: $location ");
}

function dbcommand($sql){
   global $connection;
   return mysqli_query($connection, $sql);
}

function confirm($result){
   global $connection;
   if(!$result){
      die("QUERY FAILED " . mysqli_error($connection));
   }
}

function fetch_array($result){
   return mysqli_fetch_array($result);
}

function escape_string($string){
   global $connection;
   return mysqli_real_escape_string($connection, $string);
}

function sanitize($input){
   return htmlspecialchars(trim($input));
}


/****************************FRONT END FUNCTIONS************************/

function count_all_records($table){
   return mysqli_num_rows(dbcommand("SELECT * FROM " .$table));
}

function count_all_products_in_stock(){
   return mysqli_num_rows(dbcommand("SELECT * FROM products WHERE product_quantity >= 1"));
}


function get_products_with_pagination(){
   $perPage = "6";
   $rows = count_all_products_in_stock();
   if($rows == 0){
      $rows = 1;
   }

   if(isset($_GET['page'])){  //get page from URL if it's there
      $page = preg_replace('#[^0-9]#', '', $_GET['page']);  //filter everything but numbers
   }else{
      $page = 1;
   }

   $lastPage = ceil($rows / $perPage);
   if($page < 1){
      $page = 1;
   }elseif($page > $lastPage){
      $page = $lastPage;
   }

   $middleNumbers = '';
   $sub1 = $page - 1;
   $sub2 = $page - 2;
   $add1 = $page + 1;
   $add2 = $page + 2;
   if($page == 1){
      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
   }elseif($page == $lastPage){
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
   }elseif($page > 2 && $page < ($lastPage -1)){
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">' .$sub2. '</a></li>';
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">' .$add2. '</a></li>';
   }elseif($page > 1 && $page < $lastPage){
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page= '.$sub1.'">' .$sub1. '</a></li>';
      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
   }

   $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;
   $get_products = dbcommand("SELECT * FROM products WHERE product_quantity >= 1 ORDER BY product_title ASC $limit");
   confirm($get_products);
   $outputPagination = "";  //Initialize the pagination output variable

   if($rows <= 6){
      $outputPagination = "";
   }else{
      if($page != 1){
         $prev  = $page - 1;
         $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
      }
      $outputPagination .= $middleNumbers;
      if($page != $lastPage){
         $next = $page + 1;
         $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
      }
   }
   display_products($get_products);

   echo "<div class='text-center' style='clear: both;' ><ul class='pagination' >{$outputPagination}</ul></div>";
}

function display_products($get_products){
   $pagename = basename($_SERVER['PHP_SELF']);
   $pagename = substr($pagename,0,-4);

   $marginLR = "32px";
   $productheight = "16vh";
   if($pagename == "shop" || $pagename == "category"){
      $marginLR = "56px";
      $productheight = "18vh";
   }
   $productwidth = "prodwidth-home";
   if($pagename == "shop"){
      $productwidth = "prodwidth-shop";
   }elseif($pagename == "category"){
      $productwidth = "prodwidth-cat";
   }

   while($row = fetch_array($get_products)){
      $product_image = display_image($row['product_image']);
      $product_price = number_format($row['product_price'],2);
      $product = <<<DELIMETER
      <div class=$productwidth>
         <div class="thumbnail">
            <a href="item.php?id={$row['product_id']}">
               <img style="height:$productheight" src="../resources/{$product_image}" alt="">
            </a>
            <div class="caption">
               <div style="margin:2px $marginLR 8px $marginLR;">
                  <h4 class="pull-right">&#163;{$product_price}</h4>
                  <h4 class="pull-left"><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
               </div>
               <div style="margin:48px;"></div>
               <p class="text-center fontsize14">{$row['product_short_desc']}</p>
               <div class="text-center" style="margin-top:16px;">
                  <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}&atbPage=$pagename&id={$row['product_cat_id']}">
                     Add to Basket
                  </a>
                  <a href="item.php?id={$row['product_id']}" class="btn btn-default">
                     More Info
                  </a>
               </div>
            </div>
         </div>
      </div>
      DELIMETER;
      echo $product;
   }
}


function get_categories(){
   $get_categories = dbcommand("SELECT * FROM categories ORDER BY cat_title ASC");
   confirm($get_categories);

   while($row = fetch_array($get_categories)){
      $categories_links = <<<DELIMETER
      <a href="category.php?id={$row['cat_id']}" class="list-group-item">{$row['cat_title']}</a>
      DELIMETER;

      echo $categories_links;
   }
}

function get_cat_header(){
   $get_categories = dbcommand("SELECT * FROM categories WHERE cat_id = " .escape_string($_GET['id']));
   confirm($get_categories);

   while($row = fetch_array($get_categories)){
      $category = <<<DELIMETER
      <header class="jumbotron hero-spacer cat-banner" style="color:#ffffff; background-image: url('../resources/uploads/{$row['cat_image']}')">
         <h1>{$row['cat_title']}</h1>
         <p>{$row['cat_description']}</p>
      </header>
      DELIMETER;

      echo $category;
   }
}

function get_products_in_cat_page(){
   $get_products = dbcommand("SELECT * FROM products WHERE product_cat_id = " .escape_string($_GET['id']) ." AND product_quantity >= 1 ORDER BY product_title ASC");
   confirm($get_products);

   display_products($get_products);
}

function get_products_in_shop_page(){
   $get_products = dbcommand("SELECT * FROM products WHERE product_quantity >= 1");
   confirm($get_products);

   while($row = fetch_array($get_products)){
      $product_image = display_image($row['product_image']);
      $product = <<<DELIMETER
      <div class="col-md-3 col-sm-6 hero-feature">
         <div class="thumbnail">
            <img src="../resources/{$product_image}" alt="">
            <div class="caption">
               <h3>{$row['product_title']}</h3>
               <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
               <p>
                  <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a>
                  <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
               </p>
            </div>
         </div>
      </div>
      DELIMETER;

      echo $product;
   }
}

function login_user(){
   if(isset($_POST['submit'])){
      $userid    = "";
      $username  = sanitize(escape_string($_POST['username']));
      $password  = sanitize(escape_string($_POST['password']));
      $loginpage = get_login_page();

      if(!empty($username) && !empty($password)){
         $get_user = dbcommand("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password }' LIMIT 1");
         confirm($get_user);
   
         if(mysqli_num_rows($get_user) != 0){
            $row = fetch_array($get_user);
   
            if(strcmp($username,$row['username']) == 0 && strcmp($password,$row['password']) == 0){
               $userid = $row['user_id'];
               $account = $row['account'];
               if($account == "admin"){
                  login_success($userid,$username,$account);
                  redirect("admin/index.php?dashboard=orders");
               }elseif($account == "customer" && $loginpage == "customer"){
                  login_success($userid,$username,$account);
                  set_message("<h3 class='bg-success text-center'>Welcome back $username</h3>");
                  redirect("index.php");
               }elseif($account == "customer" && $loginpage == "admin"){
                  login_fail($loginpage);
               }else{
                  login_fail($loginpage);
               }
            }else{
               login_fail($loginpage);
            }
         }else{
            login_fail($loginpage);
         }
      }else{
         set_message("<h3 class='bg-danger text-center'>Username and Password must contain values</h3>");
         redirect("login.php?loginpage=$loginpage");
      }
   }
}
function get_login_page(){
   $loginpage = "customer";
   if(isset($_GET['loginpage'])){
      $loginpage = $_GET['loginpage'];
      if($loginpage != "admin"){
         $loginpage = "customer";
      }
   }
   return $loginpage;
}
function login_success($userid,$username,$account){
   if(isset($_SESSION['userid'])){
      session_destroy();
      session_start();
   }
   $_SESSION['userid'] = $userid;
   $_SESSION['username'] = $username;
   $_SESSION['account'] = $account;
}
function login_fail($loginpage){
   set_message("<h3 class='bg-danger text-center'>User Account Not Found</h3>");
   redirect("login.php?loginpage=$loginpage");
}
function admin_security_check(){
   if(!isset($_SESSION['userid']) || !isset($_SESSION['account'])){
      redirect("../../public/login.php?loginpage=admin");
   }else{
      if($_SESSION['account'] != "admin"){
         redirect("../../public/login.php?loginpage=admin");
      }
   }
}

function send_message($page){
   if(isset($_POST['submit'])){
      $to          = "paul.hemingway27@gmail.com";
      $from_name   =   sanitize(escape_string($_POST['name']));
      $email       =   sanitize(escape_string($_POST['email']));
      $subject     =   sanitize(escape_string($_POST['subject']));
      $message     =   sanitize(escape_string($_POST['message']));

      $headers = "From: {$from_name} {$email}";
      $result = mail($to,$subject,$message,$headers);

      if($result){
         set_message("<h3 class='bg-success text-center'>Your Message has been sent</h3>");
      }else{
         set_message("<h3 class='bg-danger text-center'>Sorry we could not send your message</h3>");
      }
      if($page == "contact"){
         redirect("contact.php");
      }elseif($page == "item"){
         redirect("item.php?id={$_GET['id']}");
      }
   }
}


/****************************BACK END FUNCTIONS************************/

function set_page(){
   $page = "dashboard";

   if(isset($_GET['orders'])){
      $page = "orders";
   }elseif(isset($_GET['products'])){
      $page = "products";
   }elseif(isset($_GET['categories'])){
      $page = "categories";
   }elseif(isset($_GET['page']) && ($_GET['page'] == "categories" || $_GET['page'] == "edit_category")){
      $page = "categories";
   }
   return $page;
}

function set_section(){
   $section = "orders";

   if(isset($_GET['dashboard']) && $_GET['dashboard']){
      $section = $_GET['dashboard'];
   }elseif(isset($_GET['orders']) || isset($_GET['products']) || isset($_GET['categories'])){
      $section = "null";
   }elseif(isset($_GET['section'])){
      $section = "edit_category";
      if($_GET['section'] == "null"){
         $section = "null";
      }
   }
   return $section;
}

function set_display(){
   $page = "dashboard";

   if(isset($_GET['orders'])){
      $page = "orders";
   }elseif(isset($_GET['products'])){
      $page = "products";
   }elseif(isset($_GET['categories'])){
      $page = "categories";
   }elseif(isset($_GET['page']) && ($_GET['page'] == "categories" || $_GET['page'] == "edit_category")){
      $page = "edit_category";
   }
   return $page;
}

function redirect_page(){
   $page = "dashboard";
   $section = "orders";

   if(isset($_GET['page'])){
      $page = $_GET['page'];
      if(isset($_GET['section'])){
         $section = $_GET['section'];
      }
   }
   redirect("index.php?$page=$section");
}

function display_orders(){
   $page = set_page();
   $section = set_section();

   $get_orders = dbcommand("SELECT * FROM orders ORDER BY order_id DESC");
   confirm($get_orders);
   while($row = fetch_array($get_orders)){
      $order_total = number_format($row['order_total'],2);
      $orders = <<<DELIMETER
      <tr>
         <td>{$row['order_id']}</td>
         <td>&#163;{$order_total}</td>
         <td>{$row['order_currency']}</td>
         <td>{$row['order_transaction']}</td>
         <td>{$row['order_status']}</td>
         <td>{$row['order_timestamp']}</td>
         <td>
            <a class="btn btn-danger" href="index.php?delete_order={$row['order_id']}&page=$page&section=$section">
               <span>Delete</span>
            </a>
         </td>
      </tr>
      DELIMETER;

      echo $orders;
   }
}


/************************ Admin Products Page ********************/

function get_products_in_admin(){
   $page = set_page();
   $section = set_section();

   $get_products = dbcommand("SELECT * FROM products ORDER BY product_cat_title ASC, product_title ASC");
   confirm($get_products);

   while($row = fetch_array($get_products)){
      $category = show_product_category_title($row['product_cat_id']);
      $product_image = display_image($row['product_image']);
      $product_price = number_format($row['product_price'],2);
      $product = <<<DELIMETER
      <tr>
         <td>{$row['product_id']}</td>
         <td>{$category}</td>
         <td>{$row['product_title']}
            <br>
            <a href="index.php?edit_product&id={$row['product_id']}"><img width='100' src="../../resources/{$product_image}" alt=""></a>
         </td>
         <td>&#163;{$product_price}</td>
         <td>{$row['product_quantity']}</td>
         <td>
            <a class="btn btn-primary" href="index.php?edit_product={$row['product_id']}&page=$page&section=$section">
               <span style="margin-left:5px;margin-right:5px;">Edit</span>
            </a>
            <a class="btn btn-danger" href="index.php?delete_product={$row['product_id']}&page=$page&section=$section">
               <span>Delete</span>
            </a>
         </td>
      </tr>
      DELIMETER;

      echo $product;
   }
}

function show_product_category_title($product_cat_id){
   $get_categories = dbcommand("SELECT * FROM categories WHERE cat_id = '{$product_cat_id}'");
   confirm($get_categories);
   while($row = fetch_array($get_categories)){
      return $row['cat_title'];
   }
}

function show_categories_add_product_page(){
   $get_categories = dbcommand("SELECT * FROM categories ORDER BY cat_title ASC");
   confirm($get_categories);

   while($row = fetch_array($get_categories)){
      $categories_options = <<<DELIMETER
      <option value="{$row['cat_id']}">{$row['cat_title']}</option>
      DELIMETER;

      echo $categories_options;
   }
}

function display_image($picture){
   global $upload_directory;
   return $upload_directory.DS.$picture;
}


/***************************Add Product in Admin********************/

function add_product(){
   $product_valid = 0;
   $product_error_msg=$image_error_msg = "";
   
   if(isset($_POST['submit'])){
      $product_title=$_SESSION['prod_product_title']             = sanitize(escape_string($_POST['product_title']));
      $product_description=$_SESSION['prod_product_description'] = sanitize(escape_string($_POST['product_description']));
      $product_price=$_SESSION['prod_product_price']             = sanitize(escape_string($_POST['product_price']));
      $product_short_desc=$_SESSION['prod_product_short_desc']   = sanitize(escape_string($_POST['product_short_desc']));
      $product_cat_id=$_SESSION['prod_product_cat_id']           = sanitize(escape_string($_POST['product_cat_id']));
      $product_cat_title=$_SESSION['prod_product_cat_title']     = sanitize(show_product_category_title($_POST['product_cat_id']));
      $product_quantity=$_SESSION['prod_product_quantity']       = sanitize(escape_string($_POST['product_quantity']));

      $product_error_msg = validate_product_details($product_title,"add");

      $product_image = $_FILES['file']['name'];
      if(!empty($product_image)){
         $product_image = "product-".$_FILES['file']['name'];
      }
      $product_image_tmp = $_FILES['file']['tmp_name'];
      $target_file = UPLOAD_DIRECTORY.DS.basename($product_image);

      if(!empty($product_image) || empty($_SESSION['prod_product_image'])){
         if($product_image != $_SESSION['prod_product_image_title'] || empty($product_image)){
            $image_error_msg = validate_image($product_image,$product_image_tmp,$target_file);

            if(empty($image_error_msg)){
               if(move_uploaded_file($product_image_tmp, $target_file)){
                  unlink_image();
                  $_SESSION['prod_product_image_title'] = $product_image;
                  $_SESSION['prod_product_image'] = display_image($product_image);   
               }else{
                  $image_error_msg = "Error adding product image";
               }
            }
         }
      }

      if(empty($product_error_msg) && empty($image_error_msg)){
         $product_valid = 1;
         insert_product();
         unset_product();
         $product_id = last_id();
         set_message("<h3 class='bg-success'>New Product Added id: {$product_id}</h3>");
         redirect("index.php?products");
      }else{
         if(!empty($product_error_msg) && !empty($image_error_msg)){
            $product_error_msg .= " / ";
         }
         set_message("<h3 class='bg-danger'>$product_error_msg $image_error_msg</h3>");
      }
   }else{
      unlink_nondb_images();
      unset_product();
      get_product();
   }

   return $product_valid;
}




function insert_product(){
   $add_product  = "INSERT INTO products ";
   $add_product .= "(product_title, product_cat_id, product_cat_title, product_price, product_description, product_short_desc, product_quantity, product_image) ";
   $add_product .= "VALUES ";
   $add_product .= "('{$_SESSION['prod_product_title']}', '{$_SESSION['prod_product_cat_id']}', '{$_SESSION['prod_product_cat_title']}', '{$_SESSION['prod_product_price']}', '{$_SESSION['prod_product_description']}', '{$_SESSION['prod_product_short_desc']}', '{$_SESSION['prod_product_quantity']}', '{$_SESSION['prod_product_image_title']}')";
   $add_product = dbcommand($add_product);
   confirm($add_product);
}



function edit_product(){
   $product_valid = 0;
   $product_error_msg=$image_error_msg = "";//set default to error???
   
   if(isset($_POST['submit'])){
      $product_title=$_SESSION['prod_product_title']             = sanitize(escape_string($_POST['product_title']));
      $product_description=$_SESSION['prod_product_description'] = sanitize(escape_string($_POST['product_description']));
      $product_price=$_SESSION['prod_product_price']             = sanitize(escape_string($_POST['product_price']));
      $product_short_desc=$_SESSION['prod_product_short_desc']   = sanitize(escape_string($_POST['product_short_desc']));
      $product_cat_id=$_SESSION['prod_product_cat_id']           = sanitize(escape_string($_POST['product_cat_id']));
      $product_cat_title=$_SESSION['prod_product_cat_title']     = sanitize(show_product_category_title($_POST['product_cat_id']));
      $product_quantity=$_SESSION['prod_product_quantity']       = sanitize(escape_string($_POST['product_quantity']));

      $product_error_msg = validate_product_details($product_title,"update");
      if(empty($product_error_msg)){
         update_product("product");
      }

      $product_image = $_FILES['file']['name'];
      if(!empty($product_image)){
         $product_image = "product-".$_FILES['file']['name'];
      }
      $product_image_tmp = $_FILES['file']['tmp_name'];
      $target_file = UPLOAD_DIRECTORY.DS.basename($product_image);


      if(!empty($product_image) || empty($_SESSION['prod_product_image'])){
         if($product_image != $_SESSION['prod_product_image_title'] || empty($product_image)){//????
            $image_error_msg = validate_image($product_image,$product_image_tmp,$target_file);

            if(empty($image_error_msg)){
               if(move_uploaded_file($product_image_tmp, $target_file)){
                  unlink_image();
                  $_SESSION['prod_product_image_title'] = $product_image;
                  $_SESSION['prod_product_image'] = display_image($product_image);
                  update_product("image");
               }else{
                  $image_error_msg = "Error adding product image";
               }
            }
         }
      }
      if(empty($product_error_msg) && empty($image_error_msg)){
         $product_valid = 1;
         unset_product();
         set_message("<h3 class='bg-success'>Product Updated id: {$_GET['edit_product']}</h3>");
         redirect_page();
      }else{
         if(!empty($product_error_msg) && !empty($image_error_msg)){
            $product_error_msg .= " / ";
         }
         set_message("<h3 class='bg-danger'>$product_error_msg $image_error_msg</h3>");
      }
   }else{
      unlink_nondb_images();
      unset_product();
      get_product();
   }

   return $product_valid;
}




function update_product($update){
   if($update == "product"){
      $update_product  = "UPDATE products SET ";
      $update_product .= "product_title            = '{$_SESSION['prod_product_title']}'        , ";
      $update_product .= "product_description      = '{$_SESSION['prod_product_description']}'  , ";
      $update_product .= "product_price            = '{$_SESSION['prod_product_price']}'        , ";
      $update_product .= "product_short_desc       = '{$_SESSION['prod_product_short_desc']}'   , ";
      $update_product .= "product_cat_id           = '{$_SESSION['prod_product_cat_id']}'       , ";
      $update_product .= "product_cat_title        = '{$_SESSION['prod_product_cat_title']}'    , ";
      $update_product .= "product_quantity         = '{$_SESSION['prod_product_quantity']}'       ";
      $update_product .= "WHERE product_id = " .escape_string($_GET['edit_product']);
      $update_product = dbcommand($update_product);
      confirm($update_product);
   }elseif($update == "image"){
      $update_product_image = "UPDATE products SET product_image = '{$_SESSION['prod_product_image_title']}' WHERE product_id = " .escape_string($_GET['edit_product']);
      $update_product_image = dbcommand($update_product_image);
      confirm($update_product_image);
   }
}



function get_product(){
   if(isset($_GET['add_product'])){
      $_SESSION['prod_product_title']=$_SESSION['prod_product_description']=$_SESSION['prod_product_price']=$_SESSION['prod_product_short_desc']=$_SESSION['prod_product_cat_id']=$_SESSION['prod_product_cat_title']=$_SESSION['prod_product_quantity']=$_SESSION['prod_product_image_title']=$_SESSION['prod_product_image'] = "";
   }
   elseif(isset($_GET['edit_product'])){
      $get_product = dbcommand("SELECT * FROM products WHERE product_id = '{$_GET['edit_product']}' LIMIT 1");
      confirm($get_product);
   
      if(mysqli_num_rows($get_product) != 0){
         $row = fetch_array($get_product);
         $_SESSION['prod_product_title']       = escape_string($row['product_title']);
         $_SESSION['prod_product_title_db']    = escape_string($row['product_title']);
         $_SESSION['prod_product_description'] = escape_string($row['product_description']);
         $_SESSION['prod_product_price']       = escape_string($row['product_price']);
         $_SESSION['prod_product_short_desc']  = escape_string($row['product_short_desc']);
         $_SESSION['prod_product_cat_id']      = escape_string($row['product_cat_id']);
         $_SESSION['prod_product_cat_title']   = escape_string($row['product_cat_title']);
         $_SESSION['prod_product_quantity']    = escape_string($row['product_quantity']);
         $_SESSION['prod_product_image_title'] = escape_string($row['product_image']);
         $_SESSION['prod_product_image']       = display_image($row['product_image']);
      }
   }
}



function get_product_image($product_id){
   $get_product_image = dbcommand("SELECT product_image FROM products WHERE product_id = '{$product_id}'");
   confirm($get_product_image);
   while($row = fetch_array($get_product_image)){
      $product_image = display_image($row['product_image']);
   }
   return $product_image;
}



function validate_product_details($product_title,$function){
   $error_msg = "";

   if(empty($product_title) || empty($_SESSION['prod_product_description']) || empty($_SESSION['prod_product_price']) || empty($_SESSION['prod_product_short_desc']) || empty($_SESSION['prod_product_cat_title']) || empty($_SESSION['prod_product_quantity'])){
      $error_msg = "All entries must contain values";
   }else{
      $get_product = dbcommand("SELECT * FROM products WHERE product_title = '{$product_title}' LIMIT 1");
      confirm($get_product);
      if($function == "add"){
         if(mysqli_num_rows($get_product) != 0){
            $error_msg = "Title already exists";
         }
      }elseif($function == "update"){
         if(mysqli_num_rows($get_product) != 0){
            if(strcasecmp($product_title,$_SESSION['prod_product_title_db']) != 0){
               $error_msg = "Title not available";
            }
         }
      }
   }

   return $error_msg;
}



function validate_image($image,$image_tmp,$target_file){
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   $error_msg = "";

   if(empty($image)){
      $error_msg = "Select an image";
   }else{
      if(file_exists($target_file)){
         $error_msg = "Image already exists";
      }else{
         $check = getimagesize($image_tmp);
         if($check == false){
            $error_msg = "File is not an image";
         }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
            $error_msg = "Only JPG, JPEG, PNG & GIF images are allowed";
         }elseif($_FILES["file"]["size"] > 2000000){
            $error_msg = "Image file size exceeds 2MB limit";
         }
      }
   }

   return $error_msg;
}


//////////////////////////////////////put together more dynamic??????
function unlink_image(){
   if(!empty($_SESSION['prod_product_image_title'])){
      $target = UPLOAD_DIRECTORY.DS.$_SESSION['prod_product_image_title'];
      unlink($target);
   }
}
function unlink_slide_image(){
   if(!empty($_SESSION['slid_slide_image_title'])){
      $target = UPLOAD_DIRECTORY.DS.$_SESSION['slid_slide_image_title'];
      unlink($target);
   }
}
function unlink_category_image(){
   if(!empty($_SESSION['cat_category_image_title'])){
      $target = UPLOAD_DIRECTORY.DS.$_SESSION['cat_category_image_title'];
      unlink($target);
   }
}


function unlink_nondb_images(){
   $dir = UPLOAD_DIRECTORY."/*";

   foreach(glob($dir) as $file){
      $file = basename($file);

      $get_product = dbcommand("SELECT * FROM products WHERE product_image = '{$file}' LIMIT 1");
      confirm($get_product);
      $get_slide = dbcommand("SELECT * FROM slides WHERE slide_image = '{$file}' LIMIT 1");
      confirm($get_slide);
      $get_category = dbcommand("SELECT * FROM categories WHERE cat_image = '{$file}' LIMIT 1");
      confirm($get_category);

      if(mysqli_num_rows($get_product) == 0 && mysqli_num_rows($get_slide) == 0 && mysqli_num_rows($get_category) == 0){
         $target = UPLOAD_DIRECTORY.DS.$file;
         unlink($target);
      }
   }
}


/////////////////////////////////////////////make dynamic by combining?????????????
function unset_product(){
   foreach($_SESSION as $name => $value){
      $length = strlen($name);
      $string = substr($name, 5, $length);
      unset($_SESSION['prod_' . $string]);
   }
}
function unset_slide(){
   foreach($_SESSION as $name => $value){
      $length = strlen($name);
      $string = substr($name, 5, $length);
      unset($_SESSION['slid_' . $string]);
   }
}
function unset_category(){
   foreach($_SESSION as $name => $value){
      $length = strlen($name);
      $string = substr($name, 4, $length);
      unset($_SESSION['cat_' . $string]);
   }
}


/*************************Categories in Admin*********************/

function show_categories_in_admin(){
   $page = set_page();
   $section = set_section();
   $display = set_display();

   $get_categories = dbcommand("SELECT * FROM categories ORDER BY cat_title ASC");
   confirm($get_categories);

   while($row = fetch_array($get_categories)){
      $cat_title = $row['cat_title'];
      $cat_description = $row['cat_description'];

      $category = <<<DELIMETER
      <tr>
         <td>{$cat_title}</td>
         <td>{$cat_description}</td>
         <td>
            <a class="btn btn-primary" href="index.php?edit_category={$row['cat_id']}&page=$page&section=categories">
            <span style="margin-left:5px;margin-right:5px;">Edit</span>
            </a>
      DELIMETER;
      if($display == "categories" || $section == "categories"){
         $category .= <<<DELIMETER
         <span></span>
         <a class="btn btn-danger" href="index.php?delete_category={$row['cat_id']}&page=$page&section=categories">
            <span>Delete</span>
         </a>
         DELIMETER;
      }elseif($display == "edit_category" || $section == "edit_category"){
         $category .= <<<DELIMETER
         <span style="padding-left:71px"></span>
         DELIMETER;
      }
      $category .= <<<DELIMETER
         </td>
      </tr>
      DELIMETER;

      echo $category;
   }
}



function add_category(){
   $category_valid = 0;
   $category_error_msg=$image_error_msg = "";
   
   if(isset($_POST['submit'])){
      $category_title=$_SESSION['cat_category_title'] = sanitize(escape_string($_POST['category_title']));
      $category_description=$_SESSION['cat_category_description'] = sanitize(escape_string($_POST['category_description']));
      $category_error_msg = validate_category_details($category_title,"add");

      $category_image = $_FILES['file']['name'];
      if(!empty($category_image)){
         $category_image = "category-".$_FILES['file']['name'];
      }
      $category_image_tmp = $_FILES['file']['tmp_name'];
      $target_file = UPLOAD_DIRECTORY.DS.basename($category_image);

      if(!empty($category_image) || empty($_SESSION['cat_category_image'])){
         if($category_image != $_SESSION['cat_category_image_title'] || empty($category_image)){
            $image_error_msg = validate_image($category_image,$category_image_tmp,$target_file);

            if(empty($image_error_msg)){
               if(move_uploaded_file($category_image_tmp, $target_file)){
                  unlink_category_image();
                  $_SESSION['cat_category_image_title'] = $category_image;
                  $_SESSION['cat_category_image'] = display_image($category_image);   
               }else{
                  $image_error_msg = "Error adding category image";
               }
            }
         }
      }

      if(empty($category_error_msg) && empty($image_error_msg)){
         $category_valid = 1;
         insert_category();
         unset_category();
         $category_id = last_id();
         set_message("<h3 class='bg-success'>New Category Added id: {$category_id}</h3>");
         if(isset($_GET['categories'])){
            redirect("index.php?categories");
         }elseif(isset($_GET['dashboard'])){
            redirect("index.php?dashboard=categories");
         }
      }else{
         if(!empty($category_error_msg) && !empty($image_error_msg)){
            $category_error_msg .= " / ";
         }
         set_message("<h3 class='bg-danger'>$category_error_msg $image_error_msg</h3>");
      }
   }else{
      unlink_nondb_images();
      unset_category();
      get_category();
   }

   return $category_valid;
}





function insert_category(){
   $add_category  = "INSERT INTO categories ";
   $add_category .= "(cat_title, cat_description, cat_image) ";
   $add_category .= "VALUES ";
   $add_category .= "('{$_SESSION['cat_category_title']}', '{$_SESSION['cat_category_description']}', '{$_SESSION['cat_category_image_title']}')";
   $add_category = dbcommand($add_category);
   confirm($add_category);
}



function edit_category(){
   $category_valid = 0;
   $category_error_msg=$image_error_msg = "";
   
   if(isset($_POST['submit'])){
      $category_title=$_SESSION['cat_category_title']             = sanitize(escape_string($_POST['category_title']));
      $category_description=$_SESSION['cat_category_description'] = sanitize(escape_string($_POST['category_description']));

      $category_error_msg = validate_category_details($category_title,"update");
      if(empty($category_error_msg)){
         update_category("category");
      }

      $category_image = $_FILES['file']['name'];
      if(!empty($category_image)){
         $category_image = "category-".$_FILES['file']['name'];
      }
      $category_image_tmp = $_FILES['file']['tmp_name'];
      $target_file = UPLOAD_DIRECTORY.DS.basename($category_image);


      if(!empty($category_image) || empty($_SESSION['cat_category_image'])){
         if($category_image != $_SESSION['cat_category_image_title'] || empty($category_image)){
            $image_error_msg = validate_image($category_image,$category_image_tmp,$target_file);

            if(empty($image_error_msg)){
               if(move_uploaded_file($category_image_tmp, $target_file)){
                  unlink_image();
                  $_SESSION['cat_category_image_title'] = $category_image;
                  $_SESSION['cat_category_image'] = display_image($category_image);
                  update_category("image");
               }else{
                  $image_error_msg = "Error adding category image";
               }
            }
         }
      }
      if(empty($category_error_msg) && empty($image_error_msg)){
         $category_valid = 1;
         unset_category();
         set_message("<h3 class='bg-success'>Category Updated id: {$_GET['edit_category']}</h3>");
         redirect_page();
      }else{
         if(!empty($category_error_msg) && !empty($image_error_msg)){
            $category_error_msg .= " / ";
         }
         set_message("<h3 class='bg-danger'>$category_error_msg $image_error_msg</h3>");
      }
   }else{
      unlink_nondb_images();
      unset_category();
      get_category();
   }

   return $category_valid;
}




function update_category($update){
   if($update == "category"){
      $update_category  = "UPDATE categories SET ";
      $update_category .= "cat_title            = '{$_SESSION['cat_category_title']}'        , ";
      $update_category .= "cat_description      = '{$_SESSION['cat_category_description']}'    ";
      $update_category .= "WHERE cat_id = " .escape_string($_GET['edit_category']);
      $update_category = dbcommand($update_category);
      confirm($update_category);
   }elseif($update == "image"){
      $update_category_image = "UPDATE categories SET cat_image = '{$_SESSION['cat_category_image_title']}' WHERE cat_id = " .escape_string($_GET['edit_category']);
      $update_category_image = dbcommand($update_category_image);
      confirm($update_category_image);
   }
}



function get_category(){
   if(isset($_GET['categories']) || isset($_GET['dashboard'])){
      $_SESSION['cat_category_title']=$_SESSION['cat_category_description']=$_SESSION['cat_category_image_title']=$_SESSION['cat_category_image'] = "";
   }
   elseif(isset($_GET['edit_category'])){
      $get_category = dbcommand("SELECT * FROM categories WHERE cat_id = '{$_GET['edit_category']}' LIMIT 1");
      confirm($get_category);
   
      if(mysqli_num_rows($get_category) != 0){
         $row = fetch_array($get_category);
         $_SESSION['cat_category_title']       = escape_string($row['cat_title']);
         $_SESSION['cat_category_title_db']    = escape_string($row['cat_title']);
         $_SESSION['cat_category_description'] = escape_string($row['cat_description']);
         $_SESSION['cat_category_image_title'] = escape_string($row['cat_image']);
         $_SESSION['cat_category_image']       = display_image($row['cat_image']);
      }
   }
}




function validate_category_details($category_title,$function){
   $error_msg = "";

   if(empty($category_title) || empty($_SESSION['cat_category_description'])){
      $error_msg = "All entries must contain values";
   }else{
      $get_category = dbcommand("SELECT * FROM categories WHERE cat_title = '{$category_title}' LIMIT 1");
      confirm($get_category);
      if($function == "add"){
         if(mysqli_num_rows($get_category) != 0){
            $error_msg = "Title already exists";
         }
      }elseif($function == "update"){
         if(mysqli_num_rows($get_category) != 0){
            if(strcasecmp($category_title,$_SESSION['cat_category_title_db']) != 0){
               $error_msg = "Title not available";
            }
         }
      }
   }

   return $error_msg;
}





/************************admin users***********************/

function display_users(){
   $get_users = dbcommand("SELECT * FROM users ORDER BY username ASC");
   confirm($get_users);

   while($row = fetch_array($get_users)){
      $user_id = $row['user_id'];
      $username = $row['username'];
      $password = $row['password'];
      $email = $row['email'];
      $account = $row['account'];

      $user = <<<DELIMETER
      <tr>
         <td>{$user_id}</td>
         <td>{$username}</td>
         <td>{$email}</td>
         <td>{$account}</td>
         <td>
            <a class="btn btn-danger" href="index.php?delete_user={$row['user_id']}">
               <span>Delete</span>
            </a>
         </td>
      </tr>
      DELIMETER;

      echo $user;
   }
}

function add_user(){
   if(isset($_POST['submit'])){
      $username         = sanitize(escape_string($_POST['username']));
      $password         = sanitize(escape_string($_POST['password']));
      $password_confirm = sanitize(escape_string($_POST['password_confirm']));
      $email            = sanitize(escape_string($_POST['email']));
      $account = "customer";
 
      if(!empty($username) && !empty($password) && !empty($password_confirm) && !empty($email)){
         $get_user = dbcommand("SELECT * FROM users WHERE username = '{$username}' LIMIT 1");
         confirm($get_user);

         if(mysqli_num_rows($get_user) == 0){
            if($password == $password_confirm){
               $add_user = dbcommand("INSERT INTO users (username, password, email, account) VALUES ('{$username}', '{$password}', '{$email}', '{$account}')");
               $userid = last_id();
               confirm($add_user);
   
               login_success($userid,$username,$account);
               set_message("<h3 class='bg-success text-center'>Account created for $username</h3>");
               redirect("index.php");
            }else{
               set_message("<h3 class='bg-danger text-center'>Passwords don't match</h3>");
               redirect("add_user.php");
            }
         }else{
            set_message("<h3 class='bg-danger text-center'>Username not available</h3>");
            redirect("add_user.php");
         }
      }else{
         set_message("<h3 class='bg-danger text-center'>Username, Password, and Email must contain values</h3>");
         redirect("add_user.php");
      }
   }
}

function update_user(){
   get_user();

   if(isset($_POST['submit'])){
      $username         = sanitize(escape_string($_POST['username']));
      $password         = sanitize(escape_string($_POST['password']));
      $password_confirm = sanitize(escape_string($_POST['password_confirm']));
      $email            = sanitize(escape_string($_POST['email']));
 
      if(!empty($username) && !empty($password) && !empty($password_confirm) && !empty($email)){
         $get_user = dbcommand("SELECT * FROM users WHERE username = '{$username}' LIMIT 1");
         confirm($get_user);

         if(mysqli_num_rows($get_user) == 0 || strcasecmp($username,$_SESSION['username']) == 0){
            if($password == $password_confirm){
               $_SESSION['username'] = $username;

               $update_user = "UPDATE users SET ";
               $update_user .= "username  = '{$username}', ";
               $update_user .= "password  = '{$password}', ";
               $update_user .= "email     = '{$email}' ";
               $update_user .= "WHERE user_id =" . escape_string($_SESSION['userid']);
               $update_user = dbcommand($update_user);
               confirm($update_user);
   
               set_message("<h3 class='bg-success text-center'>Account updated for $username</h3>");
               redirect("index.php");
            }else{
               set_message("<h3 class='bg-danger text-center'>Passwords don't match</h3>");
               redirect("edit_user.php");
            }
         }else{
            set_message("<h3 class='bg-danger text-center'>Username Not Available</h3>");
            redirect("edit_user.php");
         }
      }else{
         set_message("<h3 class='bg-danger text-center'>Username, Password, and Email must contain values</h3>");
         redirect("edit_user.php");
      }
   }
}

function get_user(){
   $_GET['username']=$_GET['password']=$_GET['email'] = "";
   if(isset($_SESSION['userid'])){
      $get_user = dbcommand("SELECT * FROM users WHERE user_id = '{$_SESSION['userid']}' LIMIT 1");
      confirm($get_user);

      if(mysqli_num_rows($get_user) != 0){
         $row = fetch_array($get_user);
         $_GET['username'] = escape_string($row['username']);
         $_GET['password'] = escape_string($row['password']);
         $_GET['email']    = escape_string($row['email']);
      }
   }
}

function get_reports(){
   $get_reports = dbcommand("SELECT * FROM reports ORDER BY report_id DESC");
   confirm($get_reports);
   while($row = fetch_array($get_reports)){
      $product_price = number_format($row['product_price'],2);
      $product_total = number_format($row['product_total'],2);
      $report = <<<DELIMETER
      <tr>
         <td>{$row['report_id']}</td>
         <td>{$row['order_id']}</td>
         <td>{$row['product_id']}</td>
         <td>{$row['product_title']}
         <td>&#163;{$product_price}</td>
         <td>{$row['product_quantity']}</td>
         <td>&#163;{$product_total}</td>
         <td>
            <a class="btn btn-danger" href="./index.php?delete_report={$row['report_id']}">
               <span>Delete</span>
            </a>
         </td>
      </tr>
      DELIMETER;

      echo $report;
   }
}


//////// SLIDES ////////

function add_slide(){
   $slide_valid = 0;
   $slide_error_msg=$image_error_msg = "";
   
   if(isset($_POST['submit'])){
      $slide_title=$_SESSION['slid_slide_title'] = sanitize(escape_string($_POST['slide_title']));
      $slide_error_msg = validate_slide_details($slide_title);

      $slide_image = $_FILES['file']['name'];
      if(!empty($slide_image)){
         $slide_image = "slide-".$_FILES['file']['name'];
      }
      $slide_image_tmp = $_FILES['file']['tmp_name'];
      $target_file = UPLOAD_DIRECTORY.DS.basename($slide_image);

      if(!empty($slide_image) || empty($_SESSION['slid_slide_image'])){
         if($slide_image != $_SESSION['slid_slide_image_title'] || empty($slide_image)){
            $image_error_msg = validate_image($slide_image,$slide_image_tmp,$target_file);

            if(empty($image_error_msg)){
               if(move_uploaded_file($slide_image_tmp, $target_file)){
                  unlink_slide_image();
                  $_SESSION['slid_slide_image_title'] = $slide_image;
                  $_SESSION['slid_slide_image'] = display_image($slide_image);   
               }else{
                  $image_error_msg = "Error adding slide image";
               }
            }
         }
      }

      if(empty($slide_error_msg) && empty($image_error_msg)){
         $slide_valid = 1;
         insert_slide();
         unset_slide();
         $slide_id = last_id();
         set_message("<h3 class='bg-success'>New Slide Added id: {$slide_id}</h3>");
         redirect("index.php?slides");
      }else{
         if(!empty($slide_error_msg) && !empty($image_error_msg)){
            $slide_error_msg .= " / ";
         }
         set_message("<h3 class='bg-danger'>$slide_error_msg $image_error_msg</h3>");
      }
   }else{
      unlink_nondb_images();
      unset_slide();
      get_slide();
   }

   return $slide_valid;
}



function insert_slide(){
   $add_slide  = "INSERT INTO slides ";
   $add_slide .= "(slide_title, slide_image) ";
   $add_slide .= "VALUES ";
   $add_slide .= "('{$_SESSION['slid_slide_title']}', '{$_SESSION['slid_slide_image_title']}')";
   $add_slide = dbcommand($add_slide);
   confirm($add_slide);
}




function get_slide(){
   $_SESSION['slid_slide_title']=$_SESSION['slid_slide_image_title']=$_SESSION['slid_slide_image'] = "";
}




function validate_slide_details($slide_title){
   $error_msg = "";

   if(empty($slide_title)){
      $error_msg = "Enter a title";
   }else{
      $get_slide = dbcommand("SELECT * FROM slides WHERE slide_title = '{$slide_title}' LIMIT 1");
      confirm($get_slide);

      if(mysqli_num_rows($get_slide) != 0){
         $error_msg = "Title already exists";
      }
   }

   return $error_msg;
}


function get_slide_thumbnails_admin(){
   $get_slides = dbcommand("SELECT * FROM slides ORDER BY slide_id DESC");
   confirm($get_slides);

   if(mysqli_num_rows($get_slides) != 0){
      $slides = <<<DELIMETER
      <hr>
      <h3>Slides Available (click to delete)</h3>
      <div class="slide-container-admin">
      DELIMETER;

      while($row = fetch_array($get_slides)){
         $slide_image = display_image($row['slide_image']);

         $slides .= <<<DELIMETER
         <div class="slide-admin">
            <a href="index.php?delete_slide={$row['slide_id']}">
               <img class="slide-img-admin" src="../../resources/{$slide_image}" alt="">
            </a>
            <div>
               <p class="fontsize14">{$row['slide_title']}</p>
            </div>
         </div>
         DELIMETER;
      }

      $slides .= <<<DELIMETER
         <div class="slide-admin"></div>
      </div>
      DELIMETER;
      
      echo $slides;
   }
}


function carousel_indicators(){
   $get_slides = dbcommand("SELECT * FROM slides");
   confirm($get_slides);
   $counter = 1;

   while($row = fetch_array($get_slides)){      
      $carousel_indicators = <<<DELIMETER
      <li data-target="#carousel-example-generic" data-slide-to=$counter></li>
      DELIMETER;
      $counter++;
      echo $carousel_indicators;
   }
}

function get_active_slide_home(){
   $get_slide = dbcommand("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
   confirm($get_slide);

   while($row = fetch_array($get_slide)){
      $slide_image = display_image($row['slide_image']);
      $slide_active = <<<DELIMETER
      <div class="item active">
         <img class="slide-image slide-img-home" src="../resources/{$slide_image}" alt="">
      </div>
      DELIMETER;

      echo $slide_active;
   }
}

function get_slides_home(){
   $get_slides = dbcommand("SELECT * FROM slides");
   confirm($get_slides);

   while($row = fetch_array($get_slides)){
      $slide_image = display_image($row['slide_image']);
      
      $slides = <<<DELIMETER
      <div class="item">
         <img class="slide-image slide-img-home" src="../resources/{$slide_image}" alt="">
      </div>
      DELIMETER;

      echo $slides;
   }
}