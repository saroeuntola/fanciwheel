<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fish Shooting Game with Fire Limit</title>
  <link rel="icon" type="image/png" href="./img/fish.png">
<style>
  body {
    margin: 0;
    background: linear-gradient(to bottom, #004d66, #99d6ff);
    overflow: hidden;
    user-select: none;
    font-family: Arial, sans-serif;
    color: white;
    text-align: center;
    padding: 10px;
  }

  canvas {
    display: block;
    margin: 0 auto;
    background: #003344;
    border: 2px solid #0077aa;
    border-radius: 10px;
    max-width: 100%;
    height: auto;
  }

  #scoreboard, #shotsLeft {
    font-size: 22px;
    font-weight: bold;
    text-shadow: 0 0 5px #00ffff;
    display: inline-block;
    margin: 5px 10px;
  }

  #resetBtn {
    margin-top: 12px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 6px;
    border: none;
    background: #00aaff;
    color: white;
    box-shadow: 0 0 10px #00ccff;
  }

  #resetBtn:hover {
    background: #0077aa;
  }

  #message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 48px;
    font-weight: 900;
    color: #00ffcc;
    text-shadow: 0 0 20px #00ffcc;
    display: none;
    user-select: none;
    z-index: 9999;
  }

  p {
    font-size: 15px;
    color: #003344;
    font-weight: bold;
    margin: 15px auto;
    max-width: 90%;
  }

  a {
    color: #003344;
    text-decoration: underline;
  }

  /* 📱 Mobile Styles */
  @media (max-width: 768px) {
    #scoreboard, #shotsLeft {
      font-size: 18px;
    }

    #resetBtn {
      padding: 8px 16px;
      font-size: 14px;
    }

    #message {
      font-size: 32px;
    }

    canvas {
      width: 100%;
      height: auto;
    }
  }

  @media (max-width: 480px) {
    #scoreboard, #shotsLeft {
      font-size: 16px;
    }

    #resetBtn {
      padding: 6px 12px;
      font-size: 12px;
    }

    #message {
      font-size: 24px;
    }
  }
</style>


</head>
<body>
<?php 
  include '../loading.php'
?>
  <div>
    <span id="scoreboard">Score: 0</span>
    <span id="shotsLeft">Shots Left: 20</span>
  </div>
  <canvas id="gameCanvas" width="800" height="600"></canvas>
  <button id="resetBtn">Restart Game</button>

  <div id="message"></div>
 <p>
  Join us now to play exciting games and win real money — with safe and secure payments!
  <a href="https://fancywin.city/kh/en" target="_blank" style="color: #003344; text-decoration: underline; margin-left: 5px;">
    Visit our partner site
  </a>
</p>
<script>
(() => {
  const canvas = document.getElementById('gameCanvas');
  const ctx = canvas.getContext('2d');

  const scoreBoard = document.getElementById('scoreboard');
  const shotsLeftSpan = document.getElementById('shotsLeft');
  const resetBtn = document.getElementById('resetBtn');
  const messageDiv = document.getElementById('message');

  const CANVAS_WIDTH = canvas.width;
  const CANVAS_HEIGHT = canvas.height;

  // Game variables
  let score = 0;
  let fishes = [];
  let bullets = [];
  let gameRunning = true;
  let escapedFishCount = 0;

  const MAX_ESCAPED_FISH = 10;    // Lose if 10 fish escape
  const TARGET_SCORE = 100;       // Win if score reaches 100
  const MAX_SHOTS = 25;           // Max bullets player can fire

  let shotsLeft = MAX_SHOTS;

  // Fish types with different speed and points
  const fishTypes = [
    {color: '#ff6347', speed: 1.5, points: 10, size: 40},
    {color: '#00ff99', speed: 1, points: 20, size: 50},
    {color: '#3399ff', speed: 2, points: 5, size: 30},
  ];

  // Cannon properties
  const cannon = {
    x: CANVAS_WIDTH / 2,
    y: CANVAS_HEIGHT - 40,
    width: 60,
    height: 40,
    color: '#ffaa00',
  };

  // Bullet properties
  const bulletSpeed = 5;
  const bulletRadius = 5;
function resizeCanvas() {
  const ratio = 4 / 3;
  const width = Math.min(window.innerWidth - 20, 800);
  canvas.width = width;
  canvas.height = width / ratio;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

  // Utility: random int between min and max
  function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  // Fish class
  class Fish {
    constructor() {
      this.type = fishTypes[randomInt(0, fishTypes.length - 1)];
      this.size = this.type.size;
      this.x = Math.random() < 0.5 ? -this.size : CANVAS_WIDTH + this.size; 
      this.y = randomInt(50, CANVAS_HEIGHT - 150);
      this.speed = this.type.speed;
      this.direction = this.x < 0 ? 1 : -1;
      this.color = this.type.color;
      this.points = this.type.points;
      this.isDead = false;
      this.escaped = false;
    }

    update() {
      this.x += this.speed * this.direction;

      if (!this.isDead && !this.escaped) {
        if (this.direction === 1 && this.x - this.size > CANVAS_WIDTH) {
          this.escaped = true;
          escapedFishCount++;
          checkLoseCondition();
        }
        if (this.direction === -1 && this.x + this.size < 0) {
          this.escaped = true;
          escapedFishCount++;
          checkLoseCondition();
        }
      }
    }

    draw(ctx) {
      ctx.fillStyle = this.color;
      ctx.beginPath();
      ctx.ellipse(this.x, this.y, this.size * 0.7, this.size * 0.4, 0, 0, Math.PI * 2);
      ctx.fill();

      ctx.beginPath();
      if (this.direction === 1) {
        ctx.moveTo(this.x - this.size * 0.7, this.y);
        ctx.lineTo(this.x - this.size, this.y - this.size * 0.3);
        ctx.lineTo(this.x - this.size, this.y + this.size * 0.3);
      } else {
        ctx.moveTo(this.x + this.size * 0.7, this.y);
        ctx.lineTo(this.x + this.size, this.y - this.size * 0.3);
        ctx.lineTo(this.x + this.size, this.y + this.size * 0.3);
      }
      ctx.closePath();
      ctx.fill();

      ctx.fillStyle = 'white';
      let eyeX = this.x + this.size * 0.3 * this.direction;
      let eyeY = this.y - this.size * 0.1;
      ctx.beginPath();
      ctx.arc(eyeX, eyeY, this.size * 0.1, 0, Math.PI * 2);
      ctx.fill();
      ctx.fillStyle = 'black';
      ctx.beginPath();
      ctx.arc(eyeX, eyeY, this.size * 0.05, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  // Bullet class
  class Bullet {
    constructor(x, y) {
      this.x = x;
      this.y = y;
      this.radius = bulletRadius;
      this.speed = bulletSpeed;
      this.active = true;
    }

    update() {
      this.y -= this.speed;
      if (this.y < 0) this.active = false;
    }

    draw(ctx) {
      ctx.fillStyle = '#ffff00';
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  // Spawn fishes periodically
  function spawnFish() {
    if (!gameRunning) return;
    fishes.push(new Fish());
    setTimeout(spawnFish, 1500);
  }

  // Collision check
  function checkCollision(bullet, fish) {
    const dx = bullet.x - fish.x;
    const dy = bullet.y - fish.y;
    const distance = Math.sqrt(dx * dx + dy * dy);
    return distance < fish.size * 0.7 + bullet.radius;
  }

  // Draw cannon
  function drawCannon() {
    ctx.fillStyle = cannon.color;
    ctx.beginPath();
    ctx.fillRect(cannon.x - cannon.width / 2, cannon.y, cannon.width, cannon.height);
    ctx.fillRect(cannon.x - 10, cannon.y - 30, 20, 30);
    ctx.beginPath();
    ctx.arc(cannon.x, cannon.y - 30, 10, 0, Math.PI * 2);
    ctx.fill();
  }

  // Show message (win/lose)
  function showMessage(text, color) {
    messageDiv.style.color = color || '#00ffcc';
    messageDiv.textContent = text;
    messageDiv.style.display = 'block';
  }

  // Check win condition
  function checkWinCondition() {
    if (score >= TARGET_SCORE) {
      gameRunning = false;
      showMessage('YOU WIN! 🎉', '#00ff00');
    }
  }

  // Check lose condition
  function checkLoseCondition() {
    if (escapedFishCount >= MAX_ESCAPED_FISH) {
      gameRunning = false;
      showMessage('YOU LOSE! 💀', '#ff3300');
    }
  }

  // Check lose condition when out of shots without winning
  function checkOutOfShots() {
    if (shotsLeft <= 0 && gameRunning) {
      gameRunning = false;
      showMessage('OUT OF SHOTS! YOU LOSE! 💥', '#ff6600');
    }
  }

  // Game loop
  function gameLoop() {
    ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);

    drawCannon();

    fishes.forEach(fish => {
      fish.update();
      fish.draw(ctx);
    });
    fishes = fishes.filter(fish => !fish.isDead && !fish.escaped);

    bullets.forEach(bullet => {
      bullet.update();
      bullet.draw(ctx);
    });
    bullets = bullets.filter(bullet => bullet.active);

    // Collision detection
    bullets.forEach(bullet => {
      fishes.forEach(fish => {
        if (!fish.isDead && bullet.active && checkCollision(bullet, fish)) {
          fish.isDead = true;
          bullet.active = false;
          score += fish.points;
          scoreBoard.textContent = `Score: ${score}`;
          checkWinCondition();
        }
      });
    });

    if (gameRunning) {
      requestAnimationFrame(gameLoop);
    }
  }

  // Shoot bullet on click
  canvas.addEventListener('click', () => {
    if (!gameRunning) return;
    if (shotsLeft > 0) {
      bullets.push(new Bullet(cannon.x, cannon.y - 30));
      shotsLeft--;
      shotsLeftSpan.textContent = `Shots Left: ${shotsLeft}`;
      if (shotsLeft === 0) {
        checkOutOfShots();
      }
    }
  });

  // Restart game
  function restartGame() {
    score = 0;
    escapedFishCount = 0;
    shotsLeft = MAX_SHOTS;
    scoreBoard.textContent = `Score: ${score}`;
    shotsLeftSpan.textContent = `Shots Left: ${shotsLeft}`;
    fishes = [];
    bullets = [];
    gameRunning = true;
    messageDiv.style.display = 'none';
    spawnFish();
    gameLoop();
  }

  resetBtn.addEventListener('click', () => {
    gameRunning = false;
    setTimeout(restartGame, 100);
  });

  // Start game
  spawnFish();
  gameLoop();

})();
</script>
</body>
</html>
