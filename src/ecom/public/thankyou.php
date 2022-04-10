<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

<?php process_transaction(); ?>

<div class="container main" style="margin-top:10px">
   <h3 class="text-center">Thank you for your payment.</h3>
   <h3 class="text-center">
      Your transaction has been completed and we've emailed you a receipt of your purchase.
      Log in to your PayPal account to view transaction details.
   </h3>
</div>

<?php include(TEMPLATE_FRONT.DS."footer.php") ?>