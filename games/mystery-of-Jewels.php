<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>The Mystery of Jewels: Adventure</title>
  <link rel="icon" type="image/png" href="./img/The-Mystery-of-Jewels.jpg"> 
 <style>
  p {
    font-size: 16px;
    color: black;
    font-weight: bold;
    text-shadow: 0 0 5px #ff0;
    margin: 20px auto;
    text-align: center;
    max-width: 90%;
  }

  body {
    margin: 0;
    padding: 20px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    background: linear-gradient(to bottom, #ffebee, #ffe0b2);
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #d84315;
  }

  h1 {
    margin: 0;
    font-size: 32px;
    color: #ff5722;
    text-shadow: 2px 2px #fff3e0;
    text-align: center;
  }

  #score {
    font-size: 22px;
    margin: 10px 0 20px;
    background: black;
    color: white;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: center;
  }

  #game-board {
    margin-bottom: 10px;
    display: grid;
    grid-template-columns: repeat(8, 64px);
    grid-template-rows: repeat(8, 64px);
    gap: 6px;
    background: #fff8e1;
    padding: 10px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow-x: auto;
  }

  .tile {
    width: 64px;
    height: 64px;
    background-size: 90%;
    background-repeat: no-repeat;
    background-position: center;
    border-radius: 18px;
    background-color: #ffffff;
    box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.2);
    cursor: grab;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .tile:active {
    transform: scale(1.1);
    box-shadow: 0 0 10px #ff9800, inset 0 0 5px #fff3e0;
  }

  /* 📱 Mobile responsiveness */
  @media (max-width: 768px) {
    #game-board {
      grid-template-columns: repeat(8, 36px);
      grid-template-rows: repeat(8, 36px);
      gap: 4px;
      padding: 8px;
    }

    .tile {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background-size: 80%;
    }

    h1 {
      font-size: 24px;
    }

    #score {
      font-size: 16px;
      padding: 6px 12px;
    }

    p {
      font-size: 14px;
    }
  }
</style>

</head>
<body>
<?php 
  include '../loading.php'
?>
<h1>🍭 The Mystery of Jewels</h1>
<div id="score">Score: 0</div>
<div id="game-board"></div>
<p>
  Join us now to play exciting games and win real money — with safe and secure payments!
  <a href="https://fancywin.city/kh/en" target="_blank" style="color: black; text-decoration: underline; margin-left: 5px;">
    Visit our partner site
  </a>
</p>
<script>
  const vegetableImages = {
    carrot: "https://cdn-icons-png.flaticon.com/512/590/590685.png",
    tomato: "https://cdn-icons-png.flaticon.com/512/590/590682.png",
    cucumber: "https://cdn-icons-png.flaticon.com/512/590/590680.png",
    corn: "https://cdn-icons-png.flaticon.com/512/590/590683.png",
    garlic: "https://cdn-icons-png.flaticon.com/512/590/590688.png",
    eggplant: "https://cdn-icons-png.flaticon.com/512/590/590684.png"
  };

  const keys = Object.keys(vegetableImages);
  const grid = [];
  const board = document.getElementById("game-board");
  const scoreDisplay = document.getElementById("score");
  let score = 0;
  let draggedTile = null;
  let replacedTile = null;

  function getRandomVegetable() {
    const key = keys[Math.floor(Math.random() * keys.length)];
    return { key, url: vegetableImages[key] };
  }

  function createBoard() {
    for (let i = 0; i < 64; i++) {
      const tile = document.createElement("div");
      tile.classList.add("tile");
      tile.setAttribute("draggable", true);
      tile.setAttribute("id", i);

      const { key, url } = getRandomVegetable();
      tile.style.backgroundImage = `url(${url})`;
      tile.dataset.type = key;

      board.appendChild(tile);
      grid.push(tile);
    }
  }

  function dragStart(e) {
    draggedTile = e.target;
  }

  function dragOver(e) {
    e.preventDefault();
  }

  function dragDrop(e) {
    replacedTile = e.target;
  }

  function dragEnd() {
    if (!draggedTile || !replacedTile) return;

    const fromId = parseInt(draggedTile.id);
    const toId = parseInt(replacedTile.id);
    const validMoves = [fromId - 1, fromId + 1, fromId - 8, fromId + 8];

    if (!validMoves.includes(toId)) return;

    const fromType = draggedTile.dataset.type;
    const toType = replacedTile.dataset.type;

    // Swap
    draggedTile.dataset.type = toType;
    draggedTile.style.backgroundImage = `url(${vegetableImages[toType]})`;

    replacedTile.dataset.type = fromType;
    replacedTile.style.backgroundImage = `url(${vegetableImages[fromType]})`;

    // Check match
    if (hasMatch()) {
      checkMatches();
      moveDown();
    } else {
      // Revert if no match
      draggedTile.dataset.type = fromType;
      draggedTile.style.backgroundImage = `url(${vegetableImages[fromType]})`;

      replacedTile.dataset.type = toType;
      replacedTile.style.backgroundImage = `url(${vegetableImages[toType]})`;
    }

    draggedTile = null;
    replacedTile = null;
  }

  function hasMatch() {
    for (let i = 0; i < 64; i++) {
      const type = grid[i].dataset.type;
      if (!type) continue;

      const rowOfThree = [i, i + 1, i + 2];
      const notValid = [6, 7, 14, 15, 22, 23, 30, 31, 38, 39, 46, 47, 54, 55, 62, 63];
      if (!notValid.includes(i) && rowOfThree.every(index => grid[index]?.dataset.type === type)) {
        return true;
      }

      const colOfThree = [i, i + 8, i + 16];
      if (i < 40 && colOfThree.every(index => grid[index]?.dataset.type === type)) {
        return true;
      }
    }
    return false;
  }

  function checkMatches() {
    for (let i = 0; i < 64; i++) {
      const type = grid[i].dataset.type;

      const rowOfThree = [i, i + 1, i + 2];
      const notValid = [6, 7, 14, 15, 22, 23, 30, 31, 38, 39, 46, 47, 54, 55, 62, 63];
      if (!notValid.includes(i) && rowOfThree.every(index => grid[index]?.dataset.type === type)) {
        rowOfThree.forEach(index => {
          grid[index].dataset.type = "";
          grid[index].style.backgroundImage = "";
        });
        score += 30;
      }

      const colOfThree = [i, i + 8, i + 16];
      if (i < 40 && colOfThree.every(index => grid[index]?.dataset.type === type)) {
        colOfThree.forEach(index => {
          grid[index].dataset.type = "";
          grid[index].style.backgroundImage = "";
        });
        score += 30;
      }
    }
    scoreDisplay.textContent = `Score: ${score}`;
  }

  function moveDown() {
    for (let i = 55; i >= 0; i--) {
      if (grid[i + 8].dataset.type === "") {
        grid[i + 8].dataset.type = grid[i].dataset.type;
        grid[i + 8].style.backgroundImage = grid[i].style.backgroundImage;
        grid[i].dataset.type = "";
        grid[i].style.backgroundImage = "";
      }
    }

    for (let i = 0; i < 8; i++) {
      if (grid[i].dataset.type === "") {
        const { key, url } = getRandomVegetable();
        grid[i].dataset.type = key;
        grid[i].style.backgroundImage = `url(${url})`;
      }
    }
  }

  function setupEvents() {
    grid.forEach(tile => {
      tile.addEventListener("dragstart", dragStart);
      tile.addEventListener("dragover", dragOver);
      tile.addEventListener("drop", dragDrop);
      tile.addEventListener("dragend", dragEnd);
    });
  }

  createBoard();
  setupEvents();
  setInterval(() => {
    checkMatches();
    moveDown();
  }, 1000);
</script>

</body>
</html>
