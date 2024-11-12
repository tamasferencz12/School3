import { Cell } from './Cell.js';
//#region DELEGATE function 
function delegate(parent, child, when, what) {
  function eventHandlerFunction(event) {
    let eventTarget = event.target;
    let eventHandler = this;
    let closestChild = eventTarget.closest(child);

    if (eventHandler.contains(closestChild)) {
      what(event, closestChild);
    }
  }

  parent.addEventListener(when, eventHandlerFunction);
}
//#endregion

//#region CELL IMAGES
const cellImages = [
  'pics/tiles/railDOWNLEFT.png',
  'pics/tiles/railHORIZONTAL.png',
  'pics/tiles/railUPLEFT.png',
  'pics/tiles/railUPRIGHT.png',
  'pics/tiles/railVERTICAL.png',
  'pics/tiles/railDOWNRIGHT.png',
];

const railDirections = {
  'railDOWNLEFT.png': ['D', 'L'],
  'railDOWNRIGHT.png': ['D', 'R'],
  'railHORIZONTAL.png': ['L', 'R'],
  'railVERTICAL.png': ['U', 'D'],
  'railUPLEFT.png': ['U', 'L'],
  'railUPRIGHT.png': ['U', 'R'],
};

//#endregion

//#region update cell image
function updateCellImages(element, row, col) {
  const currentImage = element.style.backgroundImage;

  switch (true) {
    case currentImage.includes('mountainDOWNLEFT') || currentImage.includes('mountain_railDOWNLEFT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railDOWNLEFT.png')`;
      directionMatrix[row][col] = ['D', 'L'];
      break;

    case currentImage.includes('mountainDOWNRIGHT') || currentImage.includes('mountain_railDOWNRIGHT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railDOWNRIGHT.png')`;
      directionMatrix[row][col] = ['D', 'R'];
      break;

    case currentImage.includes('mountainUPLEFT') || currentImage.includes('mountain_railUPLEFT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railUPLEFT.png')`;
      directionMatrix[row][col] = ['U', 'L'];
      break;

    case currentImage.includes('mountainUPRIGHT') || currentImage.includes('mountain_railUPRIGHT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railUPRIGHT.png')`;
      directionMatrix[row][col] = ['U', 'R'];
      break;

    case currentImage.includes('bridgeHORIZONTAL') || currentImage.includes('bridge_railHORIZONTAL'):
      element.style.backgroundImage = `url('pics/tiles/bridge_railHORIZONTAL.png')`;
      directionMatrix[row][col] = ['L', 'R'];
      break;

    case currentImage.includes('bridgeVERTICAL') || currentImage.includes('bridge_railVERTICAL'):
      element.style.backgroundImage = `url('pics/tiles/bridge_railVERTICAL.png')`;
      directionMatrix[row][col] = ['U', 'D'];
      break;

    case currentImage.includes('oasis.png'):
      element.style.backgroundImage = `url("pics/tiles/oasis.png")`;
      directionMatrix[row][col] = ['P', 'P'];
      break;

    default:
      const nextImageUrl = cell.nextImage();
      element.style.backgroundImage = `url(${nextImageUrl})`;

      const imageName = nextImageUrl.split('/').pop();

      const direction = railDirections[imageName];
      directionMatrix[row][col] = direction;
      break;
  }
  /*directionMatrix.forEach((row, rowIndex) => {
    console.log(`Row ${rowIndex}: ${JSON.stringify(row)}`);
  });*/
  checkState(directionMatrix, 0, 1);
}
//#endregion

//#region  GRID LAYOUT
class GridLayout {
  constructor() {
    this.layouts = {
      5: [
        [
          'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/oasis.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/oasis.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainDOWNRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
      ],
      7: [
        [
          'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/oasis.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png',
          'pics/tiles/mountainDOWNRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainDOWNRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png',
          'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainUPRIGHT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
        [
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNRIGHT.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/bridgeHORIZONTAL.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/mountainDOWNRIGHT.png', 'pics/tiles/empty.png', 'pics/tiles/oasis.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          'pics/tiles/empty.png', 'pics/tiles/mountainUPLEFT.png', 'pics/tiles/empty.png', 'pics/tiles/bridgeVERTICAL.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
          '', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png', 'pics/tiles/empty.png',
        ],
      ]
    };
  }

  getRandomLayout(size) {
    const filteredLayouts = this.layouts[size];
    const randomIndex = Math.floor(Math.random() * filteredLayouts.length);
    return filteredLayouts[randomIndex];
  }
}
//#endregion

//#region SELECTORS
const mainMenuContainer = document.querySelector('#main-container');
const nameInput = document.querySelector("#name-input");
const nameInputText = document.querySelector("#player-name");
const difficultyButtons = document.querySelectorAll(".difficulty-level");
const difficultyButtonsContainer = document.querySelector(".difficulty-options");
const startButton = document.querySelector(".btn-start");
const descriptionButton = document.querySelector(".btn-description");
const instructions = document.querySelector("#instructions");
const gameBoard = document.querySelector("#game-board");
const menuButton = document.querySelector("#instructions-btn");
const gameGrid = document.querySelector("#game-grid");
const timer = document.querySelector("#timer");
const winnerMenuButton = document.querySelector('#winner-menu-button');
//#endregion

let selectedDifficulty = null;
let playerName = null;
let directionMatrix = [];
let startedTime;
let seconds = 0;
let boardSize = 0;

const cell = new Cell(cellImages);
const gridLayout = new GridLayout();

//#region EVENT LISTENERS
difficultyButtons.forEach((button) => {
  button.addEventListener("click", () => {
    selectedDifficulty = button.textContent;
  });
});

winnerMenuButton.addEventListener("click", () => {
  location.reload();
});

descriptionButton.addEventListener("click", () => {
  mainMenuContainer.classList.remove("visible");
  mainMenuContainer.classList.add("hidden");
  instructions.classList.remove("hidden");
  instructions.classList.add("visible");
});

startButton.addEventListener("click", () => {
  playerName = nameInput.value.trim();

  mainMenuContainer.classList.remove("visible");
  mainMenuContainer.classList.add("hidden");
  gameBoard.classList.remove("hidden");
  gameBoard.classList.add("visible");
  startGame();
  startedTime = Date.now()
});

menuButton.addEventListener("click", () => {
  instructions.classList.remove("visible");
  instructions.classList.add("hidden");
  mainMenuContainer.classList.remove("hidden");
  mainMenuContainer.classList.add("visible");
});
//#endregion

//#region START GAME

let timerInterval = null;
function startGame() {
  playerName = nameInput.value.trim();
  if (!playerName || !selectedDifficulty) {
    return;
  }
  nameInputText.textContent = playerName.toUpperCase();

  seconds = 0;
  timerInterval = setInterval(() => {
    seconds++;
    const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
    const secs = (seconds % 60).toString().padStart(2, '0');
    timer.textContent = `${minutes}:${secs}`;
  }, 1000);

  generateGrid(selectedDifficulty);

}

function generateGrid(difficulty) {
  gameGrid.innerHTML = "";
  const size = difficulty === "5 x 5" ? 5 : 7;
  boardSize = size;

  gameGrid.style.gridTemplateColumns = `repeat(${size}, 1fr)`;
  gameGrid.style.gridTemplateRows = `repeat(${size}, 1fr)`;

  directionMatrix = [];
  for (let i = 0; i < size; i++) {
    directionMatrix[i] = new Array(size).fill(null);
  }

  const layout = gridLayout.getRandomLayout(size);

  layout.forEach((imageUrl, index) => {
    const row = Math.floor(index / size);
    const col = index % size;
    const cell = document.createElement("div");
    cell.classList.add("cell");
    if (`url(${imageUrl})`.match('pics/tiles/oasis.png')) {
      directionMatrix[row][col] = ['P', 'P'];
      cell.style.backgroundImage = `url(${imageUrl})`;
    } else {
      cell.style.backgroundImage = `url(${imageUrl})`;
    }

    cell.style.backgroundSize = 'cover';
    cell.style.backgroundPosition = 'center';
    cell.addEventListener("click", () => updateCellImages(cell, row, col));
    gameGrid.appendChild(cell);
  });
}
//#endregion

//#region DELEGATE
delegate(difficultyButtonsContainer, "div", "click", (event, closestChild) => {
  document.querySelectorAll(".difficulty-level").forEach((button) => {
    button.classList.remove("dificulty-level-activated");
  });

  closestChild.classList.add("dificulty-level-activated");
});
//#endregion

//#region GAME STATE CHECK
const directionMap = {
  'R': [0, 1],
  'L': [0, -1],
  'U': [-1, 0],
  'D': [1, 0],
};

function checkState(matrix, startX, startY) {
  let connectedCount = 0;
  let visited = new Set();
  let lastPlaced = matrix[0][0];
  let poundCount = 0;
  let totalRails = 0;

  for (let i = 0; i < matrix.length; i++) {
    for (let j = 0; j < matrix[i].length; j++) {
      if (Array.isArray(matrix[i][j]) && matrix[i][j][0] === 'P') {
        poundCount++;
      } else {
        totalRails++;
      }
    }
  }

  function isValid(x, y) {
    return x >= 0 && x < matrix.length && y >= 0 && y < matrix[0].length;
  }

  function exploreRail(x, y) {
    if (visited.has(`${x},${y}`) || !isValid(x, y)) return;

    let cell = matrix[x][y];
    if (!cell || cell === 'P') return;

    visited.add(`${x},${y}`);
    connectedCount++;
    lastPlaced = matrix[x][y];

    for (let dir of cell) {
      let [dx, dy] = directionMap[dir];
      let nx = x + dx, ny = y + dy;

      if (isValid(nx, ny) && !visited.has(`${nx},${ny}`)) {
        let nextCell = matrix[nx][ny];

        if (nextCell && nextCell.includes(getOppositeDirection(dir))) {
          exploreRail(nx, ny);
        }
      }
    }
  }

  function getOppositeDirection(dir) {
    switch (dir) {
      case 'R': return 'L';
      case 'L': return 'R';
      case 'U': return 'D';
      case 'D': return 'U';
    }
  }

  exploreRail(startX, startY);

  if (connectedCount === totalRails) {
    const playerName = document.querySelector('#name-input').value;
    document.querySelector('.game-winner #player-name').innerText = playerName.toUpperCase();

    const elapsed = Date.now() - startedTime;
    const seconds = Math.floor(elapsed / 1000) % 60;
    const minutes = Math.floor(elapsed / 60000);
    document.querySelector('.game-winner #timer').innerText = `${formatTime(minutes)}:${formatTime(seconds)}`;

    document.querySelector('.main-container').classList.remove('visible');
    document.querySelector('.main-container').classList.add('hidden');
    document.querySelector('.game-winner').classList.remove('hidden');
    document.querySelector('.game-winner').classList.add('visible');
    document.querySelector('.game-board').classList.remove('visible');
    document.querySelector('.game-board').classList.add('hidden');
    document.querySelector('#winner-menu-button').classList.remove('hidden');
    document.querySelector('#winner-menu-button').classList.add('visible');

    updateTopScores(playerName, elapsed, boardSize);
    displayTopScores();
  }
}
function formatTime(time) {
  return time < 10 ? `0${time}` : time;
}
//#endregion

//#region Top Score
function updateTopScores(playerName, time, boardSize) {
  const key = boardSize === 5 ? "topScores5x5" : "topScores7x7";
  let topScores = JSON.parse(localStorage.getItem(key)) || [];

  topScores.push({ name: playerName, time: time });
  topScores.sort((a, b) => a.time - b.time);
  topScores = topScores.slice(0, 3);

  localStorage.setItem(key, JSON.stringify(topScores));

  displayTopScores();
}

function displayTopScores() {
  const key = boardSize === 5 ? "topScores5x5" : "topScores7x7";
  const scoreList = document.querySelector("#score-list");
  const scoreHeading = document.querySelector("#top-scores-h");

  scoreList.innerHTML = "";
  scoreHeading.textContent = boardSize == 5 ? "Top Scores - 5x5 Grid" : "Top Scores - 7x7 Grid";

  const topScores = JSON.parse(localStorage.getItem(key)) || [];
  topScores.forEach((score, index) => {
    const listItem = document.createElement("li");
    const minutes = Math.floor(score.time / 60000).toString().padStart(2, '0');
    const seconds = Math.floor((score.time % 60000) / 1000).toString().padStart(2, '0');
    const milliseconds = (score.time % 1000).toString().padStart(3, '0');

    listItem.textContent = `${index + 1}. ${score.name}: ${minutes}:${seconds}:${milliseconds}`;
    scoreList.appendChild(listItem);
  });
}
//#endregion