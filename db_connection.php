<?php

    $servername = getenv('DB_HOST') ?: "localhost";
    $username = getenv('DB_USER') ?: "root";
    $password = getenv('DB_PASS') ?: "";
    $dbname = getenv('DB_NAME') ?: "exploremy_db";
    $port = getenv('DB_PORT') ?: 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

?>