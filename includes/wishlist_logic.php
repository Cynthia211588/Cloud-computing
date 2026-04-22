<?php

function isInWishlist($conn, $user_id, $destination_id) {
    $stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND item_id = ?");
    $stmt->bind_param("ii", $user_id, $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}

function renderWishlistButton($conn, $item_id) {
    if (!isset($_SESSION['user_id'])) {
        echo '<a href="user/login.php" class="wishlist-link">
                <i class="far fa-heart"></i> <u>Add to Wishlist</u>
              </a>';
        return;
    }

    $is_in_wishlist = isInWishlist($conn, $_SESSION['user_id'], $item_id);

    if ($is_in_wishlist) {
        echo '<form action="wishlist_handler.php" method="POST" class="wishlist-form">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="item_id" value="' . $item_id . '">
                <button type="submit" class="wishlist-link in-wishlist">
                    <i class="fas fa-heart"></i> <u>In Wishlist</u>
                </button>
              </form>';
    } else {
        echo '<form action="wishlist_handler.php" method="POST" class="wishlist-form">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_id" value="' . $item_id . '">
                <button type="submit" class="wishlist-link">
                    <i class="far fa-heart"></i> <u>Add to Wishlist</u>
                </button>
              </form>';
    }
}
?>