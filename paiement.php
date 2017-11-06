<?php
$token = $_POST['stripeToken'];
$email = $_POST['email'];
$name = $_POST['name'];

$data = [
    'source' => $token,
    'description' => $name,
    'email' => $email
];
if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($name)) {
    require 'Stripe.php';
    $stripe = new Stripe('sk_test_8ad8nMuv2kmUJIyltCoyTuWn');
    $customer = $stripe->api('customers', [
        'source' => $token,
        'description' => $name,
        'email' => $email
    ]);
    $charge = $stripe->api('charges', [
        'amount' => 1000,
        'currency' => 'eur',
        'customer' => $customer->id
    ]);
   
}
 header("location:payment_success.php");



