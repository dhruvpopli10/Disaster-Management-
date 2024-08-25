<?php
require_once 'config.php';
$host='localhost';
$username='root';
$password='';
$database='disaster_db';
$connection = new mysqli($host,$username,$password,$database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
