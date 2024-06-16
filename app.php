<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "magicmovies") or die("Couldn't connect");

$keyId = 'your_razorpay_key_id';
$keySecret = 'your_razorpay_key_secret';
?>
