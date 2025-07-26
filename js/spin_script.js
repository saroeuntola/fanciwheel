const canvas = document.getElementById("wheelCanvas");
const ctx = canvas.getContext("2d");
const spinBtn = document.getElementById("spinBtn");
const prizeMessage = document.getElementById("prizeMessage");
const prizeText = document.getElementById("prizeText");

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
  prizeMessage.classList.remove("hidden");
  spinBtn.disabled = false;
}

spinBtn.addEventListener("click", spin);

window.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.getElementById("spinModal").classList.remove("hidden");
    rotateWheel(0); 
  }, 500);
});

function closeSpinModal() {
  document.getElementById("spinModal").classList.add("hidden");
}

