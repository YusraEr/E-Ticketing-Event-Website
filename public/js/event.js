document.addEventListener('DOMContentLoaded', function() {
    // Initialize Hero Swiper
    if (document.querySelector('.hero-swiper')) {
        const heroSwiper = new Swiper('.hero-swiper', {
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
        const popularSwiper = new Swiper('.popular-events', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    }

    // Event Filters
    const filterElements = document.querySelectorAll('#category-filter, #location-filter, #date-filter, #sort-by');

    filterElements.forEach(element => {
        element.addEventListener('change', function() {
            let category = document.getElementById('category-filter')?.value;
            let location = document.getElementById('location-filter')?.value;
            let date = document.getElementById('date-filter')?.value;
            let sortBy = document.getElementById('sort-by')?.value;

            let url = new URL(window.location.href);
            let params = url.searchParams;

            updateUrlParam(params, 'category', category);
            updateUrlParam(params, 'location', location);
            updateUrlParam(params, 'date', date);
            updateUrlParam(params, 'sort', sortBy);

            window.location.href = url.toString();
        });
    });

    function updateUrlParam(params, key, value) {
        if (value) {
            params.set(key, value);
        } else {
            params.delete(key);
        }
    }
});
