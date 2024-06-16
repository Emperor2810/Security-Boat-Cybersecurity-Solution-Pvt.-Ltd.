<?php
// Database configuration and connection (assuming app.php handles this)
require_once("app.php");

// Redirect to booking page if session variables are not set
if (!isset($_SESSION['email'])) {
    header('Location: booking.php');
    exit();
}

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Include PHPMailer files (adjust paths as necessary)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$success = true;
$error = "Payment Failed";

if (!empty($_POST['razorpay_payment_id'])) {
    $api = new Api($keyId, $keySecret);

    try {
        // Verify Razorpay payment signature
        $attributes = [
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        ];

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error: ' . $e->getMessage();
    }
}

if ($success) {
    // Retrieve customer data from session or database
    $moviename = $_SESSION['moviename'];
    $email = $_SESSION['email'];
    $number = $_SESSION['number']; // Assuming you may use this later
    $date = $_SESSION['date'];
    $seats = $_SESSION['seats'];
    $amount = $_SESSION['amount'];

    // Display payment status
    echo '<h2 style="color:#33FF00;">Your payment has been successful.</h2><hr>';
    echo '<div class="row">';
    echo '<div class="col-8">';
    echo '<table class="table">';
    echo '<tr><th>Moviename:</th><td>' . htmlspecialchars($moviename) . '</td></tr>';
    echo '<tr><th>Email:</th><td>' . htmlspecialchars($email) . '</td></tr>';
    echo '<tr><th>Date:</th><td>' . htmlspecialchars($date) . '</td></tr>';
    echo '<tr><th>Seats:</th><td>' . htmlspecialchars($seats) . '</td></tr>';
    echo '<tr><th>Paid Amount:</th><td>' . htmlspecialchars($amount) . ' INR</td></tr>';
    echo '</table>';
    echo '</div>';

    // Send email confirmation
    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Server settings for Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sampatkar0001@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'nisz eoyx gied jcio'; // Replace with your Gmail password or app-specific password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Your Name'); // Sender's email and name
        $mail->addAddress($email); // Recipient's email

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Booking Confirmation';
        $mail->Body = '
            <html>
            <head>
                <title>Booking Confirmation</title>
            </head>
            <body>
                <h2>Your booking has been confirmed!</h2>
                <p>Details:</p>
                <ul>
                    <li>Moviename: ' . htmlspecialchars($moviename) . '</li>
                    <li>Email: ' . htmlspecialchars($email) . '</li>
                    <li>Date: ' . htmlspecialchars($date) . '</li>
                    <li>Seats: ' . htmlspecialchars($seats) . '</li>
                    <li>Paid Amount: ' . htmlspecialchars($amount) . ' INR</li>
                </ul>
                <p>Thank you for booking with us!</p>
            </body>
            </html>
        ';

        // Send email
        $mail->send();
        echo '<p>Email sent successfully.</p>';
    } catch (Exception $e) {
        echo '<div class="errmsg">Email could not be sent. Mailer Error: ' . htmlspecialchars($mail->ErrorInfo) . '</div>';
    }

} else {
    // Display error message
    echo '<div class="errmsg">Invalid Transaction. Please try again.</div>';
    echo '<p>' . htmlspecialchars($error) . '</p>';
}
?>
