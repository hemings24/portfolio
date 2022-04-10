<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container main">
   <div style="margin-left:15px;margin-right:15px;">
      <header>
         <h1>Shop</h1>
      </header>
      <hr>
      <?php display_message(); ?>
      <div class="row text-center">
         <?php get_products_with_pagination("shop"); ?>
      </div>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>