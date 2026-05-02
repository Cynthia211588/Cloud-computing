<?php
require_once 'db_connection.php';

// 1) read & sanitize the item_id
$itemId = isset($_POST['id']) ? (int)$_POST['id'] : ((int)($_GET['id'] ?? 0));

// 2) fetch the item row
$item = null;
if ($itemId > 0) {
    $sql    = "SELECT * FROM attraction_details WHERE attraction_id = {$itemId}";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $item = mysqli_fetch_assoc($result);
    }
}

// 3) pull counts & totals from the URL
$adultCount    = isset($_POST['adult']) ? (int)$_POST['adult'] : ((int)($_GET['adult'] ?? 0));
$youthCount    = isset($_POST['youth']) ? (int)$_POST['youth'] : ((int)($_GET['youth'] ?? 0));
$childCount    = isset($_POST['child']) ? (int)$_POST['child'] : ((int)($_GET['child'] ?? 0));
$foreignCount  = isset($_POST['foreign']) ? (int)$_POST['foreign'] : ((int)($_GET['foreign'] ?? 0));
$malTotal      = isset($_POST['malaysianTotal']) ? floatval($_POST['malaysianTotal']) : floatval($_GET['malaysianTotal'] ?? 0);
$nonMalTotal   = isset($_POST['nonMalaysianTotal']) ? floatval($_POST['nonMalaysianTotal']) : floatval($_GET['nonMalaysianTotal'] ?? 0);

// pull date/time
 $visitDateRaw = isset($_POST['visitDate']) ? trim($_POST['visitDate']) : trim($_GET['visitDate'] ?? '');

  // optional: pretty‐format them
  $visitDate = $visitDateRaw
    ? date('F j, Y', strtotime($visitDateRaw))
    : '';
?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Not logged in → redirect to login
    header("Location: login.php");
    exit();
}
?>




<!DOCTYPE html>
<html>
<head>
	<title>ExploreMY</title>
	<link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/myStyle.css">
  <style>
  .field-error {
  display: block;
  color: #c00;
  font-size: 0.85em;
  margin-top: 0.25em;
  height: 1em;
  margin-left:25px;
}
</style>
</head>
<body>
	
	<div class="progress-container">
		<div class="step completed">
			<div class="circle">✔</div>
			<span>Choose booking</span>
		</div>

		<div class="line completed"></div>

		<div class="step completed">
			<div class="circle">✔</div>
			<span>Enter info</span>
		</div>

		<div class="line"></div>

		<div class="step active">
			<div class="circle">3</div>
			<span>Payment</span>
		</div>
	</div>

<form id="paymentForm" method="POST" action="process_payment.php">
<div class="container">
  <div class="payment-container">
  <h3>Select a payment method</h3>
  <p class="secure-text">🔒 Payments are secure and encrypted</p>

  <!-- Google Pay -->
  <label class="payment-option">
    <input type="radio" name="payment_method" value="googlepay" required/>
    <div class="option-box">
      <span>Google Pay</span>
      <img src="https://lh3.googleusercontent.com/-HMMzVNh69gL0SsLMReGytn-Wf10oFHBOO05oixe5pKe5762nCu8YGadIHQ2xj5wGW4irBS_eUZ3riQhsl63THzhkMjJYx43mzBa2Z7Wf8NNGT4HicbO=w1200-l80-sg-rj" alt="Google Pay" />
    </div>
  </label>

  <div class="googlepay-info">
    <p style="font-family:Arial, Sans Serif">You will be redirected in a new window to Google Pay to complete payment. </p>
    <p style="font-family:Arial, Sans Serif">
    By continuing, you agree to our <a href="terms_of_service.html">Terms of Service</a> and <a href="privacy_policy.html">Privacy Policy</a>.</p>
    <p style="font-family:Arial, Sans Serif">Note: This is a demo site. No actual payment will be processed.</p>
  </div>

  <!-- Credit/Debit Card -->
  <label class="payment-option">
    <input id="payCard" type="radio" name="payment_method" value="card" required/>
    <div class="option-box card-option">
      <span>Debit or credit card</span>
      <span class="card-icon">💳</span>
    </div>
  </label>

  <div class="card-form">
    <label for="cardNumber">Card number</label>
    <input id="cardNumber" type="text" placeholder="xxxx xxxx xxxx xxxx" />
    <span class="field-error" id="cardNumberError"></span>

    <div class="row">
      <div>
        <label for="expiry">Expiry (MM/YY)</label>
        <input id="expiry" type="text" placeholder="MM/YY" />
        <span class="field-error" id="expiryError"></span>
      </div>
      <div>
        <label for="cvv">CVV</label>
        <input id="cvv" type="password" placeholder="•••" />
        <span class="field-error" id="cvvError"></span>
      </div>
    </div>

    <label for="cardName">Name on card</label>
    <input id="cardName" type="text" placeholder="Card Name" />
    <span class="field-error" id="cardNameError"></span>
  </div>

      <!-- Hidden fields to send booking details -->
    <input type="hidden" name="item_id" value="<?php echo $item['attraction_id']; ?>">
    <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item['attraction_name']); ?>">
    <input type="hidden" name="image" value="<?php echo htmlspecialchars($item['image']); ?>">
    <input type="hidden" name="adult" value="<?php echo $adultCount; ?>">
    <input type="hidden" name="youth" value="<?php echo $youthCount; ?>">
    <input type="hidden" name="child" value="<?php echo $childCount; ?>">
    <input type="hidden" name="foreign" value="<?php echo $foreignCount; ?>">

    <input type="hidden" name="total" value="<?php echo ($malTotal + $nonMalTotal); ?>">
    <input type="hidden" name="visitDate" value="<?php echo $visitDateRaw; ?>">

  <button type="submit">🔒 Pay now</button>
</div>
</form>

  <div id="orderSummaryBox">
	<h2>Order Summary</h2>
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
			<span>RM<?php echo number_format($malTotal + $nonMalTotal, 2); ?><br>
			<small>All taxes and fees included</small></span>
		</div>
	</div>
</div>

<!--Java Script functions-->
<script>
    const cardForm = document.querySelector(".card-form");
    const googlePayInfo = document.querySelector(".googlepay-info");
    const paymentRadios = document.querySelectorAll(
        'input[name="payment_method"]'
    );

    function togglePaymentForms() {
        const selected = document.querySelector(
        'input[name="payment_method"]:checked'
        );

        // Reset both
        cardForm.classList.remove("active");
        googlePayInfo.classList.remove("active");

        // Expand selected
        if (selected) {
        if (selected.value === "card") {
            cardForm.classList.add("active");
        } else if (selected.value === "googlepay") {
            googlePayInfo.classList.add("active");
        }
        }
    }

    // On load → nothing expanded
    togglePaymentForms();

    // On change
    paymentRadios.forEach((radio) =>
        radio.addEventListener("change", togglePaymentForms)
    );

    /**
 * Returns true if the card form is valid or card payment isn't selected.
 */
function validateCardForm() {
  const payByCard = document.getElementById('payCard').checked;

  // If user didn't choose card, skip card validation
  if (!payByCard) return true;

  let isValid = true;

  // Grab elements
  const cardNumber = document.getElementById('cardNumber');
  const expiry     = document.getElementById('expiry');
  const cvv        = document.getElementById('cvv');
  const cardName   = document.getElementById('cardName');

  // Grab error slots
  const errors = {
    cardNumber: document.getElementById('cardNumberError'),
    expiry:     document.getElementById('expiryError'),
    cvv:        document.getElementById('cvvError'),
    cardName:   document.getElementById('cardNameError'),
  };

  // Clear previous errors
  Object.values(errors).forEach(span => span.textContent = '');

  // 1. Card number: 16 digits, allow spaces
  const numClean = cardNumber.value.replace(/\s+/g, '');
  if (!/^\d{16}$/.test(numClean)) {
    errors.cardNumber.textContent = 'Enter a valid 16-digit card number.';
    isValid = false;
  }

  // 2. Expiry: MM/YY and not in the past
  const expVal = expiry.value.trim();
  if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expVal)) {
    errors.expiry.textContent = 'Use MM/YY format.';
    isValid = false;
  } else {
    const [mm, yy] = expVal.split('/').map(Number);
    const now      = new Date();
    const expDate  = new Date(2000 + yy, mm - 1, 1);
    // Move to last day of expiry month
    expDate.setMonth(expDate.getMonth() + 1);
    expDate.setDate(0);
    if (expDate < now) {
      errors.expiry.textContent = 'Card has expired.';
      isValid = false;
    }
  }

  // 3. CVV: 3 digits
  if (!/^\d{3}$/.test(cvv.value.trim())) {
    errors.cvv.textContent = '3-digit security code required.';
    isValid = false;
  }

  // 4. Name: non-empty
  if (cardName.value.trim() === '') {
    errors.cardName.textContent = 'Name on card is required.';
    isValid = false;
  }

  return isValid;
}

document.getElementById('paymentForm').addEventListener('submit', function (e) {
  if (!validateCardForm()) {
    e.preventDefault(); // stop submission if invalid
  }
});

// ---- auto-format card number (4-4-4-4) ----
document.getElementById('cardNumber').addEventListener('input', function () {
  this.value = this.value
    .replace(/\D/g, '')           // remove non-digits
    .replace(/(.{4})/g, '$1 ')    // space every 4 digits
    .trim();
});

</script>

	

	
