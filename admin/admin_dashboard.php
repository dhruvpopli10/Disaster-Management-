<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "disaster_db"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total general users
$sql_general_users = "SELECT COUNT(*) AS total_general_users FROM users WHERE usertype = 'General User'";
$result_general_users = $conn->query($sql_general_users);
$row_general_users = $result_general_users->fetch_assoc();
$total_general_users = $row_general_users['total_general_users'];

// Get total rehab institutes
$sql_rehab_institutes = "SELECT COUNT(*) AS total_rehab_institutes FROM users WHERE usertype = 'Rehabilitation Institutes'";
$result_rehab_institutes = $conn->query($sql_rehab_institutes);
$row_rehab_institutes = $result_rehab_institutes->fetch_assoc();
$total_rehab_institutes = $row_rehab_institutes['total_rehab_institutes'];

// Get total disaster information
$sql_disaster_info = "SELECT COUNT(*) AS total_disaster_info FROM disasterinformation";
$result_disaster_info = $conn->query($sql_disaster_info);
$row_disaster_info = $result_disaster_info->fetch_assoc();
$total_disaster_info = $row_disaster_info['total_disaster_info'];

// Get total relief information
$sql_relief_info = "SELECT COUNT(*) AS total_relief_info FROM reliefinformation";
$result_relief_info = $conn->query($sql_relief_info);
$row_relief_info = $result_relief_info->fetch_assoc();
$total_relief_info = $row_relief_info['total_relief_info'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
</head>
<?php
include('navbar.php');
?>
<body>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="card">
            <h2>Total General Users</h2>
            <p><?php echo $total_general_users; ?></p>
        </div>
        <div class="card">
            <h2>Total Rehabilitation Institutes</h2>
            <p><?php echo $total_rehab_institutes; ?></p>
        </div>
        <div class="card">
            <h2>Total Disaster Information</h2>
            <p><?php echo $total_disaster_info; ?></p>
        </div>
        <div class="card">
            <h2>Total Relief Information</h2>
            <p><?php echo $total_relief_info; ?></p>
        </div>
    </div>
</body>
</html>
