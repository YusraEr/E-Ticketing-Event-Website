// Initialize Swiper
window.addEventListener('scroll', () => {
    const offset = window.pageYOffset;
    document.querySelector('.hero-parallax').style.setProperty('--scroll-offset', `${offset * 0.5}px`);
});
new Swiper(".eventSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    effect: "slide",
    speed: 1500,
    cssMode: false, // Changed to false like ticketSwiper
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
        dynamicMainBullets: 3,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});

new Swiper(".ticketSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    effect: "slide",
    speed: 1500,
    cssMode: false, // Remove cssMode to ensure smoother transitions
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
        dynamicMainBullets: 3,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});

// Initialize Popular Events Swiper
new Swiper(".popularSwiper", {
    slidesPerView:3,
    spaceBetween: 20,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    effect: "slide",
    speed: 1500,
    cssMode: false,
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
        dynamicMainBullets: 3,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});
