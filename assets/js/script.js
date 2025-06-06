
// Functionality For Navbar
let navMenuBtn = document.querySelector('nav .menu-btn button');
let navMenu = document.querySelector('nav .nav-menu');

navMenuBtn.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});

document.addEventListener('click', (event) => {
    if (!navMenu.contains(event.target) && !navMenuBtn.contains(event.target)) {
        navMenu.classList.remove('active');
    }
});

// ----------------------------------------------------------------------------------------------------

let productCards = document.querySelectorAll('.product-cards-row .product-card');

productCards.forEach((productCard) => {
    productCard.addEventListener('mouseenter', () => {
        let layer1 = productCard.querySelector('.layer-1');
        let layer2 = productCard.querySelector('.layer-2');
        layer1.classList.add('hide');
        layer2.classList.add('show');
    });

    productCard.addEventListener('mouseleave', () => {
        let layer1 = productCard.querySelector('.layer-1');
        let layer2 = productCard.querySelector('.layer-2');
        layer1.classList.remove('hide');
        layer2.classList.remove('show');
    });
});

// ----------------------------------------------------------------------------------------------------

// Refresh AOS on scroll
window.onscroll = () => {
    AOS.refresh();
}

// ----------------------------------------------------------------------------------------------------

// Functionality For CSR Page Modal Section
let modal = document.querySelector('#tabModal');
let modalHead = document.querySelector('#tabModal #tabModalLabel');
let modalBody = document.querySelector('#tabModal .modal-body .modal-text-content p');
let modalSwiperWrapper = document.querySelector('#tabModal .swiper-wrapper');
let csrCards = document.querySelectorAll('.csr-card');

let modalSwiperInstance; // Variable to store the modal Swiper instance

csrCards.forEach((card) => {
    card.addEventListener('click', () => {
        // Get the heading and description
        let cardHeading = card.querySelector('h3').textContent;
        let cardDesc = card.querySelector('.content-for-modal .para p').textContent;

        // Set the modal heading and description
        modalHead.textContent = cardHeading;
        modalBody.textContent = cardDesc;

        // Clear existing slides in the Swiper
        modalSwiperWrapper.innerHTML = '';

        // Get images from the .content-for-modal div
        let images = card.querySelectorAll('.content-for-modal .images img');

        // Create slides dynamically based on the images
        images.forEach((img) => {
            let slide = document.createElement('div');
            slide.classList.add('swiper-slide');
            slide.innerHTML = `<img src="${img.src}" alt="${img.alt}">`;
            modalSwiperWrapper.appendChild(slide);
        });

        // Destroy the existing modal Swiper instance if it exists
        if (modalSwiperInstance) {
            modalSwiperInstance.destroy(true, true);
        }

        // Reinitialize Swiper for modal only
        modalSwiperInstance = new Swiper('.modal-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            loop: false,
        });
    });
});


// Close modal when clicking outside the modal content
document.addEventListener('click', (event) => {
    const modal = document.querySelector('#tabModal');
    const modalDialog = modal.querySelector('.modal-dialog');

    if (modal.classList.contains('show') && !modalDialog.contains(event.target)) {
        const bootstrapModal = bootstrap.Modal.getInstance(modal); // Get the Bootstrap modal instance
        bootstrapModal.hide(); // Hide the modal
    }
});

// ----------------------------------------------------------------------------------------------------

// Functionality For Internal Product Pages Contact Form Phone Input Flags Selector
const phoneInput = document.querySelector(".get-in-touch-form #phone");
const iti = window.intlTelInput(phoneInput, {
    initialCountry: "in",
    separateDialCode: true,
    preferredCountries: ["in", "us", "gb", "au"],
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
});

document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault();
    const fullNumber = iti.getNumber();
    alert("Submitted phone: " + fullNumber);
});

phoneInput.addEventListener('input', function () {
    // Remove all non-digit characters and limit to 10 digits
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});

phoneInput.placeholder = "";

// ----------------------------------------------------------------------------------------------------
