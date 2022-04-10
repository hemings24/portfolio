<?php require_once("../../resources/config.php");

if(isset($_GET['delete_user'])){
   $delete_user = dbcommand("DELETE FROM users WHERE user_id = " .escape_string($_GET['delete_user']));
   confirm($delete_user);
   set_message("<h3 class='bg-success'>User Deleted</h3>");
}
redirect("./index.php?users");

?>