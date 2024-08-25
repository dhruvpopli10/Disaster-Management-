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

$message = '';

if (isset($_GET['id'])) {
    $disaster_id = $_GET['id'];

    // Fetch disaster information
    $stmt = $conn->prepare("SELECT DisasterType, Description, DateOccured, Location FROM DisasterInformation WHERE DisasterID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $disaster_id);
    $stmt->execute();
    $stmt->bind_result($disaster_type, $description, $date_occurred, $location);
    $stmt->fetch();
    $stmt->close();
}

// Update disaster information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $disaster_id = $_POST['disaster_id'];
    $disaster_type = $_POST['disaster_type'];
    $description = $_POST['description'];
    $date_occurred = $_POST['date_occurred'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE DisasterInformation SET DisasterType = ?, Description = ?, DateOccured = ?, Location = ? WHERE DisasterID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $disaster_type, $description, $date_occurred, $location, $disaster_id);
    if ($stmt->execute()) {
        $message = "Disaster information updated successfully.";
    } else {
        $message = "Error updating disaster information: " . $stmt->error;
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
    <title>Admin - Edit Disaster Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
<h2>Rehab - Edit Disaster Information</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form action="" method="POST">
    <input type="hidden" name="disaster_id" value="<?php echo htmlspecialchars($disaster_id); ?>">

    <label for="disaster_type">Disaster Type:</label>
    <input type="text" id="disaster_type" name="disaster_type" value="<?php echo htmlspecialchars($disaster_type); ?>" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>

    <label for="date_occurred">Date Occurred:</label>
    <input type="date" id="date_occurred" name="date_occurred" value="<?php echo htmlspecialchars($date_occurred); ?>" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required>

    <button type="submit">Update Disaster</button>
</form>

</body>
</html>
