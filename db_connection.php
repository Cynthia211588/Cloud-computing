<?php

    $servername = getenv('DB_HOST') ?: "localhost";
    $username = getenv('DB_USERNAME') ?: "root";
    $password = getenv('DB_PASSWORD') ?: "";
    $dbname = getenv('DB_DATABASE') ?: "exploremy_db";
    $port = getenv('DB_PORT') ?: 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

?>