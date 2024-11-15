<?php
// Database configuration
define('DB_HOST', 'localhost'); 
define('DB_USER', 'nija'); 
define('DB_PASSWORD', 'root'); 
define('DB_NAME', 'assignment3php'); 

// Create a connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
