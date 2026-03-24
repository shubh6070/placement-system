<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db   = "placetrack";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set charset (important for security & proper data)
mysqli_set_charset($conn, "utf8");
?>