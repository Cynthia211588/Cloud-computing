<?php 
session_start();

include 'includes/database_conn.php';
include 'includes/wishlist_logic.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query  = "SELECT * FROM attraction_details WHERE attraction_id = $id";
    $result = mysqli_query($conn, $query);

    $item = mysqli_fetch_assoc($result);
} else {
    $item = null;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ExploreMY</title>
	
	<link rel="stylesheet" href="style/wishlist.css">
	<link rel="stylesheet" href="style/footer.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	<link rel="stylesheet" href="style/myStyle.css">
	<link rel="stylesheet" href="style/detailPageStyle.css">
	<style>
  .error-msg {
  display: block;
  color: #c00;
  padding: 0.5em;
  margin-top: 0.5em;
  border-radius: 4px;
}

</style>
</head>

<body>
	<?php include('includes/header.php'); ?>
	
	<div class="contentWrapper">
	
		<!--First Section: Rendering item name, images and price-->

		<div class="title-wishlist-wrapper">
			<h1><?php echo htmlspecialchars($item['attraction_name']); ?></h1>
			
			<?php renderWishlistButton($conn, $item['attraction_id']); ?>
		</div>
		
		<div class="image-row"> 
			<img src="<?php echo $item['image']; ?>" width="600" height="400"> 
			<img src="<?php echo $item['image2']; ?>" width="350" height="400"> 
			<div class="right-column"> 
				<img src="<?php echo $item['image3']; ?>" width="250" height="200"> 
				<img src="<?php echo $item['image4']; ?>" width="250" height="200"> 
			</div> 
		</div>

		<h2>About this place:</h2>
		<div class="container">
			<p id="descriptionText"><?php echo $item['attraction_description']; ?></p>
			<div id="paymentBox" style="line-height: 1.0;">
				from
				<div id="price-row">
					<h2> RM <?php echo $item['adult_price']; ?></h2>
					<a href="#bookingSectionAnchor">
						<button id="btnCheckAvailability">Check Availability</button>
					</a>
				</div>
				per person
			</div>
		</div>
		
		<!--Second Section: Rendering item description-->
		<br><br>
		<section>
			<h2>What to expect at the <?php echo $item['attraction_name']; ?></h2>
			<p id="expectationText"><?php echo $item['attraction_expectation']; ?></p>
		</section>
		
		<!--Third Section: Rendering item google map-->
		<br><br>
		<section>
			<h2>Location</h2>
			<iframe
				width="1220"
				height="400"
				style="border:0"
				loading="lazy"
				allowfullscreen
				referrerpolicy="no-referrer-when-downgrade"
				src="<?php echo $item['location']; ?>">
			</iframe>
		</section>
		
		<!--Fourth Section: Ticket Booking Section-->
		<div id="bookingSectionAnchor"></div>
		<br><br>
		<section>
			<div id="Box">
				Select participants and date
			</div>
		<div class="bookingSection">
		<div class="left">
			<form action="submitForm.php" method="post">
				<label for="visitDate"><b>Visit Date</b></label>
				<input type="date" id="visitDate" name="visitDate"><br>
		
				<label><b>Nationality</b></label><br>
				<input type="radio" id="malaysian" name="nationality" value="Malaysian" onclick="showMalaysianChoice()" required>
				<label for="malaysian">Malaysian</label>
				<input type="radio" id="non-malaysian" name="nationality" value="Non-Malaysian" onclick="showNonMalaysianChoice()" required>
				<label for="non-malaysian">Non-Malaysian</label><br>
				<br>
			
				<details>
					<summary>Select participants</summary>
					<div id="participationBox">
						<div class="participant-row">
							<p><b class="optionBold" >Adult</b></p>
							<p class="ageDesc">(Age 13-99)</p>
							<div class="quantity-ctrl">
								<button type="button" class="quantity-btn" onclick="changeTicketNumber(this,-1)">-</button>
									<span class="quantity"> 0 </span>
								<button type="button" class="quantity-btn" onclick="changeTicketNumber(this,1)">+</button>
							</div>
						</div>
						<hr>
						<div class="participant-row">
							<p><b class="optionBold" >Youth</b></p>
							<p class="ageDesc">(Age 4-12)</p>
							<div class="quantity-ctrl">
								<button type="button" class="quantity-btn minus" onclick="changeTicketNumber(this,-1)">-</button>
									<span class="quantity"> 0 </span>
								<button type="button" class="quantity-btn plus" onclick="changeTicketNumber(this,1)">+</button>
							</div>
						</div>
						<hr>
						<div class="participant-row">
							<p><b class="optionBold" >Child</b></p>
							<p class="ageDesc">(Age 3 and below)</p>
						<div class="quantity-ctrl">
                            <button type="button" class="quantity-btn minus" onclick="changeTicketNumber(this,-1)">-</button>
                                <span class="quantity"> 0 </span>
							<button type="button" class="quantity-btn plus" onclick="changeTicketNumber(this,1)">+</button>
                        </div>
					</div>
						
					<div class="participant-row">
						<p>Ages 3 and younger do not require a ticket</p>
					</div>
				</div>
					
				<div id="participationBoxForNonMalaysian">
					<div class="participant-row">
						<p> <b class="optionBold">Visitors</b></p>
						<div class="quantity-ctrl">
                            <button type="button" class="quantity-btn minus" onclick="changeTicketNumber(this,-1)">-</button>
                                <span class="quantity"> 0 </span>
							<button type="button" class="quantity-btn plus" onclick="changeTicketNumber(this,1)">+</button>
                        </div>
					</div>
				</div>
						
				<!--Fifth Section: Order summary with "Add to cart" button and "Booking" button-->
				<div class="priceSummaryBox">
							
				</div>
				</details>
			</form>
		</div>
				
		<div class="divider"></div>
		<div class="right">
			<div id="priceSummaryBox">
				<p>Cancel before 4 days advance for a full refund</p>
				<div id="briefSummaryItems"></div>
					<div id="priceTotal"></div>
					<p>Malaysian Total: RM <span id="malaysianTotal">0</span></p>
					<p>Non-Malaysian Total: RM <span id="nonMalaysianTotal">0</span></p>
				</div>
		
				<button type="button" onclick="saveTotalsAndProceed()">Continue to Checkout</button>
				<div id="checkoutError" class="error-msg" role="alert" aria-live="assertive"></div>
			</div>
		</div>
	</section>

<!--Java Script functions-->
<script>
		function showMalaysianChoice(){
			document.getElementById("participationBox").style.display = "block";
			document.getElementById("participationBoxForNonMalaysian").style.display = "none";
			resetNonMalaysianSelection();
		}
		
		function showNonMalaysianChoice(){
			document.getElementById("participationBoxForNonMalaysian").style.display = "block";
			document.getElementById("participationBox").style.display = "none";
			resetMalaysianSelection();
		}
		
		function changeTicketNumber(button, delta){
			const quantitySpan = button.parentNode.querySelector(".quantity");
			let currentValue = parseInt(quantitySpan.textContent.trim());
			let newValue = currentValue + delta;
			if (newValue < 1) 
				newValue = 0;
			quantitySpan.textContent = newValue;
			
			totalPriceForEachVisitorType(button.closest(".participant-row"), newValue);
			calculateMalaysianTotal();
			calculateNonMalaysianTotal();
		}
		
		function totalPriceForEachVisitorType(row, newValue){
			const visitorTypeElement = row.querySelector(".optionBold");
			if (!visitorTypeElement) return 0.0;

			const visitorType = visitorTypeElement.textContent.trim();
			 const adult_price = <?= json_encode($item['adult_price']) ?>;
    const youth_price = <?= json_encode($item['youth_price']) ?>;
    const foreign_price = <?= json_encode($item['foreign_price']) ?>;
			let totalPrice =0.0;
			
			 if (visitorType === "Adult") {
        return adult_price * newValue;
    }
    if (visitorType === "Youth") {
        return youth_price * newValue;
    }
    if (visitorType === "Child") {
        return 0.0; // explicitly free
    }
    if (visitorType === "Visitors") {
        return foreign_price * newValue;
    }

    return 0.0;
		}
		
		
		function calculateMalaysianTotal(){
			let total = 0;
			const rows = document.querySelectorAll("#participationBox .participant-row");
    
			rows.forEach(row => {
				const visitorTypeElement = row.querySelector(".optionBold");
				if (visitorTypeElement) {
					const visitorType = visitorTypeElement.textContent.trim();
					const quantity = parseInt(row.querySelector(".quantity").textContent.trim());
					total += totalPriceForEachVisitorType(row, quantity);
				}
			});

			document.getElementById("malaysianTotal").textContent = total.toFixed(2);
			return total;
		}
		
		function calculateNonMalaysianTotal(){
			let total = 0;
			const rows = document.querySelectorAll("#participationBoxForNonMalaysian .participant-row");
			
			rows.forEach(row=>{
				const quantity = parseInt(row.querySelector(".quantity").textContent.trim());
				total += totalPriceForEachVisitorType (row,quantity);
			});
			
			document.getElementById("nonMalaysianTotal").textContent = total.toFixed(2);
			return total;
			
		}
		
		// Reset function for Malaysian
		function resetMalaysianSelection() {
			const rows = document.querySelectorAll("#participationBox .participant-row .quantity");
			rows.forEach(qty => qty.textContent = "0"); // reset quantity
			document.getElementById("malaysianTotal").textContent = "0";
		}

		// Reset function for Non-Malaysian
		function resetNonMalaysianSelection() {
			const rows = document.querySelectorAll("#participationBoxForNonMalaysian .participant-row .quantity");
			rows.forEach(qty => qty.textContent = "0"); // reset quantity
			document.getElementById("nonMalaysianTotal").textContent = "0";
		}
		
		//to remember the choice and the toal summary when load into the checkout page (checkout.php)
		function saveTotalsAndProceed() {
			const rows = document.querySelectorAll('#participationBox .participant-row');
			const adultCount  = parseInt(rows[0].querySelector('.quantity').textContent);
			const youthCount  = parseInt(rows[1].querySelector('.quantity').textContent);
			const childCount  = parseInt(rows[2].querySelector('.quantity').textContent);

			const foreignCount = parseInt(document.querySelector('#participationBoxForNonMalaysian .participant-row .quantity').textContent);
			const malTotal     = calculateMalaysianTotal();
			const nonMalTotal  = calculateNonMalaysianTotal();

			const visitDate = document.getElementById('visitDate').value;  
			const errorBox     = document.getElementById('checkoutError');

			// 1. Compute total participants across both categories
			const totalParticipants = adultCount + youthCount + childCount + foreignCount;

			// 2. If none selected, show error and stop
			if (totalParticipants === 0) {
				console.log('showing error in element:', errorBox);
				errorBox.textContent = 'Please select at least one participant to continue.';
				return;
			}

			// 3. Clear any previous error and proceed
			errorBox.textContent = '';

			const params = new URLSearchParams({
				adult: adultCount,
				youth: youthCount,
				child: childCount,
				foreign: foreignCount,
				malaysianTotal: malTotal.toFixed(2),
				nonMalaysianTotal: nonMalTotal.toFixed(2),
				visitDate: visitDate,
				id: <?= json_encode($item['attraction_id']) ?>
			});

  			window.location.href = 'checkout.php?' + params.toString();
		}


		document.addEventListener('click', function(e) {
		// Check if a wishlist button was clicked
		if (e.target.matches('.wishlist-toggle-btn')) {
			const button = e.target;
			const itemId = button.dataset.itemId;

			// Send the request to the server in the background
			fetch('wishlist_handler.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ item_id: itemId })
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Update the button's appearance based on the response
					if (data.in_wishlist) {
						button.classList.remove('btn-primary');
						button.classList.add('btn-danger');
						button.innerHTML = '<i class="fas fa-heart"></i> In Wishlist';
					} else {
						button.classList.remove('btn-danger');
						button.classList.add('btn-primary');
						button.innerHTML = '<i class="far fa-heart"></i> Add to Wishlist';
					}
				} else {
					alert(data.message); // Show error message
				}
			});
		}
	});
		
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
		<!--this is to make sure header not overlap with content-->
		<script>
			document.addEventListener("DOMContentLoaded", () => {
				const header = document.querySelector(".site-header");
				if (header) {
						document.body.style.paddingTop = header.offsetHeight + "px";
				}
			});
		</script>
	</div>
</body>
<?php include('includes/footer.php'); ?>
</html>