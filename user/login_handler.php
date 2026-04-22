<?php
session_start();

require_once '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $submitted_password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM user_profile WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($submitted_password, $user['password'])) {
            // Set ALL necessary session variables
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_id'] = $user['id']; // Make sure your DB has an 'id' column
            $_SESSION['user_name'] = $user['first_name']; // For backward compatibility
            
            // Redirect to home page
            header("Location: ../index.php");
            exit();
        }
    }
    
    // Login failed
    $_SESSION['login_error'] = "Incorrect email or password. Please try again.";
    header("Location: login.php");
    exit();
} else {
    // No POST data, redirect to login
    header("Location: login.php");
    exit();
}

$conn->close();
?>