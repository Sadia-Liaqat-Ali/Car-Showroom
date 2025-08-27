<?php
session_start();
if (!isset($_SESSION['custmrid'])) {
    header("Location: login.php");
    exit;
}

include('../includes/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Charges | Customer Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            padding: 30px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .table-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include('sidebar.php'); ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 content">
            <div class="table-title">City Wise Delivery Charges</div>
            <div class="row">
                <?php
                $sql = "SELECT * FROM city_delivery_charges ORDER BY city_name ASC";
                $result = $conn->query($sql);
                $sr = 1;

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-6">
                                <div class="card p-3">
                                    <h5 class="mb-2 text-primary">' . htmlspecialchars($row['city_name']) . '</h5>
                                    <p><strong>Charge (Rs):</strong> ' . number_format($row['charge_amount'], 2) . '</p>
                                    <p><strong>#:</strong> ' . $sr . '</p>
                                </div>
                              </div>';
                        $sr++;
                    }
                } else {
                    echo "<div class='col-12'><p>No delivery charges found.</p></div>";
                }
                ?>
            </div>
            <a href="order-now.php" class="btn btn-primary mt-4">Back to Order Page</a>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
