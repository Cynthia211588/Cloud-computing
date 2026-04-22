<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: user/login.php");
    exit();
}

require_once 'db_connection.php';

$message = "";
$error = "";
$user_email = $_SESSION['user_email']; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];

    $stmt = $conn->prepare("UPDATE user_profile SET first_name = ?, last_name = ?, phone = ?, country = ? WHERE email = ?");
    $stmt->bind_param("sssss", $firstName, $lastName, $phone, $country, $user_email);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['user_name'] = $firstName;
    } else {
        $error = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}

// ACCOUNT DELETION HANDLING
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM user_profile WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    if ($stmt->execute()) {
        session_destroy();
        header("Location: index.php?deleted=1");
        exit();
    } else {
        $error = "Failed to delete account.";
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM user_profile WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if (!$user) {
    die("Error: Could not find user data.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - ExploreMy</title>
    
	<link rel="stylesheet" href="style/header.css">
	<link rel="stylesheet" href="style/account.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
   
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div class="edit-profile-container">
        <h2><i class="fa fa-user-edit"></i> Edit Profile</h2>
        
        <?php if (!empty($message)): ?>
            <div class="success-message">
                <i class="fa fa-check-circle"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form class="edit-profile" id="editProfile" action="account.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                <small style="color: #666; font-size: 12px;">Email cannot be changed</small>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="">--Select Country--</option>
                    <option value="MY" <?php echo ($user['country'] == 'MY') ? 'selected' : ''; ?>>Malaysia</option>
                    <option value="SG" <?php echo ($user['country'] == 'SG') ? 'selected' : ''; ?>>Singapore</option>
                    <option value="TH" <?php echo ($user['country'] == 'TH') ? 'selected' : ''; ?>>Thailand</option>
                    <option value="US" <?php echo ($user['country'] == 'US') ? 'selected' : ''; ?>>United States</option>
                    <option value="CA" <?php echo ($user['country'] == 'CA') ? 'selected' : ''; ?>>Canada</option>
                    <option value="GB" <?php echo ($user['country'] == 'GB') ? 'selected' : ''; ?>>United Kingdom</option>
                    <option value="AU" <?php echo ($user['country'] == 'AU') ? 'selected' : ''; ?>>Australia</option>
                </select>
            </div>

            <input type="submit" name="update" value="Update Profile">
        </form>
        
        <hr>
        
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <button type="submit" name="delete" class="delete-btn">
                <i class="fa fa-trash"></i> Delete Account
            </button>
        </form>

        <div class="back-link">
            <a href="index.php">
                <i class="fa fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	
</body>
</html>