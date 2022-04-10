<?php require_once("../../resources/config.php");

if(isset($_GET['delete_category'])){
   $get_category = dbcommand("SELECT cat_image FROM categories WHERE cat_id = " .escape_string($_GET['delete_category']));
   confirm($get_category);

   $row = fetch_array($get_category);
   $target_path = UPLOAD_DIRECTORY.DS.$row['cat_image'];
   unlink($target_path);

   $delete_category = dbcommand("DELETE FROM categories WHERE cat_id = " .escape_string($_GET['delete_category']));
   confirm($delete_category);

   set_message("<h3 class='bg-success'>Category Deleted</h3>");
}
redirect_page();

?>