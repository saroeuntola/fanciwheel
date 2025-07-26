<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Spin Wheel Modal</title>
  <style>
    #spinModal {
      backdrop-filter: blur(5px);
      position: fixed;
      inset: 0;
      background-color: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 50;
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    #spinModal.visible {
      visibility: visible;
      opacity: 1;
    }
    #spinModal > div {
      background-color: #5b21b6; /* purple-800 */
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgba(0,0,0,0.4);
      padding: 1.5rem;
      width: 360px;
      height: 420px;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    #spinModal button.close-btn {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: none;
      border: none;
      font-size: 2rem;
      font-weight: bold;
      color: white;
      cursor: pointer;
      transition: color 0.3s;
    }
    #spinModal button.close-btn:hover {
      color: #dc2626; /* red-600 */
    }
    h2 {
      color: white;
      font-size: 2rem;
      margin-bottom: 1.5rem;
      margin-top: 0.5rem;
      font-weight: bold;
    }
    .wheel-container {
      position: relative;
      width: 288px;
      height: 288px;
      margin-bottom: 1.5rem;
    }
    #wheelCanvas {
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .needle {
      position: absolute;
      top: -24px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-left: 12px solid transparent;
      border-right: 12px solid transparent;
      border-top: 30px solid #dc2626; /* red-600 */
      filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
      z-index: 10;
    }
    #spinBtn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: linear-gradient(to right, #7c3aed, #4338ca); /* purple to indigo */
      color: white;
      font-weight: bold;
      padding: 0.75rem 1.5rem;
      border-radius: 9999px;
      border: none;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(124, 58, 237, 0.5);
      transition: background 0.3s, transform 0.1s;
      z-index: 5;
    }
    #spinBtn:hover {
      background: linear-gradient(to right, #6b21a8, #3730a3);
    }
    #spinBtn:active {
      transform: translate(-50%, -50%) scale(0.95);
    }
    #prizeMessage {
      position: absolute;
      bottom: 1.5rem;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      color: #1f2937; /* gray-900 */
      padding: 1rem;
      border-radius: 1rem;
      width: 16rem;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      user-select: none;
      display: none;
      z-index: 20;
    }
    #prizeMessage p {
      font-weight: 800;
      font-size: 1.25rem;
      margin: 0.25rem 0;
    }
    #prizeMessage a {
      display: inline-block;
      background-color: #4338ca; /* indigo-700 */
      color: white;
      padding: 0.5rem 1.25rem;
      border-radius: 9999px;
      font-weight: 600;
      text-decoration: none;
      transition: background-color 0.3s;
    }
    #prizeMessage a:hover {
      background-color: #312e81; /* indigo-900 */
    }
    button.hide-today-btn {
      margin-top: 1rem;
      border: none;
      color: white;
      text-decoration: underline;
      font-size: 0.875rem;
      cursor: pointer;
      transition: color 0.3s;
    }
    button.hide-today-btn:hover {
      color: #ef4444; /* red-500 */
    }
  </style>
</head>
<body>

<!-- Modal -->
<div id="spinModal" aria-modal="true" role="dialog" aria-labelledby="modalTitle" class="">
  <div>
    <button class="close-btn" onclick="closeSpinModal()" aria-label="Close">&times;</button>
    <h2 id="modalTitle">🎉 Spin to Win 🎁</h2>
    <div class="wheel-container">
      <canvas id="wheelCanvas" width="288" height="288"></canvas>
      <div class="needle"></div>
      <button id="spinBtn" aria-label="Spin the wheel">SPIN</button>
      <div id="prizeMessage" role="alert" aria-live="assertive">
        <p id="prizeText"></p>
        <p>Join with us now to claim</p>
        <a href="https://fwsuperace.xyz/kh/en" target="_blank" rel="noopener noreferrer">Join Now</a>
      </div>
    </div>
          <button class="hide-today-btn" onclick="hideForToday()">❌ Hide for Today</button>
  </div>
</div>

<script>
  const canvas = document.getElementById("wheelCanvas");
  const ctx = canvas.getContext("2d");
  const spinBtn = document.getElementById("spinBtn");
  const prizeMessage = document.getElementById("prizeMessage");
  const prizeText = document.getElementById("prizeText");
  const spinModal = document.getElementById("spinModal");

  const prizes = ["20$", "100$", "1$", "50$", "0$", "1000$", "10$", "5$"];
  const colors = [
    "#f87171",
    "#a78bfa",
    "#60a5fa",
    "#34d399",
    "#fbbf24",
    "#f472b6",
    "#818cf8",
    "#22d3ee",
  ];

  const segments = prizes.length;
  const segmentAngle = (2 * Math.PI) / segments;

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
      ctx.arc(
        canvas.width / 2,
        canvas.height / 2,
        canvas.width / 2 - 10,
        angle,
        angle + segmentAngle,
        false
      );
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
    prizeMessage.style.display = "none";

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
    rotateWheel((angle * Math.PI) / 180);
    spinTimeout = setTimeout(rotate, 16); // 60fps
  }

  function stopRotateWheel() {
    clearTimeout(spinTimeout);

    const finalAngle = easeOut(spinTimeTotal, 0, spinAngleStart, spinTimeTotal);
    const degrees = finalAngle % 360;

    // Adjust based on the pointer being at 270 degrees (top of the canvas)
    const adjustedDegrees = (360 - degrees + 270) % 360;

    const index =
      Math.floor(adjustedDegrees / (360 / prizes.length)) % prizes.length;

    prizeText.textContent = `🎉 You won: ${prizes[index]}!`;
    prizeMessage.style.display = "block";
    spinBtn.disabled = false;
  }

  function closeSpinModal() {
    spinModal.classList.remove("visible");
  }

  function hideForToday() {
    const today = new Date().toDateString();
    localStorage.setItem("spinModalHiddenDate", today);
    closeSpinModal();
  }

  function shouldShowSpinModal() {
    const savedDate = localStorage.getItem("spinModalHiddenDate");
    const today = new Date().toDateString();
    return savedDate !== today;
  }

  window.addEventListener("DOMContentLoaded", () => {
    if (shouldShowSpinModal()) {
      setTimeout(() => {
        spinModal.classList.add("visible");
        rotateWheel(0); // draw initial wheel
      }, 500);
    } else {
      console.log("Spin modal is hidden for today");
    }
  });

  spinBtn.addEventListener("click", spin);
</script>

</body>
</html>
