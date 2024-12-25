
<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: #B2B2B2;
        }
      
        .navbar-scroll .nav-link,
.navbar-scroll .navbar-toggler-icon,
.navbar-scroll .navbar-brand {
  color: #fff;
}

/* Color of the links AFTER scroll */
.navbar-scrolled .nav-link,
.navbar-scrolled .navbar-toggler-icon,
.navbar-scrolled .navbar-brand {
  color: #fff;
}

/* Color of the navbar AFTER scroll */
.navbar-scroll,
.navbar-scrolled {
  background-color: #cbbcb1;
}

.mask-custom {
  backdrop-filter: blur(5px);
  background-color: rgba(255, 255, 255, .15);
}

.navbar-brand {
  font-size: 1.75rem;
  letter-spacing: 3px;
}
    </style>
    <link rel="shortcut icon" href="cvf.png" type="image/x-icon">
</head>
<body>
<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
    <div class="container">
      <a class="navbar-brand" href="#!"><span style="color: #5e9693;">ab</span><span style="color: #fff;">out</span></a>
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link " href="home.php">home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cv.php">Cv</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blogs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="about.php">About</a>
          </li>
          
        </ul>
        <ul class="navbar-nav d-flex flex-row">
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="#!">
              <i > <span class="navbar-text">User, <?php echo $username; ?></span></i>
            </a>
          </li>
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="profile.php">
              <i >   profile</i>
            </a>
          </li>
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="login.php">
              <i >Log in</i>
            </a>
          </li>

          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="signup.php">
              <i >Log out</i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</header>

<div class="jumbotron">
    <div class="container py-5">
        <h1 class="display-4">About Us</h1>
        <p class="lead">We are a user-friendly site to help you make a CV.</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Our Mission</h2>
            <p>To make creating a CV easier.</p>
        </div>
        <div class="col-md-6">
            <h2>Our Vision</h2>
            <p>Creating a CV used to be complicated, but not anymore. Our vision is to make your life easier.</p>
            <img src="cvi.jpg" alt="">
        </div>
    </div>
</div>

<footer id="ftr" class="bg-dark text-center text-white">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-facebook-f"></i
      > <img src="icons8-facebook-50.png" alt=""></a>

      <!-- Twitter -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-twitter"></i
      ><img src="twitter.png" alt=""></a>

     

      <!-- Instagram -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button" > <i class="fab fa-instagram"></i
      ><img src="instagram.png" alt=""></a>

    

    
    </section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2023 Copyright: Cv creator
    
  </div>
  <!-- Copyright -->
</footer>

<style>
#ftr{
    position: fixed ; bottom: 0px; width:100%;
    
}



</style>

</body>
 </html>