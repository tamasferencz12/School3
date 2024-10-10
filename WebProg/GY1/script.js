//console.log("alma", 5 + "5", 5 - 5);

/**
 * # Cim
 * ## Alcim
 * Osszeadja a szamokat
 * @param {Number} a
 * @param {Number} b
 * @returns
 */
function osszead(a, b) {
  let osszeg = a + b;
  return osszeg;
}

console.log(osszead(1, 2));

let nevek1 = ["Gergo", "Laci", "Dalma"];
const nevek2 = ["Laura", "Istvan", "Nandor"]; // nem mutathat uj helyre a valtozo
const szam = 15;

nevek1[0] = "Viktoria";
nevek1[8] = "Abel";
nevek1[-1] = "Bence";
nevek1["5"] = "Miklos";
nevek1["alma"] = "Gabor";
nevek1.alma = "Kiskutya";

console.log(nevek1);
console.log(nevek1.length);

for (let i = 0; i < nevek1.length; i++) {
  console.log(nevek1[i]);
} //valtoztatast is lehet

//for of - elemeken megy vegig
//for in - indexeken megy vegig

for (let name of nevek1) {
  //nev = "Valaki";
  console.log(name);
} // kiirok

for (let name in nevek1) {
  //nev = "Valaki";
  console.log(name);
} // kiirok

let ember1 = {
  nev: "Gergo",
  kor: 30,
  szin: "fekete",
  isMarried: false,
  allatok: [
    { nev: "Macska", kor: 2, szin: "feher" },
    { nev: "Kutya", kor: 1, szin: "fekete" },
  ],
};

let fajokEmoji = {
  Macska: "macskaEmoji",
  lemur: "lemurEmoji",
  Kutya: "kutyaEmoji",
};

for (const allat of ember1.allatok) {
  let emoji = fajokEmoji[allat.nev];
  let emojiFajHossz = fajokEmoji[allat.nev]?.length;
  console.log(`${ember1.nev} egyik allata: ${allat.nev} ${emoji}`);
}

