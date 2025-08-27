<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

include('../includes/connection.php');  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $car_name = $_POST['car_name'];
    $car_model = $_POST['car_model'];
    $car_year = $_POST['car_year'];
    $car_price = $_POST['car_price'];
    $availability_status = $_POST['availability_status'];
    $car_description = $_POST['car_description'];

    // Insert into the cars table
    $query = "INSERT INTO cars (car_name, car_model, car_year, car_price, availability_status, car_description)
              VALUES ('$car_name', '$car_model', '$car_year', '$car_price', '$availability_status', '$car_description')";
    if (mysqli_query($conn, $query)) {
        // Insert car price into the prices table as well
        $car_id = mysqli_insert_id($conn);
        $query_price = "INSERT INTO prices (car_id, price, availability_status) 
                        VALUES ('$car_id', '$car_price', '$availability_status')";
        if (mysqli_query($conn, $query_price)) {
            echo "Car added successfully!";
        } else {
            echo "Error adding price: " . mysqli_error($conn);
        }
    } else {
        echo "Error adding car: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        
        .container {
            margin-left: 270px;
            padding: 20px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;  /* Reduced form width */
            margin: 0 auto;
            background-color: #e9f5fe;  /* Light blue background */
        }
        .form-container .btn-primary {
            width: 100%; /* Button width to span the form */
        }
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?>

    <!-- Main Content -->
    <div class="container">
        <h2 class="my-4">Add Car to Inventory</h2>
        <div class="form-container">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="car_name" class="form-label">Car Name</label>
                    <input type="text" class="form-control" id="car_name" name="car_name" required>
                </div>
                <div class="mb-3">
                    <label for="car_model" class="form-label">Car Model</label>
                    <input type="text" class="form-control" id="car_model" name="car_model" required>
                </div>
                <div class="mb-3">
                    <label for="car_year" class="form-label">Car Year</label>
                    <input type="number" class="form-control" id="car_year" name="car_year" required>
                </div>
                <div class="mb-3">
                    <label for="car_price" class="form-label">Car Price</label>
                    <input type="number" class="form-control" id="car_price" name="car_price" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="availability_status" class="form-label">Availability Status</label>
                    <select class="form-select" id="availability_status" name="availability_status" required>
                        <option value="Available">Available</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="car_description" class="form-label">Car Description</label>
                    <textarea class="form-control" id="car_description" name="car_description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Car</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
