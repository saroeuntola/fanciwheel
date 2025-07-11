<?php
include './admin/page/library/game_lib.php';
include './admin/page/library/category_lib.php'; 
include './admin/page/library/db.php';
$gameObj = new Games();
$categoryObj = new Category();

// Get all categories
$categories = $categoryObj->getCategories();

// Check if a category is selected
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

// Get games (filter if category is selected)
if ($selectedCategory) {
    $games = array_filter($gameObj->getgames(), function($g) use ($selectedCategory) {
        return $g['category_id'] == $selectedCategory;
    });
} else {
    $games = $gameObj->getgames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- Title for search engines -->
  <title>FancyWheel - Spin & Win Real Rewards Instantly!</title>

  <!-- Meta description for Google -->
  <meta name="description" content="Spin the FancyWheel and win real cash rewards instantly. No sign-up required — just pure luck and fun! Try your fortune now.">

  <!-- Canonical URL -->
  <link rel="canonical" href="https://fanciwheel.com" />

  <!-- Open Graph (for Facebook, LinkedIn, etc.) -->
  <meta property="og:title" content="FancyWheel - Spin & Win Real Rewards!" />
  <meta property="og:description" content="Spin the lucky wheel and win exciting prizes instantly. It’s fun, fast, and free to play." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://fanciwheel.com" />
  <meta property="og:image" content="https://fanciwheel.com/assets/og-image.jpg" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="FancyWheel - Spin & Win Real Rewards!" />
  <meta name="twitter:description" content="Try your luck on FancyWheel and win instant rewards. Spin now!" />
  <meta name="twitter:image" content="https://fanciwheel.com/assets/og-image.jpg" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>


<style>
  /* Line clamp utilities */
  .line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Custom scrollbar for select */
  select::-webkit-scrollbar {
    width: 8px;
  }
  
  select::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
  }
  
  select::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  
  select::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }

  /* Enhanced hover effects */
  .group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
  }

  /* Smooth transitions */
  * {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
  }

  /* Backdrop blur fallback */
  @supports not (backdrop-filter: blur(12px)) {
    .backdrop-blur-sm {
      background-color: rgba(255, 255, 255, 0.8);
    }
  }

  /* Loading animation for images */
  img {
    transition: opacity 0.3s ease;
  }

  img:not([src]) {
    opacity: 0;
  }

  /* Focus styles for accessibility */
  select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
  }

  /* Custom animation for shine effect */
  @keyframes shine {
    0% {
      transform: translateX(-200%) skewX(-12deg);
    }
    100% {
      transform: translateX(200%) skewX(-12deg);
    }
  }

  /* Gradient animations */
  @keyframes gradient-x {
    0%, 100% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
  }

  .animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 3s ease infinite;
  }
</style>
<body>
  <nav class="w-full shadow-md sticky top-0 z-50">
    <!-- Include Navbar -->
  <?php include 'navbar.php'; ?>
  </nav>
  <?php 
    include 'loading.php';
  ?>
<!-- Banner Slideshow -->
<?php include 'cover.php'; ?>
<div class="mb-10">

</div>

<div class="w-full flex justify-center mt-4 sm:mt-0">
  <div class="flex flex-wrap justify-center gap-2">
    <!-- 'All' Button -->
    <a href="?category=" class="px-4 py-2 rounded-xl shadow-md text-sm font-medium transition-all duration-300 
      <?= empty($selectedCategory) ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-300 hover:bg-blue-50' ?>">
      All
    </a>

    <?php foreach ($categories as $cat): ?>
      <a href="?category=<?= $cat['id'] ?>"
         class="px-4 py-2 rounded-xl shadow-md text-sm font-medium transition-all duration-300 
           <?= $selectedCategory == $cat['id'] ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-300 hover:bg-blue-50' ?>">
        <?= htmlspecialchars($cat['name']) ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
<!-- Modern Game Grid Section -->

<div class="lg:px-20">
<?php 
  include 'card.php';
?>
</div>


<?php include 'footer.php';?>
<!-- Spin Wheel Modal -->
<div id="spinModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-purple-800 rounded-2xl shadow-2xl p-6 w-[360px] h-[360px] relative flex flex-col items-center">
    <!-- Close Button -->
    <button onclick="closeSpinModal()" 
      class="absolute top-4 right-4 text-white hover:text-red-600 text-2xl font-bold transition">&times;</button>

    <!-- Wheel Container -->
    <div class="relative w-72 h-72 mt-2">
      <canvas id="wheelCanvas" width="288" height="288" class="rounded-full shadow-lg"></canvas>
      
      <!-- Needle -->
      <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-0 h-0 text-red-600 
                  border-l-[12px] border-r-[12px] border-t-[30px] 
                  border-l-transparent border-r-transparent border-b-red-600 z-20 drop-shadow-lg"></div>

      <!-- Spin Button -->
      <button id="spinBtn" 
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
               bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold px-6 py-3 rounded-full 
               shadow-lg hover:from-purple-700 hover:to-indigo-700 active:scale-95 transition-transform">
        SPIN
      </button>

      <!-- Prize Message -->
      <div id="prizeMessage" 
        class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white text-gray-900 
               p-4 rounded-xl shadow-xl text-center w-64 hidden z-30 select-none">
        <p class="font-extrabold text-xl mb-2" id="prizeText"></p>
        <p class="font-extrabold text-xl mb-2">join with us now to claim</p>
        <a href="https://fwsuperace.xyz/kh/en" 
          class="inline-block bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold 
                 hover:bg-indigo-700 transition">
          Join Now
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  const canvas = document.getElementById('wheelCanvas');
  const ctx = canvas.getContext('2d');
  const spinBtn = document.getElementById('spinBtn');
  const prizeMessage = document.getElementById('prizeMessage');
  const prizeText = document.getElementById('prizeText');

  const prizes = ["20$", "100$", "1$", "50$", "0$", "1000$", "10$", "5$"];
  const colors = ["#f87171", "#a78bfa", "#60a5fa", "#34d399", "#fbbf24", "#f472b6", "#818cf8", "#22d3ee"];

  const segments = prizes.length;
  const segmentAngle = 2 * Math.PI / segments;

  let startAngle = 0;
  let spinTimeout = null;
  let spinAngleStart = 0;
  let spinTime = 0;
  let spinTimeTotal = 0;

  function drawWheel() {
    for (let i = 0; i < segments; i++) {
      const angle = startAngle + i * segmentAngle;
      ctx.beginPath();
      ctx.fillStyle = colors[i];
      ctx.moveTo(canvas.width / 2, canvas.height / 2);
      ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2 - 10, angle, angle + segmentAngle, false);
      ctx.lineTo(canvas.width / 2, canvas.height / 2);
      ctx.fill();

      // Draw prize text
      ctx.save();
      ctx.fillStyle = "#fff";
      ctx.translate(canvas.width / 2, canvas.height / 2);
      ctx.rotate(angle + segmentAngle / 2);
      ctx.textAlign = "right";
      ctx.font = "bold 18px Arial";
      ctx.fillText(prizes[i], canvas.width / 2 - 20, 10);
      ctx.restore();
    }
  }

  function rotateWheel(angle) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.save();
    ctx.translate(canvas.width / 2, canvas.height / 2);
    ctx.rotate(angle);
    ctx.translate(-canvas.width / 2, -canvas.height / 2);
    drawWheel();
    ctx.restore();
  }

  function easeOut(t, b, c, d) {
    const ts = (t /= d) * t;
    const tc = ts * t;
    return b + c * (tc + -3 * ts + 3 * t);
  }

  function spin() {
    spinBtn.disabled = true;
    prizeMessage.classList.add("hidden");

    spinAngleStart = Math.random() * 4000 + 5000; // random total spin angle
    spinTime = 0;
    spinTimeTotal = Math.random() * 5000 + 6000; // spin duration

    rotate();
  }

  function rotate() {
    spinTime += 16;
    if (spinTime >= spinTimeTotal) {
      stopRotateWheel();
      return;
    }

    const angle = easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
    rotateWheel(angle * Math.PI / 180);
    spinTimeout = setTimeout(rotate, 16); // 60fps
  }

  function stopRotateWheel() {
  clearTimeout(spinTimeout);

  const finalAngle = easeOut(spinTimeTotal, 0, spinAngleStart, spinTimeTotal);
  const degrees = finalAngle % 360;

  // Adjust based on the pointer being at 270 degrees (top of the canvas)
  const adjustedDegrees = (360 - degrees + 270) % 360;

  const index = Math.floor(adjustedDegrees / (360 / prizes.length)) % prizes.length;

  prizeText.textContent = `🎉 You won: ${prizes[index]}!`;
  prizeMessage.classList.remove("hidden");
  spinBtn.disabled = false;
}

  spinBtn.addEventListener("click", spin);

  window.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
      document.getElementById("spinModal").classList.remove("hidden");
      rotateWheel(0); // Draw the wheel initially
    }, 500);
  });

  function closeSpinModal() {
    document.getElementById("spinModal").classList.add("hidden");
  }
</script>

<script>
  // Example banner images (update with your real URLs)
  const banners = [
    'https://store-images.s-microsoft.com/image/apps.46648.13839736556320994.df80f16e-5cb1-44e6-8aeb-c2921556326d.71fe5692-88db-490e-b495-7dc79da34c03',
    'https://images.sftcdn.net/images/t_app-cover-s-16-9,f_auto/p/19c18f31-37e6-4809-a6ed-3d4e6ed50959/3781302577/lucky-winner-tsx-screenshot',
    'https://via.placeholder.com/1200x400/059669/FFFFFF?text=Game+3',
    'https://via.placeholder.com/1200x400/F59E0B/FFFFFF?text=Game+4'
  ];
  const slideImage = document.getElementById('slide-image');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');

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
  nextBtn.addEventListener('click', () => {
    stopAutoSlide();
    nextSlide();
    startAutoSlide();
  });

  prevBtn.addEventListener('click', () => {
    stopAutoSlide();
    prevSlide();
    startAutoSlide();
  });
</script>

<style>
  /* Optional custom styles */
  #spinModal {
    backdrop-filter: blur(5px);
  }
</style>

</body>
</html>