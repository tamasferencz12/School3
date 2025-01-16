const phonePrices = {
    "Galaxy-S21": 299990,
    "Galaxy-S22": 349990,
    "Galaxy-S23": 399990,
    "Galaxy-S24": 449990,
    "Huawei-P20": 149990,
    "Huawei-P30": 179990,
    "Huawei-P40": 219990,
    "Huawei-P50": 249990,
    "iPhone-12": 299990,
    "iPhone-13": 349990,
    "iPhone-14": 399990,
    "iPhone-15": 449990
};

const coupons = {
    "SAVE5NOW": 5,
    "DISCOUNT10": 10,
    "WELCOME15": 15,
    "SUMMER20": 20,
    "FALL5OFF": 5,
    "SPRING10": 10,
    "EXTRA15DEAL": 15,
    "FLASH20SALE": 20,
    "HAPPY5": 5,
    "MEGA15SAVE": 15
};

const itemList = document.querySelector("#item-list")
const cartList = document.querySelector("table")
const couponCode = document.querySelector("#coupon")
const discount = document.querySelector("#discount")
const filter = document.querySelector("#type")
const sum = document.querySelector("#sum")
const checkoutButton = document.querySelector("#checkout")

function formatPrice(unformattedPrice) {
    return new Intl.NumberFormat('hu-HU', {
        style: 'currency',
        currency: 'HUF',
        minimumFractionDigits: 0,
    }).format(Math.round(unformattedPrice));
}

function delegate(parent, type, selector, handler) {
    parent.addEventListener(type, function (event) {
        const targetElement = event.target.closest(selector);

        if (this.contains(targetElement)) {
            handler.call(targetElement, event);
        }
    });
}

// a. (2 pont) Írj egy függvényt, amely a html-ben található minta,
// illetve phonePrices objektum alapján kigenerálja a teljes készletet az itemList div-be.
function generateItemList() {
    itemList.innerHTML = "";
    for (const [key, price] of Object.entries(phonePrices)) {
        const [brand, model] = key.split("-");
        const itemDiv = document.createElement("div");
        itemDiv.innerHTML = `
            <img src="assets/${key}.png" alt="${model}" />
            <p>${brand} ${model}</p>
            <span>${formatPrice(price)}</span>
            <button id="${key}">Kosárba</button>
        `;
        itemList.appendChild(itemDiv);
    }
}

generateItemList();

// b. (2 pont) Írj egy függvényt, amely a "Kosárba" gomb megnyomásakor elhelyezi az adott
// terméket a cart divben található táblázatba. A feladatot a delegate felhasználásával
// oldd meg, különben csak 1 pont szerezhető.

function addToCart(event) {
    const itemId = this.id;
    const price = phonePrices[itemId];
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${itemId}</td>
        <td>${formatPrice(price)}</td>
    `;
    cartList.appendChild(row);
}

delegate(itemList, "click", "button", addToCart);

// c. (3 pont) Írj egy függvényt, amely a coupon mező minden változására beírja az elérhető
// kedvezményt a discount tagbe, illetve a sum tagbe a kedvezménnyel csökkentett végösszeget.
// (Az összegek formázásához használd a formatPrice függvényt)

function updateDiscount() {
    const code = couponCode.value.trim();
    const discountPercentage = coupons[code] || 0;
    discount.textContent = `Kedvezmény: ${discountPercentage}%`;

    const total = Array.from(cartList.rows).reduce((sum, row) => {
        const price = parseInt(row.cells[1].textContent.replace(/\D/g, ""), 10);
        return sum + price;
    }, 0);

    const discountedTotal = total * (1 - discountPercentage / 100);
    sum.textContent = `Végösszeg: ${formatPrice(discountedTotal)}`;
}

couponCode.addEventListener("input", updateDiscount);


// d. (2 pont) Írj egy függvényt, amely a †ype legördülő minden
// változására szűri az itemList tartalmát.
function filterItems() {
    const type = filter.value;
    Array.from(itemList.children).forEach(item => {
        const matches = type === "all" || item.querySelector("p").textContent.startsWith(type);
        item.style.display = matches ? "block" : "none";
    });
}

filter.addEventListener("change", filterItems);

// e. (1 pont) A fizetés gomb megnyomására töröld a kosár tartalmát.
function clearCart() {
    cartList.innerHTML = "";
    sum.textContent = "";
    discount.textContent = "";
}

checkoutButton.addEventListener("click", clearCart);