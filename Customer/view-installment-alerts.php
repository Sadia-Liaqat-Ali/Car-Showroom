<?php
session_start();
include('../includes/connection.php');
include('sidebar.php'); // link to external sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installment Alerts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .content-wrapper {
            margin-left: 250px; /* Assuming the sidebar has 250px width */
            padding: 20px;
        }
        .alert-card {
            border-left: 8px solid #0d6efd;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .alert-card:hover {
            box-shadow: 0 0 18px rgba(0,0,0,0.2);
        }
        .alert-warning { border-left-color: orange !important; }
        .alert-danger { border-left-color: red !important; }
        .alert-success { border-left-color: green !important; }
        .alert-card h5 {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .note {
            font-size: 0.9rem;
            color: #dc3545;
            font-style: italic;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="content-wrapper">
        <h4 class="mb-4 text-primary">📢 Installment Alerts</h4>

        <?php
        if (!isset($_SESSION['custmrid'])) {
            echo "<div class='alert alert-danger'>User session not found. Please login again.</div>";
            exit;
        }

        $custid = $_SESSION['custmrid'];
        $today = date('Y-m-d');

        $sql = "SELECT * FROM voucher_requests 
                WHERE customer_id = ? 
                  AND payment_method = 'Installment' 
                  AND status != 'Paid'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $custid);
            $stmt->execute();
            $result = $stmt->get_result();

            $rowCount = 0; // Initialize row count

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $orderTime = $row['order_time'];
                    $totalInstallments = $row['installments'];
                    $amount = $row['amount'];

                    for ($i = 1; $i <= $totalInstallments; $i++) {
                        $dueDate = date('Y-m-d', strtotime("+".(($i - 1) * 3)." months", strtotime($orderTime)));
                        $daysLeft = (strtotime($dueDate) - strtotime($today)) / (60 * 60 * 24);

                        if ($daysLeft < 0) {
                            $msg = "❗ <strong>Installment #$i of Rs. $amount</strong> is <span class='text-danger fw-bold'>OVERDUE</span>!<br>Due Date: <strong>$dueDate</strong>";
                            $class = "alert-danger";
                            $note = "<div class='note'>⚠️ Immediate action required! Failure to pay may result in cancellation of your booking.</div>";
                        } elseif ($daysLeft <= 7) {
                            $msg = "⚠️ <strong>Installment #$i of Rs. $amount</strong> is due in <strong>$daysLeft day(s)</strong>.<br>Due Date: <strong>$dueDate</strong>";
                            $class = "alert-warning";
                            $note = "<div class='note'>⏳ Please make the payment before the due date to avoid penalties.</div>";
                        } else {
                            continue; // skip safe installments
                        }

                        // Display the alert card
                        echo "
                            <div class='alert-card $class'>
                                <h5><i class='bi bi-exclamation-triangle-fill'></i> Installment Alert</h5>
                                <p>$msg</p>
                                $note
                            </div>
                        ";
                    }
                }
            } else {
                echo "<div class='alert alert-info'>No pending installment-based vouchers found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Query error: " . $conn->error . "</div>";
        }
        ?>
    </div>

</body>
</html>
