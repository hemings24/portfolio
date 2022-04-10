<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
   <ol class="carousel-indicators">
      <?php carousel_indicators(); ?>
   </ol>
   <div class="carousel-inner">
      <?php get_active_slide_home(); ?>
      <?php get_slides_home(); ?>
   </div>
   <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
   </a>
   <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
   </a>
</div>