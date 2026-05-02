<?php
session_start(); // Start session at the top

// Initialize message variable
$message = "";

// Process form if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../db_connection.php';

    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $phoneCode = isset($_POST['phoneCode']) ? $_POST['phoneCode'] : '';
    $country = $_POST['country'];
    
    // Combine phone code and phone number
    $fullPhone = $phoneCode . $phone;
    
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM user_profile WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        $message = "<h2 style='color:red; text-align:center;'>Error: Email already exists!</h2>";
        $message .= "<p style='text-align:center;'><a href='login.php'>Go to Login</a></p>";
    } else {
        // Insert using prepared statement
        $stmt = $conn->prepare("INSERT INTO user_profile 
            (first_name, last_name, email, phone, password, country) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $fullPhone, $hashedPassword, $country);

        if ($stmt->execute()) {
            // Set session variables after successful registration
            $_SESSION['user_email'] = $email;
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;
            $_SESSION['user_id'] = $conn->insert_id;
            
            $message = "<h2 style='color:green; text-align:center;'>Registration Successful!</h2>";
            $message .= "<p style='text-align:center;'>Welcome, " . htmlspecialchars($firstName) . "!</p>";
            $message .= "<p style='text-align:center;'><a href='../index.php'>Go to Home</a></p>";

            $message .= "<script>setTimeout(function(){ window.location.href = '../index.php'; }, 10000);</script>";
        } else {
            $message = "<h2 style='color:red; text-align:center;'>Error: Could not register. " . $stmt->error . "</h2>";
        }
        $stmt->close();
    }
    
    $checkEmail->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device=width, initial-scale=1.0">
    <title>Create a New Account</title>
	<!-- Bootstrap CSS (Required for header dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome (Required for header icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/userStyle.css">
	<link rel="stylesheet" href="../style/header.css">
</head>

<body>
    
	<?php include('../includes/auth_header.php'); ?>

    <div class="account-container">
		<?php if (!empty($message)): ?>
        <div class="registration-message" style="padding: 20px; margin: 20px;">
            <?php echo $message; ?>
        </div>
		<?php endif; ?>
        <div class="account-header">
            <h1 class="signup-title">Create a New Account</h1>
            <p class="signup-subtitle">Start your journey with us</p>
        </div>
            
        <form class="signup-form" id="signupForm" action="signup.php" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" required>
                    <div class="error" id="firstNameError"></div>
                </div>
                
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required>
                    <div class="error" id="lastNameError"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="emailError"></div>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <div class="phone-container">
                    <select id="phoneCode" name="phoneCode" required>
                        <option value="">--Code--</option>
                        <option value="+60">Malaysia (+60)</option>
                        <option value="+65">Singapore (+65)</option>
                        <option value="+66">Thailand (+66)</option>
                        <option value="+1">United States / Canada (+1)</option>
                        <option value="+44">United Kingdom (+44)</option>
                        <option value="+61">Australia (+61)</option>
                        <option value="+81">Japan (+81)</option>
                        <option value="+86">China (+86)</option>
                        <option value="+82">South Korea (+82)</option>
                        <option value="+84">Vietnam (+84)</option>
                        <option value="+62">Indonesia (+62)</option>
                        <option value="+63">Philippines (+63)</option>
                    </select>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="error" id="phoneError"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="error" id="passwordError"></div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <div class="error" id="confirmPasswordError"></div>
            </div>
                
            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="">--Country--</option>
                    <option value="MY">Malaysia</option>
                    <option value="SG">Singapore</option>
                    <option value="TH">Thailand</option>
                    <option value="US">United States</option>
                    <option value="GB">United Kingdom</option>
                    <option value="AU">Australia</option>
                    <option value="JP">Japan</option>
                    <option value="CN">China</option>
                    <option value="KR">South Korea</option>
                    <option value="VN">Vietnam</option>
                    <option value="ID">Indonesia</option>
                    <option value="PH">Philippines</option>
                </select>
                <div class="error" id="countryError"></div>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    I agree to the <a href="../terms_of_service.html" >Terms of Service</a>
                    and <a href="../privacy_policy.html">Privacy Policy</a>
                </label>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="newsletter" name="newsletter">
                <label for="newsletter">
                    Send me travel deals and updates via email
                </label>
            </div>
            
            <button type="submit" class="signup-btn">Create Account</button>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <div class="social-signup">
                <a href="google-signup.php" class="social-btn">
                    <i class="fab fa-google"></i>
                    Google
                </a>
                <a href="facebook-signup.php" class="social-btn">
                    <i class="fab fa-facebook"></i>
                    Facebook
                </a>
            </div>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <script>
        function validateForm(){
            // Clear previous errors
            document.getElementById("firstNameError").innerText = "";
            document.getElementById("lastNameError").innerText = "";
            document.getElementById("emailError").innerText = "";
            document.getElementById("phoneError").innerText = "";
            document.getElementById("passwordError").innerText = "";
            document.getElementById("confirmPasswordError").innerText = "";
            document.getElementById("countryError").innerText = "";

            let isValid = true;

            // First name validation
            let firstName = document.getElementById("firstName").value.trim();
            if(firstName === ""){
                document.getElementById("firstNameError").innerText = "Please enter your first name";
                isValid = false;
            }

            // Last name validation
            let lastName = document.getElementById("lastName").value.trim();
            if(lastName === ""){
                document.getElementById("lastNameError").innerText = "Please enter your last name";
                isValid = false;
            }

            // Email validation
            let email = document.getElementById("email").value.trim();
            if(email === ""){
                document.getElementById("emailError").innerText = "Please enter your email address";
                isValid = false;
            } else {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(!emailRegex.test(email)){
                    document.getElementById("emailError").innerText = "Please enter a valid email address";
                    isValid = false;
                }
            }
            
            // Phone validation
            let phoneCode = document.getElementById("phoneCode").value;
            if(phoneCode === ""){
                document.getElementById("phoneError").innerText = "Please select a phone code";
                isValid = false;
            }

            let phone = document.getElementById("phone").value.trim();
            if(phone === ""){
                document.getElementById("phoneError").innerText = "Please enter your phone number";
                isValid = false;
            }
            
            // Password validation
            let password = document.getElementById("password").value;
            if(password === ""){
                document.getElementById("passwordError").innerText = "Password cannot be empty";
                isValid = false;
            } else if(password.length < 8){
                document.getElementById("passwordError").innerText = "Password must be at least 8 characters";
                isValid = false;
            }
            
            // Confirm password validation
            let confirmPassword = document.getElementById("confirmPassword").value;
            if(confirmPassword === ""){
                document.getElementById("confirmPasswordError").innerText = "Please confirm your password";
                isValid = false;
            } else if(confirmPassword !== password){
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match";
                isValid = false;
            }
                    
            // Country validation
            let country = document.getElementById("country").value;
            if(country === ""){
                document.getElementById("countryError").innerText = "Please select a country";
                isValid = false;
            }

            // Terms checkbox validation
            let terms = document.getElementById("terms").checked;
            if(!terms){
                alert("Please agree to the Terms of Service and Privacy Policy");
                isValid = false;
            }
            
            return isValid;
        }
    </script>
    <!--this is to make sure header not overlap with content-->
	<script>
		document.addEventListener("DOMContentLoaded", () => {
			const header = document.querySelector(".site-header");
			if (header) {
					document.body.style.paddingTop = header.offsetHeight + "px";
			}
		});
	</script>
</body>
</html>