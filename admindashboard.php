<?php
// Hide warnings
error_reporting(E_ERROR | E_PARSE);

session_start();

// Connect to the database
$host = "localhost";
$user = "root";
$password = "";
$database = "cvcreatdb1";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve all users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Retrieve contact_us information from the database
$sql_contact = "SELECT * FROM contact_us";
$result_contact = mysqli_query($conn, $sql_contact);
$contacts = mysqli_fetch_all($result_contact, MYSQLI_ASSOC);

// Delete user
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = $id";
    mysqli_query($conn, $delete_sql);
    header("Location: admindashboard.php");
    exit();
}

// Edit user
if (isset($_POST['edit'])) {
    $id = $_POST['edit_id'];
    $new_username = $_POST['edit_username'];
    $new_email = $_POST['edit_email'];
    $new_fullname = $_POST['edit_fullname'];

    $edit_sql = "UPDATE users SET username = '$new_username', email = '$new_email', fullname = '$new_fullname' WHERE id = $id";
    mysqli_query($conn, $edit_sql);
    header("Location: admindashboard.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
            top: 0;
            left: 0;
            bottom: 15;
            right: 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 800px;
            width: 100%;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #212529;
        }
        .table {
            margin-top: 20px;
        }
        .btn-edit {
            padding: 0.25rem 0.5rem;
        }
        .btn-delete {
            padding: 0.25rem 0.5rem;
        }
    </style>
    <script>
        function switchTables() {
            var table1 = document.getElementById("table1");
            var table2 = document.getElementById("table2");
            var switchButton = document.getElementById("switchButton");

            if (table1.style.display === "none") {
                table1.style.display = "table";
                table2.style.display = "none";
                switchButton.innerText = "Switch to Contact Us Table";
            } else {
                table1.style.display = "none";
                table2.style.display = "table";
                switchButton.innerText = "Switch to Users Table";
            }
        }
    </script>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card text-center">
            <div class="card-title">Admin Dashboard</div>

            <button id="switchButton" class="btn btn-primary mb-3" onclick="switchTables()">Switch to Contact Us Table</button>

            <table id="table1" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['fullname']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><img src="<?php echo $user['photo']; ?>" alt="User Photo" style="max-width: 100px;"></td>
                            <td>
                                <!-- Delete user form -->
                                <form method="post" action="">
                                    <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-delete">Delete</button>
                                </form>

                                <!-- Edit user form -->
                                <form method="post" action="">
                                    <input type="hidden" name="edit_id" value="<?php echo $user['id']; ?>">
                                    <div class="input-group">
                                        <input type="text" name="edit_username" class="form-control" value="<?php echo $user['username']; ?>">
                                        <input type="email" name="edit_email" class="form-control" value="<?php echo $user['email']; ?>">
                                        <input type="text" name="edit_fullname" class="form-control" value="<?php echo $user['fullname']; ?>">
                                        <button type="submit" name="edit" class="btn btn-primary btn-edit">Edit</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table id="table2" class="table table-striped" style="display: none;">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo $contact['username']; ?></td>
                            <td><?php echo $contact['name']; ?></td>
                            <td><?php echo $contact['email']; ?></td>
                            <td><?php echo $contact['message']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="login.php" class="btn btn-dark mt-3">Log out</a>
        </div>
    </div>
</body>
</html>
