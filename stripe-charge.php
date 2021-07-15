<?php
  require_once('config.php');

  $token  = $_POST['stripeToken'];

  $customer = \Stripe\Customer::create([
      'source'  => $token,
  ]);

  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd',
  ]);
?>