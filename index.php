<?php

require_once 'db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Travel Itinerary Booking</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/css/home.css">
  <link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php'); ?>

<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center" style="background-image: url('https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/homeImages/hero-travel.jpg');">
  <div>
    <h1>ExploreMy.</h1>
    <p>Find your perfect trip with us</p>

    <!-- Search Box -->
    <div class="search-box mt-4">
      <form id="stateForm" class="row g-2" method="get" action="/listingPage/itemListing.php">
        <div class="col-md-9 position-relative">
          <input type="text" id="stateSearch" name="state" class="form-control" placeholder="Search by state...">
          <div class="suggestions" id="stateSuggestions"></div>
        </div>
        <div class="col-md-3 d-grid">
          <button type="submit" class="btn btn-warning">Search</button>
        </div>
      </form>
    </div>

  </div>
</section>



<!-- ===================== Popular Destinations ===================== -->
<section class="popular-destinations py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Popular Destinations</h2>

    <div class="carousel-container position-relative">
      <div class="carousel-wrapper" id="carouselWrapper">
        <?php
          $sql = "SELECT attraction_id, attraction_name, attraction_description, adult_price, image2 
                  FROM attraction_details
                  ORDER BY attraction_id ASC
                  LIMIT 42";
          $result = $conn->query($sql);

          $destinations = [];
          while ($row = $result->fetch_assoc()) {
              $destinations[] = $row;
          }

          $totalDestinations = count($destinations);
          $cardsPerPage = 6;
          $totalPages = ($cardsPerPage > 0) ? ceil($totalDestinations / $cardsPerPage) : 0;

          for ($i = 0; $i < $totalPages; $i++) {
              echo '<div class="carousel-page">';
              for ($j = 0; $j < $cardsPerPage; $j++) {
                  $index = $i * $cardsPerPage + $j;
                  if ($index >= $totalDestinations) break;
                  $d = $destinations[$index];
        ?>
          <div class="destination-card">
            <img src="<?php echo htmlspecialchars($d['image2']); ?>" alt="Destination">
            <div class="card-body">
              <div class="title-wrapper">
                <h5 class="title"><?php echo htmlspecialchars($d['attraction_name']); ?></h5>
              </div>
              <p class="card-text desc">
                <?php 
                  $desc = htmlspecialchars($d['attraction_description']);
                  echo strlen($desc) > 60 ? substr($desc, 0, 60) . '...' : $desc;
                ?>
              </p>
              <p class="card-text fw-bold">RM <?php echo number_format($d['adult_price'], 2); ?></p>
              <a href="item_detail.php?id=<?php echo $d['attraction_id']; ?>" 
                class="btn btn-primary btn-sm view-details-btn">
                View Details</a>
            </div>
          </div>
        <?php
              }
              echo '</div>'; 
          }
        ?>
      </div>

      <div class="carousel-dots text-center mt-3">
        <?php for ($i = 0; $i < $totalPages; $i++) { ?>
          <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<!-- ===== Carousel & Hero JS ===== -->
<script>
  // ====== Robust carousel init & debug ======
  (function() {
    const wrapper = document.getElementById("carouselWrapper");
    if (!wrapper) {
      console.error('carouselWrapper not found!');
      return;
    }
    const pages = Array.from(wrapper.querySelectorAll(".carousel-page"));
    const dots = Array.from(document.querySelectorAll('.carousel-dots .dot'));
    const totalPages = pages.length;
    let currentIndex = 0;

    wrapper.style.display = 'flex';
    wrapper.style.transition = 'transform 0.6s ease-in-out';
    wrapper.style.willChange = 'transform';


    function updateDots() {
      dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
    }

    function showPage(index) {
      if (index < 0 || index >= totalPages) return;
      // translate by full-page %
      wrapper.style.transform = `translateX(-${index * 100}%)`;
      currentIndex = index;
      updateDots();
    }

    dots.forEach(dot => {
      dot.addEventListener('click', () => {
        const idx = parseInt(dot.dataset.index, 10);
        showPage(idx);
      });
    });

    if (totalPages > 0) {
      showPage(0);
    } else {
      console.log('No pages to show (totalPages = 0)');
    }

    // ===== Hero Background Switch (8s) =====
    const hero = document.querySelector(".hero");
    if (hero) {
      const heroImages = [
        "https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/homeImages/hero-travel.jpg",
        "https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/homeImages/hero-2.jpg",
        "https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/homeImages/hero-3.jpg",
        "https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/homeImages/hero-4.jpg"
      ];
      let heroIndex = 0;

      hero.style.backgroundImage = `url('${heroImages[heroIndex]}')`;

      setInterval(() => {
        heroIndex = (heroIndex + 1) % heroImages.length;
        hero.style.backgroundImage = `url('${heroImages[heroIndex]}')`;
      }, 8000);
    }
  })();
</script>


<!-- Why Choose Us -->
<section class="container my-5">
  <h2 class="text-center mb-4">Why Choose Us</h2>
  <div class="row text-center">
    <div class="col-md-3">
      <i class="bi bi-cash-coin fs-1 text-primary"></i>
      <h5>Best Price</h5>
      <p>We offer the most competitive rates.</p>
    </div>
    <div class="col-md-3">
      <i class="bi bi-headset fs-1 text-primary"></i>
      <h5>24/7 Support</h5>
      <p>Always here to help during your trip.</p>
    </div>
    <div class="col-md-3">
      <i class="bi bi-compass fs-1 text-primary"></i>
      <h5>Personalized Trips</h5>
      <p>Itineraries tailored for your needs.</p>
    </div>
    <div class="col-md-3">
      <i class="bi bi-shield-check fs-1 text-primary"></i>
      <h5>Secure Payment</h5>
      <p>Safe and reliable booking process.</p>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="bg-light py-5">
  <div class="container">
    <h2 class="text-center mb-4">What Our Travelers Say</h2>
    <div class="row">
      <div class="col-md-4">
        <blockquote class="blockquote">
          <p>“Booking was super easy and my Paris trip was unforgettable!”</p>
          <footer class="blockquote-footer">Alice, Malaysia</footer>
        </blockquote>
      </div>
      <div class="col-md-4">
        <blockquote class="blockquote">
          <p>“Great support team, they helped me even at midnight.”</p>
          <footer class="blockquote-footer">John, UK</footer>
        </blockquote>
      </div>
      <div class="col-md-4">
        <blockquote class="blockquote">
          <p>“Best honeymoon ever in Malaysia. Thank you!”</p>
          <footer class="blockquote-footer">Wei & Mei, Singapore</footer>
        </blockquote>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="text-center py-5">
  <h2>Ready for your next adventure?</h2>
  <a href="listingPage/itemListing.php" class="btn btn-lg btn-warning mt-3">Start Booking Now</a>
</section>

<script>
  // state name
  const allStates = [
    "Johor", "Kuala Lumpur", "Pahang", 
    "Penang", "Sabah", "Sarawak",
    "Perak", "Kedah"
  ];

  const stateSearch = document.getElementById('stateSearch');
  const stateSuggestions = document.getElementById('stateSuggestions');

  const errorMsg = document.createElement("div");
  errorMsg.style.color = "red";
  errorMsg.style.fontSize = "0.9rem";
  errorMsg.style.marginTop = "4px";
  errorMsg.style.display = "none";
  errorMsg.textContent = "State not found. Please try again.";
  stateSearch.parentNode.appendChild(errorMsg);

  // provide suggestions as user types
  stateSearch.addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    errorMsg.style.display = "none"; 

    if (searchText.length === 0) {
      stateSuggestions.style.display = 'none';
      return;
    }
    const filteredStates = allStates.filter(state =>
      state.toLowerCase().includes(searchText)
    );
    showSuggestions(filteredStates);
  });

  function showSuggestions(states) {
    if (!states.length) {
      stateSuggestions.style.display = 'none';
      return;
    }

    // show suggestions
    stateSuggestions.innerHTML = states.map(state =>
      `<div class="suggestion-item">${state}</div>`
    ).join('');

    stateSuggestions.style.display = 'block';

    // click suggestion to fill input
    document.querySelectorAll('.suggestion-item').forEach(item => {
      item.addEventListener('click', () => {
        stateSearch.value = item.textContent;
        stateSuggestions.style.display = 'none';
      });
    });
  }
  document.getElementById("stateForm").addEventListener("submit", function(e) {
    const userInput = stateSearch.value.trim();
    if (!allStates.some(state => state.toLowerCase() === userInput.toLowerCase())) {
      e.preventDefault();
      errorMsg.style.display = "block"; 
    } else {
      errorMsg.style.display = "none";
    }
  });
</script>
</body>


<?php include('includes/footer.php'); ?>
</html>

<?php
$conn->close();
?>
