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

// Handle relief information deletion
if (isset($_GET['delete'])) {
    $relief_id = $_GET['delete'];

    // SQL query to delete the relief information
    $stmt = $conn->prepare("DELETE FROM Reliefinformation WHERE ReliefID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $relief_id);
    if ($stmt->execute()) {
        echo "<p>Relief information deleted successfully.</p>";
    } else {
        echo "<p>Error deleting relief information: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch all relief information
$query = "SELECT ReliefID, Title, description, date_granted, Amount FROM Reliefinformation";
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
    <title>Rehab - Manage Relief Information</title>
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
<h2>Rehab - Manage Relief Information</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Date Granted</th>
        <th>Amount</th>
        <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ReliefID']); ?></td>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['date_granted']); ?></td>
            <td><?php echo htmlspecialchars($row['Amount']); ?></td>
            <td>
                <a href="edit_relief_info.php?id=<?php echo $row['ReliefID']; ?>">Edit</a> |
                <a href="manage_relief_info.php?delete=<?php echo $row['ReliefID']; ?>" onclick="return confirm('Are you sure you want to delete this relief information?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No relief information found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
