document.addEventListener('DOMContentLoaded', function() {
    // Initialize Hero Swiper
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    // Initialize Popular Events Swiper
    if (document.querySelector('.popular-events')) {
        new Swiper('.popular-events', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            effect: "slide",
            speed: 1500,
            cssMode: false,
            grabCursor: true,
            navigation: {
                nextEl: '.swiper-button-prev',
                prevEl: '.swiper-button-next',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 3,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
        });
    }

    // Show More/Less Events functionality
    const showMoreBtn = document.getElementById('showMoreEvents');
    const eventCards = document.querySelectorAll('#topEventsGrid .event-card');
    let isExpanded = false;

    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            const hiddenCards = document.querySelectorAll('#topEventsGrid .event-card.hidden');

            if (!isExpanded) {
                // Show More
                hiddenCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.remove('hidden');
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(-50px)';
                        card.offsetHeight; // Trigger reflow
                        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 200);
                });
                showMoreBtn.textContent = 'Show Less';
                isExpanded = true;
            } else {
                // Show Less
                const allCards = Array.from(eventCards);
                allCards.slice(6).forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(-50px)';
                        setTimeout(() => {
                            card.classList.add('hidden');
                            card.style.transform = '';
                            card.style.opacity = '';
                        }, 500);
                    }, index * 200);
                });
                showMoreBtn.textContent = 'Show More';
                isExpanded = false;

                // Smooth scroll to last visible card
                setTimeout(() => {
                    const lastVisibleCard = document.querySelector('#topEventsGrid .event-card:not(.hidden):last-child');
                    if (lastVisibleCard) {
                        lastVisibleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            }
        });
    }

    // Search and Filter Functionality
    function initializeFilters() {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const filterSelects = document.querySelectorAll('.filter-select');
        const dateFilter = document.getElementById('date-filter');
        const mainEventsGrid = document.getElementById('main-events-grid');
        const categoryButtons = document.querySelectorAll('.category-scroll button');  // Changed from links to buttons

        // Debug logging
        console.log('Initializing filters with buttons...');
        console.log('Form found:', !!searchForm);
        console.log('Filters found:', filterSelects.length);
        console.log('Category buttons found:', categoryButtons.length);

        // Update URL without reload
        function updateURL(params) {
            console.log('Updating URL with params:', params);
            const url = new URL(window.location);
            Object.entries(params).forEach(([key, value]) => {
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.history.pushState({}, '', url);
            console.log('New URL:', url.toString());
        }

        // Update active states
        function updateActiveStates() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeCategoryId = urlParams.get('category') || '';

            // Update category buttons
            categoryButtons.forEach(button => {
                const categoryId = button.getAttribute('data-category');
                if (categoryId === activeCategoryId) {
                    button.classList.add('bg-gradient-to-r', 'from-teal-500', 'to-emerald-500', 'text-white');
                    button.classList.remove('bg-slate-700', 'text-teal-300');
                } else {
                    button.classList.remove('bg-gradient-to-r', 'from-teal-500', 'to-emerald-500', 'text-white');
                    button.classList.add('bg-slate-700', 'text-teal-300');
                }
            });

            // Update filter selects
            document.getElementById('category-filter').value = activeCategoryId;
            if (urlParams.get('location')) document.getElementById('location-filter').value = urlParams.get('location');
            if (urlParams.get('date')) document.getElementById('date-filter').value = urlParams.get('date');
            if (urlParams.get('sort')) document.getElementById('sort-by').value = urlParams.get('sort');
            if (urlParams.get('search')) searchInput.value = urlParams.get('search');
        }

        function updateEvents(e) {
            if (e) {
                e.preventDefault();
                console.log('Event prevented from:', e.target);
            }

            console.log('Updating events...');
            const searchValue = searchInput.value;
            const categoryValue = document.getElementById('category-filter').value;
            const locationValue = document.getElementById('location-filter').value;
            const dateValue = dateFilter.value;
            const sortValue = document.getElementById('sort-by').value;

            console.log('Filter values:', {
                search: searchValue,
                category: categoryValue,
                location: locationValue,
                date: dateValue,
                sort: sortValue
            });

            // Update URL and active states
            updateURL({
                search: searchValue,
                category: categoryValue,
                location: locationValue,
                date: dateValue,
                sort: sortValue
            });

            // Show loading state
            mainEventsGrid.style.opacity = '0.5';

            fetch(`/api/events/filter?search=${searchValue}&category=${categoryValue}&location=${locationValue}&date=${dateValue}&sort=${sortValue}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text();
                })
                .then(html => {
                    console.log('Received HTML length:', html.length);
                    mainEventsGrid.innerHTML = html;
                    mainEventsGrid.style.opacity = '1';
                    updateActiveStates();
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    mainEventsGrid.style.opacity = '1';
                });

        }

        // Event Listeners with debug
        if (searchForm) {
            console.log('Adding event listeners...');

            searchForm.addEventListener('submit', function(e) {
                console.log('Form submitted');
                e.preventDefault();
                e.stopPropagation();
                updateEvents();
            });

            let debounceTimer;
            searchInput.addEventListener('input', function(e) {
                console.log('Search input changed');
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => updateEvents(), 300);
            });

            filterSelects.forEach(select => {

                select.addEventListener('change', function(e) {
                    console.log('Filter changed:', this.id);
                    e.preventDefault();
                    e.stopPropagation();
                    updateEvents();
                });
            });

            dateFilter.addEventListener('change', function(e) {
                console.log('Date changed');
                e.preventDefault();
                e.stopPropagation();
                updateEvents();
            });

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Category button clicked:', this.getAttribute('data-category'));
                    const categoryId = this.getAttribute('data-category');
                    document.getElementById('category-filter').value = categoryId;
                    updateEvents();
                });
            });

            // Initialize active states on page load
            console.log('Setting up initial state...');
            updateActiveStates();
        } else {
            console.error('Search form not found!');
        }
    }

    // Initialize all functionality
    console.log('DOM loaded, initializing...');
    initializeFilters();
});




