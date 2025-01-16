const task1 = document.querySelector("#task1");
const task2 = document.querySelector("#task2");
const task3 = document.querySelector("#task3");
const task4 = document.querySelector("#task4");
const task5 = document.querySelector("#task5");

// data
console.log(products);

let sampleInt = 12345678

task1.innerText = sampleInt.toLocaleString('hu-HU', { useGrouping: true }) + " Ft"

// a. (1 pont) A task1 azonosítójú elembe írd ki a raktárkészlet teljes értékét Ft-ban. A formázáshoz találsz segítséget a mintafájlban!
const totalStockValue = products.reduce((sum, product) => sum + product.price * product.stock, 0);
task1.innerText = `${totalStockValue.toLocaleString('hu-HU')} Ft`;

// b. (1 pont) A task2 azonosítójú elembe sorold fel azokat a termékeket, amelyekből rendelni kell (raktárkészlet nullán áll)!
const outOfStockProducts = products.filter(product => product.stock === 0).map(product => product.name);
task2.innerText = outOfStockProducts.join(', ');

// c. (2 pont) A task3 azonosítójú elembe írd ki, hogy mekkora az átlagos kosárérték novemberre! Átlagos kosárérték = Összes bevétel / Rendelések száma
const novemberiOsszes = products.reduce((acc, product) => {
    const novemberiEladasok = Object.entries(product.sales)
        .filter(([date]) => date.startsWith("2024-11"))
        .reduce((sum, [, quantity]) => sum + quantity, 0);

    return acc + (novemberiEladasok * product.price);
}, 0);
document.getElementById("task3").innerText = `${novemberiOsszes.toLocaleString('hu-HU')} Ft`;

// d. (3 pont) A task4 azonosítójú elembe írd ki melyik a legtöbbet eladott termék!
let maxSold = 0;
let bestSellingProduct = "";

products.forEach(product => {
    const totalSales = Object.values(product.sales).reduce((sum, count) => sum + count, 0);
    if (totalSales > maxSold) {
        maxSold = totalSales;
        bestSellingProduct = product.name;
    }
});

document.getElementById("task4").innerText = bestSellingProduct;

// e. (3 pont) A task5 azonosítójú elembe sorold fel az összes eléhető márkát illetve a hozzájuk tartozó elérhető raktárkészletet.
const brandStock = products.reduce((acc, product) => {
    if (!acc[product.brand]) {
        acc[product.brand] = 0;
    }
    acc[product.brand] += product.stock;
    return acc;
}, {});
const brandStockList = Object.entries(brandStock).map(([brand, stock]) => `${brand}: ${stock} db`);
task5.innerText = brandStockList.join(', ');