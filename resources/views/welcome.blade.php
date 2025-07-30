<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AgroConnect System</title>

  <!-- Bootstrap -->
  <link href="/build/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="/build/assets/icon/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #e0f2f1, #f1f8e9);
      color: #2e7d32;
      padding-top: 70px;
      padding-bottom: 100px;
    }

    .navbar {
      background: #1b5e20;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand, .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 600;
    }

    .navbar-nav .nav-link:hover {
      color: #c8e6c9 !important;
    }

    .carousel-item {
      position: relative;
      height: 550px;
    }

    .carousel-item img {
      object-fit: cover;
      height: 100%;
      width: 100%;
      border-radius: 10px;
    }

    .carousel-caption {
      position: absolute;
      bottom: 20%;
      left: 10%;
      right: 10%;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 20px;
      border-radius: 10px;
    }

    .carousel-caption h5 {
      font-size: 2rem;
      font-weight: bold;
      color: #fff;
    }

    .carousel-caption p {
      font-size: 1.1rem;
      color: #e0f7fa;
    }

    .section-card {
      background: #ffffff;
      padding: 50px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      margin-bottom: 40px;
      transition: all 0.3s ease-in-out;
    }

    .section-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .section-icon {
      font-size: 50px;
      color: #2e7d32;
      margin-bottom: 20px;
    }

    .footer {
      background: linear-gradient(to right, #1b5e20, #388e3c);
      color: #fff;
      padding: 25px 0;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1000;
      font-size: 15px;
    }

    .footer a {
      color: #c8e6c9;
      text-decoration: none;
      padding: 0 8px;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .btn-primary {
      background: #1b5e20;
      border: none;
    }

    .btn-primary:hover {
      background: #43a047;
    }

    h2.section-title {
      font-weight: 600;
      color: #1b5e20;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">AgroConnect</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contacts</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide container-fluid p-0" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
  </div>
  <div class="carousel-inner rounded">
    <div class="carousel-item active">
      <img src="/build/assets/picha/zao.jpg" class="d-block w-100" alt="Agriculture 1">
      <div class="carousel-caption">
        <h5>Empowering Farmers with Technology</h5>
        <p>Join AgroConnect and transform your farming experience.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/build/assets/picha/zao.jpg" class="d-block w-100" alt="Agriculture 2">
      <div class="carousel-caption">
        <h5>Linking Buyers and Sellers Easily</h5>
        <p>Buy fresh, sell smart — all in one platform.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/build/assets/picha/zao.jpg" class="d-block w-100" alt="Agriculture 3">
      <div class="carousel-caption">
        <h5>Grow Your Business with AgroConnect</h5>
        <p>Modern tools for modern agriculture.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- About Section -->
<div id="about" class="container mt-5">
  <div class="section-card text-center">
    <div class="section-icon"><i class="fas fa-seedling"></i></div>
    <h2 class="section-title">About AgroConnect</h2>
    <p>
      AgroConnect is a cutting-edge platform connecting farmers and buyers across regions.
      We empower agricultural communities by simplifying trade and promoting transparency.
    </p>
  </div>
</div>

<!-- Contact Section -->
<div id="contact" class="container mt-5">
  <div class="section-card text-center">
    <div class="section-icon"><i class="fas fa-envelope-open-text"></i></div>
    <h2 class="section-title">Contact Us</h2>
    <p>Have questions or need help? Reach out to us through:</p>
    <p><i class="fas fa-envelope"></i> support@agroconnect.com</p>
    <p><i class="fas fa-phone"></i> +255 123 456 789</p>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  <p>&copy;{{ date('Y') }} AgroConnect. All rights reserved.</p>
</div>

<!-- Scripts -->
<script src="/build/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
