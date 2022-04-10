<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container main">
   <?php include(TEMPLATE_FRONT.DS."side_nav.php") ?>

   <?php
   if(isset($_GET['id'])){
      $get_product = dbcommand("SELECT * FROM products WHERE product_id = " .escape_string($_GET['id']));
      confirm($get_product);
   }

   while($row = fetch_array($get_product)):
   ?>

   <div class="col-md-9" style="margin-top:20px">
      <?php display_message(); ?>
      <!--Row For Image and Short Description-->
      <div class="row">
         <div class="col-md-7">
            <img class="img-responsive" src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
         </div>
         <div class="col-md-5">
            <div class="thumbnail">
               <div class="caption-full">
                  <h4><a href="#"><?php echo $row['product_title']; ?></a> </h4>
                  <hr>
                  <h4 class=""><?php echo "&#163;" .number_format($row['product_price'],2); ?></h4>

                  <div class="ratings">
                     <p class="fontsize14">
                        <span class="glyphicon glyphicon-star fontsize14"></span>
                        <span class="glyphicon glyphicon-star fontsize14"></span>
                        <span class="glyphicon glyphicon-star fontsize14"></span>
                        <span class="glyphicon glyphicon-star fontsize14"></span>
                        <span class="glyphicon glyphicon-star-empty fontsize14"></span>
                        4.0 stars
                     </p>
                  </div>
          
                  <p class="fontsize14"><?php echo $row['product_short_desc']; ?></p>

                  <form action="">
                     <div class="form-group">
                        <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>&atbPage=item" class="btn btn-primary">
                           Add to Basket
                        </a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <hr>

      <!--Row for Tab Panel-->
      <div class="row">
         <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
               <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
               <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
            </ul>
            <!-- Tab panels -->
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="home">
                  <p></p>
                  <p class="fontsize14"><?php echo $row['product_description']; ?></p>
               </div>
               <div role="tabpanel" class="tab-pane" id="profile">
                  <div class="col-md-6">
                     <h3>3 Reviews From </h3>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           Anonymous
                           <span class="pull-right fontsize14">10 days ago</span>
                           <p class="fontsize14">This product was great in terms of quality. I would definitely buy another!</p>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star-empty fontsize14"></span>
                           Anonymous
                           <span class="pull-right fontsize14">12 days ago</span>
                           <p class="fontsize14">I've alredy ordered another one!</p>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star-empty fontsize14"></span>
                           Anonymous
                           <span class="pull-right fontsize14">15 days ago</span>
                           <p class="fontsize14">I've seen some better than this, but not at this price. I definitely recommend this item.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-8 col-md-7 col-lg-6">
                     <h3>Add a Review</h3>
                     <form action="" method="post" class="form-inline">
                        <?php send_message("item"); ?>
                        <div class="form-group">
                           <label for="">Name</label>
                           <input type="text" name="name" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name">
                        </div>
                        <div class="form-group">
                           <label for="">Email</label>
                           <input type="email" name="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address">
                        </div>
                        <div>
                           <h3>Your Rating</h3>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                           <span class="glyphicon glyphicon-star fontsize14"></span>
                        </div>
                        <br>       
                        <div class="form-group">
                           <textarea name="message" cols="60" rows="10" class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message"></textarea>
                        </div>
                        <br><br>
                        <div class="form-group">
                           <input type="hidden" name="subject" value="Product Review: <?php echo $row['product_title']; ?>">
                           <input type="hidden" name="id" value="{escape_string($_GET['id'])}">
                           <input type="submit" name="submit" value="Send" class="btn btn-primary">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php endwhile; ?>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>