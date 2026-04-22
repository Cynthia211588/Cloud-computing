
<?php
session_start();
include 'includes/database_conn.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Collect POST data (sanitize if needed)
$userId   = $_SESSION['user_id'];
$email    = $_SESSION['user_email'];
$itemId   = (int)($_POST['item_id'] ?? 0); // changed to match form and DB
$itemName = $_POST['item_name'] ?? '';
$image = $_POST['image'] ?? '';
$adult    = (int)($_POST['adult'] ?? 0);
$youth    = (int)($_POST['youth'] ?? 0);
$child    = (int)($_POST['child'] ?? 0);
$foreign  = (int)($_POST['foreign'] ?? 0);
$total    = (float)($_POST['total'] ?? 0.00);
$method   = $_POST['payment_method'] ?? 'unknown';
$visitDate = $_POST['visitDate'] ?? null;

// Format visitDate to YYYY-MM-DD if not empty
if ($visitDate) {
    $visitDate = date('Y-m-d', strtotime($visitDate));
} else {
    $visitDate = null;
}

// Insert into Payment_History
$stmt = $conn->prepare("INSERT INTO Payment_History 
(user_id, email, purchasedItem_id, purchasedItem_name, visit_date, adult_count, youth_count, child_count, foreign_count, image, total_amount, payment_method) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "isissiiiisds", 
    $userId, $email, $itemId, $itemName, $visitDate,
    $adult, $youth, $child, $foreign, $image, $total, $method
);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Success → Redirect to success page
    header("Location: success.php?id=$itemId&adult=$adult&youth=$youth&child=$child&foreign=$foreign&total=$total&visitDate=$visitDate&image=" . urlencode($image));
} else {
    echo "Payment failed. Try again.";
}
?>