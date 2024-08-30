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

// Get the relief ID from the URL
$relief_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_granted = $_POST['date_granted'];
    $amount = $_POST['amount'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE Reliefinformation SET Title = ?, description = ?, date_granted = ?, Amount = ? WHERE ReliefID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters - Note that the correct bind_param string is "sssdi"
    $stmt->bind_param("sssdi", $title, $description, $date_granted, $amount, $relief_id);

    if ($stmt->execute()) {
        $message = "Relief information updated successfully.";
    } else {
        $message = "Error updating relief information: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch the relief information to edit
$stmt = $conn->prepare("SELECT Title, description, date_granted, Amount FROM Reliefinformation WHERE ReliefID = ?");
$stmt->bind_param("i", $relief_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($title, $description, $date_granted, $amount);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
} else {
    die("No record found.");
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Relief Information</title>
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
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
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
<h2 style="text-align: center;">Edit Relief Information</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($relief_id); ?>">

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>

    <label for="date_granted">Date Granted:</label>
    <input type="date" id="date_granted" name="date_granted" value="<?php echo htmlspecialchars($date_granted); ?>" required>

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" step="0.01" value="<?php echo htmlspecialchars($amount); ?>" required>

    <button type="submit">Update Relief Information</button>
    <a href="manage_relief_info.php">View relief information</a>

</form>

</body>
</html>
