// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.data('userDashboard', () => ({
        searchQuery: '',
        statusFilter: 'all',
        favoriteSearch: '',

        init() {
            this.initializeSearch();
            this.initializeLazyLoading();
            this.initializeAnimations();
            this.initializeCharts();
        },

        initializeSearch() {
            // Enhanced search with debounce
            let searchTimeout;

            this.$watch('searchQuery', (value) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(value);
                }, 300);
            });

            // Enhanced status filter with animation
            this.$watch('statusFilter', (value) => {
                const bookingCards = document.querySelectorAll('.booking-card');
                bookingCards.forEach(card => {
                    card.style.transition = 'all 0.3s ease-out';

                    if (value === 'all' || card.dataset.status === value) {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                        card.style.display = 'block';
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(10px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });

            // Favorite search
            this.$watch('favoriteSearch', (value) => {
                const favoriteCards = document.querySelectorAll('.favorite-card');
                favoriteCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    card.style.display = title.includes(value.toLowerCase()) ? 'block' : 'none';
                });
            });
        },

        performSearch(query) {
            const elements = document.querySelectorAll('.booking-card, .favorite-card');
            elements.forEach(element => {
                const searchableText = element.textContent.toLowerCase();
                const matches = searchableText.includes(query.toLowerCase());

                element.style.transition = 'all 0.3s ease-out';
                if (matches) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                    element.style.display = 'block';
                } else {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        element.style.display = 'none';
                    }, 300);
                }
            });
        },

        initializeLazyLoading() {
            const images = document.querySelectorAll('img[loading="lazy"]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('opacity-0');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        },

        initializeAnimations() {
            // Add scroll reveal animations
            const sr = ScrollReveal({
                origin: 'bottom',
                distance: '20px',
                duration: 1000,
                delay: 200,
                easing: 'cubic-bezier(0.5, 0, 0, 1)',
            });

            sr.reveal('.stats-card', { interval: 100 });
            sr.reveal('.booking-card', { interval: 100 });
            // sr.reveal('.favorite-card', { interval: 100 });
        },

        initializeCharts() {
            // Initialize booking trends chart
            const ctx = document.getElementById('bookingTrends');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Bookings',
                            data: [12, 19, 3, 5, 2, 3],
                            borderColor: '#2dd4bf',
                            tension: 0.4
                        }]
                    },

                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                borderColor: 'rgba(20, 184, 166, 0.3)',
                                borderWidth: 1,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return `Bookings: ${context.parsed.y}`;
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        },

        resetFilters() {
            this.searchQuery = '';
            this.statusFilter = 'all';
            this.dateRange = null;

            // Add elegant reset animation
            const cards = document.querySelectorAll('.booking-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.transform = 'translateY(20px)';
                    card.style.opacity = '0';

                    setTimeout(() => {
                        card.style.display = 'block';
                        card.style.transform = 'translateY(0)';
                        card.style.opacity = '1';
                    }, 300);
                }, index * 50);
            });
        },

        toggleFavorite(event, eventId) {
            const card = event.target.closest('.favorite-card');

            axios.post(`/events/${eventId}/toggle-favorite`)
                .then(response => {
                    // Add fade out animation
                    card.style.transition = 'all 0.3s ease-out';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';

                    // Remove card after animation
                    setTimeout(() => {
                        card.remove();

                        // Check if no more favorites
                        const remainingCards = document.querySelectorAll('.favorite-card');

                        if (remainingCards.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 300);
                })
                .catch(error => {
                    console.error('Error toggling favorite:', error);
                    alert('Failed to remove from favorites');
                });
        }
    }));
});


