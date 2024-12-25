<?php
error_reporting(0); // Disable error reporting

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

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

// Get the current CV information for the user
$sql = "SELECT * FROM cvs WHERE username = '$username'";
$sql = "SELECT name, email, phone, address, summary, education, experience FROM cvs WHERE username = '$username' ORDER BY id DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Update CV information in the database
if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $summary = $_POST['summary'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    
    $sql = "UPDATE cvs SET name = '$name', email = '$email', phone = '$phone', address = '$address',
            summary = '$summary', education = '$education', experience = '$experience'
            WHERE username = '$username'";

    if (mysqli_query($conn, $sql)) {
        echo "CV information updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit CV</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="address" class="form-control" value="<?php echo $row['address']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="summary" class="form-label">Summary:</label>
                <textarea name="summary" class="form-control" required><?php echo $row['summary']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="education" class="form-label">Education:</label>
                <textarea name="education" class="form-control" required><?php echo $row['education']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="experience" class="form-label">Experience:</label>
                <textarea name="experience" class="form-control" required><?php echo $row['experience']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update CV</button>
        </form>
    </div>

    <!-- Add your JavaScript scripts or external links here -->
</body>
</html>

