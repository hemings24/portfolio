<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container main">
   <div class="row">
      <div class="col-lg-12 text-center">
         <h1 class="section-heading">Contact Us</h1>
         <?php display_message(); ?>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <form name="sentMessage" id="contactForm" method="post">
            <?php send_message("contact"); ?>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <input type="text" name="name" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name">
                     <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                     <input type="email" name="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address">
                     <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                     <input name="subject" type="text" class="form-control" placeholder="Your Subject" id="phone" required data-validation-required-message="Please enter your phone number">
                     <p class="help-block text-danger"></p>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <textarea name="message" class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message"></textarea>
                     <p class="help-block text-danger"></p>
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="col-lg-12 text-center">
                  <div id="success"></div>
                  <button type="submit" name="submit" class="btn btn-xl">Send</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>