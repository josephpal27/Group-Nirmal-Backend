// Functionlity for Timeline Slider
const years = [
  '', '1971', '1995', '1996', '2003', '2010', '2013', '2014', '2018', '2019',
  '2021', '2022', '2023', '2024', '2024', ''
];

const totalSlides = years.length;
const firstDisabledIndex = 0;
const lastDisabledIndex = totalSlides - 1;
const dotSize = 17;
const gap = 100;
const dotOffset = dotSize + gap;

const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentIndex = 1;
let allowDragLeft = true;
let allowDragRight = true;

const swiper = new Swiper('.ourJourneySwiper', {
  loop: true,
  slidesPerView: 1,
  initialSlide: currentIndex,
  effect: 'fade',
  fadeEffect: { crossFade: true },
  speed: 500,
  allowTouchMove: false,
  on: {
    init() {
      renderDots(this.realIndex);
      updateNavButtons(this.realIndex);
      updateDragDirection(this.realIndex);
    },
    slideChange() {
      currentIndex = this.realIndex;
      renderDots(this.realIndex);
      updateNavButtons(this.realIndex);
      updateDragDirection(this.realIndex);
    }
  }
});

function renderDots(activeIndex) {
  const container = document.querySelector('.custom-pagination');
  container.innerHTML = '';

  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('button');
    dot.classList.add('pagination-dot');
    if (i === activeIndex) dot.classList.add('active');
    dot.innerHTML = `<span>${years[i]}</span>`;

    if (i === firstDisabledIndex || i === lastDisabledIndex) {
      dot.style.pointerEvents = 'none';
      dot.classList.add('disabled-dot');
    } else {
      dot.onclick = () => swiper.slideToLoop(i);
    }

    container.appendChild(dot);
  }

  const centerOffset = Math.max(0, activeIndex - 1) * dotOffset;
  container.style.transform = `translateX(-${centerOffset}px)`;
}

function updateNavButtons(activeIndex) {
  const prevIndex = (activeIndex - 1 + totalSlides) % totalSlides;
  prevBtn.disabled = prevIndex === firstDisabledIndex;
  prevBtn.style.opacity = prevBtn.disabled ? 0.5 : 1;
  prevBtn.style.cursor = prevBtn.disabled ? 'not-allowed' : 'pointer';

  const nextIndex = (activeIndex + 1) % totalSlides;
  nextBtn.disabled = nextIndex === lastDisabledIndex;
  nextBtn.style.opacity = nextBtn.disabled ? 0.5 : 1;
  nextBtn.style.cursor = nextBtn.disabled ? 'not-allowed' : 'pointer';
}

function updateDragDirection(index) {
  allowDragLeft = index !== 1;   // index 1 (2nd slide) → no left
  allowDragRight = index !== 14; // index 14 → no right
}

nextBtn.addEventListener('click', () => {
  if (!nextBtn.disabled) swiper.slideNext();
});
prevBtn.addEventListener('click', () => {
  if (!prevBtn.disabled) swiper.slidePrev();
});

let startX = 0;
let isDragging = false;
let lockSlide = false;

const paginationContainer = document.querySelector('.custom-pagination');

paginationContainer.addEventListener('mousedown', (e) => {
  startX = e.clientX;
  isDragging = true;
});
document.addEventListener('mousemove', (e) => {
  if (!isDragging || lockSlide) return;

  const diff = e.clientX - startX;
  if (Math.abs(diff) > 50) {
    if (diff < 0 && allowDragRight) {
      lockSlide = true;
      swiper.slideNext();
    } else if (diff > 0 && allowDragLeft) {
      lockSlide = true;
      swiper.slidePrev();
    }
    setTimeout(() => (lockSlide = false), 400);
    startX = e.clientX;
  }
});
document.addEventListener('mouseup', () => {
  isDragging = false;
  lockSlide = false;
});

paginationContainer.addEventListener('touchstart', (e) => {
  startX = e.touches[0].clientX;
  isDragging = true;
});
paginationContainer.addEventListener('touchmove', (e) => {
  if (!isDragging || lockSlide) return;

  const diff = e.touches[0].clientX - startX;
  if (Math.abs(diff) > 50) {
    if (diff < 0 && allowDragRight) {
      lockSlide = true;
      swiper.slideNext();
    } else if (diff > 0 && allowDragLeft) {
      lockSlide = true;
      swiper.slidePrev();
    }
    setTimeout(() => (lockSlide = false), 400);
    startX = e.touches[0].clientX;
  }
});
paginationContainer.addEventListener('touchend', () => {
  isDragging = false;
  lockSlide = false;
});

// ----------------------------------------------------------------------------------------------------------------------




