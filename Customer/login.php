<?php
session_start();
$conn = new mysqli("localhost", "root", "", "carshowroom_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert = '';
$type = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $alert = "Please enter both email and password.";
        $type = "danger";
    } else {
        $stmt = $conn->prepare("SELECT customer_id, password FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($customer_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['custmrid'] = $customer_id;
                header("Location: dashboard.php");
                exit;
            } else {
                $alert = "Invalid password.";
                $type = "danger";
            }
        } else {
            $alert = "Email not found.";
            $type = "warning";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Customer Login</title>
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
      <i class="bi bi-person-check-fill me-2"></i> Customer Login
    </div>
    <div class="card-body">
      <?php if (!empty($alert)): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($alert) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Email" required />
        </div>
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <div class="link-text">
        Don't have an account? <a href="register.php">Register</a><br />
        <a href="../index.php">Back to home?</a>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
