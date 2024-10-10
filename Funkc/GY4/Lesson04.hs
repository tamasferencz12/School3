module Lesson04 where

----------------------------------
-- Rekurzió
----------------------------------

{-
Funkcionális programozásban nincsenek ciklusok, nincs for, nincs while, nincs foreach és más ezekhez hasonló konstrukció.
Az egyetlen egy dolog, amivel egy struktúrán (pl. listán) végig tudunk menni az nem más, mint a rekurzió.

Lássunk erre egy példát!
Hogyan tudjuk definiálni a korábbi add1 függvényt rekurzióval?
-}
add1' :: Num a => [a] -> [a]
-- Először végig kell gondolni, hogy mi lesz a függvény alapesete.
-- Jelen esetben ha nincs több elemünk, akkor egész egyértelmű, hogy mit kell csinálni. Ha nincs elem, akkor nincs elem.
add1' [] = []
-- Ez után szükséges végig gondolni, hogy mit kell akkor tenni, ha van elemem.
-- Minden elemhez hozzá kell adnom 1-et.
-- Ez azt jelenti, hogy először a lista eleméhez hozzáadok 1-et, majd utána a többihez is.
add1' (x:xs) = x + 1 : add1' xs
--             ^^^^^^^^^^^^^^^^
--             A listát, mint eredményt
--             fel kell építeni újra.

-- (:) előtt: hozzáadtunk az első elemhez egyet.
-- (:) után: A lista minden eleméhez hozzá kell adni egyet. Melyik függvény az, amelyik ezt tudja? Pont az, amelyiket éppen írjuk.

{-
Lássunk egy példát a működésre, hogy lépésenként mi történik:
add1' [1,5,9,0] ≡⟨ legalább egy elemű listám van, (x:xs) illeszkedik, x = 1, xs = [5,9,0] ⟩
1 + 1 : add1' [5,9,0] ≡⟨ legalább egy elemű listám van, (x:xs) illeszkedik, x = 5, xs = [9,0] ⟩
1 + 1 : (5 + 1 : add1' [9,0]) ≡⟨ legalább egy elemű listám van, (x:xs) illeszkedik, x = 9, xs = [0] ⟩
1 + 1 : (5 + 1 : (9 + 1 : add1' [0])) ≡⟨ legalább egy elemű listám van, (x:xs) illeszkedik, x = 0, xs = [] ⟩
1 + 1 : (5 + 1 : (9 + 1 : (0 + 1 : add1' []))) ≡⟨ üres a lista, [] ágon lévő eredmény kell ⟩
1 + 1 : (5 + 1 : (9 + 1 : (0 + 1 : []))) ≡
2 : (5 + 1 : (9 + 1 : (0 + 1 : []))) ≡
2 : (6 : (9 + 1 : (0 + 1 : []))) ≡
2 : (6 : (10 : (0 + 1 : []))) ≡
2 : (6 : (10 : (1 : []))) ≝ [2,6,10,1]
-}

{-
Definíció:
-- Rekurzív függvény: Olyan függvény, amely önmaga definiálásához saját magát használja fel.
-}

{-
Még egy példa, matematikában elcsépelt példa a rekurzióra: faktoriális
Pozitív egész számok szorzata n-ig
n! = n * (n - 1) * ... * 2 * 1
         ^^^^^^^^^^^^^^^^^^^^^
         Vegyük észre, hogy ez valójában (n - 1)!
-}

fact :: Integer -> Integer
-- Mi az alapeset? 0! = 1
fact 0 = 1
-- Nem 0 esetben a faktorálist rekurzívan számoljuk ki.
fact n = n * fact (n - 1)

-- Mi a probléma a fenti definícióval ebben a formában?

{-
Működés egy példán:
fact 5 ≡⟨ nem 0 ⟩
5 * fact (5 - 1) ≡
5 * fact 4 ≡⟨ nem 0 ⟩
5 * (4 * fact (4 - 1)) ≡
5 * (4 * fact 3) ≡⟨ nem 0 ⟩
5 * (4 * (3 * fact (3 - 1))) ≡
5 * (4 * (3 * fact 2)) ≡⟨ nem 0 ⟩
5 * (4 * (3 * (2 * fact (2 - 1)))) ≡
5 * (4 * (3 * (2 * fact 1))) ≡⟨ nem 0 ⟩
5 * (4 * (3 * (2 * (1 * fact (1 - 1))))) ≡
5 * (4 * (3 * (2 * (1 * fact 0)))) ≡⟨ most már 0 ⟩
5 * (4 * (3 * (2 * (1 * 1)))) ≡
5 * (4 * (3 * (2 * 1))) ≡
5 * (4 * (3 * 2)) ≡
5 * (4 * 6) ≡
5 * 24 ≡
120
-}

-- Feladatok:

-- Definiáld a sum' függvényt, amely összegzi egy számokat tartalmazó lista elemeit.
-- A listáról feltehető, hogy véges.
-- Mi lesz a legáltalánosabb típusa?
sum' :: Num a => [a] -> a
sum' [] = 0
sum' (x : xs) = x + sum' xs

-- Definiáld a product' függvényt, amely összeszorozza egy számokat tartalmazó lista elemeit.
-- A listáról feltehető, hogy véges.
-- Mi lesz a legáltalánosabb típusa?
product' :: Num a => [a] -> a
product' [] = 1
product' (x : xs) = x * product' xs

-- Definiáld az elem' függvényt, amely megállapítja, hogy egy elem benne van-e egy listában.
-- A függvénynek működnie kell végtelen listán, de csak akkor, ha a keresett elem benne van a listában. (Mert csak akkor van értelme.)
-- Mi lesz a legáltalánosabb típusa?
elem' :: Eq a => a -> [a] -> Bool
elem' y [] = False
elem' y (x : xs) = x == y || elem' y xs

-- SZÉP KÓD: Ha az eredmény egy Bool típusú érték, akkor felesleges bármilyen jellegű elágazást használni. A logikai műveletek elegek.

-- Definiáld a genericLength' függvényt, amely megadja, hogy egy lista hány elemű.
-- A listáról feltehető, hogy véges.
-- Mi lesz a lehető legáltalánosabb típusa?
genericLength' :: Num b => [a] -> b
genericLength' [] = 0
genericLength' (x : xs) = 1 + genericLength' xs
-- genericLength' xs = sum' [1 | _ <- xs]
-- Az eredeti függvény a Data.List modulban érhető el.

-- HELYES KÓD: Nem érdemes a sima length függvényt használni, mert az csak Int-et ad vissza, amelyről megtanultuk,
--             véges méretű, értékei -2⁶³ ─ 2⁶³-1 között vannak.

-- Példa feladat, ahol el tudja rontani a rossz függvény használata a megoldást:
-- Definiáljuk egy másik módon a faktoriális függvényt:
-- Segítség: a faktoriális csak 1-től n-ig a szorzata a számoknak. Hogy tudunk 1-től n-ig számokat generálni?
--           Melyik függvényt tudjuk felhasználni utána?
factorial :: Integral a => a -> a
factorial n = product' [1..n]

-- Definiáld a replicateFact függvényt, amely egy adott lista elemszámának faktoriálisaszor ismétel meg egy adott elemet.
-- replicateFact [1,2] 'a' == "aa" -- 2! = 2
-- replicateFact [] 'a' == "a"  -- 0! = 1
-- replicateFact "abc" 'b' == "bbbbbb" -- 3! = 6
-- replicateFact "abcd" 'c' == "cccccccccccccccccccccccc" -- 4! = 24
-- Csak meglévő függvényekkel definiáljuk rekurzió nélkül, de rosszul.
-- Használjuk a replicate, factorial, length függvényeket!
replicateFact :: [a] -> b -> [b]
replicateFact i e = replicate (factorial (fromIntegral (length i))) e

-- Próbáljuk ki:
-- replicateFact [1..21] 'a'
-- Mi lesz az eredmény?
-- A 21! egy nulla vagy attól kisebb szám?

-- A probléma ott van, hogy az Int korlátos, a length pedig csak Int-et ad vissza. Mivel 21! > 2⁶³-1,
-- ezért túlcsordulás történik, ami azt jelenti, hogy negatív lesz az eredmény.
-- Ezt ki is lehet próbálni: (maxBound :: Int) + 1 eredménye egy negatív szám lesz. (maxBound :: Int) == 2⁶³-1

-- Próbáljuk meg jobban definiálni, mi van akkor, ha átalakítjuk az Int-et Integer-ré az ismert fromIntegral függvénnyel?
-- A replicate függvényt cseréljük le a fenti rep függvényre, ugyanazt csinálja, csak az Integer-rel működik.
replicateFact' :: [a] -> b -> [b]
replicateFact' i e = undefined

-- Próbáljuk ki:
-- replicateFact [1..21] 'a'
-- Mi lesz az eredmény?
-- Ha sok 'a', akkor már közelebb járunk a jó megoldáshoz*, de nem lesz úgy jó soha.
-- Ha még mindig üres lista, akkor a factorial függvényen kívülre került a fromIntegral, és továbbra is látni,
-- hogy nem igazán segít az átalakítás.
-- Maga a számolás ténye Int-ként történik meg és az az, ami elrontja az egészet.

-- *Ha van sok 'a', akkor egy 2⁶³ elemű listával lehet elrontani a length függvényt, hiszen túlcsordulás miatt a length eredménye egy negatív szám lesz.
--  Ennek az eredményét ne várjuk meg, mert valahol több ezer év lesz, mire visszaadja az üres listát arra.

{-
Tanulság: NE HASZNÁLJUNK olyan függvényeket, amik közvetlen csak Int-tel dolgoznak.
          Használjuk ezeknek megfelelő generic párjait:

Int-es fgv    │    length     │    replicate     │    take     │    drop     │     (!!)     │    splitAt      ⟵ Ezek használatát kerüljük
──────────────┼───────────────┼──────────────────┼─────────────┼─────────────┼──────────────┼───────────────
generic párja │ genericLength │ genericReplicate │ genericTake │ genericDrop │ genericIndex │ genericSplitAt  ⟵ Ezeket használjuk helyettük

Az összes ilyen függvény a Data.List modulban található!
-}

-- Feladatok:
-- Definiáld a (+++) függvényt, amely két listát összefűz!
(+++) :: [a] -> [a] -> [a]
(+++) [] ys = ys
(+++) (x : xs) ys = x : (xs +++ ys)

infixr 5 +++
-- Megj.: Az eredeti függvény neve (++).

-- Definiáld az előző óráról ismert concat' függvényt rekurzívan!
concat' :: [[a]] -> [a]
concat' [] = []
concat' (xs : xss) = xs +++ concat' xss
-- Definiáld a slowReverse függvényt, amely egy lista elemeinek sorrendjét megfordítja egy naív módon.
-- A listáról feltehető, hogy véges.
slowReverse :: [a] -> [a]
slowReverse [] = []
slowReverse (x : xs) = slowReverse xs +++ [x]

{-
Nem mindegyik rekurzió alapesete ugyanaz.
Nem mindig az üres lista az alapeset.
Nem mindig van alapeset. (Legsűrűbb esetben van.)
A rekurzió lépése lehet sokkal érdekesebb is annál, mint hogy egy listaelemet elhagyunk.
Nyilván nem csak listán lehet rekurziót használni, de a félévben azzal fogunk a legtöbbet foglalkozni.
-}

-- Feladatok:
-- Definiáld a repeat' függvényt, amely egy adott elemet a végtelenségig ismétel.
repeat' :: a -> [a]
repeat' x = x : repeat' x

-- Definiáld a last' függvényt, amely visszaadja egy lista utolsó elemét.
-- A listáról feltehető, hogy véges.
last' :: [a] -> a
last' [x] = x
last' (x : xs) = last' xs

-- Definiáld az init' függvényt, amely kitörli egy lista utolsó elemét; az elejét tartja meg.
init' :: [a] -> [a]
init' [x] = [] 
init' (x:xs) = x : init' xs

-- Definiáld a zip' függvényt, amely két lista elemin párhuzamosan haladva összeteszi azokat rendezett párokba.
-- A függvény a rövidebb lista hosszáig működik.
-- (Ez a továbbiakban azt jelenti, hogy ha valamelyik lista több elemű, a fennmaradó elemeket abból a listából eldobjuk.)
zip' :: [első] -> [második] -> [(első,második)]
zip' [][] = []
zip' [](x:xs) = []
zip' (x:xs) [] = []
zip' (x:xs) (y:ys) = (x, y) : zip' xs ys

-- Definiáld a nub' függvényt, amely egy lista ismétlődő elemeit törli megtartva csak az elsőket.
-- nub' [1,2,1,3,5,3,2,2,3,3,1,1,2,4,4] == [1,2,3,5,4]
-- nub' [2,1,2,2] == [2,1]
-- nub' [1,2,2,2] == [1,2]
nub' :: Eq a => [a] -> [a]
nub' [] = []
nub' (x:xs) = x : nub' [y | y <- xs, x /= y]

----------------
-- Számozás
----------------

{-
Sűrűn találkozni olyannal, hogy a "valahányadik elemmel" kell valamit csinálni.
Esetleg olyannal, hogy "minden párosadik elemmel" vagy hasonló.
Ugyan egyszerű esetek átfogalmazhatók csak mintaillesztésre (pl. minden párosadik elem esetén csak kettesével kell lépkedni a listán),
bonyolultabb esetek esetleg "trükközést" igényelhetnek. Trükközés helyett egy általános módszer megszámozni az egyes szavakat, majd
az adott feladatnak megfelelően fel lehet használni a számokat, számozott szavakat.
-}

-- Feladat:
-- Számozzuk meg egy szövegnek az egyes szavait 1-től kezdve. Az eredmény legyen egy rendezett párokból álló lista, az első komponens a szó száma, a második maga a szó.
--numberWords ::(Num a, Enum a) => String -> [(a, String)]
--numberWords xs = zip' [1..] [words xs]
