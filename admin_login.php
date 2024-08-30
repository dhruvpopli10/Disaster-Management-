<?php
session_start();

// Database connection
$host = 'localhost';
$db   = 'disaster_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to fetch the admin
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if admin exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fetched_username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if ($password=== $hashed_password) {
            // Set session variables
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $fetched_username;

            // Redirect to admin dashboard
            header("Location: ./admin/admin_dashboard.php");
            exit();
        } else {
            $message = "Incorrect password. Please try again.";
        }
    } else {
        $message = "No admin found with this username.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin-bottom: 8px;
        }
        .container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
include('navbar.php');
?>
<style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('back2.jpg'); /* Replace with your image URL */
    background-size: cover;
    background-position: center;
    margin: 0;
    padding: 0;
}

.navbar {
    display: flex;
    justify-content: center;
    background-color: rgba(51, 51, 51, 0.8); /* Make navbar semi-transparent */
    padding: 10px 0;
    margin: 0;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.navbar ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar li {
    margin: 0 15px;
}

.navbar a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.container {
    background-color: rgba(255, 255, 255, 0.9); /* Make container semi-transparent */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin: 100px auto 0; /* Adjust margin-top to account for the fixed navbar */
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.container label {
    display: block;
    margin-bottom: 8px;
}

.container input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.container button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
}

.container button:hover {
    background-color: #218838;
}

.message {
    color: red;
    text-align: center;
    margin-bottom: 20px;
}

    </style>

<div class="container">
    <h2>Admin Login</h2>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
