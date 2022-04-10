<?php require_once("../../resources/config.php");

if(isset($_GET['delete_report'])){
   $delete_report = dbcommand("DELETE FROM reports WHERE report_id = " .escape_string($_GET['delete_report']));
   confirm($delete_report);
   set_message("<h3 class='bg-success'>Report Deleted</h3>");
}
redirect("./index.php?reports");

?>