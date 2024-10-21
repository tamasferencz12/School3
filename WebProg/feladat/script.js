function newElement(elementType, parent, fillWithContent) {
  const elem = document.createElement(elementType);
  fillWithContent(elem);
  parent.appendChild(elem);
}

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

const railServices = [
  {
    startCity: "New York",
    endCity: "Washington D.C.",
    length: 225,
    time: 6,
    price: 8,
  },
  {
    startCity: "San Francisco",
    endCity: "Los Angeles",
    length: 380,
    time: 10,
    price: 12,
  },
  {
    startCity: "Chicago",
    endCity: "St. Louis",
    length: 300,
    time: 9,
    price: 10,
  },
  {
    startCity: "Seattle",
    endCity: "Portland",
    length: 175,
    time: 5,
    price: 6,
  },
  {
    startCity: "Boston",
    endCity: "New York",
    length: 215,
    time: 7,
    price: 9,
  },
  {
    startCity: "Philadelphia",
    endCity: "Baltimore",
    length: 95,
    time: 3,
    price: 4,
  },
  {
    startCity: "Miami",
    endCity: "Orlando",
    length: 235,
    time: 8,
    price: 9,
  },
  {
    startCity: "Dallas",
    endCity: "Houston",
    length: 240,
    time: 8,
    price: 9,
  },
  {
    startCity: "Denver",
    endCity: "Salt Lake City",
    length: 525,
    time: 15,
    price: 15,
  },
  {
    startCity: "Atlanta",
    endCity: "Charlotte",
    length: 245,
    time: 8,
    price: 9,
  },
];

// Task 1
const longestRailLine = railServices.find(
  (service) =>
    service.length ===
    Math.max(...railServices.map((service) => service.length))
);
console.log(longestRailLine);
document.querySelector("#task-1").innerText =
  longestRailLine.startCity + " - " + longestRailLine.endCity;

// Task 2
const x = document.getElementById("task-2");
const moreThan5HoursRoutes = railServices.filter((service) => service.time > 5);

newElement("tbody", x, (tbody) => {
  moreThan5HoursRoutes.forEach((service) => {
    newElement("tr", tbody, (tr) => {
      newElement("td", tr, (td) => (td.innerText = service.startCity));
      newElement("td", tr, (td) => (td.innerText = service.endCity));
    });
  });
});

//Task3
const y = document.getElementById("task-34");
railServices.forEach((service) =>
  newElement(
    "li",
    y,
    (li) =>
      (li.innerHTML =
        service.startCity +
        " - " +
        service.endCity +
        ": " +
        service.price +
        "$")
  )
);

//Task4

delegate(y, "li", "click", (event, closestChild) => {
  closestChild.classList.toggle("kivalasztva");
});

//Task5
document
  .querySelector("#task-5-plusz-gomb")
  .addEventListener("click", (event) => {});
document
  .querySelector("#task-5-minusz-gomb")
  .addEventListener("click", (event) => {});
