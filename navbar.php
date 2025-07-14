<?php
session_start();
include './admin/page/library/users_lib.php';
include './admin/page/library/brand_lib.php';
include $_SERVER['DOCUMENT_ROOT'] . '/spinwheel/config/baseURL.php';
$auth = new User();
$brand = new Brand();

$username = $_SESSION['username'] ?? '';
$userId = $_SESSION['user_id'] ?? null;

$brandList = $brand->getBrand();
$user = null;

// Get user
if ($userId) {
  $userLib = new User();
  $user = $userLib->getUserByID($userId);
}

// Build profile image path
$profileImage = isset($user['profile']) && !empty($user['profile']) ? $user['profile'] : 'default.png';
$profilePath = $baseURL . '/admin/page/user/user_image/' . htmlspecialchars($profileImage);

// Check if file exists on server
$fullPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/page/user/user_image/' . $profileImage;
if (!file_exists($fullPath)) {
  $profilePath = $baseURL . '/admin/page/user/user_image/default.png';
}
?>


<!-- Modern Navbar with Glassmorphism Effect -->
<nav class="relative bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 backdrop-blur-md shadow-2xl border-b border-white/10">
  <!-- Background Pattern -->
  <div class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.1)_1px,transparent_0)] bg-[size:20px_20px] opacity-20"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <div class="flex justify-between items-center h-16">
      
      <div class="flex-shrink-0">
        <a href="index.php" class="group relative">
          <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent transition-all duration-300 group-hover:scale-105">
            FancyWheel
          </span>
          <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-lg opacity-0 group-hover:opacity-20 blur transition-all duration-300"></div>
        </a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden lg:flex items-center space-x-8">
        <!-- Navigation Links -->
        <a href="index.php" class="relative text-white/90 hover:text-white transition-all duration-300 group">
          <span class="relative z-10">Home</span>
          <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-pink-500/0 group-hover:from-blue-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 rounded-lg transition-all duration-300"></div>
        </a>
        <a href="about.php" class="relative text-white/90 hover:text-white transition-all duration-300 group">
          <span class="relative z-10">About</span>
          <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-pink-500/0 group-hover:from-blue-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 rounded-lg transition-all duration-300"></div>
        </a>
        <a href="#" class="relative text-white/90 hover:text-white transition-all duration-300 group">
          <span class="relative z-10">Services</span>
          <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-pink-500/0 group-hover:from-blue-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 rounded-lg transition-all duration-300"></div>
        </a>
        <a href="#" class="relative text-white/90 hover:text-white transition-all duration-300 group">
          <span class="relative z-10">Contact</span>
          <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-pink-500/0 group-hover:from-blue-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 rounded-lg transition-all duration-300"></div>
        </a>
        <!-- Modern Search Bar -->
        <form action="search.php" method="GET" class="relative group">
          <div class="relative">
            <input type="text" name="q" placeholder="Search..."
              class="w-64 px-4 py-2 pl-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 focus:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>
            <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/60 hover:text-white transition-colors duration-300">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
              </svg>
            </button>
          </div>
        </form>
        <!-- Desktop Profile -->
        <?php if ($userId): ?>
          <div class="relative">
            <button id="profileMenuBtn" class="group flex items-center gap-2 px-3 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
              <img src="<?= $profilePath ?>"
                alt=""
                title="<?= htmlspecialchars($username) ?>"
                class="w-8 h-8 object-cover rounded-full border-2 border-white/30 group-hover:border-white/60 transition-all duration-300">
              <span class="text-white/90 text-sm font-medium group-hover:text-white transition-colors duration-300"><?= htmlspecialchars(substr($username, 0, 8)) ?></span>
              <svg class="w-4 h-4 text-white/60 group-hover:text-white transition-all duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-slate-800/95 backdrop-blur-lg border border-slate-700/50 text-white rounded-xl shadow-2xl hidden z-[9999] overflow-hidden">
              <div class="py-1">
                <a href="<?= $baseURL ?>/admin/page/user/profile.php" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-700/50 transition-all duration-200">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  <span>Profile</span>
                </a>
                <div class="border-t border-slate-700/50 my-1"></div>
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  <span>Logout</span>
                </a>
              </div>
            </div>
          </div>
        <?php else: ?>
          <a href="login.php" class="relative group px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
            <span class="relative z-10 font-medium">GET START</span>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full opacity-0 group-hover:opacity-20 blur transition-all duration-300"></div>
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Toggle + Profile -->
    <!-- Mobile Toggle + Profile -->
<div class="lg:hidden flex items-center gap-3 relative">
  <?php if ($userId): ?>
    <button id="mobileProfileBtn" class="relative p-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-300 focus:outline-none">
      <img src="<?= $profilePath ?>" 
        alt="Profile" 
        title="<?= htmlspecialchars($username) ?>"
        class="w-8 h-8 object-cover rounded-full border-2 border-white/30">
    </button>
    <!-- Mobile Profile Dropdown -->
    <div id="mobileProfileDropdown" class="absolute right-12 top-12 w-48 bg-slate-800/95 backdrop-blur-lg border border-slate-700/50 text-white rounded-xl shadow-2xl hidden z-[9999] overflow-hidden">
      <div class="py-1">
        <a href="<?= $baseURL ?>/admin/page/user/profile.php" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-700/50 transition-all duration-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <span>Profile</span>
        </a>
        <div class="border-t border-slate-700/50 my-1"></div>
        <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span>Logout</span>
        </a>
      </div>
    </div>
  <?php else: ?>
    <a href="login.php" class="p-2 text-white/90 hover:text-white rounded-full hover:bg-white/10 transition-all duration-300">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
      </svg>
    </a>
  <?php endif; ?>

  <!-- Modern Hamburger Toggle -->
  <button onclick="toggleMenu()" class="relative p-2 text-white focus:outline-none group" aria-label="Toggle Menu">
    <div class="absolute inset-0 bg-white/10 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
    <svg id="hamburgerIcon" class="w-6 h-6 relative z-10 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
  </button>
</div>
    </div>
  </div>

  <!-- Modern Mobile Menu -->
  <div id="mobileMenu" class="lg:hidden hidden bg-slate-900/95 backdrop-blur-lg border-t border-white/10">
    <div class="px-4 py-6 space-y-3">
      <a href="index.php" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span>Home</span>
      </a>
      <a href="about.php" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>About</span>
      </a>
      <a href="service.php" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <span>Services</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <span>Contact</span>
      </a>
      <form action="search.php" method="GET" class="relative group">
          <div class="relative">
            <input type="text" name="q" placeholder="Search..."
              class="w-full px-4 py-2 pl-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>
            <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/60 hover:text-white transition-colors duration-300">
              <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
              </svg>
            </button>
          </div>
        </form>
    </div>
  </div>
</nav>

<!-- JavaScript for Navbar Interactions -->
<script>
  function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    
    menu.classList.toggle('hidden');
    hamburgerIcon.classList.toggle('rotate-90');
  }

  // Desktop profile dropdown with enhanced interactions
  const profileBtn = document.getElementById('profileMenuBtn');
  const profileDropdown = document.getElementById('profileDropdown');
  if (profileBtn && profileDropdown) {
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileDropdown.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.add('hidden');
      }
    });
    
    // Close dropdown on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !profileDropdown.classList.contains('hidden')) {
        profileDropdown.classList.add('hidden');
      }
    });
  }

  // Mobile profile dropdown with enhanced interactions
  const mobileProfileBtn = document.getElementById('mobileProfileBtn');
  const mobileProfileDropdown = document.getElementById('mobileProfileDropdown');
  if (mobileProfileBtn && mobileProfileDropdown) {
    mobileProfileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      mobileProfileDropdown.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!mobileProfileBtn.contains(e.target) && !mobileProfileDropdown.contains(e.target)) {
        mobileProfileDropdown.classList.add('hidden');
      }
    });
    
    // Close dropdown on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !mobileProfileDropdown.classList.contains('hidden')) {
        mobileProfileDropdown.classList.add('hidden');
      }
    });
  }

  // Enhanced search bar interactions
  const searchInput = document.querySelector('input[name="q"]');
  if (searchInput) {
    searchInput.addEventListener('focus', () => {
      searchInput.parentElement.classList.add('ring-2', 'ring-purple-500');
    });
    
    searchInput.addEventListener('blur', () => {
      searchInput.parentElement.classList.remove('ring-2', 'ring-purple-500');
    });
  }

  // Add smooth scroll behavior for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
</script>

<style>
  /* Custom gradient animations */
  @keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .animate-gradient {
    background-size: 200% 200%;
    animation: gradient-shift 4s ease infinite;
  }

  /* Enhanced focus styles */
  .focus-visible:focus {
    outline: 2px solid #8b5cf6;
    outline-offset: 2px;
  }

  /* Smooth transitions for all interactive elements */
  * {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
  }

  /* Enhanced hover effects */
  .hover-lift:hover {
    transform: translateY(-2px);
  }

  /* Backdrop blur fallback */
  @supports not (backdrop-filter: blur(12px)) {
    .backdrop-blur-md {
      background-color: rgba(30, 41, 59, 0.8);
    }
    .backdrop-blur-lg {
      background-color: rgba(30, 41, 59, 0.9);
    }
  }
</style>