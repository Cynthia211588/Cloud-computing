<?php
session_start();
include 'includes/database_conn.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $item_id = $_POST['item_id'] ?? 0;

    if ($item_id > 0) {
        $stmt_check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND item_id = ?");
        $stmt_check->bind_param("ii", $user_id, $item_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows === 0) {
            $stmt_insert = $conn->prepare("INSERT INTO wishlist (user_id, item_id) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $user_id, $item_id);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    header('Location: item_detail.php?id=' . $item_id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $wishlist_id = $_POST['wishlist_id'] ?? 0;

    if ($wishlist_id > 0) {
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $wishlist_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: wishlist.php');
    exit();
}

$conn->close();
header('Location: index.php');
exit();
?>