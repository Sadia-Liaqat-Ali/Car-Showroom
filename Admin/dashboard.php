<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');  // Redirect to login page if not logged in
    exit();
}

include('../includes/connection.php');  // Include database connection

// Admin details can be fetched here if needed
$admin_id = $_SESSION['admin_id'];

// Perform the query and check if it was successful
$query = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    // If the query fails, output an error
    die("Query failed: " . mysqli_error($conn));
}

$admin = mysqli_fetch_assoc($result);

// Check if the admin details are retrieved
if (!$admin) {
    die("No admin found with this ID.");
}

// Fetch total number of customers, cars, and orders based on the provided conditions
$query_customers = "SELECT COUNT(*) as total_customers FROM customers";
$result_customers = mysqli_query($conn, $query_customers);
$customers = mysqli_fetch_assoc($result_customers);

$query_cars = "SELECT COUNT(*) as total_cars FROM cars";
$result_cars = mysqli_query($conn, $query_cars);
$cars = mysqli_fetch_assoc($result_cars);

// Updated query to fetch total paid orders (at least one installment paid, not canceled)
$query_orders = "
    SELECT COUNT(DISTINCT car_id) as total_orders 
    FROM voucher_requests 
    WHERE status != 'Cancelled' 
    AND status != 'Checking Process' 
    AND installments > 0 
    AND paid_voucher IS NOT NULL";
$result_orders = mysqli_query($conn, $query_orders);
$orders = mysqli_fetch_assoc($result_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Make sure sidebar is not overlapping */
        .content {
            margin-left: 250px; /* Ensure content does not overlap with sidebar */
        }
        /* Optional: Fix the height for sidebar and make it sticky */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            z-index: 100;
        }
        /* Optional: Add some space around the content */
        .dashboard-message {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3">
        <div class="text-center mb-4">
            <h4>Admin Panel</h4>
        </div>
        <div class="list-group">
            <a href="admin_dashboard.php" class="list-group-item list-group-item-action text-white bg-primary">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="add-cars.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-car-front"></i> Add Cars
            </a>
            <a href="manage-cars.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-car-front"></i> Manage Cars
            </a>
            <a href="order-management.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-file-earmark-text"></i> Orders Tracking
            </a>
            <a href="generate_reports.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-bar-chart"></i> Generate Reports
            </a>
            <a href="manage-delivery-charges.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-truck"></i> Manage Delivery Charges
            </a>
            <a href="admin_logout.php" class="list-group-item list-group-item-action text-white bg-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="content p-4" style="flex-grow: 1;">
        <h2>Welcome, Admin</h2>
        <p class="lead">Logged in as: <?php echo $admin['email']; ?></p>

        <!-- Dashboard Cards -->
        <div class="row">
            <!-- Total Customers -->
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <p class="card-text"><?php echo $customers['total_customers']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Cars -->
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Cars</h5>
                        <p class="card-text"><?php echo $cars['total_cars']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text"><?php echo $orders['total_orders']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="alert alert-info">
            <h4 class="alert-heading">Welcome to the Admin Dashboard!</h4>
            <p>To get started, please <a href="add_car.php" class="alert-link">add your cars</a> to the inventory or manage existing records.</p>
        </div>
    </div> <!-- End of Dashboard Content -->
</div> <!-- End of Flex Container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
