<?php
session_start();
if (!isset($_SESSION['custmrid'])) {
  header("Location: login.php");
  exit;
}

include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_id'])) {
  $car_id = intval($_POST['car_id']);
  if ($car_id > 0) {
    $_SESSION['selected_car_id'] = $car_id;
    header("Location: order-now.php");
    exit;
  }
}

$search = $_GET['search'] ?? '';
$brand_filter = $_GET['brand'] ?? '';
$model_filter = $_GET['model'] ?? '';

$brands_result = mysqli_query($conn, "SELECT DISTINCT car_name FROM cars");
$models_result = mysqli_query($conn, "SELECT DISTINCT car_model FROM cars");

$sql = "SELECT * FROM cars WHERE 1=1";
if (!empty($search)) {
  $sql .= " AND (car_name LIKE '%$search%' OR car_model LIKE '%$search%')";
}
if (!empty($brand_filter)) {
  $sql .= " AND car_name = '$brand_filter'";
}
if (!empty($model_filter)) {
  $sql .= " AND car_model = '$model_filter'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Cars</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f1f3f8;
      font-family: 'Segoe UI', sans-serif;
    }
    .content {
      margin-left: 250px;
      padding: 30px;
    }
    .filter-bar {
      background-color: #ffffff;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .card {
      border: none;
      border-radius: 15px;
      background: linear-gradient(145deg, #ffffff, #e6e6e6);
      box-shadow: 5px 5px 15px #d1d1d1, -5px -5px 15px #ffffff;
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .card h5 {
      font-weight: 600;
      color: #2d2d2d;
    }
    .card p {
      color: #555;
    }
    .btn-outline-primary {
      border-radius: 50px;
      padding: 6px 20px;
    }
    .btn-outline-primary:hover {
      background-color: green;
      color: white;
      border-color: #4c4caa;
    }
    .no-cars {
      color: #888;
      font-size: 18px;
      text-align: center;
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
  <h2 class="mb-2">Browse Cars</h2>
  <h5 class="text-primary mb-4">Choose from a wide range of top brands and latest models</h5>

  <form class="filter-bar row g-3" method="GET">
    <div class="col-md-4">
      <input type="text" class="form-control" name="search" placeholder="Search by brand or model..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-3">
      <select class="form-select" name="brand">
        <option value="">All Brands</option>
        <?php while ($b = mysqli_fetch_assoc($brands_result)) { ?>
          <option value="<?= $b['car_name'] ?>" <?= $brand_filter == $b['car_name'] ? 'selected' : '' ?>>
            <?= $b['car_name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" name="model">
        <option value="">All Models</option>
        <?php while ($m = mysqli_fetch_assoc($models_result)) { ?>
          <option value="<?= $m['car_model'] ?>" <?= $model_filter == $m['car_model'] ? 'selected' : '' ?>>
            <?= $m['car_model'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Search</button>
    </div>
  </form>

  <div class="row g-4">
    <?php if (mysqli_num_rows($result) > 0) { 
      while ($car = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4">
          <div class="card p-4">
            <h5 class="text-danger"><?= $car['car_name'] ?> - <?= $car['car_model'] ?></h5>
            <p><strong>Year:</strong> <?= $car['car_year'] ?></p>
            <p><strong>Price:</strong> $<?= number_format($car['car_price']) ?></p>
            <p><strong>Status:</strong> <?= $car['availability_status'] ?></p>
            <p><?= $car['car_description'] ?></p>
            <form method="POST">
              <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
              <button type="submit" class="btn btn-outline-primary">Order Now</button>
            </form>
          </div>
        </div>
    <?php } 
    } else { ?>
      <div class="col-12">
        <p class="no-cars">No cars found matching your criteria.</p>
      </div>
    <?php } ?>
  </div>
</div>

</body>
</html>
