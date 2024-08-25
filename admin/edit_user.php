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

// Fetch user details
$user_id = $_GET['id'];
$stmt = $conn->prepare("SELECT id, username, email, contact_info, user_type, address FROM users WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($id, $username, $email, $contact_info, $user_type, $address);
$stmt->fetch();
$stmt->close();

// Update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_contact_info = $_POST['contact_info'];
    $new_user_type = $_POST['user_type'];
    $new_address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, contact_info = ?, user_type = ?, address = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $new_username, $new_email, $new_contact_info, $new_user_type, $new_address, $user_id);
    if ($stmt->execute()) {
        header("Location: manage_user.php");
        exit();
    } else {
        echo "<p>Error updating user: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit User</title>
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
    </style>
</head>
<body>

<h2>Admin - Edit User</h2>

<form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

    <label for="contact_info">Contact Info:</label>
    <input type="text" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($contact_info); ?>" required>

    <label for="user_type">User Type:</label>
    <select id="user_type" name="user_type" required>
        <option value="Rehabilitation Institute" <?php echo $user_type == 'Rehabilitation Institute' ? 'selected' : ''; ?>>Rehabilitation Institute</option>
        <option value="General" <?php echo $user_type == 'General' ? 'selected' : ''; ?>>General</option>
    </select>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

    <button type="submit">Update User</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
