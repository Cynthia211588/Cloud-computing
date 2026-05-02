<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="site-header">
    <div class="container header-container">
        <div class="logo">
            <a href="/index.php" class="logo-link">
                <img src="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/assets/logo/light-mode-logo.png" alt="Logo" class="logo-img">
                <span class="logo-explore">Explore</span><span class="logo-my">My.</span>
            </a>
        </div>

        <button class="mobile-nav-toggle" aria-controls="main-nav" aria-expanded="false">
            <i class="fa fa-bars"></i>
        </button>

        <nav class="main-nav" id="main-nav">
            <ul class="nav-list">
                <li><a href="/index.php" class="active">Home</a></li>
                <li><a href="/about.php">About Us</a></li>
				<li class="has-dropdown">
                    <a href="#">Attraction <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown">

                            <li><a href="/listingPage/itemListing.php?state=Kuala%20Lumpur">Kuala Lumpur</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Johor">Johor</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Kedah">Kedah</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Pahang">Pahang</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Penang">Penang</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Perak">Perak</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Sabah">Sabah</a></li>
                            <li><a href="/listingPage/itemListing.php?state=Sarawak">Sarawak</a></li>
                        </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#">Help <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown">
                        <li><a href="/contactUs.php">Contact Us</a></li>
                        <li><a href="/faq.php">FAQ</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div class="user-actions">
            <?php if (!empty($_SESSION['user_email'])): ?>
                <div class="user-dropdown">
                    <button class="btn btn-secondary dropdown-toggle profile-btn" type="button" aria-expanded="false">
                        <i class="fa fa-user-circle"></i> 
                        <span class="user-name">Hi, <?php echo htmlspecialchars($_SESSION['first_name'] ?? ''); ?></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/account.php"><i class="fa fa-user"></i> Edit Profile</a></li>
                        <li><a class="dropdown-item" href="/wishlist.php"><i class="fa fa-heart"></i> Wishlist</a></li>
                        <li><a class="dropdown-item" href="/payment_history.php"><i class="fa fa-history"></i> Purchase History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout.php"><i class="fa fa-sign-out-alt"></i> Log Out</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="/user/login.php" class="btn-auth signin">Login</a>
                    <a href="/user/signup.php" class="btn-auth signup">Register</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Add this CSS for responsive behavior -->
<style>
/* Header Styles */
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

/* Logo */
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

/* Mobile Navigation Toggle */
.mobile-nav-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    color: #333;
}

/* Main Navigation */
.main-nav {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 2rem;
}

.nav-list li {
    position: relative;
}

.nav-list a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.nav-list a:hover,
.nav-list a.active {
    background: #667eea;
    color: white;
}

/* Dropdown Menu */
.has-dropdown .dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 5px;
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
}

.has-dropdown:hover .dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dropdown li {
    border-bottom: 1px solid #eee;
}

.dropdown li:last-child {
    border-bottom: none;
}

.dropdown a {
    padding: 1rem;
    display: block;
    color: #333;
    border-radius: 0;
}

.dropdown a:hover {
    background: #f8f9fa;
    color: #667eea;
}

/* User Actions */
.user-actions {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.auth-buttons {
    display: flex;
    gap: 1rem;
}

.btn-auth {
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.signin {
    color: #667eea;
    border: 1px solid #667eea;
}

.signin:hover {
    background: #667eea;
    color: white;
}

.signup {
    background: #667eea;
    color: white;
    border: 1px solid #667eea;
}

.signup:hover {
    background: #0056b3;
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.profile-btn {
    background: #667eea;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.profile-btn:hover {
    background: #0056b3;
}

.user-dropdown .dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 5px;
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
    list-style: none;
    padding: 0;
    margin: 0;
    display: block !important;  
}

.user-dropdown.open .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: block;
    padding: 0.75rem 1rem;
    text-decoration: none;
    color: #333;
    border-bottom: 1px solid #eee;
}

.dropdown-item:hover {
    background: #f8f9fa;
    color: #007bff;
}

.dropdown-divider {
    margin: 0;
    border: 0;
    border-top: 1px solid #dee2e6;
}

/* Responsive Design */
@media (max-width: 992px) {
    .header-container {
        padding: 0.75rem;
    }
    
    .nav-list {
        gap: 1.5rem;
    }
    
    .logo-explore, .logo-my {
        font-size: 1.25rem;
    }
}

@media (max-width: 768px) {
    .mobile-nav-toggle {
        display: block;
        order: 2;
    }
    
    .logo {
        order: 1;
    }
    
    .user-actions {
        order: 3;
    }
    
    .main-nav {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        order: 4;
        width: 100%;
    }
    
    .main-nav.is-active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .nav-list {
        flex-direction: column;
        gap: 0;
        padding: 1rem 0;
    }
    
    .nav-list li {
        width: 100%;
    }
    
    .nav-list a {
        padding: 1rem;
        border-radius: 0;
        border-bottom: 1px solid #eee;
    }
    
    .has-dropdown .dropdown {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        background: #f8f9fa;
        display: none;
    }
    
    .has-dropdown.mobile-open .dropdown {
        display: block;
    }
    
    .auth-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn-auth {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .user-name {
        display: none;
    }
}

@media (max-width: 480px) {
    .header-container {
        padding: 0.5rem;
    }
    
    .logo-img {
        height: 35px;
    }
    
    .logo-explore, .logo-my {
        font-size: 1.1rem;
    }
    
    .profile-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .auth-buttons {
        gap: 0.25rem;
    }
    
    .btn-auth {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>

<!-- Enhanced JS for Responsive Menu -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const mainNav = document.querySelector('.main-nav');
    const icon = mobileNavToggle.querySelector('i');

    if (mobileNavToggle && mainNav) {
        mobileNavToggle.addEventListener('click', function() {
            const isActive = mainNav.classList.contains('is-active');
            
            mainNav.classList.toggle('is-active');
            icon.classList.toggle('fa-bars', isActive);
            icon.classList.toggle('fa-times', !isActive);
            
            // Update aria-expanded for accessibility
            this.setAttribute('aria-expanded', !isActive);
        });

        // Close mobile menu when clicking on a link
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    mainNav.classList.remove('is-active');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                    mobileNavToggle.setAttribute('aria-expanded', 'false');
                }
            });
        });

        // Handle mobile dropdown toggles
        const hasDropdown = document.querySelectorAll('.has-dropdown > a');
        hasDropdown.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('mobile-open');
                }
            });
        });
    }

    // User dropdown toggle
    const profileBtn = document.querySelector('.profile-btn');
    const userDropdown = document.querySelector('.user-dropdown');
    
    if (profileBtn && userDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('open');
            
            // Update aria-expanded for accessibility
            const isOpen = userDropdown.classList.contains('open');
            this.setAttribute('aria-expanded', isOpen);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                userDropdown.classList.remove('open');
                profileBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            mainNav.classList.remove('is-active');
            icon.classList.add('fa-bars');
            icon.classList.remove('fa-times');
            mobileNavToggle.setAttribute('aria-expanded', 'false');
            
            // Remove mobile dropdown classes
            document.querySelectorAll('.has-dropdown').forEach(el => {
                el.classList.remove('mobile-open');
            });
        }
    });
});
</script>