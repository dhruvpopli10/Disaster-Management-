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

// Query to get total disaster information
$sql_disaster_info = "SELECT COUNT(*) as total_disaster_info FROM disasterinformation";
$result_disaster_info = $conn->query($sql_disaster_info);
$total_disaster_info = $result_disaster_info->fetch_assoc()['total_disaster_info'];

// Query to get total relief information
$sql_relief_info = "SELECT COUNT(*) as total_relief_info FROM reliefinformation";
$result_relief_info = $conn->query($sql_relief_info);
$total_relief_info = $result_relief_info->fetch_assoc()['total_relief_info'];

// Query to get total public messages
$sql_public_message = "SELECT COUNT(*) as total_public_message FROM publicmessage WHERE Institute = ?";
$stmt_public_message = $conn->prepare($sql_public_message);
$stmt_public_message->bind_param("i", $_SESSION['user_id']);
$stmt_public_message->execute();
$result_public_message = $stmt_public_message->get_result();
$total_public_message = $result_public_message->fetch_assoc()['total_public_message'];

$stmt_public_message->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehabilitation Institutes Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px 0;
            list-style: none;
            margin: 0;
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
            margin: 20px auto;
        }
        .dashboard-item {
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .dashboard-item h2 {
            margin: 0;
            color: #333;
        }
        .dashboard-item p {
            font-size: 24px;
            color: #007bff;
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

<?php
include('navbar.php');
?>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>You are logged in as a <strong><?php echo htmlspecialchars($usertype); ?></strong>.</p>

    <div class="dashboard-item">
        <h2>Total Disaster Information</h2>
        <p><?php echo $total_disaster_info; ?></p>
    </div>

    <div class="dashboard-item">
        <h2>Total Relief Information</h2>
        <p><?php echo $total_relief_info; ?></p>
    </div>

    <div class="dashboard-item">
        <h2>Total Public Messages</h2>
        <p><?php echo $total_public_message; ?></p>
    </div>

    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>
