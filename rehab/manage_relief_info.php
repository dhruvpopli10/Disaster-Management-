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

// Fetch relief information
$query = "SELECT Title, Description, date_granted, Amount FROM ReliefInformation";
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
    <title>Relief Information</title>
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



<body>
    <div class="container">
        <h2>Relief Information</h2>
        
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date Granted</th>
                <th>Amount</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                <td><?php echo htmlspecialchars($row['Description']); ?></td>
                <td><?php echo htmlspecialchars($row['date_granted']); ?></td>
                <td><?php echo htmlspecialchars($row['Amount']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        
    </div>

    <a href="rehabilitation_home.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Back to Home</a>
    <a href="logout.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
