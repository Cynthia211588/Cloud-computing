<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}


require_once 'db_connection.php';


$wishlist_items = []; 


$user_id = $_SESSION['user_id']; 


$sql = "SELECT 
            d.attraction_id, 
            d.attraction_name, 
            d.adult_price, 
            d.image,
            w.id AS wishlist_id,
            w.added_date
        FROM wishlist AS w
        JOIN attraction_details AS d ON w.item_id = d.attraction_id 
        WHERE w.user_id = ?"; 
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $wishlist_items = $result->fetch_all(MYSQLI_ASSOC);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - ExploreMy</title>
    <link rel="stylesheet" href="style/header.css">
	<link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/wishlist.css">
	<link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/footer.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1><i class="fas fa-heart"></i> My Wishlist</h1>
            <p>Your saved destinations for future adventures.</p>
        </div>

        <?php if (empty($wishlist_items)): ?>
            <div class="empty-wishlist">
                <h3>Your wishlist is empty</h3>
                <p>Start adding items you love!</p>
                <a href="index.php" class="btn btn-primary">Browse Destinations</a>
            </div>
        <?php else: ?>
            <?php foreach ($wishlist_items as $item): ?>
                <div class="wishlist-item">
                    <div class="item-row">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['attraction_name']); ?>">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name"><?php echo htmlspecialchars($item['attraction_name']); ?></h3>
                            <div class="item-price">
                                <span class="current-price">From RM <?php echo number_format($item['adult_price'], 2); ?></span>
                            </div>
                        </div>
                        <div class="item-actions">
                            <a href="item_detail.php?id=<?php echo $item['attraction_id']; ?>" class="btn btn-outline-primary">View</a>
                            <form action="wishlist_handler.php" method="POST">
								<input type="hidden" name="action" value="remove">
								<input type="hidden" name="wishlist_id" value="<?php echo $item['wishlist_id']; ?>">
								<button type="submit" class="btn btn-danger">
									<i class="fas fa-trash"></i> Remove
								</button>
							</form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
