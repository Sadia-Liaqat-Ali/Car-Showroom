<?php  
session_start();
include('../includes/connection.php'); // Include the connection file

// Check if the customer is logged in
if (!isset($_SESSION['custmrid'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['custmrid'];

// Fetch all orders of the logged-in customer
$query = "SELECT * FROM voucher_requests WHERE customer_id = $customer_id ORDER BY order_time DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching orders: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .main {
            margin-left: 270px;
            padding: 30px;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }

        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Include the external sidebar -->
    <?php include('sidebar.php'); ?>  <!-- External Sidebar file -->

    <!-- Main content -->
    <div class="main">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">Welcome, Customer</a>
        </nav>

        <div class="container">
            <h2>Your Orders</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Car Model</th>
                        <th>City</th>
                        <th>Payment Method</th>
                        <th>Installments</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Order Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)) { 
                        // Get car model and name from cars table
                        $car_id = $order['car_id'];
                        $car_query = mysqli_query($conn, "SELECT car_model, car_name FROM cars WHERE car_id = $car_id");
                        $car = mysqli_fetch_assoc($car_query);
                    ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $car['car_model'] ?> (<?= $car['car_name'] ?>)</td>
                            <td><?= $order['city'] ?></td>
                            <td><?= $order['payment_method'] ?></td>
                            <td><?= $order['installments'] ?></td>
                            <td>Rs. <?= number_format($order['amount'], 2) ?></td>
                            <td><?= $order['status'] ?></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($order['order_time'])) ?></td>
                            <td>
                            <p class="text-primary">visit that car section</p>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

