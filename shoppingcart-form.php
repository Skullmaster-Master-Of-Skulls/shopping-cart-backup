<?php
  
   $total = 100.00;
   echo "<h3>The test total is: ".$total."</h3>";
?>

<form action="shoppingcart-charge.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" 
          data-key=pk_test_51IzlmTCa2579eqbJnEjPTlDAempMIUfhKjoCEp6iYKc037QXGL9mplO5yPhWOpl2YrFzmy70rK6zMnyG5P7YDbWe00BuORLaHc
          data-description="<?php echo 'Payment Checkout'; ?>"
          data-amount="<?php echo $total*100; ?>"
          data-locale="auto"
					data-billing-address="true"></script>
	      <input type="hidden" name="total" value="<?php echo $total*100; ?>" />
</form>



