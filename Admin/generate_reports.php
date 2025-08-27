<?php
$conn = new mysqli("localhost", "root", "", "carshowroom_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filter logic
$where = "vr.status = 'Paid'";
if (!empty($_GET['car_id'])) {
    $car_id = (int)$_GET['car_id'];
    $where .= " AND vr.car_id = $car_id";
}
if (!empty($_GET['payment_method'])) {
    $payment = $conn->real_escape_string($_GET['payment_method']);
    $where .= " AND vr.payment_method = '$payment'";
}
if (!empty($_GET['customer_id'])) {
    $customer_id = (int)$_GET['customer_id'];
    $where .= " AND vr.customer_id = $customer_id";
}
$query = "
SELECT vr.*, c.name as customer_name, cr.car_name
FROM voucher_requests vr
JOIN customers c ON vr.customer_id = c.customer_id
JOIN cars cr ON vr.car_id = cr.car_id
WHERE $where
ORDER BY vr.order_time DESC
";
$result = $conn->query($query);

// Fetch filter data
$cars = $conn->query("SELECT car_id, car_name FROM cars");
$customers = $conn->query("SELECT customer_id, name FROM customers");
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to Bootstrap Icons if needed -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body style="background-color: #f4f6f9;">

<?php include 'sidebar.php'; ?>

<div class="container-fluid" style="margin-left: 250px; padding: 30px;">
    <div class="report-header text-center bg-dark text-white p-3 rounded mb-4">
        <h2>Sales Report - Paid Orders Only</h2>
        <p>Filter by Car, Payment Method, or Customer</p>
    </div>

    <!-- Filter Form -->
    <form method="get" class="row g-3 mb-4 bg-white p-4 rounded shadow-sm">
        <div class="col-md-4">
            <label class="form-label">Select Car</label>
            <select name="car_id" class="form-select">
                <option value="">All Cars</option>
                <?php while($c = $cars->fetch_assoc()): ?>
                    <option value="<?= $c['car_id'] ?>" <?= (@$_GET['car_id'] == $c['car_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['car_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select">
                <option value="">All</option>
                <option value="Installment" <?= (@$_GET['payment_method'] == 'Installment') ? 'selected' : '' ?>>Installment</option>
                <option value="Full Payment" <?= (@$_GET['payment_method'] == 'Full Payment') ? 'selected' : '' ?>>Full Payment</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Select Customer</label>
            <select name="customer_id" class="form-select">
                <option value="">All Customers</option>
                <?php while($cust = $customers->fetch_assoc()): ?>
                    <option value="<?= $cust['customer_id'] ?>" <?= (@$_GET['customer_id'] == $cust['customer_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cust['name']) ?> (ID: <?= $cust['customer_id'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-12 text-end">
            <button class="btn btn-primary px-4">Generate Report</button>
        </div>
    </form>

    <!-- Report Table -->
    <div class="bg-white p-4 rounded shadow-sm">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Car</th>
                    <th>Payment</th>
                    <th>Installments</th>
                    <th>Amount</th>
                    <th>Delivery</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): $i = 1; ?>
                    <?php while($row = $result->fetch_assoc()): 
                        $total += $row['amount']; ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['car_name']) ?></td>
                            <td><?= $row['payment_method'] ?></td>
                            <td><?= $row['installments'] ?></td>
                            <td><?= number_format($row['amount'], 2) ?></td>
                            <td><?= number_format($row['delivery_charge'], 2) ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['order_time'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center text-danger">No paid records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($total > 0): ?>
            <div class="bg-light p-3 mt-3 rounded text-end fw-bold">
                Total Amount: Rs <?= number_format($total, 2) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
