<?php
session_start();
include 'includes/database_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM payment_history WHERE user_id = ? ORDER BY payment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payment History - ExploreMy</title>
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/wishlist.css"> <!-- Reuse wishlist styles -->
    <link rel="stylesheet" href="style/footer.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 70px 20px 20px; /* adjusted padding so header won't overlap */
        }

        .payment-header {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 20px;
            padding: 40px 0;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            border-radius: 15px;
        }

        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            display:flex;
            align-items: center;
            justify-content: space-between;
            gap:20px;
        }

        .payment-content {
            flex: 1; /* left side grows */
        }

        .payment-image {
            width: 200px;       /* adjust size as needed */
            height: 150px;
            border-radius: 10px;
            object-fit: cover;  /* keeps aspect ratio */
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .payment-card h4 {
            margin-bottom: 15px;
            color: #333;
        }

        .payment-details {
            font-size: 0.95rem;
            color: #555;
        }

        .payment-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 10px;
        }

        .empty-history {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .empty-history i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .payment-actions {
            min-width: 150px;
        }
        .payment-actions .btn {
            width: 100%;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <div class="payment-container">
        <div class="payment-header">
            <h1><i class="fas fa-receipt"></i> My Payment History</h1>
            <p>Track your purchases and payment details here.</p>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <div class="empty-history">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>No payment history found</h3>
                <p>Start exploring and booking your next adventure!</p>
                <a href="index.php" class="btn btn-primary">Browse Destinations</a>
            </div>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
    <div class="payment-card">
        <!-- LEFT SIDE: Image -->
        <?php if (!empty($row['image'])): ?>
            <div class="payment-image-wrapper">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                     alt="Purchased Item" class="payment-image">
            </div>
        <?php endif; ?>

        <!-- CENTER: Payment Details -->
        <div class="payment-content">
            <h4><?php echo htmlspecialchars($row['purchasedItem_name']); ?></h4>
            <div class="payment-details">
                <p><strong>Date:</strong> <?php echo htmlspecialchars($row['visit_date']); ?></p>
                <p><strong>Counts:</strong><br>
                    <?php
                    $categories = [
                        "Adults" => $row['adult_count'],
                        "Youth"  => $row['youth_count'],
                        "Child"  => $row['child_count'],
                        "Foreign"=> $row['foreign_count']
                    ];
                    foreach ($categories as $label => $count) {
                        if ($count > 0) {
                            echo htmlspecialchars($label) . ": " . intval($count) . "<br>";
                        }
                    }
                    ?>
                </p>
                <p><strong>Method:</strong> <?php echo htmlspecialchars($row['payment_method']); ?></p>
                <p class="payment-total">Total: RM<?php echo number_format($row['total_amount'], 2); ?></p>
            </div>
        </div>

        <!-- RIGHT SIDE: Actions -->
        <div class="payment-actions d-flex flex-column gap-2">
            <a href="item_detail.php?id=<?php echo $row['purchasedItem_id']; ?>" 
               class="btn btn-outline-primary">
                <i class="fas fa-redo"></i> Book Again
            </a>
            <form action="payment_history_handler.php" method="POST" onsubmit="return confirm('Delete this record?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
<?php endwhile; ?>

        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
