<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Initialize the $stmt variable
$stmt = null;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and validate the input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || empty($email) || empty($message)) {
        // Handle form validation errors
        die('Please fill in all the required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email format
        die('Please enter a valid email address.');
    }

    // Establish a database connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'cvcreatdb1';

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die('Failed to connect to the database: ' . mysqli_connect_error());
    }

    // Prepare the SQL query
    $sql = "INSERT INTO contact_us (username, name, email, message) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Failed to prepare the SQL query: ' . mysqli_error($conn));
    }

    // Bind the input parameters
    mysqli_stmt_bind_param($stmt, "ssss", $username, $name, $email, $message);

    if ($stmt->execute() === TRUE) {
      // Success message
      echo "<div class='alert alert-success' role='alert' style='margin-top: 5%;'>
                  Your message has been sent successfully!
                </div>";
  } else {
      // Error message
      echo "<div class='alert alert-danger' role='alert'>
          Sorry, there was an error sending your message. Please try again later.
        </div>";
  }


    // Close the prepared statement and the database connection if they were initialized successfully
    if ($stmt) {
        $stmt->close();
    }
    if ($conn) {
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>


    <title>Contact</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
          <style>
            body{
                background-color:#B2B2B2;
                
               flex: auto;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
    <div class="container ">
      <a class="navbar-brand" href="#!"><span style="color: #5e9693;">con</span><span style="color: #fff;">tact</span></a>
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
            <a class="nav-link " href="cv.php">Cv</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blogs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
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

    <div class="container my-4 py-5">
        <h1 class="text-center mb-5">Contact Us</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
            <form method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block" name="submit"><a class="text-white">Submit</a></button>
</form>

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
