<?php
error_reporting(E_ALL & ~E_WARNING);

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Connect to database
$host = "localhost";
$user = "root";
$password = "";
$database = "cvcreatdb1";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM cvs WHERE username = '$username'";
$sql = "SELECT name, email, phone, address, summary, education, experience FROM cvs WHERE username = '$username' ORDER BY id DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: #B2B2B2;
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
            <div class="container">
                <a class="navbar-brand" href="#!"><span style="color: lightblue;">Cv</span><span style="color: #fff;">creator</span></a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"                            href="cv.php">Cv</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav d-flex flex-row">
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="#!">
                                <i><span class="navbar-text">User, <?php echo $username; ?></span></i>
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="profile.php">
                                <i>Profile</i>
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="login.php">
                                <i>Log in</i>
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="signup.php">
                                <i>Log out</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container my-4 py-5">
        <div class="bg-light p-4 rounded">
            <h1 class="text-center mb-4" style="color: #343a40;">Your CV</h1>
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo $row['name']; ?></h2>
                    <p>Email: <?php echo $row['email']; ?></p>
                    <p>Phone: <?php echo $row['phone']; ?></p>
                    <p>Address: <?php echo $row['address']; ?></p>
                  
                    <p> <div id="display-image">
    <?php
                          $query = " select * from image ";
                         $result = mysqli_query($db, $query);
 
                         while ($data = mysqli_fetch_assoc($result)) {
    ?>
                <img src="./image/<?php echo $data['filename']; ?>">
 
    <?php
        }
    ?>
    </div></p>
                </div>
                <div class="col-md-6">
                    <h3>Summary</h3>
                    <p><?php echo $row['summary']; ?></p>
                </div>
                
                <div class="col-md-6">
                    <h3>Education</h3>
                    <p><?php echo $row['education']; ?></p>
                </div>
                <div class="col-md-6">
                    <h3>Experience</h3>
                    <p><?php echo $row['experience']; ?></p>
                    <button class="btn btn-primary" onclick="window.location.href = 'edit_cv.php'">Edit</button>

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
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                    <i class="fab fa-facebook-f"></i><img src="icons8-facebook-50.png" alt="">
                </a>
                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!"
                role="button">
                    <i class="fab fa-twitter"></i><img src="twitter.png" alt="">
                </a>
                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                    <i class="fab fa-instagram"></i><img src="instagram.png" alt="">
                </a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Cv creator
        </div>
    </footer>
    <style>
        #ftr {
            position: fixed;
            bottom: 0px;
            width: 100%;
        }
    </style>
</body>
</html>

