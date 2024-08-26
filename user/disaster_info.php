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
$host = 'localhost';
$db   = 'disaster_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch disaster information
$query = "SELECT DisasterType, Description, DateOccured, Location FROM DisasterInformation";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin-top: 20px;
        }
        .container h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Disaster Information</h2>
        
        <table>
            <tr>
                <th>Disaster Type</th>
                <th>Description</th>
                <th>Date Occurred</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['DisasterType']); ?></td>
                <td><?php echo htmlspecialchars($row['Description']); ?></td>
                <td><?php echo htmlspecialchars($row['DateOccured']); ?></td>
                <td><?php echo htmlspecialchars($row['Location']); ?></td>
                <td><a href="add_relief_info.php">Help Financial</a></td>
        
            </tr>
            <?php endwhile; ?>
        </table>
        
    </div>

    <a href="general_user_home.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Back to Home</a>
    <a href="logout.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
