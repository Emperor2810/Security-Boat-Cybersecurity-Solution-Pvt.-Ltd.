<?php
require_once('app.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $moviename = mysqli_real_escape_string($con, $_POST['moviename']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $seats = mysqli_real_escape_string($con, $_POST['seats']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);

    $sql = "INSERT INTO customer (moviename, email, number, date, seats, amount) 
            VALUES ('$moviename', '$email', '$number', '$date', '$seats', '$amount')";

    if (mysqli_query($con, $sql)) {

        $_SESSION['moviename'] = $moviename;
        $_SESSION['email'] = $email;
        $_SESSION['number'] = $number;
        $_SESSION['date'] = $date;
        $_SESSION['seats'] = $seats;
        $_SESSION['amount'] = $amount;
        $_SESSION['posterurl'] = $_POST['posterurl'];

        header('Location: pay.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
?>
