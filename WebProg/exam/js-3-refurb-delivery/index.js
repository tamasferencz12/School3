console.log(deliveries);

const canvas = document.querySelector('canvas');
const ctx = canvas.getContext('2d');

canvas.width = 800;
canvas.height = 800;


// Animation loop
let lastFrame = performance.now()
function loop(now) {
  let dt = (now - lastFrame) / 1000;
  lastFrame = now;

  update(dt);
  render();
  requestAnimationFrame(loop);
}
function update(dt) {
  console.log(dt);

}
function render() {

}

requestAnimationFrame(loop);  // start the animation loop

// Képek betöltése
const warehouseImg = new Image();
const houseImg = new Image();
const packagingImg = new Image();
const waitingImg = new Image();
const deliveryImg = new Image();
const deliveredImg = new Image();

warehouseImg.src = "assets/warehouse.png";
houseImg.src = "assets/house.png";
packagingImg.src = "assets/packaging.png";
waitingImg.src = "assets/waiting_for_delivery.png";
deliveryImg.src = "assets/under_delivery.png";
deliveredImg.src = "assets/delivered.png";

// Téglalap rajzolása
ctx.fillStyle = "gray";
ctx.fillRect(0, 100, canvas.width, 30);

// Képek kirajzolása
warehouseImg.onload = () => ctx.drawImage(warehouseImg, 100, 50, 100, 100);
houseImg.onload = () => ctx.drawImage(houseImg, 650, 50, 100, 100);

// Szövegek kirajzolása
ctx.fillStyle = "black";
ctx.font = "16px Arial";
ctx.textAlign = "center";
ctx.fillText("Szállítási azonosító", canvas.width / 2, 120);
ctx.fillText("Szállítási cím", 700, 160);

// Rendelések kezdő állapota
packagingImg.onload = () => {
  deliveries.forEach((delivery, index) => {
    const yOffset = 200 + index * 50;
    ctx.drawImage(packagingImg, 50, yOffset - 25, 50, 50);
    ctx.fillText(delivery.id, 400, yOffset);
    ctx.fillText(delivery.destination, 700, yOffset);
  });
};

// Státuszok időzített változtatása
function updateStatus() {
  let statusIndex = 0;

  const interval = setInterval(() => {
    if (statusIndex === 0) {
      deliveries.forEach((_, index) => {
        const yOffset = 200 + index * 50;
        waitingImg.onload = () => ctx.drawImage(waitingImg, 50, yOffset - 25, 50, 50);
      });
    } else if (statusIndex === 1) {
      deliveries.forEach((_, index) => {
        const yOffset = 200 + index * 50;
        deliveryImg.onload = () => ctx.drawImage(deliveryImg, 50, yOffset - 25, 50, 50);
      });
    } else {
      clearInterval(interval);
    }
    statusIndex++;
  }, 3000);
}
updateStatus();

// Autó animáció
function animateCar(delivery, index) {
  const carImg = new Image();
  carImg.src = "assets/under_delivery.png";
  const startX = 100;
  const endX = 650;
  let x = startX;
  let direction = 1; // 1 előre, -1 vissza

  carImg.onload = () => {
    function move() {
      ctx.clearRect(100, 200 + index * 50 - 25, 800, 50);
      ctx.drawImage(carImg, x, 200 + index * 50 - 25, 50, 50);
      ctx.fillText(delivery.id, 400, 200 + index * 50);
      ctx.fillText(delivery.destination, 700, 200 + index * 50);

      x += direction * 2;

      if (x >= endX || x <= startX) {
        direction *= -1;
        if (x <= startX) {
          deliveredImg.onload = () => ctx.drawImage(deliveredImg, 50, 200 + index * 50 - 25, 50, 50);
          return;
        }
      }
      requestAnimationFrame(move);
    }
    move();
  };
}

deliveries.forEach(animateCar);
