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
//#endregion

//#region update cell image
function updateCellImages(element) {
  const currentImage = element.style.backgroundImage;

  switch (true) {
    case currentImage.includes('mountainDOWNLEFT') || currentImage.includes('mountain_railDOWNLEFT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railDOWNLEFT.png')`;
      break;

    case currentImage.includes('mountainDOWNRIGHT') || currentImage.includes('mountain_railDOWNRIGHT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railDOWNRIGHT.png')`;
      break;

    case currentImage.includes('mountainUPLEFT') || currentImage.includes('mountain_railUPLEFT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railUPLEFT.png')`;
      break;

    case currentImage.includes('mountainUPRIGHT') || currentImage.includes('mountain_railUPRIGHT'):
      element.style.backgroundImage = `url('pics/tiles/mountain_railUPRIGHT.png')`;
      break;

    case currentImage.includes('bridgeHORIZONTAL') || currentImage.includes('bridge_railHORIZONTAL'):
      element.style.backgroundImage = `url('pics/tiles/bridge_railHORIZONTAL.png')`;
      break;

    case currentImage.includes('bridgeVERTICAL') || currentImage.includes('bridge_railVERTICAL'):
      element.style.backgroundImage = `url('pics/tiles/bridge_railVERTICAL.png')`;
      break;

    case currentImage.includes('oasis.png'):
      element.style.backgroundImage = `url("pics/tiles/oasis.png")`;
      break;

    default:
      element.style.backgroundImage = `url(${cell.nextImage()})`;
      break;
  }
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
//#endregion

let selectedDifficulty = null;
let playerName = null;
let timerInterval = null;

const cell = new Cell(cellImages);
const gridLayout = new GridLayout();

//#region EVENT LISTENERS
difficultyButtons.forEach((button) => {
  button.addEventListener("click", () => {
    selectedDifficulty = button.textContent;
  });
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
});

menuButton.addEventListener("click", () => {
  instructions.classList.remove("visible");
  instructions.classList.add("hidden");
  mainMenuContainer.classList.remove("hidden");
  mainMenuContainer.classList.add("visible");
});

startButton.addEventListener("click", startGame);
//#endregion

//#region START GAME
function startGame() {
  playerName = nameInput.value.trim();
  if (!playerName || !selectedDifficulty) {
    return;
  }
  nameInputText.textContent = playerName.toUpperCase();

  let seconds = 0;
  timerInterval = setInterval(() => {
    seconds++;
    const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
    const secs = (seconds % 60).toString().padStart(2, '0');
    timer.textContent = `${minutes}:${secs}`;
  }, 1000);

  generateGrid(selectedDifficulty);

  document.querySelectorAll(".cell").forEach(cell => {
    cell.addEventListener('click', () => {
      updateCellImages(cell);
    });
  });
}

function generateGrid(difficulty) {
  gameGrid.innerHTML = "";
  const size = difficulty === "5 x 5" ? 5 : 7;

  gameGrid.style.gridTemplateColumns = `repeat(${size}, 1fr)`;
  gameGrid.style.gridTemplateRows = `repeat(${size}, 1fr)`;

  const layout = gridLayout.getRandomLayout(size);;

  layout.forEach(imageUrl => {
    const cell = document.createElement("div");
    cell.classList.add("cell");
    cell.style.backgroundImage = `url(${imageUrl})`;
    cell.style.backgroundSize = 'cover';
    cell.style.backgroundPosition = 'center';
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

//#endregion