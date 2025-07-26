<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cold Slideshow</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #ECEFF1;
    }

.slideshow-container {
 
  position: relative;
  width: 80%;
  height: 400px;
  max-width: 1200px;
  max-height: 400px;
  overflow: hidden;
  background-color: #B3E5FC;
  margin: 30px auto; /* Center the container horizontally */
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 15px;
}


    .slide-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: opacity 0.7s ease-in-out, transform 0.7s ease-in-out;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      z-index: 0;
    }

    .slide-image.active {
      opacity: 1;
      z-index: 1;
    }

    .nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.8);
      border: none;
      padding: 12px;
      border-radius: 50%;
      color: #263238;
      font-size: 1.2rem;
      cursor: pointer;
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
    }

    .dot.active {
      background: #B3E5FC;
    }

   @media (max-width: 768px) {
  .slideshow-container {
    width: 95%;
    height: 300px;
  }
}

@media (max-width: 480px) {
  .slideshow-container {
    height: 240px;
  }
}

  </style>
</head>
<body>

<section class="slideshow-container">
  <div id="slide-container">
    <img class="slide-image active" src="./image/fancywin-banner.webp" alt="Slide 1">
    <img class="slide-image" src="./image/1200x400_Slots_&_Fishing_30_.png" alt="Slide 2">
    <img class="slide-image" src="./image/1200x400_Slots_WB_150_.png" alt="Slide 3">
  </div>

  <button id="prevBtn" class="nav-btn"><i class="fas fa-chevron-left"></i></button>
  <button id="nextBtn" class="nav-btn"><i class="fas fa-chevron-right"></i></button>
  <div class="dots-container" id="dots"></div>
</section>

<script>
  const slides = document.querySelectorAll('.slide-image');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsContainer = document.getElementById('dots');
  let currentSlide = 0;
  const totalSlides = slides.length;

  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('span');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
  }

  const dots = document.querySelectorAll('.dot');

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

  function goToSlide(index) {
    currentSlide = (index + totalSlides) % totalSlides;
    showSlide(currentSlide);
  }

  function nextSlide() {
    goToSlide(currentSlide + 1);
  }

  function prevSlide() {
    goToSlide(currentSlide - 1);
  }

  nextBtn.addEventListener('click', nextSlide);
  prevBtn.addEventListener('click', prevSlide);

  let autoSlide = setInterval(nextSlide, 5000);

  document.querySelector('.slideshow-container').addEventListener('mouseenter', () => {
    clearInterval(autoSlide);
  });

  document.querySelector('.slideshow-container').addEventListener('mouseleave', () => {
    autoSlide = setInterval(nextSlide, 4000);
  });

  showSlide(currentSlide);
</script>

</body>
</html>
