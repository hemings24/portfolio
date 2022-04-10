<h1 class="page-header">Reports</h1>
<?php display_message(); ?>

<table class="table table-hover table-striped">
   <thead><tr>
      <th>Id</th>
      <th>Order Id</th>
      <th>Product Id</th>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
   </tr></thead>
   <tbody>
      <?php get_reports(); ?>
   </tbody>
</table>