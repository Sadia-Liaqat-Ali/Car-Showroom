<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Footer Section</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #222;
      color: #fff;
    }

    #contact {
      padding: 50px 0;
    }

    #contact .form-control {
      border-radius: 10px;
    }

    #contact .btn-light {
      background-color: #fff;
      color: #343a40;
      border: none;
      border-radius: 5px;
    }

    #contact .btn-light:hover {
      background-color: #d3bfff;
      color: #343a40;
    }

    .bi {
      margin-right: 8px;
      color: #4c4caa;
    }

    footer {
      background-color: #111;
      padding: 20px 0;
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Contact Us Section -->
<section id="contact" class="section">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <!-- Left Column: Location Info -->
      <div class="col-md-6 mb-4 mb-md-0">
        <div>
         <h2 class="text-white">Contact Us</h2>
      <p class="lead">Have questions or need help? Reach out anytime.</p>
      <p><i class="bi bi-geo-alt-fill"></i> 123 Main Street, City, Country</p>
      <p><i class="bi bi-telephone-fill"></i> +123 456 7890</p>
      <p><i class="bi bi-envelope-fill"></i> support@autoease.com</p>
      <p><i class="bi bi-clock-fill"></i> Mon - Fri: 9AM - 6PM</p>
      <p><i class="bi bi-globe2"></i> www.autoease.com</p>
    </div>
      </div>

      <!-- Right Column: Contact Form -->
      <div class="col-md-6">
        <form id="contactForm" onsubmit="sendMessage(event)">
          <div class="mb-3">
            <input type="email" class="form-control" id="email" placeholder="Your Email" required>
          </div>
          <div class="mb-3">
            <textarea class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" class="btn btn-light">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container text-white">
    <p>&copy; 2025 AutoEase | All rights reserved.</p>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function sendMessage(event) {
    event.preventDefault();
    alert('Your message has been sent! We will get back to you soon.');
  }
</script>

</body>
</html>
