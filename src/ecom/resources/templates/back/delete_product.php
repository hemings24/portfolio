<?php require_once("../../resources/config.php");

if(isset($_GET['delete_product'])){
   $get_product = dbcommand("SELECT product_image FROM products WHERE product_id = " .escape_string($_GET['delete_product']));
   confirm($get_product);

   $row = fetch_array($get_product);
   $target_path = UPLOAD_DIRECTORY.DS.$row['product_image'];
   unlink($target_path);

   $delete_product = dbcommand("DELETE FROM products WHERE product_id = " .escape_string($_GET['delete_product']));
   confirm($delete_product);
   
   set_message("<h3 class='bg-success'>Product Deleted</h3>");
}
redirect_page();

?>