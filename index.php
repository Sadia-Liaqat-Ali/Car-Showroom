<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AutoEase | Online Car Showroom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <style>
    body {
      background-color: #f8f9fa;
      color: #343a40;
      font-family: 'Segoe UI', sans-serif;
      padding-top: 80px;
    }
    .hero {
      padding: 80px 0;
      background: linear-gradient(to right, #4c4caa, #8360c3);
      color: #ffffff;
    }
    .hero h1, .hero p {
      color: #ffffff;
    }
    .hero .btn-primary {
      background-color: #ffffff;
      color: #4c4caa;
      border: none;
    }
    .hero .btn-primary:hover {
      background-color: #d3bfff;
      color: #343a40;
    }

    .section {
      padding: 60px 0;
    }
    .section h2 {
      text-align: center;
      margin-bottom: 40px;
      color: #4c4caa;
    }

    .service-box {
      background: #ffffff;
      color: #102336;
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }
    .service-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      background-color: #5D88BB;
      color: #ffffff;
    }

    .about-img {
      width: 100%;
      border-radius: 10px;
    }
    #contact {
      background-color: #4c4caa;
      color: #ffffff;
    }
    #about{
      background-color: lightslategray;
      color: white;
    }
  </style>
</head>
<body>
<?php include 'navbar.html'; ?>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="display-5 fw-bold">Buy Your Dream Car Online</h1>
        <p class="lead mt-3">Explore a wide range of cars across Lahore, Islamabad, Peshawar, and Karachi. Choose full payment or easy instalments with doorstep delivery.</p>
        <div class="mt-4">
          <a href="register.php" class="btn btn-primary btn-lg me-3">Get Started</a>
          <a href="#services" class="btn btn-outline-light btn-lg">Explore Services</a>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <img src="img/red.png" class="img-fluid rounded" alt="Car">
      </div>
    </div>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="section">
  <div class="container">
    <h2>Our Services</h2>
    <div class="row text-center g-4">

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-car-front-fill fs-1 mb-3 text-primary"></i>
          <h5>Browse Cars</h5>
          <p>Explore a variety of cars by brand, type, and price. Updated stock available for immediate booking.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-geo-alt-fill fs-1 mb-3 text-primary"></i>
          <h5>Select City</h5>
          <p>Choose your desired city for doorstep delivery.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-cart-check-fill fs-1 mb-3 text-primary"></i>
          <h5>Place Order</h5>
          <p>Order your dream car with full or installment payment option.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-list-check fs-1 mb-3 text-primary"></i>
          <h5>Order Status</h5>
          <p>Track your current and past orders easily.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-credit-card-2-front-fill fs-1 mb-3 text-primary"></i>
          <h5>Payment Info</h5>
          <p>View payment details including installment records.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-box shadow-sm">
          <i class="bi bi-x-circle-fill fs-1 mb-3 text-primary"></i>
          <h5>Cancel Order</h5>
          <p>Cancel your order within 24 hours if needed.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- About Us Section -->
<section id="about" class="section">
  <div class="container">
    <h2>About Us</h2>
    <div class="row">
      <div class="col-md-6">
        <img src="img/blu.jpg" alt="About Us Image" class="about-img">
      </div>
      <div class="col-md-6">
        <h5>Welcome to AutoEase!</h5>
        <p>At AutoEase, we are dedicated to offering a seamless online car buying experience. From browsing cars to placing orders and getting doorstep delivery, we make car shopping hassle-free. We offer various payment methods, including installments, ensuring you find the best car that fits your budget.</p>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
