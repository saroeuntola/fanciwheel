<?php
  include "./admin/page/library/banner_lib.php";
 $bannerObj = new Banner();
  $banners = $bannerObj->getBanner();
  if (!$banners) {
    echo "No banners found.";
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Cold Slideshow</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #ECEFF1; /* Light gray background for cold vibe */
    }

    /* Slideshow Container */
    .slideshow-container {
      position: relative;
      width: 100%;
      height: 400px;
      overflow: hidden;
      margin-bottom: 2.5rem;
      background-color: #B3E5FC; /* Light icy blue fallback */
    }

    /* Slide Image */
    .slide-image {
      width: 100%; /* Fixed width for larger images */
      height: 100%;
      /* object-fit: cover; */
      transition: opacity 0.7s ease-in-out, transform 0.7s ease-in-out;
      position: absolute;
      top: 0;
      left: 0;
    }

    .slide-image.active {
      opacity: 1;
      transform: scale(1);
    }

    /* Frosted Glass Overlay for Cold Effect */
  

    /* Navigation Buttons */
    .nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.8); /* Frosted glass effect */
      border: none;
      padding: 12px;
      border-radius: 50%;
      color: #263238; /* Dark gray for contrast */
      font-size: 1.2rem;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      z-index: 2;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .nav-btn:hover {
      background: rgba(255, 255, 255, 1);
      transform: translateY(-50%) scale(1.1);
    }

    #prevBtn {
      left: 1rem;
    }

    #nextBtn {
      right: 1rem;
    }

    /* Navigation Dots */
    .dots-container {
      position: absolute;
      bottom: 1rem;
      width: 100%;
      text-align: center;
      z-index: 2;
    }

    .dot {
      display: inline-block;
      width: 10px;
      height: 10px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      margin: 0 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .dot.active {
      background: #B3E5FC; /* Icy blue for active dot */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .slideshow-container {
        height: 300px;
      }

      .nav-btn {
        padding: 10px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Banner Slideshow -->
  <section class="slideshow-container">
  <div id="slide-container">
    <?php foreach ($banners as $i => $banner): ?>
      <img 
        class="slide-image<?= $i === 0 ? ' active' : '' ?>" 
        src="<?='/spinwheel/admin/page/banner/' . htmlspecialchars($banner['image']) ?>" 
        alt="Banner <?= $i + 1 ?>">
    <?php endforeach; ?>
  </div>

  <!-- Prev Button -->
  <button id="prevBtn" class="nav-btn">
    <i class="fas fa-chevron-left"></i>
  </button>
  <!-- Next Button -->
  <button id="nextBtn" class="nav-btn">
    <i class="fas fa-chevron-right"></i>
  </button>
  
  <!-- Navigation Dots -->
  <div class="dots-container" id="dots"></div>
</section>


  <script>
    const slides = document.querySelectorAll('.slide-image');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dots');
    let currentSlide = 0;
    const totalSlides = slides.length;

    // Create navigation dots
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement('span');
      dot.classList.add('dot');
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => goToSlide(i));
      dotsContainer.appendChild(dot);
    }

    const dots = document.querySelectorAll('.dot');

    // Show slide
    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
        dots[i].classList.remove('active');
        if (i === index) {
          slide.classList.add('active');
          dots[i].classList.add('active');
        }
      });
    }

    // Go to specific slide
    function goToSlide(index) {
      currentSlide = (index + totalSlides) % totalSlides;
      showSlide(currentSlide);
    }

    // Next slide
    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    // Previous slide
    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    // Event listeners for buttons
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Auto-slide every 5 seconds
    let autoSlide = setInterval(nextSlide, 5000);

    // Pause auto-slide on hover
    document.querySelector('.slideshow-container').addEventListener('mouseenter', () => {
      clearInterval(autoSlide);
    });

    document.querySelector('.slideshow-container').addEventListener('mouseleave', () => {
      autoSlide = setInterval(nextSlide, 4000);
    });

    // Initialize first slide
    showSlide(currentSlide);
  </script>
</body>
</html>