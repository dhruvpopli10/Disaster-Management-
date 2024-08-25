<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's details from the session
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Database connection
$servername = "localhost";
$db_username = "root"; // Replace with your database username
$db_password = ""; // Replace with your database password
$dbname = "disaster_db"; // Replace with your database name

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the latest 3 relief information
$sql_relief_info = "SELECT Title, description, date_granted FROM reliefinformation ORDER BY date_granted DESC LIMIT 3";
$result_relief_info = $conn->query($sql_relief_info);

// Query to get the latest 3 public messages
$sql_public_message = "SELECT Title, Message, DatePosted FROM publicmessage ORDER BY DatePosted DESC LIMIT 3";
$result_public_message = $conn->query($sql_public_message);

// Check if there are more than 3 relief information records
$sql_relief_info_count = "SELECT COUNT(*) as total_relief_info FROM reliefinformation";
$total_relief_info = $conn->query($sql_relief_info_count)->fetch_assoc()['total_relief_info'];

// Check if there are more than 3 public messages
$sql_public_message_count = "SELECT COUNT(*) as total_public_message FROM publicmessage";
$total_public_message = $conn->query($sql_public_message_count)->fetch_assoc()['total_public_message'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General User Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px 0;
            list-style: none;
            margin: 0;
            width: 100%;
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            margin-bottom: 20px;
        }
        .card-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .card {
            background-color: #e9ecef;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }
        .card h3 {
            margin-top: 0;
            color: #007bff;
        }
        .view-more {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<ul class="navbar">
    <li><a href="general_user_home.php">Home</a></li>
    <li><a href="register.php">Update Profile</a></li>
    <li><a href="relief_info.php">Check Relief Information</a></li>
    <li><a href="disaster_info.php">Check Disaster Information</a></li>
    <li><a href="view_messages.php">View Public Message</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>You are logged in as a <strong><?php echo htmlspecialchars($usertype); ?></strong>.</p>
</div>

<div class="container">
    <h2>Latest Relief Information</h2>
    <div class="card-row">
        <?php while ($row = $result_relief_info->fetch_assoc()) { ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p><strong>Date Granted:</strong> <?php echo htmlspecialchars($row['date_granted']); ?></p>
        </div>
        <?php } ?>
    </div>
    <?php if ($total_relief_info > 3) { ?>
        <a href="relief_info.php" class="view-more">View More</a>
    <?php } ?>
</div>

<div class="container">
    <h2>Latest Public Messages</h2>
    <div class="card-row">
        <?php while ($row = $result_public_message->fetch_assoc()) { ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
            <p><?php echo htmlspecialchars($row['Message']); ?></p>
            <p><strong>Date Posted:</strong> <?php echo htmlspecialchars($row['DatePosted']); ?></p>
        </div>
        <?php } ?>
    </div>
    <?php if ($total_public_message > 3) { ?>
        <a href="view_messages.php" class="view-more">View More</a>
    <?php } ?>
</div>

<a href="logout.php" class="logout">Logout</a>

</body>
</html>
