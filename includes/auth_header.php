<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<header class="site-header">
    <div class="container header-container">
        <div class="logo">
            <a href="../index.php" class="logo-link">
                <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/logo/light-mode-logo.png" alt="Logo" class="logo-img">
                <span class="logo-explore">Explore</span><span class="logo-my">My.</span>
            </a>
        </div>
</header>

<style>
.site-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
}

.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
}

.logo-img {
    height: 40px;
    margin-right: 10px;
}

.logo-explore {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.logo-my {
    font-size: 24px;
    font-weight: bold;
    color: #667eea;
}
</style>