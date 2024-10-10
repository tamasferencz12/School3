//be --> ki
/**
 * JS docsot erdemes hasznalni
 * @param {akarmi} param1
 * @returns
 */
function pelda(param1) {
  return param1 + 3;
}

const szamok = [1, 5, 23, -8, 45, 8, -12, 641, -23, 23];

// tomb[T] --> logikai
// Eldontes, egyeb keresesek
//Van a tombben paros szam?
let van = false;
for (const szam of szamok) {
  van = szam % 2 == 0;
  if (van) {
    break;
  }
}
console.log(van);

const paros = function (szam) {
  return szam % 2 == 0;
};

let szam = 5;
paros(szam);

console.log(szamok.some(paros));
console.log(
  szamok.some(function (szam) {
    return szam % 2 == 0;
  }),

  szamok.some((szam) => szam % 2 == 0), // van olyan, amire teljesul
  szamok.every((szam) => szam % 2 == 0) // mindegyikre teljesul?
);

// tomb[T] --> T
//kivalasztas
console.log(szamok.find((szam) => szam < -1000));

const emberek = [
  { nev: "Peti", eletkor: 27 },
  { nev: "Gergo", eletkor: 28 },
  { nev: "Aron", eletkor: 19 },
  { nev: "Rezso", eletkor: 32 },
  { nev: "Alma", eletkor: 18 },
];

console.log(
  emberek.find((emberek) => emberek.nev == "Peti")?.eletkor ?? "Nincs Laura"
);

// tomb[T] --> Y
//kivalasztas (index)
console.log(szamok.findIndex((szam) => szam < -1000));

// tomb[T] --> tomb[T]
// kivalogatas
console.log(szamok.filter((szam) => szam > 20));
console.log(emberek.filter((ember) => ember.eletkor > 25));
//rendezes
//console.log(emberek.sort((balszam, jobbszam) => balszam - jobbszam));
console.log(
  emberek.toSorted((ember1, ember2) => ember1.eletkor - ember2.eletkor)
);

// meggyfa, nyitva, Nyx, meggyoz
// meggyoz, meggyfa, Nyx, nyitva --> nem lehet detektalni magyar dupla es tripla betuket

// tomb[T] --> tomb[Y]
console.log(szamok.map((szam) => szam * 2));
console.log(
  emberek
    .filter((ember) => ember.eletkor <= 25)
    .toSorted((ember1, ember2) => ember1.eletkor - ember2.eletkor)
    .map((ember) => ember.nev)
);

////////////////////////////////////////////////////////////////
const filmek = [
  "Star Wars",
  "Jurassic Park",
  "The Matrix",
  "The Shawshank Redemption",
  "Pulp Fiction",
  "The Godfather",
  "Inception",
];

