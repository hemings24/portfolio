<?php require_once("../../resources/config.php");

if(isset($_GET['delete_order'])){
   $delete_order = dbcommand("DELETE FROM orders WHERE order_id = " .escape_string($_GET['delete_order']));
   confirm($delete_order);
   set_message("<h3 class='bg-success'>Order Deleted</h3>");
}
redirect_page();

?>