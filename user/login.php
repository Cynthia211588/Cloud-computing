<?php
session_start();
// This part is for displaying an error message if the login handler finds one
$message = "";
if (isset($_SESSION['login_error'])) {
    $message = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Clear the error after showing it
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ExploreMy</title>
	<!-- Bootstrap CSS (Required for header dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome (Required for header icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../style/userStyle.css">
	<link rel="stylesheet" href="../style/header.css">
</head>


<body>
    <!-- Include Header (adjust path as needed) -->


    <?php include('../includes/auth_header.php'); ?>
    
    <div class="account-container">
        <?php if (!empty($message)): ?>
            <div class="login-message" style="color:red; text-align:center; padding: 10px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="account-header">
            <h1>Login to Your Account</h1>
        </div>
        
        <form action="login_handler.php" method="POST">
            <div class="form-row">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-row">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
            
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (Required for header dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
		<!--this is to make sure header not overlap with content-->
		<script>
			document.addEventListener("DOMContentLoaded", () => {
				const header = document.querySelector(".site-header");
				if (header) {
						document.body.style.paddingTop = header.offsetHeight + "px";
				}
			});
		</script>
</html>