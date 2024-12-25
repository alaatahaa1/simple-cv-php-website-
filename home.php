<?php
error_reporting(0); // Disable error reporting
session_start();

$username = $_SESSION['username'];
// Connect to the database
$host = "localhost";
$user = "root";
$password = "";
$database = "cvcreatdb1";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert CV information into the database
if (!empty($_POST)) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $summary = $_POST['summary'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];

    // Handle photo upload
    $photo = $_FILES['photo'];
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoPath = 'uploads/' . $photoName;

    // Move the uploaded photo to the desired directory
    if (move_uploaded_file($photoTmpName, $photoPath)) {
        // Photo uploaded successfully, continue with database insertion
        $sql = "INSERT INTO cvs (name, email, phone, address, summary, education, experience, username, photo) 
                VALUES ('$name', '$email', '$phone', '$address', '$summary', '$education', '$experience', '$username', '$photoPath')";

        if (mysqli_query($conn, $sql)) {
            echo "CV information saved successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload the photo.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
<header>
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


<div class="container my-5 p-4">
    <h1>Create your CV</h1>
   
    <form action="home.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input style="width:30%;" type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input style="width:30%;" type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input style="width:30%;" type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input style="width:30%;" type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="summary">Summary</label>
            <textarea class="form-control" style="width:30%;" id="summary" name="summary" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="education">Education</label>
            <textarea class="form-control" style="width:30%;" id="education" name="education" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="experience">Experience</label>
            <textarea class="form-control" style="width:30%;" id="experience" name="experience" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-dark mt-2">Submit</button>
    </form>
</div>
<footer>
    <!-- Add your footer code here -->
</footer>
</body>
</html>
