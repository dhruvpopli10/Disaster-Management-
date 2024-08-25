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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $disaster_type = $_POST['disaster_type'];
    $description = $_POST['description'];
    $date_occurred = $_POST['date_occurred'];
    $location = $_POST['location'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO DisasterInformation (DisasterType, Description, DateOccured, Location) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssss", $disaster_type, $description, $date_occurred, $location);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Disaster information added successfully.";
    } else {
        $message = "Error adding disaster information: " . $stmt->error;
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
    <title>Admin - Add Disaster Information</title>
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
<h2>Rehab - Add Disaster Information</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form action="" method="POST">
    <label for="disaster_type">Disaster Type:</label>
    <input type="text" id="disaster_type" name="disaster_type" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>

    <label for="date_occurred">Date Occurred:</label>
    <input type="date" id="date_occurred" name="date_occurred" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required>

    <button type="submit">Add Disaster</button>
    <a href="manage_disasters.php">View Disaster Information</a>
</form>

</body>
</html>
