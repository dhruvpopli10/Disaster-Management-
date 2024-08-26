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

// Query to get the latest 3 disaster information
$sql_disaster_info = "SELECT DisasterType, Description, DateOccured, Location FROM disasterinformation ORDER BY DateOccured DESC LIMIT 3";
$result_disaster_info = $conn->query($sql_disaster_info);

// Query to get the latest 3 relief information
$sql_relief_info = "SELECT Title, description, date_granted, Amount FROM reliefinformation ORDER BY date_granted DESC LIMIT 3";
$result_relief_info = $conn->query($sql_relief_info);

// Query to get the latest 3 public messages for the user's institute
$sql_public_message = "SELECT Title, Message, DatePosted FROM publicmessage WHERE Institute = ? ORDER BY DatePosted DESC LIMIT 3";
$stmt_public_message = $conn->prepare($sql_public_message);
$stmt_public_message->bind_param("i", $_SESSION['user_id']);
$stmt_public_message->execute();
$result_public_message = $stmt_public_message->get_result();

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
            width: 80%;
            margin: 20px auto;
        }
        .card-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            flex: 1 1 calc(33% - 20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin-top: 0;
        }
        .card p {
            margin: 5px 0;
        }
        .view-more {
            text-align: right;
            margin-top: 20px;
        }
        .view-more a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
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

<?php include('navbar.php'); ?>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>You are logged in as a <strong><?php echo htmlspecialchars($usertype); ?></strong>.</p>

    <div class="card-container">
        <div class="card">
            <h3>Disaster Information</h3>
            <?php while ($row = $result_disaster_info->fetch_assoc()): ?>
                <p><strong><?php echo htmlspecialchars($row['DisasterType']); ?></strong></p>
                <p><?php echo htmlspecialchars($row['Description']); ?></p>
                <p><em><?php echo htmlspecialchars($row['DateOccured']); ?></em> - <?php echo htmlspecialchars($row['Location']); ?></p>
            <?php endwhile; ?>
            <div class="view-more">
                <a href="manage_disasters.php">View More</a>
            </div>
        </div>

        <div class="card">
            <h3>Relief Information</h3>
            <?php while ($row = $result_relief_info->fetch_assoc()): ?>
                <p><strong><?php echo htmlspecialchars($row['Title']); ?></strong></p>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p><em><?php echo htmlspecialchars($row['date_granted']); ?></em> - $<?php echo htmlspecialchars($row['Amount']); ?></p>
            <?php endwhile; ?>
            <div class="view-more">
                <a href="manage_relief_info.php">View More</a>
            </div>
        </div>

        <div class="card">
            <h3>Public Messages</h3>
            <?php while ($row = $result_public_message->fetch_assoc()): ?>
                <p><strong><?php echo htmlspecialchars($row['Title']); ?></strong></p>
                <p><?php echo htmlspecialchars($row['Message']); ?></p>
                <p><em><?php echo htmlspecialchars($row['DatePosted']); ?></em></p>
            <?php endwhile; ?>
            <div class="view-more">
                <a href="view_messages.php">View More</a>
            </div>
        </div>
    </div>

    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>
