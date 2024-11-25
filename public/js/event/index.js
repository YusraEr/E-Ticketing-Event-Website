
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
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    }

    // Event Filters
    const filterElements = document.querySelectorAll('#category-filter, #location-filter, #date-filter, #sort-by');

    filterElements.forEach(element => {
        element.addEventListener('change', function() {
            const filters = {
                category: document.getElementById('category-filter')?.value,
                location: document.getElementById('location-filter')?.value,
                date: document.getElementById('date-filter')?.value,
                sort: document.getElementById('sort-by')?.value
            };

            const url = new URL(window.location.href);
            Object.entries(filters).forEach(([key, value]) => {
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            });

            window.location.href = url.toString();
        });
    });
});