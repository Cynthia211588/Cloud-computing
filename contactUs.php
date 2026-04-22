<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    $errors = [];
    $response = ["success" => false, "errors" => []];

    // trim inputs
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // checkbox: must not be empty
    $not_Robot = !empty($_POST["not_Robot"]);

    // validation
    if (empty($name)) {
        $errors['name'] = "Name is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email";
    } elseif (!str_ends_with(strtolower($email), "@gmail.com")) {
        $errors['email'] = "Only Gmail addresses are allowed";
    }

    if (empty($message)) {
        $errors['message'] = "Message is required";
    }
    if (!$not_Robot) {
        $errors['not_Robot'] = "Please confirm you are not a robot.";
    }

    if (empty($errors)) {
        $response["success"] = true;
    } else {
        $response["errors"] = $errors;
    }

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/contactUs.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<?php include('includes/header.php'); ?>

<div class="container py-5">
    <h1 class="mb-4 text-center">Contact Us</h1>

    <!-- Map -->
    <div class="mb-4">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d79691.704!2d101.6869!3d3.139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc362774e23b%3A0xd62b9c9aa0e8b93b!2sKuala%20Lumpur%2C%20Malaysia!5e0!3m2!1sen!2smy!4v1690000000000"
            width="100%" height="300" style="border:0;" allowfullscreen loading="lazy"></iframe>
    </div>

    <!-- Contact Info -->
    <div class="row mb-5">
        <div class="col-md-4">
            <h5>Our Address</h5>
            <p>ExploreMy HQ<br>Jalan Bukit Bintang<br>55100 Kuala Lumpur, Malaysia</p>
        </div>
        <div class="col-md-4">
            <h5>Email Us</h5>
            <p><a href="mailto:info@exploremy.com">info@exploremy.com</a></p>
        </div>
        <div class="col-md-4">
            <h5>Call Us</h5>
            <p><a href="tel:+60312345678">+60 3-1234 5678</a></p>
        </div>
    </div>

    <!-- Enquiry Form -->
    <div class="card shadow p-4">
        <h5>Send Us Your Enquiry</h5>

        <div id="formAlert" class="mb-3"></div>

        <form id="contactForm" method="POST" action="" novalidate>
        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" aria-describedby="error-name">
            <small class="text-danger d-none" id="error-name" aria-live="polite"></small>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control" aria-describedby="error-email">
            <small class="text-danger d-none" id="error-email" aria-live="polite"></small>
        </div>

        <!-- Message -->
        <div class="mb-3">
            <label class="form-label">Message <span class="text-danger">*</span></label>
            <textarea id="message" name="message" rows="5" class="form-control" aria-describedby="error-message"></textarea>
            <small class="text-danger d-none" id="error-message" aria-live="polite"></small>
        </div>

        <!-- validate not robot -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="not_robot" name="not_Robot" value="1">
            <label class="form-check-label" for="not_robot">I'm not a robot <span class="text-danger">*</span></label>
            <small class="text-danger d-none" id="error-not_Robot" aria-live="polite"></small>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">
            <span id="btnText">Send Enquiry</span>
            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function(){
    // Elements
    const form = document.getElementById("contactForm");
    const submitBtn = document.getElementById("submitBtn");
    const btnText = document.getElementById("btnText");
    const btnSpinner = document.getElementById("btnSpinner");
    const formAlert = document.getElementById("formAlert");

    // Input elements
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const messageInput = document.getElementById("message");
    const notRobotInput = document.getElementById("not_robot");

    // Helper to get input element by field key
    function getInputEl(fieldKey) {
        switch(fieldKey) {
            case "name": return nameInput;
            case "email": return emailInput;
            case "message": return messageInput;
            case "not_Robot": return notRobotInput;
            default: return null;
        }
    }

    // Show error message for a field
    function showError(fieldKey, message) {
        const errEl = document.getElementById("error-" + fieldKey);
        if (!errEl) return;
        errEl.textContent = message;            // set error message
        errEl.classList.remove("d-none");       // make it visible
        const inputEl = getInputEl(fieldKey);
        if (inputEl && inputEl.classList) inputEl.classList.add("is-invalid");
    }

    // Clear error message for a field
    function clearError(fieldKey) {
        const errEl = document.getElementById("error-" + fieldKey);
        if (!errEl) return;
        errEl.textContent = "";       // clear error message
        errEl.classList.add("d-none");  // hide it
        const inputEl = getInputEl(fieldKey);
        if (inputEl && inputEl.classList) inputEl.classList.remove("is-invalid");
    }

    // Clear all errors
    function clearAllErrors() {
        ["name","email","message","not_Robot"].forEach(k => clearError(k));
    }

    // Validate email format
    function isEmailFormatValid(v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    // Validate a specific field
    function validateField(fieldKey) {
        const valEl = getInputEl(fieldKey);
        const val = valEl ? (valEl.type === "checkbox" ? valEl.checked : (valEl.value || "").trim()) : "";

        // name
        if (fieldKey === "name") {
            if (!val) { 
                showError("name", "Name is required"); 
                return false; 
            }
                clearError("name"); return true;
        }

        // email
        if (fieldKey === "email") {
            if (!val) { 
                showError("email", "Email is required");
                return false; 
            }
            if (!isEmailFormatValid(val)) { 
                showError("email", "Invalid email"); 
                return false; 
            }
            if (!val.toLowerCase().endsWith("@gmail.com")) { 
                showError("email", "Only Gmail addresses are allowed"); 
                return false;                 
            }
            clearError("email"); 
            return true;
        }

        // message
        if (fieldKey === "message") {
            if (!val) { 
                showError("message", "Message is required"); 
                return false; 
            }
            clearError("message"); 
            return true;
        }

        // not_Robot
        if (fieldKey === "not_Robot") {
            if (!val) { 
                showError("not_Robot", "Please confirm you are not a robot."); 
                return false; 
            }
            clearError("not_Robot"); 
            return true;
        }

        return true;
    }

    // Real-time validation
    nameInput.addEventListener("input", () => validateField("name"));
    emailInput.addEventListener("input", () => validateField("email"));
    messageInput.addEventListener("input", () => validateField("message"));
    notRobotInput.addEventListener("change", () => validateField("not_Robot"));

    // Form submission
    form.addEventListener("submit", function(e){
        e.preventDefault();
        formAlert.innerHTML = "";

        clearAllErrors();
        const vName = validateField("name");
        const vEmail = validateField("email");
        const vMessage = validateField("message");
        const vNotRobot = validateField("not_Robot");

        if (!(vName && vEmail && vMessage && vNotRobot)) {
            const firstInvalid = form.querySelector(".is-invalid");
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        let formData = new FormData(form);
        formData.append("ajax", "1"); // indicate AJAX submission

        fetch("", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {                   // handle JSON response
            if (data.success) {
                formAlert.innerHTML = `<div class="alert alert-success">Form submitted successfully!</div>`;
                form.reset();
                clearAllErrors();

                btnText.textContent = "Send Enquiry";
                btnSpinner.classList.add("d-none");
                submitBtn.disabled = false;
            } else {
                ["name","email","message","not_Robot"].forEach(k => clearError(k));
                for (let field in data.errors) {
                    showError(field, data.errors[field]);
                }
                const firstErr = form.querySelector(".is-invalid");
                if (firstErr) firstErr.focus();

                btnText.textContent = "Send Enquiry";
                btnSpinner.classList.add("d-none");
                submitBtn.disabled = false;
            }
        })
        .catch(err => {
        console.error(err);
        formAlert.innerHTML = `<div class="alert alert-danger">Something went wrong. Try again later.</div>`;
        btnText.textContent = "Send Enquiry";
        btnSpinner.classList.add("d-none");
        submitBtn.disabled = false;
        });
  });

})();
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".site-header");
  if (header) {
    document.body.style.paddingTop = header.offsetHeight + "px";
  }
});
</script>

</body>

<?php include('includes/footer.php'); ?>
</html>
