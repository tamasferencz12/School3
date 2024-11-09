module Lesson06 where

-- Feladatok:
-- Definiáld a tails' függvényt, előállítja egy lista összes lehetséges végződését!
-- tails' [1,2,3] == [[1,2,3],[2,3],[3],[]]
-- tails' "abcd" == ["abcd","bcd","cd","d",""]
tails' :: [a] -> [[a]]
tails' [] = [[]]
tails' xxs@(_ : xs) = xxs : tails' xs
-- A függvény a Data.List modulban található!

--------------------------------------------
-- Érdekesebb rekurziók
--------------------------------------------

-- Definiáld az inits' függvényt, amely előállítja egy lista összes prefixét!
-- inits' [1,2,3] == [[],[1],[1,2],[1,2,3]]
-- inits' "ab" == ["","a","ab"]
-- inits' [5,10,9,1,0] == [[],[5],[5,10],[5,10,9],[5,10,9,1],[5,10,9,1,0]]
inits' :: [a] -> [[a]]
inits' [] = [[]]
inits' (x : xs) = [] : [x : y | y <- inits' xs]
-- A függvény a Data.List modulban található!

-- Definiáld a quickSort függvényt, amely a quick sort műveletét végzi el, azon módszerrel rendezi a lista elemeit.
-- A quick sort úgy rendezi az elemeket, hogy először választunk egy összehasonlítási pontot, értéket (angolul "pivot"),
-- és az összes elemet ezen elemhez képest rendezzük. Az attól kisebbek balra, az attól nagyobb vagy egyenlők pedig jobbra lesznek; magát a pivot-ot pedig a két rész közé helyezzük.
-- Az így keletkezett két részt természetesen ugyanúgy rendezni kell az azonos algoritmussal.
-- A "pivot" az első elem legyen, láncolt lista esetén az a legegyszerűbb választás.
-- A listáról feltehető, hogy véges.
quickSort :: undefined
quickSort = undefined

-- Definiáld a mergeSort függvényt, amely egy lista elemeit rendezi az összefésüléses rendezés algoritmusát használva.
-- Az összefésüléses rendezés úgy működik, hogy a kezdeti listát két részre bontjuk, majd mindkét részlistán ugyanezt az algoritmust használjuk
-- addig, amíg az alapesetig el nem érünk, tehát amiről egyértelműen el tudjuk dönteni, hogy rendezett.
-- Ez után elkezdjük visszaépíteni a legkisebb egyértelműen rendezett darabokból a rendezett listát összefésüléssel.
-- Ezen a ponton tudjuk, hogy az összes részlista, amit kapunk az rendezett, tehát az összefésülés során feltehetjük, hogy a részlisták már rendezettek.
-- Két rendezett listát úgy fésülünk össze, hogy összehasonlítjuk az első két elemet, megnézzük, hogy melyik a kisebb,
-- azt tesszük az eredménylista elejére, majd azon a listán lépünk a rekurzióban, ahol a kisebb elem volt, a másik listát meghagyjuk, ahogy volt.
-- Ha ezt eljátszuk, akkor a végén egy rendezett listát kell kapnunk.

-- Segítség: A where/let-in kelleni fog, hogy az összefésülés műveletét definiáljuk, hiszen olyan műveletet definiálunk, ami csak bizonyos előfeltétellel működik helyesen.
-- Segítség: A lista felezéséhez lassú használni a genericLength-et, az keresztülmegy az egész listán, csak hogy egy számot megkapjunk, majd szétválasztani ott még egyszer ugyanannyi munka.
--           Érdemes definiálni egy segédfüggvényt, amely a listát megfelezi. Az ötlet annyi, hogy legyen két másolatunk az eredeti listáról, az egyiken egyesével lépkedünk, a másikon kettesével.
--           Ha az egyiknek elérünk a végéig (amelyiken kettesével lépkedtünk, akkor a másikban pont a lista másik fele van.
-- A listáról feltehető, hogy véges.
mergeSort :: undefined
mergeSort = undefined

-- Állítsuk elő egy lista elemeinek az ismétlés nélküli kombinációit! (A lista elemeit tekintsük különbözőknek.)
-- combinations (-1) "abcd" == []
-- combinations 0 "abcd" == [[]]
-- combinations 1 "abcd" == ["a","b","c","d"]
-- combinations 2 "abcd" == ["ab", "ac", "ad", "bc", "bd", "cd"]
-- combinations 3 "abcd" == ["abc","abd","acd","bcd"]
-- combinations 4 "abcd" == ["abcd"]
-- combinations 5 "abcd" == []
-- combinations 2 [1,1,2,2] == [[1,1],[1,2],[1,2],[1,2],[1,2],[2,2]]
-- combinations :: undefined
combinations n _ | n < 0 = []
combinations 0 _ = [[]]
combinations n [] = []
combinations n (x : xs) = [x : y | y <- combinations (n - 1) xs] ++ combinations n xs

-- Definiáld a deletions függvényt, amely egy elemet töröl egy listából az összes lehetséges módon!
-- deletions [1,2,3] == [[2,3],[1,3],[1,2]]
-- deletions "alma" == ["lma","ama","ala","alm"]
deletions :: undefined
deletions = undefined

-- Definiáld az insertions függvényt, amely beszúr egy elemet egy listába az összes lehetséges módon!
-- insertions 1 [] == [[1]]
-- insertions 0 [1,2,3] == [[0,1,2,3],[1,0,2,3],[1,2,0,3],[1,2,3,0]]
-- insertions 'a' "sdfg" == ["asdfg","sadfg","sdafg","sdfag","sdfga"]
insertions :: undefined
insertions = undefined

-- Definiáld a permutations függvényt, amely megadja egy lista összes permutációját!
-- Az egyszerűbb megoldás érdekében feltehető a listáról, hogy véges. (Megoldható úgy is, hogy végtelen listával is működjön, de az exponenciálisan nehezebb.)
permutations' :: undefined
permutations' = undefined
-- A függvény a Data.List modulban található!

-------------------------
-- Típusszinonimák
-------------------------

{-
Az első, amivel említés szintjén találkoztunk az az, hogy tudjuk, hogy Haskellben a String nem más, mint [Char].

Típusszinonimák szintaxisa az alábbiként néz ki Haskellben:

type <Típusnév> [típusparaméterek...] = <Létező típus>

pl. a String-et, ahogy korábban is láttuk, az alábbi módon lehet definiálni:
type String = [Char]

A típusszinonimák semmiben sem különböznek azon típusoktól, amelyekre a szinonima definiálva lett,
teljesen szabadon felcserélhetőek.
-}

-- Feladatok:
-- Definiáld a Point típusszinonimát, amely jelöljön egy Integer-ekből álló rendezett párt.


-- Definiáld a moveX függvényt, amely egy pontot az X-tengely mentén eltol egy adott értékkel.
-- Használjuk az előbb definiált Point típust.
moveX :: undefined
moveX = undefined

{-
Mire is jó a típusszinonima, ha teljesen ugyanúgy viselkedik, mint az eredeti típus, amire a szinonimát készítettük?
Nézzük az alábbi példát:
-}
person :: (String,String,String,String,Int)
{-
Mi szeretne lenni az a sok String? Mint programozók, egy-két ötletünk lehet, pl. illető neve, lakcím, telefonszám, ímélcím, stb.
Az Int-ről ki tudjuk találni, hogy az az illető életkora lesz.
Ember legyen a talpán, aki ennyiből megmondja, hogy most melyik String mit jelöl.
A félév elején arról volt szó, hogy Haskellben a típus beszél, nem a változók nevei. A változók itt ráadásul nehezen beszélnének, hiszen egy konstans értéket
reprezentál a típus.

Persze, hogy ha ezen komment alá tekintünk, kiderül, hogy melyik adat mi szeretne lenni.
Nagy általánosságban azonban csak a függvény típusához lesz hozzáférésünk, nem a definícióhoz.
-}
person = ("Én","Alma utca 10","06-20-nemmondommeg","alma@alma.hu",20)

-- Tegyük egy kicsit beszédesebbé a típusát a person-nek, hogy tudjuk, hogy melyik adat mi szeretne lenni!

person2 :: undefined
person2 = undefined person

-- SZÉP KÓD: Erre való a típusszinonima, hogy a kódunkat olvashatóbbá, informatívabbá tegyük.
--           Használjuk nyugodtan, semmilyen lassulással nem jár a program szempontjából, viszont sokkal jobb annak,
--           aki olvassa a kódot (persze ha jók és beszédesek a nevek).

{-
Természetesen a veszélye is megvan ennek. Mivel a típusszinonimák szabadon felcserélhetőek, simán el lehet végezni olyan műveleteket rajtuk,
amelyeknek esetleg logikailag semmi közük egymáshoz.
-}
type Age' = Int -- fentebb kéne legyen definiálva
type Euro = Int

eztNemKéne :: Euro -> Age' -> Int
eztNemKéne e a = e + a

-- Semmi hiba nincs a fenti kódban, pedig jó lenne, ha lenne, mert egy eurónak egy életkorhoz sok köze nincs.
-- Hogy mit lehet ezzel csinálni, az a következő órán kiderül.
