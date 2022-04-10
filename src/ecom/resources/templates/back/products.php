<h1 class="page-header">Products</h1>
<?php display_message(); ?>

<table class="table table-hover table-striped">
   <thead><tr>
      <th>Id</th>
      <th>Category</th>
      <th>Title</th>
      <th>Price</th>
      <th>Quantity</th>
   </tr></thead>
   <tbody>
      <?php
         unlink_nondb_images(); 
         get_products_in_admin();
      ?>
  </tbody>
</table>