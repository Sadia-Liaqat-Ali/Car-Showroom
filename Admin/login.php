<?php
session_start();
include('../includes/connection.php');  // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check admin credentials
    $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];  // Save admin ID in session
        header('Location: dashboard.php');  // Redirect to dashboard
    } else {
        $error_message = "Invalid credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
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
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
