<?php
$servername = "localhost";
$username = "root";   
$password = "";      
$dbname = "ExploreMY_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM states ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaysia States Navigation</title>
    <link rel="stylesheet" href="assets/css/navigation.css">
</head>
<body>
    <div class="container">
        <div class="section-header">
            <h2>Explore 🇲🇾 by State</h2>
            <p>Click on any state to discover amazing destinations and plan your perfect trip</p>
        </div>

        <div class="state-wrapper">
            <button class="nav-btn left" onclick="scrollStates(-1)" id="leftBtn">‹</button>
            
            <div id="stateList">
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $state = htmlspecialchars($row['name']);
                        $code = htmlspecialchars($row['code']);
                        $imgPath = "images/nav-place/" . strtolower($code) . ".jpg";
                        if (!file_exists($imgPath)) {
                            $imgPath = "images/nav-place/default.jpg"; // fallback
                        }
                        echo "
                        <a href='listingPage/itemListing.php?state=" . urlencode($state) . "' class='state-card'>
                            <img src='$imgPath' alt='$state'>
                            <div class='state-overlay'>
                                <h6>$state</h6>
                            </div>
                        </a>
                        ";
                    }
                } else {
                    echo "<p>No states found in database.</p>";
                }
                ?>
            </div>

            <button class="nav-btn right" onclick="scrollStates(1)" id="rightBtn">›</button>        
        </div>
    </div>

<script>
const stateList = document.getElementById('stateList');

function scrollStates(direction) {
    const cardWidth = stateList.querySelector('.state-card').offsetWidth;
    const gap = 20;
    const scrollAmount = cardWidth + gap;

    if (direction === 1) {
        stateList.scrollLeft += scrollAmount;
    } else if (direction === -1) {
        stateList.scrollLeft -= scrollAmount;
    }
}
</script>

</body>
</html>
