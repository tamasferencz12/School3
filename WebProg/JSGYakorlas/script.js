function ujElem(tipus, szulo, tartalommalFeltolt) {
  const elem = document.createElement(tipus);
  tartalommalFeltolt(elem);
  szulo.appendChild(elem);
}

function delegal(szulo, gyerek, mikor, mitortenik) {
  function eventHandlerFunction(event) {
    let eventTarget = event.target;
    let eventHandler = this;
    let closestChild = eventTarget.closest(gyerek); // ez csak felfele néz

    if (eventHandler.contains(closestChild)) {
      mitortenik(event, closestChild);
    }
  }

  szulo.addEventListener(mikor, eventHandlerFunction);
}

const car = [
  { name: "Toyota GR86", value: "60.000$", fuelType: "Gasoline" },
  { name: "Skoda Octavia vRs", value: "20.000$", fuelType: "Biodiesel" },
  { name: "Ford Fiesta", value: "50.000$", fuelType: "Biodiesel" },
  { name: "Volkswagen Golf V", value: "40.000$", fuelType: "Biodiesel" },
  { name: "BMW 3 Series", value: "80.000$", fuelType: "Gasoline" },
];

const lista = document.querySelector("#cars");
const dieselCars = document.querySelector("#diesel");

ujElem("thead", lista, (thead) => {
  ujElem("tr", thead, (tr) => {
    ujElem("th", tr, (th) => (th.textContent = "Brand"));
    ujElem("th", tr, (th) => (th.textContent = "Price"));
    ujElem("th", tr, (th) => (th.textContent = "Fuel Type"));
  });
});

ujElem("tbody", lista, (tbody) => {
  car.forEach((car) => {
    ujElem("tr", tbody, (tr) => {
      ujElem("td", tr, (td) => (td.textContent = car.name));
      ujElem("td", tr, (td) => (td.textContent = car.value));
      ujElem("td", tr, (td) => (td.textContent = car.fuelType));
    });
  });
});

delegal(lista, "tr", "click", (event, tr) => {
  const fuelCell = tr.querySelectorAll("td")[2];

  fuelCell.textContent === "Biodiesel"
    ? (fuelCell.textContent = "Gasoline")
    : (fuelCell.textContent = "Biodiesel");
});

const onlyDieselCars = car
  .filter((c) => c.fuelType.toLowerCase() === "biodiesel")
  .map((c) => c.name);

onlyDieselCars.forEach((diesel) =>
  ujElem("li", dieselCars, (li) => (li.innerHTML = diesel))
);

