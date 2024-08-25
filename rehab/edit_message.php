<?php
session_start();

// Check if the user is logged in and is a Rehabilitation Institute
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] != 'Rehabilitation Institute') {
    header("Location: login.php");
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

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
$messageId = $_GET['id'] ?? '';

if (empty($messageId)) {
    die("Message ID is required.");
}

// Fetch the message details
$query = "SELECT Title, Message FROM publicmessage WHERE messageId = ? AND Institute = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $messageId, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messageDetails = $result->fetch_assoc();

if (!$messageDetails) {
    die("Message not found or you do not have permission to edit this message.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $messageText = $_POST['message'];

    $stmt = $conn->prepare("UPDATE publicmessage SET Title = ?, Message = ? WHERE messageId = ? AND Institute = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssii", $title, $messageText, $messageId, $user_id);
    if ($stmt->execute()) {
        $message = "Message updated successfully.";
    } else {
        $message = "Error updating message: " . $stmt->error;
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
    <title>Edit Public Message</title>
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
    <h2>Edit Public Message</h2>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="title" value="<?php echo htmlspecialchars($messageDetails['Title']); ?>" placeholder="Message Title" required>
        <textarea name="message" rows="4" placeholder="Your message..." required><?php echo htmlspecialchars($messageDetails['Message']); ?></textarea>
        <button type="submit">Update Message</button>
    </form>
</div>

</body>
</html>
