<?php
require_once('razorpay-php/Razorpay.php');
require_once('app.php'); // Include your database connection and other necessary setup
require_once('gateway-config.php'); // Include your Razorpay API keys


// Redirect to booking page if email is not set in session
if (!isset($_SESSION['email'])) {
    header('Location: booking.php');
    exit();
}

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret); // Initialize Razorpay API

// Retrieve session variables
$moviename = $_SESSION['moviename'];
$email = $_SESSION['email'];
$number = $_SESSION['number'];
$date = $_SESSION['date'];
$seats = $_SESSION['seats'];
$amount = $_SESSION['amount'];

// Prepare data for Razorpay order creation
$orderData = [
    'receipt' => 3456, // Example receipt number
    'amount' => $amount * 100, // Amount in paise (Indian currency)
    'currency' => 'INR',
    'payment_capture' => 1 // Auto-capture payment
];

try {
    // Create Razorpay order
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];
    $_SESSION['razorpay_order_id'] = $razorpayOrderId;
    $displayAmount = $amount;

    // Prepare data for the Razorpay checkout form
    $data = [
        "key" => $keyId,
        "amount" => $amount * 100, // Amount in paise
        "name" => 'MagicMovies',
        "description" => 'Movie Ticket Booking',
        "prefill" => [
            "name" => $email,
            "email" => $email,
            "contact" => $number,
        ],
        "notes" => [
            "address" => 'Movie Ticket Booking',
            "merchant_order_id" => $moviename,
        ],
        "theme" => [
            "color" => "#F37254"
        ],
        "order_id" => $razorpayOrderId,
    ];

    $json = json_encode($data);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MagicMovies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="payment.css">
    <!-- Include Razorpay checkout.js -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 form-container">
            <h1>Payment</h1>
            <hr>
            <div class="row">
                <div class="col-8">
                    <h4>Payer Details</h4>
                    <div class="mb-3">
                        <label class="label">Email:</label>
                        <?php echo $email; ?>
                    </div>
                    <div class="mb-3">
                        <label class="label">Phone Number:</label>
                        <?php echo $number; ?>
                    </div>
                    <div class="mb-3">
                        <label class="label">Seats:</label>
                        <?php echo $seats; ?>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $moviename; ?></h5>
                            <p class="card-text"><?php echo $amount; ?> INR</p>
                        </div>
                    </div>
                    <br>
                    <center>
                        <!-- Button to trigger Razorpay checkout -->
                        <button id="rzp-button1" class="btn btn-primary">Proceed to Pay</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize Razorpay checkout
var options = {
    "key": "<?php echo $data['key']; ?>",
    "amount": "<?php echo $data['amount']; ?>",
    "currency": "INR",
    "name": "<?php echo $data['name']; ?>",
    "description": "<?php echo $data['description']; ?>",
    "prefill": {
        "name": "<?php echo $data['prefill']['name']; ?>",
        "email": "<?php echo $data['prefill']['email']; ?>",
        "contact": "<?php echo $data['prefill']['contact']; ?>"
    },
    "notes": {
        "shopping_order_id": "<?php echo $moviename; ?>"
    },
    "theme": {
        "color": "#F37254"
    },
    "order_id": "<?php echo $razorpayOrderId; ?>",
    "handler": function (response){
        // Handle successful payment
        window.location.href = "verify.php?razorpay_payment_id=" + response.razorpay_payment_id + "&razorpay_signature=" + response.razorpay_signature;
    }
};

var rzp1 = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e) {
    rzp1.open();
    e.preventDefault();
}
</script>

</body>
</html>
