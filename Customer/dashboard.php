<?php
session_start();
if (!isset($_SESSION['custmrid'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f4f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .content {
      margin-left: 250px;
      padding: 40px;
    }

    .dashboard-title {
      font-weight: 700;
      color: #343a40;
    }

    .card {
      border: none;
      border-radius: 12px;
      transition: transform 0.3s, box-shadow 0.3s;
      background: white;
      text-align: center;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card i {
      font-size: 35px;
      color: #0d6efd;
      margin-bottom: 15px;
    }

    .card h5 {
      font-weight: 600;
      margin-bottom: 10px;
    }

    .card p {
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>
<div class="content">
  <h2 class="dashboard-title mb-2">Welcome to Your Dashboard</h2>
  <h4 class=" mb-4 text-primary">Our Professional Services for You</h4>



  <div class="row g-4">
    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-car-front-fill"></i>
        <h5>Browse Cars</h5>
        <p>Explore a wide range of cars based on brand and model.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-geo-alt-fill"></i>
        <h5>Select City</h5>
        <p>Choose your desired city for doorstep delivery.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-cart-check-fill"></i>
        <h5>Place Order</h5>
        <p>Order your dream car with full or installment payment option.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-list-check"></i>
        <h5>Order Status</h5>
        <p>Track your current and past orders easily.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-credit-card-2-front-fill"></i>
        <h5>Payment Info</h5>
        <p>View payment details including installment records.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <i class="bi bi-x-circle-fill"></i>
        <h5>Cancel Order</h5>
        <p>Cancel your order within 24 hours if needed.</p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
