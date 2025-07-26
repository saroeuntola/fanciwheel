<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Spin Wheel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/png" href="./img/pngegg.png"> 
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: radial-gradient(#1f1f1f, #000000);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    h1 {
      font-size: 2em;
      margin-bottom: 10px;
      color: gold;
      text-shadow: 0 0 10px #ff0;
    }

    #wheelContainer {
      margin-top: 30px;
      position: relative;
      width: 350px;
      height: 350px;
      margin-bottom: 30px;
    }

    canvas {
      border-radius: 50%;
      background: #111;
      box-shadow: 0 0 30px gold;
    }

    .pointer {
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-left: 20px solid transparent;
      border-right: 20px solid transparent;
      border-top: 40px solid red;
      z-index: 3;
    }

    #spinBtn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 14px 28px;
      font-size: 18px;
      background: linear-gradient(to right, #d97706, #facc15);
      border: none;
      border-radius: 999px;
      cursor: pointer;
      font-weight: bold;
      color: #111;
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
      z-index: 2;
    }

    #prizeMessage {
      margin-top: 20px;
      font-size: 22px;
      font-weight: bold;
      color: #10b981;
      text-shadow: 0 0 10px #0f0;
    }
    p {
  font-size: 16px;
  color: #facc15;
  font-weight: bold;
  text-shadow: 0 0 5px #ff0;
  margin: 15px auto;
}

  </style>
</head>
<body>
<?php 
  include '../loading.php'
?>
  <h1>🎰Spin Wheel🎰</h1>

  <div id="wheelContainer">
    <div class="pointer"></div>
    <canvas id="wheelCanvas" width="350" height="350"></canvas>
    <button id="spinBtn">SPIN</button>


  </div>
<p>
  Join us now to play exciting games and win real money — with safe and secure payments!
  <a href="https://fancywin.city/kh/en" target="_blank" style="color: #facc15; text-decoration: underline; margin-left: 5px;">
    Visit our partner site
  </a>
</p>
  <div id="prizeMessage"></div>

  <script>
    const canvas = document.getElementById("wheelCanvas");
    const ctx = canvas.getContext("2d");
    const spinBtn = document.getElementById("spinBtn");
    const prizeMessage = document.getElementById("prizeMessage");

    const prizes = ["💎 500$", "😢 Try Again", "🎲 100$", "🎉 1000$", "🍀 50$", "💰 200$", "🔥 5$", "❌ Miss"];
    const colors = ["#FFD700", "#C0C0C0", "#FF4500", "#00CED1", "#8A2BE2", "#228B22", "#DC143C", "#1E90FF"];

    const segments = prizes.length;
    const anglePerSegment = (2 * Math.PI) / segments;

    let startAngle = 0;
    let spinTime = 0;
    let spinTimeTotal = 0;
    let spinTimeout = null;
    let rotation = 0;

    function drawWheel() {
      for (let i = 0; i < segments; i++) {
        const angle = startAngle + i * anglePerSegment;
        ctx.beginPath();
        ctx.fillStyle = colors[i];
        ctx.moveTo(175, 175);
        ctx.arc(175, 175, 170, angle, angle + anglePerSegment);
        ctx.lineTo(175, 175);
        ctx.fill();

        ctx.save();
        ctx.fillStyle = "#fff";
        ctx.translate(175, 175);
        ctx.rotate(angle + anglePerSegment / 2);
        ctx.textAlign = "right";
        ctx.font = "bold 16px Arial";
        ctx.fillText(prizes[i], 160, 5);
        ctx.restore();
      }
    }

    function rotateWheel(angle) {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.save();
      ctx.translate(175, 175);
      ctx.rotate(angle);
      ctx.translate(-175, -175);
      drawWheel();
      ctx.restore();
    }

    function easeOut(t, b, c, d) {
      t /= d;
      t--;
      return c * (t * t * t + 1) + b;
    }

    function spin() {
      spinBtn.disabled = true;
      prizeMessage.textContent = "";

      spinTime = 0;
      spinTimeTotal = Math.random() * 5000 + 4000;
      const spinAngle = Math.random() * 5000 + 5000;

      function animate() {
        spinTime += 16;
        if (spinTime >= spinTimeTotal) {
          finishSpin(spinAngle);
          return;
        }

        const eased = easeOut(spinTime, 0, spinAngle, spinTimeTotal);
        rotation = (eased * Math.PI) / 180;
        rotateWheel(rotation);
        requestAnimationFrame(animate);
      }

      animate();
    }

    function finishSpin(spinAngle) {
      const finalDeg = spinAngle % 360;
      const index = Math.floor(((360 - finalDeg + 270) % 360) / (360 / segments));
      const prize = prizes[index];
      prizeMessage.textContent = `🎁 You won: ${prize}`;
      spinBtn.disabled = false;
    }

    drawWheel();
    spinBtn.addEventListener("click", spin);
  </script>

</body>
</html>
