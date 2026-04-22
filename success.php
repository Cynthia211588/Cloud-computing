<?php
include 'includes/database_conn.php'; // connect to DB

// 1) read & sanitize the item_id
$itemId = (int)($_GET['id'] ?? 0);

// 2) fetch the item row
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query  = "SELECT * FROM attraction_details WHERE attraction_id = $id";
    $result = mysqli_query($conn, $query);

    $item = mysqli_fetch_assoc($result);
} else {
    $item = null;
}

// 3) pull counts & totals from the URL
$adultCount    = (int)($_GET['adult']             ?? 0);
$youthCount    = (int)($_GET['youth']             ?? 0);
$childCount    = (int)($_GET['child']             ?? 0);
$foreignCount  = (int)($_GET['foreign']           ?? 0);
$total = floatval($_GET['total'] ?? 0);
$image = $_GET['image'] ?? ($item['image'] ?? '');

// pull date/time
  $visitDateRaw = trim($_GET['visitDate'] ?? '');

  // optional: pretty‐format them
  $visitDate = $visitDateRaw
    ? date('F j, Y', strtotime($visitDateRaw))
    : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Explore MY</title>
  <link rel="stylesheet" href="style/myStyle.css">
</head>
<body>
  <div class="success-container">
    <h1>Payment Successful</h1>
    <p>Thank you for your order!</p>
    <p>A confirmation has been generated for demo purposes.</p>

	<div id="summaryCard">
		<div id="summaryCardHeader">
			<?php if ($item): ?>
    			<img src="<?php echo htmlspecialchars($item['image']); ?>">
    			<div class="info">
        			<h3><?php echo htmlspecialchars($item['attraction_name']); ?></h3>
   				 </div>
			<?php else: ?>
    			<p>Item not found.</p>
			<?php endif; ?>
		</div>

		<?php
			$participants = [
			'Adults'    => ['count'=>$adultCount,   'price'=>$item['adult_price']],
			'Youths'    => ['count'=>$youthCount,   'price'=>$item['youth_price']],
			'Children'  => ['count'=>$childCount,   'price'=>0.00],
			'Foreigners'=> ['count'=>$foreignCount, 'price'=>$item['foreign_price']],
			];
		?>
		<div id="summaryCardBody">
			<?php foreach ($participants as $label => $data): ?>
    		<?php if ($data['count'] > 0): ?>
      		<p>👥
        		<?php echo $label; ?>: 
       			<?php echo $data['count']; ?> 
       			× RM <?php echo number_format($data['price'], 2); ?>
      		</p>
    		<?php endif; ?>
  			<?php endforeach; ?>

			<?php if ($visitDate): ?>
  			<p>📅Visit Date: <?php echo htmlspecialchars($visitDate); ?></p>
			<?php endif; ?>
				

		<div id="summaryCardFooter"></div>

		<div class="total">	
			<span>Total</span>
			<span>RM<?php echo number_format($total, 2); ?><br>
		</div>
	</div>
</div>

    <button class="btn-home" onclick="window.location.href='index.php'">
      Back to Home
    </button>
  </div>
</body>
</html>
