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
<h2>Rehab - Manage Disasters</h2>

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
