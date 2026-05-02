<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="faq.css">
    <link rel="stylesheet" href="https://travel-itinerary-malcolm.s3.ap-southeast-1.amazonaws.com/style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anta&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:wght@400;600;700&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <title>FAQ ExploreMy Website</title>
</head>
<body>
    <!-- Header -->
     <?php include('includes/header.php'); ?>
    <main>
    <div class="header">
        <h1 class="header-title"> FAQ</h1>
        <p class="header-desc">Frequently Asked Questions</p>
        <!-- Search -->
        <div class="search">
            <input type="text" id="faqSearch" placeholder="Search FAQs...">
            <button onclick="searchFAQ()">Search</button>
        </div>
    </div>

        <!-- FAQ accordion -->
        <div class="faq">
            <div class="faq-name">
                <h1 class="faq-header">Have <br> questions?</h1>
                <img class="faq-img" src="images/faq.jpg" >
            </div>
            <div class="faq-box">
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-1">
                    <label class="faq-title" for="faq-trigger-1">What is ExploreMy?</label>
                    <div class="faq-detail">
                        <p>ExploreMy is a Malaysia travel itinerary booking system that helps travelers discover and book unique trip packages across the country, including Johor, Kedah, Kuala Lumpur, Pahang, Penang, Perak, Sabah, and Sarawak.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-2">
                    <label class="faq-title" for="faq-trigger-2">Do I need to register an account to use the system?</label>
                    <div class="faq-detail">
                        <p>Yes, you need to create a free account in order to save itineraries, make bookings, and enjoy personalized recommendations.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-3">
                    <label class="faq-title" for="faq-trigger-3">What payment methods are supported?</label>
                    <div class="faq-detail">
                        <p>We support multiple payment methods such as online banking, credit/debit cards (Visa/MasterCard), and popular e-wallets like GrabPay, Touch ‘n Go eWallet, and Boost.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-4">
                    <label class="faq-title" for="faq-trigger-4">Can I cancel or modify my booking?</label>
                    <div class="faq-detail">
                        <p>Most packages allow cancellation or modification, but it depends on the provider’s cancellation policy. Please check the package details before booking.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-5">
                    <label class="faq-title" for="faq-trigger-5">Can I book for multiple travelers at once?</label>
                    <div class="faq-detail">
                        <p>Yes, you can book for multiple travelers at once by selecting the desired number of travelers during the booking process.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-6">
                    <label class="faq-title" for="faq-trigger-6">What should I do if I face issues during my trip?</label>
                    <div class="faq-detail">
                        <p>Our customer support team is available 24/7 to assist you. You can contact us via live chat, email, or hotline anytime.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-7">
                    <label class="faq-title" for="faq-trigger-7">Are there any hidden charges?</label>
                    <div class="faq-detail">
                        <p>No, there are no hidden charges. The price you see during the booking process is the final price you pay.</p>
                    </div>
                </div>
                <div class="faq-wrapper">
                    <input type="checkbox" class="faq-trigger" id="faq-trigger-8">
                    <label class="faq-title" for="faq-trigger-8">How can I contact ExploreMy?</label>
                    <div class="faq-detail">
                        <p><ul>
                            <li>Email: info@exploremy.com</li>
                            <li>Phone: +60 12-345 6789</li>
                            <li>Live Chat: Available on our website 24/7</li>
                            <li>Social Media: Follow us on Facebook, Instagram, and Twitter for updates and
                        </ul></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function searchFAQ() {
            let input = document.getElementById("faqSearch").value.toLowerCase().trim();
            if (!input) return;

            let titles = document.querySelectorAll(".faq-title");
            let found = false;

            titles.forEach(title => {
                let text = title.innerText.toLowerCase();

                let checkbox = document.getElementById(title.getAttribute("for"));
                checkbox.checked = false;

                if (text.includes(input) && !found) {
                    found = true;

                    checkbox.checked = true;

                    title.scrollIntoView({behavior: "smooth", block: "center"});
                }
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const header = document.querySelector(".site-header");
            if (header) {
                    document.body.style.paddingTop = header.offsetHeight + "px";
            }
        });
    </script>

</body>
<?php include('includes/footer.php'); ?>
</html>