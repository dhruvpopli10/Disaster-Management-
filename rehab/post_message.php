<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's details from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $messageText = $_POST['message'];
    $datePosted = date('Y-m-d'); // Get today's date

    // Prepare the SQL statement with the correct column names
    $stmt = $conn->prepare("INSERT INTO publicmessage (Institute, Title, Message, DatePosted) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    // Bind parameters to the SQL query
    $stmt->bind_param("isss", $user_id, $title, $messageText, $datePosted);
    if ($stmt->execute()) {
        $message = "Public message posted successfully.";
    } else {
        $message = "Error posting message: " . $stmt->error;
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
    <title>Post Public Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input[type="text"],
        .container form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container form button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .container form button:hover {
            background-color: #0056b3;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container">
    <h2>Post Public Message</h2>

    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="title" placeholder="Message Title" required>
        <textarea name="message" rows="4" placeholder="Your message..." required></textarea>
        <button type="submit">Post Message</button>
    </form>
</div>
<ul>
    <li><a href="view_messages.php">View Messages </a></li>
    <li><a href="rehabilitation_home.php">Back to Home</a>
    </li>
</ul>
<a href="logout.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Logout</a>

</body>
</html>
