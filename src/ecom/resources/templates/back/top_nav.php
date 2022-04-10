<div class="navbar-header">
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
   </button>
   <a class="navbar-brand" href="../index.php">Home</a>
</div>

<ul class="nav navbar-right top-nav" style='padding-left:4px;padding-right:30px;'>
   <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
         <?php echo isset($_SESSION['userid']) ? "<i class='fa fa-user'></i><span class='fontsize14' style='margin-left:8px'>{$_SESSION['username']}</span>" : "<span class='fontsize14'>guest</span>"; ?>
         <b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
         <li class="divider"></li>
         <li>
            <a href="../../public/edit_user.php"><i class="fa fa-fw fa-user-edit"></i> Edit account</a>
         </li>
         <li>
            <a href="../../public/login.php?loginpage=switch"><i class="fa fa-fw fa-exchange-alt"></i> Switch account</a>
         </li>
         <li>
            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Sign out</a>
         </li>
      </ul>
   </li>
</ul>