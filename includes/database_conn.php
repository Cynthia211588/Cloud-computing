<?php

// --- Database Configuration ---
$servername = "exploremy-db.cvgce2ioovk9.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "admin123!"; 
$dbname = "ExploreMY_db"; 

// --- Create the Connection Object ---
$conn = new mysqli($servername, $username, $password, $dbname);

// --- Check for Connection Errors ---
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
