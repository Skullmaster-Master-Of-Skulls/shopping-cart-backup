<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_51IzlmTCa2579eqbJQmoQMs8zJHXvefQF87cBIO1VtMwcm7Aiy1BQlHULMLzQgphVYfqluICRqlaqQyAve8pg2irs00a1IHXvAX",
  "publishable_key" => "pk_test_51IzlmTCa2579eqbJnEjPTlDAempMIUfhKjoCEp6iYKc037QXGL9mplO5yPhWOpl2YrFzmy70rK6zMnyG5P7YDbWe00BuORLaHc",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>