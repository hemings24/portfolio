<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK."/header.php"); ?>

<!--?php admin_security_check(); ?-->

<div id="page-wrapper">
   <div class="container-fluid admincontainerfix">

      <?php
      if($_SERVER['REQUEST_URI'] == "/ecom/public/admin/" || $_SERVER['REQUEST_URI'] == "/ecom/public/admin/index.php"){
         include(TEMPLATE_BACK."/admin_content.php");
      }
      if(isset($_GET['dashboard'])){
         include(TEMPLATE_BACK."/admin_content.php");
      }
      if(isset($_GET['orders'])){
         include(TEMPLATE_BACK."/orders.php");
      }
      if(isset($_GET['categories'])){
         include(TEMPLATE_BACK."/categories.php");
      }
      if(isset($_GET['edit_category'])){
         if(isset($_GET['page'])){
            if($_GET['page'] == "categories" || $_GET['page'] == "edit_category"){
               include(TEMPLATE_BACK."/edit_category.php");
            }elseif($_GET['page'] == "dashboard"){
               include(TEMPLATE_BACK."/admin_content.php");
            }
         }
      }
      if(isset($_GET['products'])){
         include(TEMPLATE_BACK."/products.php");
      }
      if(isset($_GET['add_product'])){
         include(TEMPLATE_BACK."/add_product.php");
      }
      if(isset($_GET['edit_product'])){
         include(TEMPLATE_BACK."/edit_product.php");
      }
      if(isset($_GET['users'])){
         include(TEMPLATE_BACK."/users.php");
      }
      if(isset($_GET['add_user'])){
         include(TEMPLATE_BACK."/add_user.php");
      }
      if(isset($_GET['edit_user'])){
         include(TEMPLATE_BACK."/edit_user.php");
      }
      if(isset($_GET['reports'])){
         include(TEMPLATE_BACK."/reports.php");
      }
      if(isset($_GET['slides'])){
         include(TEMPLATE_BACK."/slides.php");
      }
      if(isset($_GET['delete_order'])){
         include(TEMPLATE_BACK."/delete_order.php");
      }
      if(isset($_GET['delete_product'])){
         include(TEMPLATE_BACK."/delete_product.php");
      }
      if(isset($_GET['delete_category'])){
         include(TEMPLATE_BACK."/delete_category.php");
      }
      if(isset($_GET['delete_report'])){
         include(TEMPLATE_BACK."/delete_report.php");
      }
      if(isset($_GET['delete_user'])){
         include(TEMPLATE_BACK."/delete_user.php");
      }
      if(isset($_GET['delete_slide'])){
         include(TEMPLATE_BACK."/delete_slide.php");
      }
      ?>
      
   </div>
</div>

<?php include(TEMPLATE_BACK."/footer.php"); ?>