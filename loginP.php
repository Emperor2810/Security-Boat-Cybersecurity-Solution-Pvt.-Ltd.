<?php
session_start();

include_once 'app.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email']; 
$password = $_POST['password']; 


$query = "SELECT * FROM form WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) == 1) {

    header('Location: home.html');
    exit();
} else {

    echo "Invalid email or password";
}

mysqli_close($con);
?>
