<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "exploremy_db";


// Connect to database
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); }

// Get state from URL, default Kuala Lumpur
$stateName = isset($_GET['state']) ? $_GET['state'] : 'Kuala Lumpur';
$stateNameEscaped = mysqli_real_escape_string($conn, $stateName);

// Get state ID
$stateResult = mysqli_query($conn, "SELECT id FROM states WHERE name='$stateNameEscaped'");
if (mysqli_num_rows($stateResult) == 0) {
     die("State not found."); 
}
$stateRow = mysqli_fetch_assoc($stateResult);
$stateId = $stateRow['id'];

// Fetch attractions for particular state
$sql = "SELECT id, name, category, price, rating, review_count, booking_count, type, accessibility, image_url
        FROM attractions
        WHERE state_id=$stateId AND is_active=1
        ORDER BY rating DESC, booking_count DESC";

$attractionsResult = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($stateName); ?> Attractions</title>
    <link rel="stylesheet" href="itemListing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <?php include('../includes/header.php');?>


<!-- search bar -->
 <div class="search-container">
    <form method = "get" action = "itemListing.php" class = "search-box">
        <i class="fa fa-search"></i>
        <input type="text" id="stateSearch" name = "state" placeholder="Search by state...">
        <div class="suggestions" id="stateSuggestions"></div>
    </form>
</div>

<div class="container">
    <!-- Filters (Price, Recommendation, Type) -->
    <div class="filters">
        <h2>Filters</h2>
        <!-- price range -->
        <div class="filter-section">
            <div class="filter-title">Price range</div>
            <input type="range" class="price-slider" id="priceSlider" min="0" max="500" value="500">
            <div class="price-range"><span>RM 0</span><span id="maxPriceDisplay">RM 500</span></div>
        </div>

        <!-- filter by star rating -->
        <div class="filter-section">
            <div class="filter-title">Star Rating</div>
            <div class="star-filter">
                <a href="#" class="star-box" data-star="1">1<span class="stars">★</span></a>
                <a href="#" class="star-box" data-star="2">2<span class="stars">★</span></a>
                <a href="#" class="star-box" data-star="3">3<span class="stars">★</span></a>
                <a href="#" class="star-box" data-star="4">4<span class="stars">★</span></a>
                <a href="#" class="star-box" data-star="5">5<span class="stars">★</span></a>
                <a href="#" class="star-box active" data-star="all">All</a>
            </div>
        </div>

        <!-- filter by Booking count -->
        <div class="filter-section">
            <div class="filter-title">Booking Count</div>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="booking-most" name="booking" value="most">
                    <label for="booking-most">Most Booked</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="booking-all" name="booking" value="all" checked>
                    <label for="booking-all">All</label>
                </div>
            </div>
        </div>

        <!-- indoor/outdoor filter -->
        <div class="filter-section">
            <div class="filter-title">Place Type</div>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" name="place-type" value="indoor" id="type-indoor">
                    <label for="type-indoor">Indoor</label>
                </div>
                <div class="radio-option">
                    <input type="radio" name="place-type" value="outdoor" id="type-outdoor">
                    <label for="type-outdoor">Outdoor</label>
                </div>
                <div class="radio-option">
                    <input type="radio" name="place-type" value="both" id="type-both" checked>
                    <label for="type-both">Both</label>
                </div>
            </div>
        </div>


        <!-- filter by Accessibility -->
<div class="filter-section">
    <div class="filter-title">Accessibility</div>
    <div class="accessibility-filter">
        <a href="#" class="access-box" data-access="wheelchair accessible"><i class="fa fa-wheelchair"></i>Wheelchair Accessible</a>
        <a href="#" class="access-box" data-access="kid friendly"><i class="fa fa-child"></i>Kid Friendly</a>
        <a href="#" class="access-box" data-access="pet friendly"><i class="fa fa-paw"></i>Pet Friendly</a>
        <a href="#" class="access-box" data-access="guided tours"><i class="fa fa-map"></i>Guided Tours</a>
        <a href="#" class="access-box" data-access="cafeteria"><i class="fa fa-cutlery"></i>Cafeteria</a>
        <a href="#" class="access-box" data-access="restroom accessibility"><i class="fa fa-bath"></i>Restroom Accessible</a>
        <a href="#" class="access-box" data-access="parking availability"><i class="fa fa-car"></i>Parking Available</a>
        <a href="#" class="access-box" data-access="public transport"><i class="fa fa-bus"></i>Public Transport</a>
        <a href="#" class="access-box active" data-access="all">All</a>

    </div>
</div>


    </div>

    <!-- Attractions Grid -->
    <div class="results">
        <div class="results-header">
            <div class="results-count" id="resultsCount"><?php echo mysqli_num_rows($attractionsResult); ?> results found</div>
            <div class = "sort-by" id="sortByText">Sort By: All Recommendations</div>
        </div>

        <div class="attractions-grid" id="attractionsGrid">
            <?php while ($row = mysqli_fetch_assoc($attractionsResult)): ?>
                <div class="attraction-card"
                     data-price="<?php echo $row['price']; ?>"
                     data-rating="<?php echo $row['rating']; ?>"
                     data-booking="<?php echo $row['booking_count'];?>"
                     data-access="<?php echo $row['accessibility'];?>"
                     data-type="<?php echo $row['type']; ?>"
                     data-location="<?php echo htmlspecialchars($stateName); ?>">
                    <a href="../item_detail?id=<?php echo $row['id']; ?>" target="_blank" class="card-link">
                        <img class="card-image" src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-content">
                            <div class="category">Religious sites • <?php echo htmlspecialchars($row['category']); ?></div>
                            <div class="attraction-name"><?php echo htmlspecialchars($row['name']); ?></div>
                            <div class="confirmation">Instant confirmation</div>
                            <div class="rating">
                                <span class="stars">
                                    <?php 
                                    $rating = $row['rating'];
                                    $fullStar = floor($rating);
                                    $halfStar = ($rating - $fullStar >= 0.5) ? 1 : 0;
                                    $emptyStar = 5 - $fullStar - $halfStar;

                                    echo str_repeat('★', $fullStar);
                                    if($halfStar){
                                        echo '⯨';
                                    }
                                    echo str_repeat('☆', $emptyStar); 
                                    ?>
                                </span>

                                <span><?php echo $row['rating']; ?> (<span class="review-count"><?php echo $row['review_count']; ?></span>)
                                 • <span class="booking-count"><?php echo $row['booking_count']; ?></span>+ booked</span>
                            </div>
                            <div class="price">RM <?php echo number_format($row['price'], 2); ?></div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script src="itemListing.js"></script>
<!--this is to make sure header not overlap with content-->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const header = document.querySelector(".site-header");
        if (header) {
                document.body.style.paddingTop = header.offsetHeight + "px";
        }
    });
</script>

</body>
    <?php include '../includes/footer.php'; ?>
</html>

<?php mysqli_close($conn); ?>
