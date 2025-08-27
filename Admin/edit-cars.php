<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include('../includes/connection.php');

$car_id = $_GET['id'] ?? 0;

// Fetch car data
$query = "SELECT * FROM cars WHERE car_id = '$car_id'";
$result = mysqli_query($conn, $query);
$car = mysqli_fetch_assoc($result);

// Update data on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_name = $_POST['car_name'];
    $car_model = $_POST['car_model'];
    $car_year = $_POST['car_year'];
    $car_price = $_POST['car_price'];
    $availability_status = $_POST['availability_status'];
    $car_description = $_POST['car_description'];

    $update_query = "UPDATE cars SET 
                        car_name = '$car_name', 
                        car_model = '$car_model', 
                        car_year = '$car_year', 
                        car_price = '$car_price', 
                        availability_status = '$availability_status', 
                        car_description = '$car_description'
                     WHERE car_id = '$car_id'";

    $update_price_query = "UPDATE prices SET 
                            price = '$car_price', 
                            availability_status = '$availability_status'
                          WHERE car_id = '$car_id'";

    if (mysqli_query($conn, $update_query) && mysqli_query($conn, $update_price_query)) {
        header("Location: manage-cars.php");
        exit();
    } else {
        echo "Error updating car: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car - Admin</title>
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
        <h2 class="my-4">Edit Car Details</h2>
        <div class="form-container">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="car_name" class="form-label">Car Name</label>
                    <input type="text" class="form-control" id="car_name" name="car_name" value="<?= $car['car_name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="car_model" class="form-label">Car Model</label>
                    <input type="text" class="form-control" id="car_model" name="car_model" value="<?= $car['car_model'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="car_year" class="form-label">Car Year</label>
                    <input type="number" class="form-control" id="car_year" name="car_year" value="<?= $car['car_year'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="car_price" class="form-label">Car Price</label>
                    <input type="number" class="form-control" id="car_price" name="car_price" step="0.01" value="<?= $car['car_price'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="availability_status" class="form-label">Availability Status</label>
                    <select class="form-select" id="availability_status" name="availability_status" required>
                        <option value="Available" <?= $car['availability_status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                        <option value="Out of Stock" <?= $car['availability_status'] == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="car_description" class="form-label">Car Description</label>
                    <textarea class="form-control" id="car_description" name="car_description"><?= $car['car_description'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Car</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
