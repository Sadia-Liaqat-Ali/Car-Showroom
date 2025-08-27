<?php
session_start(); 
$conn = new mysqli("localhost", "root", "", "carshowroom_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert = '';
$type = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $cnic = trim($_POST['cnic']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $g_name = trim($_POST['guarantor_name']);
    $g_bank = trim($_POST['guarantor_bank']);
    $g_account = trim($_POST['guarantor_account']);
    $g_branch = trim($_POST['guarantor_branch']);

    if (empty($name) || empty($email) || empty($password) || empty($cnic) || empty($g_name) || empty($g_bank) || empty($g_account)) {
        $alert = "Please fill all required fields including guarantor details.";
        $type = "danger";
    } else {
        $check = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $alert = "This email is already registered.";
            $type = "warning";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO customers (name, email, password, cnic, phone, address, guarantor_name, guarantor_bank_name, guarantor_account_no, guarantor_branch_code)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $name, $email, $hashed_password, $cnic, $phone, $address, $g_name, $g_bank, $g_account, $g_branch);

            if ($stmt->execute()) {
                $alert = "Registration successful. You can now login.";
                $type = "success";
            } else {
                $alert = "Error: " . $stmt->error;
                $type = "danger";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: black;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
   .card {
  border: none;
  border-radius: 15px;
  overflow: hidden;
  width: 100%;
  max-width: 600px;
  background-color: #1e1e2f;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
  color: #f0f0f0;
}
.card-header {
  background-color: #6f42c1;
  color: #fff;
  text-align: center;
  font-size: 1.25rem;
  font-weight: 600;
}
.card-body {
  background-color: #2c2c3e;
  padding: 2rem;
}
.input-group-text {
  background-color: #6f42c1;
  color: #fff;
  border: none;
}
.form-control {
  background-color: #1e1e2f;
  color: #f0f0f0;
  border: 1px solid #555;
}
.form-control::placeholder {
  color: #aaa;
}
.btn-primary {
  background-color: #6f42c1;
  border: none;
}
.btn-primary:hover {
  background-color: #5931a9;
}
.alert {
  border-radius: 0.5rem;
  margin-bottom: 1.5rem;
}
.link-text {
  font-size: 0.9rem;
  text-align: center;
  margin-top: 1rem;
}
.link-text a {
  color: #9d80ff;
  text-decoration: none;
  font-weight: 500;
}
.link-text a:hover {
  text-decoration: underline;
}
.section-title {
  font-size: 1rem;
  margin-top: 1rem;
  font-weight: 600;
  color: #d8bfff;
}

  </style>
</head>
<body>

  <div class="card">
    <div class="card-header">
      <i class="bi bi-person-plus-fill me-2"></i> Customer Registration
    </div>
    <div class="card-body">
      <?php if (!empty($alert)): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($alert) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

     <!-- Replace the form section inside your <body> tag with this -->
<form method="post" novalidate>
  <div class="section-title text-light">Personal Details</div>
  <div class="row mb-3">
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
      <input type="text" name="name" class="form-control" placeholder="Full Name" required />
    </div>
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
      <input type="email" name="email" class="form-control" placeholder="Email Address" required />
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
      <input type="password" name="password" class="form-control" placeholder="Password" required />
    </div>
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-card-text"></i></span>
      <input type="text" name="cnic" class="form-control" placeholder="CNIC" required />
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
      <input type="text" name="phone" class="form-control" placeholder="Phone Number" />
    </div>
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
      <input type="text" name="address" class="form-control" placeholder="Address" />
    </div>
  </div>

  <div class="section-title text-light">Guarantor Bank Details</div>
  <div class="row mb-3">
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
      <input type="text" name="guarantor_name" class="form-control" placeholder="Guarantor Name" required />
    </div>
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-bank"></i></span>
      <input type="text" name="guarantor_bank" class="form-control" placeholder="Bank Name" required />
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
      <input type="text" name="guarantor_account" class="form-control" placeholder="Account Number" required />
    </div>
    <div class="col-md-6 input-group">
      <span class="input-group-text"><i class="bi bi-code-slash"></i></span>
      <input type="text" name="guarantor_branch" class="form-control" placeholder="Branch Code" />
    </div>
  </div>

  <button type="submit" class="btn btn-primary w-100">Register</button>
</form>

      <div class="link-text">
        Already have an account? <a href="login.php">Login</a><br />
        <a href="../index.php">Back to home?</a>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
