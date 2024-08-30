<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Shelter Finder</title>
    <link rel="stylesheet" href="safehouse.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<?php include('navbar.php'); ?>
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

<body>
    <div class="container">
        <h1>Find Nearest Safe Places or Shelters</h1>
        <input type="text" id="location-input" placeholder="Enter a location">
        <button onclick="searchLocation()">Search</button>
        <p id="status"></p>
        <div id="map"></div>
        <ul id="shelter-list"></ul>
    </div>
    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="safehouse.js"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    margin: 20px auto;
    padding: 20px;
    max-width: 600px;
    background: white;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

#map {
    height: 300px;
    width: 100%;
    margin-top: 20px;
}

#shelter-list {
    list-style: none;
    padding: 0;
}

#shelter-list li {
    background: #eee;
    margin: 5px 0;
    padding: 10px;
    border-radius: 5px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

#status {
    margin-top: 10px;
    font-size: 14px;
    color: #888;
}

#location-input {
    padding: 10px;
    width: 80%;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

    </style>

</body>
</html>
