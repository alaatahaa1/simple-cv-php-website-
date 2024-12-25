<?php
// Hide warnings
error_reporting(E_ERROR | E_PARSE);

session_start();

// Check if user is not logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Get the user's username from the session
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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input values
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // Get the user's current password hash from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $hash = $row['password'] ?? '';

    if (empty($old_password) || empty($new_password)) {
        $error = 'Please enter both old and new passwords';
    } elseif (!password_verify($old_password, $hash)) {
        $error = 'Invalid old password';
    } else {
        // Hash the new password
        $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_hash, $username);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows === 1) {
            $success = 'Password changed successfully!';
            // Destroy the session to log out the user
            session_destroy();
            header('Location: login.php');
            exit;
        } else {
            $error = 'Failed to change password';
        }
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: #B2B2B2;
        }
        .card {
            background-color: #F8F8F8;
            border-radius: 10px;
            padding: 30px;
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 15; right: 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 300px;
            width: 100%;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #212529;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
        }
        .btn-dark {
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            margin-top: 20px;
        }
    </style>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card text-center">
            <div class="card-title">Welcome <?php echo $username; ?>!</div>
            
           

            <form method="post">
    <div class="mb-3">
        <label for="password" class="form-label">Old Password</label>
        <input type="password" class="form-control" id="old_password" name="old_password" required>
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary" name="submit">Change Password</button>
</form>


            <a href="signup.php" class="btn btn-dark mt-3">Log out</a>
        </div>
    </div>


</footer>

<style>
#ftr{
    position: fixed ; bottom: 0px; width:100%;
    
}



</style>


</body>
</html>

