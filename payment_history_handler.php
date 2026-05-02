<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $paymentId = intval($_POST['payment_id']);

    if ($paymentId > 0) {
        $sql = "DELETE FROM payment_history WHERE id = ? AND user_id = ?"; 
        // ✅ use "id" if that’s your column name in payment_history
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $paymentId, $userId);

        if ($stmt->execute()) {
            header("Location: payment_history.php?msg=deleted");
        } else {
            header("Location: payment_history.php?msg=error");
        }
        exit();
    }
}

// fallback
header("Location: payment_history.php");
exit();
