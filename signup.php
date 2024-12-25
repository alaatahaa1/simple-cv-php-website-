<?php
session_start();

require_once('cvdb.php');
$cvdb = new Cvdb();

// Initialize variables
$username = '';
$password = '';
$error = null;
$success = null;

$fullname = '';
$email = '';

if (isset($_POST['signup'])) {
    $new_username = htmlspecialchars(trim($_POST['username']));
    $new_password = htmlspecialchars(trim($_POST['password']));
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Validate the inputs
    if (empty($new_username) || empty($new_password) || empty($fullname) || empty($email)) {
        $error = 'Please enter all required fields.';
    } else {
        // Hash the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Save the username, hashed password, full name, and email to session variables
        $_SESSION['username'] = $new_username;
        $_SESSION['hashed_password'] = $hashed_password;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;

        // Insert the user into the database
        if ($cvdb->userExists($new_username)) {
            $error = 'Username already exists.';
        } else {
            $cvdb->insertUser($new_username, $hashed_password, $fullname, $email);
            $success = 'Your account has been created successfully!';
        }
    }
}

if (isset($_POST['login'])) {
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign up</title>
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
                    <h4 class="text-center">Sign up</h4>
                </div>
                
                <div class="card-body">
                    <?php if (isset($error) && $error !== null) { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php } ?>
                    <?php if (isset($success) && $success !== null) { ?>
                    <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
                    <?php } ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo htmlspecialchars($fullname); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="signup" class="btn btn-dark">Sign up</button>
                            <button type="submit" name="login" class="btn btn-dark"><a href="login.php">Log in</a></button>
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
    &copy; 2023 Cv creator
  </div>
  <!-- Copyright -->
</footer>

<style>
#ftr{
    position: fixed; bottom: 0px; width:100%;
}
</style>

</body>
</html>

