<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container main">
   <div>
      <h1 class="text-center">Create Account</h1>
      <?php display_message(); ?>
   </div>

   <div class="login-center">
      <form action="" method="post" enctype="multipart/form-data">
         <?php add_user(); ?>
         <div class="form-group">
            <label for="">
               Username<input type="text" name="username" class="form-control">
            </label>
         </div>
         <div class="form-group">
            <label for="password">
               Password<input type="password" name="password" class="form-control">
            </label>
            <div></div>
            <label for="password_confirm">
               Confirm Password<input type="password" name="password_confirm" class="form-control">
            </label>
         </div>
         <div class="form-group">
            <label for="">
               Email<input type="text" name="email" class="form-control">
            </label>
         </div>
         <div class="form-group">
            <input type="submit" name="submit" value="Continue" class="btn btn-primary">
         </div>
      </form>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>