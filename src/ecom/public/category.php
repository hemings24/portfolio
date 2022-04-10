<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div><div class="container">
   <div style="margin-left:15px;margin-right:15px;">
      <?php get_cat_header(); ?>
   </div>
</div></div>

<div class="container main">
   <div style="margin-left:15px;margin-right:15px;">
      <header>
         <h2>Latest Products</h2>
      </header>
      <hr>
      <?php display_message(); ?>
      <div class="row text-center">
         <?php get_products_in_cat_page(); ?>
      </div>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>