<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - MagicMovies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="success.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Payment Successful</h1>
                <hr>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Thank you for your booking!</h4>
                    <p>Your movie ticket(s) have been successfully booked.</p>
                    <hr>
                    <h5>Booking Details:</h5>
                    <p><strong>Movie Name:</strong> <?php echo $_SESSION['moviename']; ?></p>
                    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $_SESSION['mobile']; ?></p>
                    <p><strong>Booking Date:</strong> <?php echo $_SESSION['date']; ?></p>
                    <p><strong>Selected Seats:</strong> <?php echo $_SESSION['seats']; ?></p>
                    <p><strong>Total Amount Paid:</strong> <?php echo $_SESSION['amount']; ?> Rs</p>
                </div>
                <p>For any queries, please contact our support.</p>
            </div>
        </div>
    </div>
</body>
</html>
