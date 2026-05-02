<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - ExploreMy</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/css/about.css">
    <link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/footer.css">

</head>
<body>

    <!-- ===== Header ===== -->
    <?php include 'includes/header.php'; ?>

    <!-- ===== Hero Slideshow ===== -->
    <div class="hero-slideshow">
        <div class="slides active">
            <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/about1.jpg" alt="Malaysia Travel">
        </div>
        <div class="slides">
            <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/about2.jpg" alt="Malaysia Nature">
        </div>
        <div class="slides">
            <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/about3.jpg" alt="Malaysia Culture">
        </div>

        <!-- Overlay Text -->
        <div class="hero-overlay">
            <h1 class="hero-title">ExploreMy</h1>
            <p class="hero-subtitle">Your trusted Malaysia trip companion</p>
        </div>
    </div>

    <!-- ===== About Section ===== -->
    <section class="about-section container my-5">
        <h2 class="text-center mb-4 fw-bold">About Us</h2>
        <p>
            ExploreMy is a Malaysia travel itinerary booking system, helping travelers discover 
            and book unique trip packages across Malaysia. From <strong>Johor, Kedah, Kuala Lumpur, 
            Pahang, Penang, Perak, Sabah,</strong> to <strong>Sarawak</strong>, we bring together 
            the best experiences for your journey.
        </p>
        <p>
            Our mission is simple: to make travel planning <strong>easy, modern, and user-friendly</strong>. 
            Whether you're seeking adventure, relaxation, or cultural exploration, ExploreMy 
            provides the tools to create unforgettable travel memories.
        </p>
    </section>

    <!-- ===== Features Section ===== -->
    <section class="features container my-5 text-center">
        <div class="row">
            <div class="col-md-4">
                <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/icons/savings.png" alt="Affordable" class="feature-icon">
                <h3>Affordable Packages</h3>
                <p>Enjoy competitive prices and exclusive travel deals tailored for all budgets.</p>
            </div>
            <div class="col-md-4">
                <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/icons/flexible.png" alt="Flexible" class="feature-icon">
                <h3>Flexible Itineraries</h3>
                <p>Choose from different states and customize your trip based on your preferences.</p>
            </div>
            <div class="col-md-4">
                <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/images/icons/support.png" alt="Support" class="feature-icon">
                <h3>24/7 Support</h3>
                <p>Our dedicated team ensures a smooth travel experience anytime, anywhere.</p>
            </div>
        </div>
    </section>

    <!-- Slideshow Script -->
    <script>
    let slideIndex = 0;
    let slides = document.getElementsByClassName("slides");

    function showSlides() {
        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }

        slides[slideIndex].classList.add("active");

        slideIndex++;
        if (slideIndex >= slides.length) { slideIndex = 0; }

        setTimeout(showSlides, 5000);
    }

    showSlides();
    </script>

    <!-- ===== Footer ===== -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
