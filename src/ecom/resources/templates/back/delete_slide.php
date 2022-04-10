<?php require_once("../../resources/config.php");

if(isset($_GET['delete_slide'])){
   $get_slide = dbcommand("SELECT slide_image FROM slides WHERE slide_id = " .escape_string($_GET['delete_slide']));
   confirm($get_slide);

   $row = fetch_array($get_slide);
   $target_path = UPLOAD_DIRECTORY.DS.$row['slide_image'];
   unlink($target_path);

   $delete_slide = dbcommand("DELETE FROM slides WHERE slide_id = " .escape_string($_GET['delete_slide']));
   confirm($delete_slide);

   set_message("<h3 class='bg-success'>Slide Deleted</h3>");
}
redirect("index.php?slides");

?>