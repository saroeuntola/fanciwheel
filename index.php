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

  <link rel="icon" href="https://img.f369w.com/fw/h5/assets/images/icons/PWAicon-192px.png?v=1753166904845" type="image/png">
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
<body class="bg-gray-900 text-white">
  <nav class="w-full shadow-md sticky top-0 z-50 bg-gray-800">
    <?php include 'navbar.php'; ?>
  </nav>

  <?php include 'loading.php'; ?>
  <?php include 'slideshow.php'; ?>
  <?php include 'scroll-top-button.php'; ?>

  <?php
    include 'games-grid.php'
  ?>
  <div class="mb-10"></div>

  <!-- Category Buttons -->
  <div class="w-full flex justify-center mt-4 sm:mt-0">
    <div class="flex flex-wrap justify-center gap-2">
      <!-- 'All' Button -->
      <a href="?category=" class="px-4 py-2 rounded-xl shadow-md text-sm font-medium transition-all duration-300 
        <?= empty($selectedCategory) ? 'bg-blue-600 text-white' : 'bg-gray-800 text-white border border-slate-500 hover:bg-blue-600' ?>">
        All
      </a>
      <?php foreach ($categories as $cat): ?>
        <a href="?category=<?= $cat['id'] ?>"
           class="px-4 py-2 rounded-xl shadow-md text-sm font-medium transition-all duration-300 
             <?= $selectedCategory == $cat['id'] ? 'bg-blue-600 text-white' : 'bg-gray-800 text-white border border-slate-500 hover:bg-blue-600' ?>">
          <?= htmlspecialchars($cat['name']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Cards Section -->
  <div class="lg:px-20 mt-6">
    <?php include 'card.php'; ?>
  </div>

  <?php include 'footer.php'; ?>
  <?php include 'spin-popup.php'; ?>
</body>

</html>