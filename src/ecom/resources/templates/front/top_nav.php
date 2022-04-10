<div class="container">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
   </div>
   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav">
         <li><a href="shop.php">Shop</a></li>
         <li><a href="checkout.php">Checkout</a></li>
         <li><a href="contact.php">Contact</a></li>
         <li><a href="admin/index.php?dashboard=orders">Admin</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <?php echo isset($_SESSION['userid']) ? "<i class='fa fa-user'></i><span class='fontsize14' style='margin-left:8px'>{$_SESSION['username']}</span>" : "<li><a href='login.php?loginpage=customer'><i class='fa fa-user'></i><span class='fontsize14' style='margin-left:8px'>Sign in</span></a></li>"; ?>
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li class="divider"></li>
               <li>
                  <a href="edit_user.php"><i class="fa fa-fw fa-user-edit"></i> Edit account</a>
               </li>
               <li>
                  <a href="login.php?loginpage=switch"><i class="fa fa-fw fa-exchange-alt"></i> Switch account</a>
               </li>
               <li>
                  <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Sign out</a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</div>