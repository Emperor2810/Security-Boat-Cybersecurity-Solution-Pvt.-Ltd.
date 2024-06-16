<?php
session_start();

include_once 'app.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];


    $query = "INSERT INTO form (name, email, number, password) VALUES ('$name', '$email', '$number', '$password')";
    $result = mysqli_query($con, $query);

    if ($result) {

        header("Location: login.html");
        exit();
    } else {

        echo "Error: " . mysqli_error($con);
    }
}
?>
