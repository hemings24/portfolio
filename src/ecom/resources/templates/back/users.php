<h1 class="page-header">Users</h1>
<?php display_message(); ?>

<table class="table table-hover table-striped">
   <thead><tr>
      <th>Id</th>
      <th>Username</th>
      <th>Email</th>
      <th>Account</th>
   </tr></thead>
   <tbody>
      <?php display_users(); ?>
   </tbody>
</table>