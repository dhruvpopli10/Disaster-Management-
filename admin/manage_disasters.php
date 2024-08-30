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

// Handle disaster deletion
if (isset($_GET['delete'])) {
    $disaster_id = $_GET['delete'];

    // SQL query to delete the disaster information
    $stmt = $conn->prepare("DELETE FROM DisasterInformation WHERE DisasterID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $disaster_id);
    if ($stmt->execute()) {
        echo "<p>Disaster information deleted successfully.</p>";
    } else {
        echo "<p>Error deleting disaster information: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch all disaster information
$query = "SELECT DisasterID, DisasterType, Description, DateOccured, Location FROM DisasterInformation";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Disasters</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
<?php
include('navbar.php');
?>

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
        .card{
            background-color: #fff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin-top: 0;
        }

        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            width: 80%;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin-top: 0;
        }

        .card p {
            font-size: 24px;
            color: #333;
        }
    

    </style>
<h2 style="text-align: center;">Admin - Manage Disasters</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Disaster Type</th>
        <th>Description</th>
        <th>Date Occurred</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['DisasterID']); ?></td>
        <td><?php echo htmlspecialchars($row['DisasterType']); ?></td>
        <td><?php echo htmlspecialchars($row['Description']); ?></td>
        <td><?php echo htmlspecialchars($row['DateOccured']); ?></td>
        <td><?php echo htmlspecialchars($row['Location']); ?></td>
        <td>
            <a href="edit_disaster.php?id=<?php echo $row['DisasterID']; ?>">Edit</a> |
            <a href="manage_disasters.php?delete=<?php echo $row['DisasterID']; ?>" onclick="return confirm('Are you sure you want to delete this disaster information?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
