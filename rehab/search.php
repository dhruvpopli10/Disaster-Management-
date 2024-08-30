<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Precautions Search</title>
    <link rel="stylesheet" href="search.css">
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
    padding-top: 10px; /* Add top padding to avoid content being hidden under the navbar */
}

.navbar {
    display: flex;
    justify-content: center;
    background-color: #333;
    padding: 10px 0;
    list-style: none;
    margin: 0;
    position: fixed; /* Make the navbar stay at the top */
    width: 100%; /* Ensure the navbar spans the full width */
    top: 0;
    z-index: 1000; /* Ensure it stays on top of other elements */
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
</style>

<div class="container">
    <h1>Disaster Precautions Search</h1>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for a disaster...">
        <button onclick="searchPrecautions()">Search</button>
    </div>
    <div id="results" class="results"></div>
    <a href="rehabilitation_home.php" style="display: inline-block; margin: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Back to Home</a>

</div>

<script src="search.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    margin-bottom: 20px;
}

.search-container {
    margin-bottom: 20px;
}

input[type="text"] {
    padding: 10px;
    font-size: 16px;
    width: 300px;
    border: 2px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    cursor: pointer;
    margin-left: 10px;
}

button:hover {
    background-color: #0056b3;
}

.results {
    margin-top: 20px;
}

.result-item {
    background-color: #007BFF;
    color: white;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    text-align: left;
}
.back-to-home {
    display: block;
    margin: 20px auto 0;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    width: fit-content;
    position: inline;
    left: 50%;
    transform: translateX(-50%);
    bottom: 20px;
}

</style>

</body>

</html>
