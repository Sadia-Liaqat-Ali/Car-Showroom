<?php  
session_start();
include('../includes/connection.php');

// Check if the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch all orders, ordered by order time in descending order
$orders_query = mysqli_query($conn, "SELECT * FROM voucher_requests ORDER BY order_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Order Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f7fc;
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }
    .table-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .table th, .table td {
      text-align: center;
      vertical-align: middle;
    }
    .btn-download {
      color: #28a745;
      text-decoration: none;
    }
    .btn-download:hover {
      color: #155724;
    }
  </style>
</head>
<body>
<div style="display: flex;">
  <?php include('sidebar.php'); ?> <!-- Sidebar inclusion -->

  <div class="main-content">
    <h2>Order Management</h2>

    <div class="table-container">
      <h4>All Orders</h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Car Model</th>
            <th>Payment Method</th>
            <th>Amount</th>
            <th>Delivery Charge</th>
            <th>Paid Voucher</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($order = mysqli_fetch_assoc($orders_query)) { ?>
          <tr>
            <td><?= $order['customer_id'] ?></td>
            <td><?= $order['car_id'] ?></td>
            <td><?= $order['payment_method'] ?></td>
            <td>Rs. <?= number_format($order['amount'], 2) ?></td>
            <td>Rs. <?= number_format($order['delivery_charge'], 2) ?></td>
            <td>
              <?php if (!empty($order['paid_voucher'])) { ?>
                <a href="../uploads/<?= $order['paid_voucher'] ?>" class="btn-download" target="_blank">
                  <i class="fas fa-download"></i> Download
                </a>
              <?php } else { ?>
                <span class="text-muted">Not available</span>
              <?php } ?>
            </td>
            <td>
              <?php if (!empty($order['paid_voucher'])) { ?>
                <form method="POST" style="display: flex; gap: 5px;">
                  <select name="status" class="form-select form-select-sm">
                    <option <?= $order['status'] == 'Pending' ? 'selected' : '' ?> value="Pending">Pending</option>
                    <option <?= $order['status'] == 'Processed' ? 'selected' : '' ?> value="Processed">Processed</option>
                    <option <?= $order['status'] == 'Paid' ? 'selected' : '' ?> value="Paid">Paid</option>
                    <option <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?> value="Cancelled">Cancelled</option>
                  </select>
                  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                  <button type="submit" name="update_status" class="btn btn-sm btn-success">Update</button>
                </form>
              <?php } else { ?>
                <?= $order['status'] ?>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
// Update order status when the form is submitted
if (isset($_POST['update_status']) && isset($_POST['order_id'])) {
  $order_id = $_POST['order_id'];
  $new_status = $_POST['status'];
  mysqli_query($conn, "UPDATE voucher_requests SET status = '$new_status' WHERE id = $order_id");
  echo "<script>alert('Order status updated successfully.'); window.location.href='order-management.php';</script>";
}
?>
</body>
</html>
