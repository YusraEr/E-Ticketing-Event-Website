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
            // effect: 'fade',
            // fadeEffect: {
            //     crossFade: true
            // },
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
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
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

                        // Trigger reflow
                        card.offsetHeight;

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

                // Smooth scroll ke card terakhir yang visible
                setTimeout(() => {
                    const lastVisibleCard = document.querySelector('#topEventsGrid .event-card:not(.hidden):last-child');
                    if (lastVisibleCard) {
                        lastVisibleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            }
        });
    }
});
