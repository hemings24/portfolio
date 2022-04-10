<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<div class="container main">
   <div>
      <h1 class="text-center">
      <?php
      $pagetitle = "Sign in";
      if(isset($_GET['loginpage'])){
         if($_GET['loginpage'] == "admin"){
            $pagetitle = "Sign in (Admin)";
         }elseif($_GET['loginpage'] == "switch"){
            $pagetitle = "Switch Account";
         }
      }
      echo $pagetitle;
      ?>
      </h1>
      <?php display_message(); ?>
   </div>

   <div class="login-center">
      <form action="" method="post" enctype="multipart/form-data">
         <?php login_user(); ?>
         <div class="form-group">
            <label for="">
               Username<input type="text" name="username" class="form-control">
            </label>
         </div>
         <div class="form-group">
            <label for="password">
               Password<input type="password" name="password" class="form-control">
            </label>
         </div>    
         <div class="form-group">
            <input type="submit" name="submit" value="Sign in" class="btn btn-primary">
         </div>

         <div class="form-group">
            <?php
            if(!isset($_SESSION['userid']) && isset($_GET['loginpage']) && $_GET['loginpage'] == "customer"){
               $newaccount = <<<DELIMETER
               <div style="margin-top:70px">
                  <span class="fontsize14" style="margin-right:10px">New to Website?</span>
                  <a href="add_user.php" class="btn btn-primary">Create Account</a>
               </div>
               DELIMETER;
               echo $newaccount; 
            }
            ?>
         </div> 
      </form>
   </div>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>