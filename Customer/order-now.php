<?php  
session_start();
include('../includes/connection.php');

if (!isset($_SESSION['custmrid']) || !isset($_SESSION['selected_car_id'])) {
    header("Location: browse-cars.php");
    exit;
}

$customer_id = $_SESSION['custmrid'];
$car_id = $_SESSION['selected_car_id'];

$delivery_charge = 0;
$selected_city = '';

if (isset($_POST['cancel_order'])) {
    mysqli_query($conn, "DELETE FROM voucher_requests WHERE customer_id = $customer_id AND car_id = $car_id");
    echo "<script>alert('Order cancelled successfully'); window.location.href='order-now.php';</script>";
    exit;
}

if (isset($_POST['download_voucher'])) {
    $city = $_POST['city'];
    $selected_city = $city;
    $delivery = $_POST['delivery'];
    $payment = $_POST['payment'];
    $installments = $payment === 'Installment' ? (int)$_POST['installments'] : 1;

    $car_query = mysqli_query($conn, "SELECT * FROM cars WHERE car_id = $car_id");
    $car = mysqli_fetch_assoc($car_query);
    $car_price = (float)$car['car_price'];
    $car_model = $car['car_model'];
    $brand = $car['car_name'];
    $base_fee = $car_price / $installments;
    $current_time = date("Y-m-d H:i:s");

    // Fetch delivery charge from the city_delivery_charges table
    $charge_query = mysqli_query($conn, "SELECT charge_amount FROM city_delivery_charges WHERE city_name = '$city'");
    $charge_result = mysqli_fetch_assoc($charge_query);
    $delivery_charge = $charge_result ? $charge_result['charge_amount'] : 0;

    for ($i = 1; $i <= $installments; $i++) {
        $amount = $base_fee;
        $charge = 0.00;

        if ($i == 1 && $delivery === "Home Delivery") {
            $charge = $delivery_charge;
            $amount += $charge;
        }

        mysqli_query($conn, "INSERT INTO voucher_requests (customer_id, car_id, city, payment_method, installments, amount, status, delivery_charge, order_time)
                             VALUES ($customer_id, $car_id, '$city', '$payment', $i, $amount, 'Pending', $charge, '$current_time')");
    }

    echo "<script>alert('Order placed! Kindly pay your 1st voucher to proceed to the next.'); window.location.href='order-now.php?city=" . urlencode($city) . "';</script>";
    exit;
}

if (isset($_POST['upload_paid']) && isset($_POST['voucher_id']) && isset($_FILES['paid_voucher'])) {
    $voucher_id = $_POST['voucher_id'];
    $file = $_FILES['paid_voucher'];

    if ($file['error'] === 0) {
        $filename = "../uploads/" . time() . "_" . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $filename)) {
            $update_query = "UPDATE voucher_requests SET paid_voucher = '$filename', status = 'Checking Process' WHERE id = $voucher_id";
            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Voucher uploaded and status updated to Checking Process');</script>";
            } else {
                echo "<script>alert('Error updating voucher status');</script>";
            }
        }
    }
}

$vouchers = mysqli_query($conn, "SELECT * FROM voucher_requests WHERE customer_id = $customer_id AND car_id = $car_id ORDER BY id ASC");
$has_voucher = mysqli_num_rows($vouchers) > 0;

if (isset($_GET['city'])) {
    $selected_city = $_GET['city'];
    // Fetch delivery charge from the city_delivery_charges table dynamically
    $charge_query = mysqli_query($conn, "SELECT charge_amount FROM city_delivery_charges WHERE city_name = '$selected_city'");
    $charge_result = mysqli_fetch_assoc($charge_query);
    $delivery_charge = $charge_result ? $charge_result['charge_amount'] : 0;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Order Now</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    .body {
      background-color: lightcoral;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
    }
    .main {
      margin-left: 250px;
      padding: 30px;
    }
    .notification-bubble {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: red;
      color: white;
      padding: 15px;
      border-radius: 12px;
      font-size: 14px;
      z-index: 999;
    }
  </style>
  <script>
    function toggleInstallments() {
      let method = document.getElementById('payment').value;
      document.getElementById('installment_section').style.display = (method === 'Installment') ? 'block' : 'none';
    }
  </script>
</head>
<body>
  <div class="notification-bubble">
    <?php if ($selected_city != ''): ?>
      Delivery Charge for <?= htmlspecialchars($selected_city) ?>: Rs. <?= number_format($delivery_charge, 2) ?>
    <?php else: ?>
      Select a city to view delivery charges.
    <?php endif; ?>
  </div>

  <div style="display: flex;">
    <?php include('sidebar.php'); ?>

    <div class="main">
      <h2>Order Details</h2>

      <?php if (!$has_voucher) { ?>
        <form method="POST">
          <div class="mb-3">
            <label>Your City</label>
            <select name="city" class="form-select" required>
              <option value="">Select City</option>
              <?php
                // Fetch all cities from the city_delivery_charges table
                $cities_query = mysqli_query($conn, "SELECT city_name FROM city_delivery_charges");
                while ($city_row = mysqli_fetch_assoc($cities_query)) {
              ?>
                <option value="<?= $city_row['city_name'] ?>"><?= $city_row['city_name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Delivery Option</label>
            <select name="delivery" class="form-select" required>
              <option value="">Select</option>
              <option value="Home Delivery">Home Delivery</option>
              <option value="Self Pickup">Self Pickup</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment" id="payment" class="form-select" onchange="toggleInstallments()" required>
              <option value="">Select</option>
              <option value="Full Payment">Full Payment</option>
              <option value="Installment">Installment</option>
            </select>
          </div>

          <div class="mb-3" id="installment_section" style="display:none;">
            <label>Number of Installments</label>
            <input type="number" name="installments" class="form-control" min="1">
          </div>

          <button type="submit" name="download_voucher" class="btn btn-primary">Download Voucher</button>
        </form>
      <?php } else { ?>
        <h4>Your Voucher Records</h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>City</th>
              <th>Payment</th>
              <th>Installment</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Upload Voucher</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $first_row = mysqli_fetch_assoc($vouchers);
              mysqli_data_seek($vouchers, 0);
              $order_time = strtotime($first_row['order_time']);
              $now = time();
              $show_cancel = ($now - $order_time) <= (24 * 60 * 60);

              while ($row = mysqli_fetch_assoc($vouchers)) {
            ?>
              <tr>
                <td><?= $row['city'] ?></td>
                <td><?= $row['payment_method'] ?></td>
                <td><?= $row['installments'] ?></td>
                <td>Rs. <?= number_format($row['amount'], 2) ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                  <?php if ($row['status'] === 'Pending') { ?>
                    <form method="POST" enctype="multipart/form-data" class="d-flex">
                      <input type="hidden" name="voucher_id" value="<?= $row['id'] ?>">
                      <input type="file" name="paid_voucher" required class="form-control me-2">
                      <button type="submit" name="upload_paid" class="btn btn-success">Upload</button>
                    </form>
                  <?php } elseif ($row['status'] === 'Checking Process') {
                    echo '<span class="text-warning">In Checking</span>';
                  } else {
                    echo '<span class="text-success">Uploaded</span>';
                  } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php if ($show_cancel) { ?>
          <form method="POST">
            <button type="submit" name="cancel_order" class="btn btn-danger">Cancel Order</button>
          </form>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</body>
</html>
