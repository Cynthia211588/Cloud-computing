// DOM elements
const priceSlider = document.getElementById('priceSlider');
const maxPriceDisplay = document.getElementById('maxPriceDisplay');
const attractionsGrid = document.getElementById('attractionsGrid');
const resultsCount = document.getElementById('resultsCount');
const placeTypeRadios = document.querySelectorAll('input[name="place-type"]');
const attractionCards = document.querySelectorAll('.attraction-card');
const sortByText = document.querySelector('.sort-by');
const stateSearch = document.getElementById('stateSearch');
const stateSuggestions = document.getElementById('stateSuggestions');
const starBoxes = document.querySelectorAll('.star-box');
const bookingRadios = document.querySelectorAll('input[name="booking"]');
const accessBoxes = document.querySelectorAll('.access-box');

// Current filter values
let currentFilters = {
    maxPrice: 500,
    currentStar: 'all',
    placeType: 'both',
    booking: 'all',
    accessibility: 'all'
};

// Function to format counts (e.g., 1000 → 1K)
function formatCount(number) {
    if (number >= 1000) return (number / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    return number.toString();
}

// Apply formatted counts to each attraction card
attractionCards.forEach(card => {
    const ratingSpan = card.querySelector('.rating span:nth-child(2)');
    if (ratingSpan) {
        const reviewText = ratingSpan.textContent;
        const parts = reviewText.split('•'); // "5 (52K) • 92K+ booked"
        if (parts.length === 2) {
            const reviewCountRaw = parts[0].match(/\d+/);
            const bookingCountRaw = parts[1].match(/\d+/);
            if (reviewCountRaw) parts[0] = parts[0].replace(/\d+/, formatCount(parseInt(reviewCountRaw[0])));
            if (bookingCountRaw) parts[1] = parts[1].replace(/\d+/, formatCount(parseInt(bookingCountRaw[0])));
            ratingSpan.textContent = parts.join('•');
        }
    }
});

// Initialize the page
function init() {
    setupSearch();

    // Price range filter
    priceSlider.addEventListener('input', function() {
        currentFilters.maxPrice = parseInt(this.value);
        maxPriceDisplay.textContent = `RM ${currentFilters.maxPrice}`;
        filterAttractions();
    });

    // Place type filter
    placeTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            currentFilters.placeType = this.value;
            filterAttractions();
        });
    });

    // Star rating filter
    starBoxes.forEach(box => {
        box.addEventListener('click', function(e) {
            e.preventDefault();
            starBoxes.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilters.currentStar = this.dataset.star;
            filterAttractions();
        });
    });

    // Booking count filter
    bookingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            currentFilters.booking = this.value;
            filterAttractions();
        });
    });

    // Accessibility filter
    accessBoxes.forEach(box => {
        box.addEventListener('click', function(e) {
            e.preventDefault();
            accessBoxes.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilters.accessibility = this.dataset.access.toLowerCase();
            filterAttractions();
        });
    });

    // Initial filter
    filterAttractions();
}

// Search functionality
function setupSearch() {
    const allStates = [
        "Johor", "Kedah", "Kuala Lumpur",
        "Pahang", "Penang", "Perak", "Sabah",
        "Sarawak"
    ];

    stateSearch.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        if (searchText.length === 0) {
            stateSuggestions.style.display = 'none';
            return;
        }
        const filteredStates = allStates.filter(state => state.toLowerCase().includes(searchText));
        showSuggestions(filteredStates);
    });
}

function showSuggestions(states) {
    if (!states.length) {
        stateSuggestions.style.display = 'none';
        return;
    }
    stateSuggestions.innerHTML = states.map(state => 
        `<a class="suggestion-item" href="itemListing.php?state=${encodeURIComponent(state)}">${state}</a>`
    ).join('');
    stateSuggestions.style.display = 'block';
}

// Filter attractions
function filterAttractions() {
    let visibleCount = 0;

    // Determine top booking if needed
    let topBooking = 0;
    if(currentFilters.booking === 'most'){
        attractionCards.forEach(card => {
            const bookingCount = parseInt(card.dataset.booking || 0);
            if(bookingCount > topBooking) topBooking = bookingCount;
        });
    }

    attractionCards.forEach(card => {
        const price = parseFloat(card.dataset.price);
        const rating = parseFloat(card.dataset.rating);
        const type = card.dataset.type;
        const bookingCount = parseInt(card.dataset.booking || 0);
        const cardAccess = (card.dataset.access || "").toLowerCase();

        let show = true;

        // Price filter
        if (price > currentFilters.maxPrice) show = false;

        // Star filter
        if (currentFilters.currentStar !== 'all' && Math.floor(rating) !== parseInt(currentFilters.currentStar)) show = false;

        // Place type filter
        if (currentFilters.placeType !== 'both' && type !== currentFilters.placeType) show = false;

        // Booking filter
        if (currentFilters.booking === 'most' && bookingCount < topBooking) show = false;

        // Accessibility filter
        if (currentFilters.accessibility !== 'all' && 
            !cardAccess.includes(currentFilters.accessibility)) show = false;

        card.style.display = show ? 'block' : 'none';
        if (show) visibleCount++;
    });

    resultsCount.textContent = `${visibleCount} results found`;
}

// Initialize when page loads
window.addEventListener('DOMContentLoaded', init);


