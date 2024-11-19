<?php
// Database connection file
$servername = "localhost"; // or your server name
$username = "texcorpc_admin"; // your database username
$password = "Thato@2018"; // your database password (empty if default XAMPP)
$dbname = "texcorpc_hlms"; // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
