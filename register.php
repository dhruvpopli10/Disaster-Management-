<?php
include('config.php');
// Database connection
$host = 'localhost'; // Database host
$db   = 'disaster_db'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $contact_info = $_POST['contact_info'];
    $address = $_POST['address'];
    $usertype = $_POST['usertype'];

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, contact_info, address, usertype) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $password, $contact_info, $address, $usertype);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $stmt->error;
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
    <title>User Registration</title>
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
        .container input, .container select, .container textarea {
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
            color: green;
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
    <h2>User Registration</h2>
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
        <input type="text" id="contact_info" name="contact_info">

        <label for="address">Address:</label>
        <textarea id="address" name="address"></textarea>

        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype" required>
            <option value="Rehabilitation Institutes">General User</option>
            <option value="General User">Volunteer</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
