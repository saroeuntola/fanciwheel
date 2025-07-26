<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Spin Lucky Slot </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="./img/slot.jpg"> 
  <style>
        p {
  font-size: 16px;
  color: #facc15;
  font-weight: bold;
  text-shadow: 0 0 5px #ff0;
  margin: 15px auto;
}
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: radial-gradient(#000000, #1a1a1a);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    h1 {
      color: gold;
      text-shadow: 0 0 15px #ff0;
    }

    .slot-machine {
      margin-top: 20px;
      margin-bottom: 30px;
      background: #222;
      padding: 30px;
      border: 5px solid gold;
      border-radius: 20px;
      box-shadow: 0 0 30px gold;
      text-align: center;
    }

    .reels {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
    }

    .reel {
      width: 80px;
      height: 80px;
      font-size: 48px;
      background: #000;
      border: 3px solid #ffcc00;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: inset 0 0 10px #ff0;
    }

    .spin-btn {
      background: linear-gradient(to right, #f59e0b, #facc15);
      color: #111;
      border: none;
      padding: 14px 30px;
      border-radius: 999px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 0 15px gold;
    }

    .message {
      margin-top: 20px;
      font-size: 22px;
      font-weight: bold;
      text-shadow: 0 0 10px #0f0;
    }
  </style>
</head>
<body>
<?php 
  include '../loading.php'
?>
  <h1>🎰Spin Lucky Slot🎰</h1>

  <div class="slot-machine">
    <div class="reels">
      <div class="reel" id="reel1">🍒</div>
      <div class="reel" id="reel2">🍋</div>
      <div class="reel" id="reel3">🍇</div>
    </div>
    <button class="spin-btn" onclick="spin()">SPIN</button>
    <div class="message" id="message"></div>
  </div>
  <p>
  Join us now to play exciting games and win real money — with safe and secure payments!
  <a href="https://fancywin.city/kh/en" target="_blank" style="color: #facc15; text-decoration: underline; margin-left: 5px;">
    Visit our partner site
  </a>
</p>

  <script>
    const symbols = ["🍒", "🍋", "🍇", "⭐", "🔔", "💎"];
    const reels = [
      document.getElementById("reel1"),
      document.getElementById("reel2"),
      document.getElementById("reel3"),
    ];
    const message = document.getElementById("message");

    function spin() {
  message.textContent = "Spinning...";
  message.style.color = "#fff";

  let count = 0;
  const totalFrames = 20;
  let result = [];

  const willWin = Math.random() < 0.3; 
  const interval = setInterval(() => {
    count++;

    if (count < totalFrames) {
      reels.forEach((reel) => {
        reel.textContent = symbols[Math.floor(Math.random() * symbols.length)];
      });
    } else {
      clearInterval(interval);
      if (willWin) {
        const winSymbol = symbols[Math.floor(Math.random() * symbols.length)];
        result = [winSymbol, winSymbol, winSymbol];
      } else {
        // Ensure at least two symbols are different
        let a = symbols[Math.floor(Math.random() * symbols.length)];
        let b;
        do {
          b = symbols[Math.floor(Math.random() * symbols.length)];
        } while (b === a);
        let c;
        do {
          c = symbols[Math.floor(Math.random() * symbols.length)];
        } while (c === a || c === b);
        result = [a, b, c];
      }

      // Set final result
      reels.forEach((reel, i) => {
        reel.textContent = result[i];
      });

      showResult(result);
    }
  }, 100);
}
    function showResult(result) {
      if (result[0] === result[1] && result[1] === result[2]) {
        message.textContent = "🎉 JACKPOT! You Win!";
        message.style.color = "#10b981";
      } else {
        message.textContent = "😢 Try Again";
        message.style.color = "#ef4444";
      }
    }
  </script>

</body>
</html>
