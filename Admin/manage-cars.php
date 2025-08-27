<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

include('../includes/connection.php');  // Include the database connection

// Fetch cars from the database
$query = "SELECT * FROM cars";
$result = mysqli_query($conn, $query);

// Handle car deletion
if (isset($_GET['delete'])) {
    $car_id = $_GET['delete'];
    $delete_query = "DELETE FROM cars WHERE car_id = '$car_id'";
    $delete_price_query = "DELETE FROM prices WHERE car_id = '$car_id'";
    
    if (mysqli_query($conn, $delete_query) && mysqli_query($conn, $delete_price_query)) {
        echo "Car deleted successfully!";
        header("Location: manage-cars.php");
        exit();
    } else {
        echo "Error deleting car: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            color: #ffffff;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .container {
            margin-left: 270px;
            padding: 20px;
        }

        .table-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .table th, .table td {
            text-align: center;
        }

        .active {
            background-color: #575757;
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Main Content -->
    <div class="container">
        <h2 class="my-4">Manage Cars Inventory</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Car Name</th>
                        <th>Car Model</th>
                        <th>Car Year</th>
                        <th>Car Price</th>
                        <th>Availability Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($car = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $car['car_name'] . "</td>
                                    <td>" . $car['car_model'] . "</td>
                                    <td>" . $car['car_year'] . "</td>
                                    <td>" . $car['car_price'] . "</td>
                                    <td>" . $car['availability_status'] . "</td>
                                    <td>
                                        <a href='edit-cars.php?id=" . $car['car_id'] . "' class='btn btn-warning btn-sm'>
                                            <i class='bi bi-pencil'></i> Edit
                                        </a>
                                        <a href='?delete=" . $car['car_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this car?\")'>
                                            <i class='bi bi-trash'></i> Delete
                                        </a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No cars found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
