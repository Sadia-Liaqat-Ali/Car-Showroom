<?php  
session_start();
include('../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handle update: Update delivery charges for a specific city
if (isset($_POST['update_charge'])) {
    $city_id = intval($_POST['city_id']);
    $new_charge = floatval($_POST['charge_amount']);
    
    $query = "UPDATE city_delivery_charges SET charge_amount = '$new_charge' WHERE id = '$city_id'";
    mysqli_query($conn, $query);
    
    echo "<script>alert('Delivery charge updated successfully.'); window.location.href='manage-delivery-charges.php';</script>";
}

// Fetch cities and their current delivery charges
$cities_query = mysqli_query($conn, "SELECT * FROM city_delivery_charges");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Delivery Charges</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f7fc;
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }
    .box {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-label {
      font-weight: 500;
    }
  </style>
</head>
<body>
<div style="display: flex;">
  <?php include('sidebar.php'); ?>

  <div class="main-content">
    <h2>Manage Delivery Charges for Cities</h2>

    <div class="box">
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Select City:</label>
          <select name="city_id" class="form-control" required>
            <?php while ($city = mysqli_fetch_assoc($cities_query)): ?>
              <option value="<?= $city['id'] ?>"><?= $city['city_name'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">New Delivery Charge (Rs):</label>
          <input type="number" step="0.01" name="charge_amount" class="form-control" required>
        </div>

        <button type="submit" name="update_charge" class="btn btn-primary">Update Charge</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
