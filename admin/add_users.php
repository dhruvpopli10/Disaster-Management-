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

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // No hashing
    $contact_info = $_POST['contact_info'];
    $user_type = $_POST['user_type'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, contact_info, user_type, address) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $username, $email, $password, $contact_info, $user_type, $address);
    if ($stmt->execute()) {
        $message = "User added successfully.";
    } else {
        $message = "Error adding user: " . $stmt->error;
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
    <title>Admin - Add User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<ul class="navbar">
    <li><a href="admin_dashboard.php">Home</a></li>
    <li><a href="manage_user.php">Manage users</a></li>
    <li><a href="add_relief_info.php">Add Relief Info</a></li>
    <li><a href="admin_login.php">Admin login</a></li>
</ul>


<h2>Admin - Add User</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="contact_info">Contact Info:</label>
    <input type="text" id="contact_info" name="contact_info" required>

    <label for="user_type">User Type:</label>
    <select id="user_type" name="user_type" required>
        <option value="Rehabilitation Institute">Rehabilitation Institute</option>
        <option value="General">General</option>
    </select>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>

    <button type="submit">Add User</button>
</form>

</body>
</html>
