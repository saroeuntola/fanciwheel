const banners = [
  "https://store-images.s-microsoft.com/image/apps.46648.13839736556320994.df80f16e-5cb1-44e6-8aeb-c2921556326d.71fe5692-88db-490e-b495-7dc79da34c03",
  "https://images.sftcdn.net/images/t_app-cover-s-16-9,f_auto/p/19c18f31-37e6-4809-a6ed-3d4e6ed50959/3781302577/lucky-winner-tsx-screenshot",
  "https://via.placeholder.com/1200x400/059669/FFFFFF?text=Game+3",
  "https://via.placeholder.com/1200x400/F59E0B/FFFFFF?text=Game+4",
];
const slideImage = document.getElementById("slide-image");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

let currentIndex = 0;
let slideInterval;

function showSlide(index) {
  slideImage.src = banners[index];
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % banners.length;
  showSlide(currentIndex);
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + banners.length) % banners.length;
  showSlide(currentIndex);
}

// Auto slide every 5 seconds
function startAutoSlide() {
  slideInterval = setInterval(nextSlide, 5000);
}

function stopAutoSlide() {
  clearInterval(slideInterval);
}

// Initialize
showSlide(currentIndex);
startAutoSlide();

// Add event listeners
nextBtn.addEventListener("click", () => {
  stopAutoSlide();
  nextSlide();
  startAutoSlide();
});

prevBtn.addEventListener("click", () => {
  stopAutoSlide();
  prevSlide();
  startAutoSlide();
});
