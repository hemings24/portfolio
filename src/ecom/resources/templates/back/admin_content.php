<!--FIRST ROW WITH PANELS-->
<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">
         Dashboard <small>Statistics</small>
      </h1>
      <ol class="breadcrumb">
         <li class="active"><i class="fa fa-dashboard"></i> Overview</li>
      </ol>
   </div>
</div>
                
<div class="row">
   <div class="col-lg-4 col-md-6">
      <div class="panel panel-yellow">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-shopping-cart fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo count_all_records('orders'); ?></div>
                  <div>New Orders!</div>
               </div>
            </div>
         </div>
         <a href="index.php?dashboard=orders">
            <div class="panel-footer">
               <span class="pull-left fontsize14">View Details</span>
               <span class="pull-right fontsize14"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>

   <div class="col-lg-4 col-md-6">
      <div class="panel panel-red">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-tag fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo count_all_records('products'); ?></div>
                  <div>Products!</div>
               </div>
            </div>
         </div>
         <a href="index.php?dashboard=products">
            <div class="panel-footer">
               <span class="pull-left fontsize14">View Details</span>
               <span class="pull-right fontsize14"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
          
   <div class="col-lg-4 col-md-6">
      <div class="panel panel-green">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-list-check fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo count_all_records('categories'); ?></div>
                  <div>Categories!</div>
               </div>
            </div>
         </div>
         <a href="index.php?dashboard=categories">
            <div class="panel-footer">
               <span class="pull-left fontsize14">View Details</span>
               <span class="pull-right fontsize14"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
</div>        

<?php

if(isset($_GET['dashboard'])){
   if($_GET['dashboard'] == "products"){
      include(TEMPLATE_BACK."/products.php");
   }elseif($_GET['dashboard'] == "categories"){
      include(TEMPLATE_BACK."/categories.php");
   }else{
      include(TEMPLATE_BACK."/orders.php");
   }
}else{
   if(isset($_GET['page']) && isset($_GET['section'])){
      if($_GET['section'] == "categories" || $_GET['section'] == "edit_category"){
         include(TEMPLATE_BACK."/edit_category.php");
      }
   }else{
      include(TEMPLATE_BACK."/orders.php");
   }
}

?>