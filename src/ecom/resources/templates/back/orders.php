<div class="col-md-12">
   <div class="row">
      <h1 class="page-header">Orders</h1>
      <?php display_message(); ?>
   </div>
   <div class="row">
      <table class="table table-hover table-striped">
         <thead><tr>
            <th>Id</th>
            <th>Total</th>
            <th>Currency</th>
            <th>Transaction</th>
            <th>Status</th>
            <th>Date</th>
         </tr></thead>
         <tbody>
            <?php display_orders(); ?>
         </tbody>
      </table>
   </div>
</div>