<?php
session_start();

require_once('cvdb.php');
$cvdb = new Cvdb();

// Initialize variables
$username = '';
$password = '';

$error = null;
if (isset($_POST['login'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Check if the username and password match the admin credentials
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: admindashboard.php');
        exit;
    }

    // Retrieve the hashed password from the database
    $hashed_password = $cvdb->getHashedPassword($username);

    // Check if the username and hashed password match the saved values in the database
    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: home.php');
        exit;
    }

    // If the credentials are invalid, show an error message
    $error = 'Invalid username or password';
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: #B2B2B2;
        }

        a{
            text-decoration:none;
            color:white;
        }
    </style>

    <link rel="shortcut icon" href="cvf.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h4 class="text-center">Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php } ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="login" class="btn btn-dark">Log in</button>
                            <button  class="btn btn-dark "><a href="signup.php">Sign up</a></button>
                        </div>
                    </form>
                </div>
            </div>
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

