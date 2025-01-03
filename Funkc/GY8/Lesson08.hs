module Lesson08 where

-----------------------------
-- Paraméteres típusok
-----------------------------

-- Motiváció:
{-
Emlékezzünk vissza, hogy léteznek a parciális függvények: head, tail, div, mod, stb.
Továbbá emlékezzünk arra is, hogy a parciális függvények nem működnek minden lehetséges bemeneti értékkel, melynek a következménye, hogy
olyan csúnya értékek átadásakor a program menthetetlenül elszáll (tiszta világban nincs try, nincs catch, nincs semmi, mert a kivétel elkapása nem egy tiszta dolog).

Ezért az ötlet az volna, hogy próbáljuk meg valahogy az előbb említett függvényeket totálissá tenni.
Szerencsére vannak saját típusaink, azokat valahogy megpróbálhatjuk használni.
-}

-- Definiáld a safeHead' függvényt, amely ha van legalább egy elemünk a listában, akkor visszaadja azt, üres lista esetén pedig "semmit" ad vissza.
-- Segítség: Természetesen ezt a "semmit" valahogy reprezentálni kell. Az év elején megbeszéltük, hogy olyan nincs, hogy egy függvény csak csinál valamit,
--           de nincs eredménye. Definiáljunk pl. egy típust, ami Int-et tárol magában és definiáljuk úgy a safeHead'-et.

data MaybeInt = JustInt Int | NoInt deriving (Show, Eq)

safeHead' :: [Int] -> MaybeInt
safeHead' [] = NoInt
safeHead' (x : _) = JustInt x

-- Definiáld a safeHead''-t most Char-ra.


data MaybeChar = JustChar Char | NoChar deriving (Show, Eq)

safeHead'' :: [Char] -> MaybeChar
safeHead'' [] = NoChar
safeHead'' (x : _) = JustChar x


-- Definiáld a safeHead'''-t Bool-ra.


data MaybeBool = JustBool Bool | NoBool deriving (Show, Eq)

safeHead''' :: [Bool] -> MaybeBool
safeHead''' [] = NoBool
safeHead''' (x : _) = JustBool x


{-
Mi a probléma?
Emlékezzünk vissza a head függvény típusára. head :: [a] -> a
Tetszőleges értékekkel működik, lehet az String, Char, Integer, Float, Bool, másik lista, rendezett pár, stb.
Mindegyikre nem tudunk ezzel a módszerrel típust generálni, hiszen ezekből végtelen van.
Szerencsére meg tudjuk mi is oldani egy típusban, hogy tetszőleges típusokkal működjön.

Ehhez csak annyit kell tenni, hogy a típusnak egy típusváltozót fel kell venni paraméterül.
-}

-- Definiáld a Maybe' típuskonstruktort, amelynek legyen egy típusparamétere.
-- Legyen továbbá két konstruktora, egy Nothing' és egy Just', amelynek a paramétere legyen a felvett típusváltozó.

data Maybe' a = Just' a | Nothing' 

-- Megjegyzés, "definíció": Ahogy az (érték)konstruktor egy bizonyos típusú értéket képes létrehozni, úgy a típuskonstruktor egy típust hoz létre.
-- Év elején volt róla szó, hogy a Haskell egy statikusan típusos nyelv. Ez azt jelenti, hogy mindennek van fordítási időben típusa. Még a Maybe'-nek is, meg az összes többi típusnak is.
-- Nézzük meg, hogy mi a Maybe' típusa! (Mivel ez típus, a :t nem működik, helyette vagy :i-t vagy :k-t kell használni.)
-- Tudunk-e Maybe' típusú értéket definiálni?
-- Tehát:
-- m :: Maybe'
-- m = ...
-- Van-e értelmes definíciója m-nek? (akár végtelen rekurzió, akár undefined)

-- Definiáld a safeHead függvényt úgy, hogy minden típusra működjön helyesen!
safeHead :: [a] -> Maybe a
safeHead [] = Nothing
safeHead (x : _) = Just x

-- Definiáld a safeDiv függvényt, amely a 0-val való osztást kiszűri, tehát ha a második paramétere 0, akkor az eredmény legyen Nothing,
-- egyébként osszuk el az elsőt a másodikkal.
safeDiv :: Integral a => a -> a -> Maybe a
safeDiv _ 0 = Nothing
safeDiv a b = Just (div a b)

-- Definiáld az add függvényt, amely két lehetségesen hibás értéket összead. Ha valamelyik érték Nothing, az eredmény legyen Nothing.
add :: Num a => Maybe a -> Maybe a -> Maybe a
add (Just a) (Just b) = Just (a + b)
add _        _        = Nothing

add' :: Num a => Maybe a -> Maybe a -> a
add' (Just a) (Just b) = a + b
add' (Just a) Nothing  = a
add' Nothing  (Just b) = b
add' Nothing  Nothing  = 0

-- Definiáld a doubleHead függvényt, amely egy listák listájának veszi az első listájának első elemét, ha az létezik.
doubleHead :: [[a]] -> Maybe a
doubleHead [] = Nothing
doubleHead ([] : _) = Nothing
doubleHead ((x : _) : _) = Just x

-- Mi lesz a probléma akkor, ha az eredmény Nothing?
-- Válasz:

-- Definiáld a divHead függvényt, amely egy listának az első elemét elosztja egy második paraméterül kapott egész számmal.
divHead :: undefined
divHead = undefined

-- A probléma itt is ugyanaz lesz, mint az előbb. Mit tudunk, ha az eredmény Nothing?

-- Definiáld a lookup' függvényt, amely egy adott kulcsú értéket megkeres egy listában. A lista rendezett párokból áll, amelyeknek az első komponensét tekintjük
-- a kulcsnak, a másodikat pedig az értéknek. Előfordulhat, hogy nincs a listában a kulcs, ekkor Nothing legyen az eredmény.
lookup' :: Eq k => [(k, v)] -> k -> Maybe v
lookup' [] _ = Nothing
lookup' ((k, v) : xs) k'
  | k == k' = Just v
  | otherwise = lookup' xs k'

-- Definiáld az elemIndex' függvényt, amely visszaadja az első adott elem indexét egy listából, ha létezik olyan.
-- A típusa legyen minél általánosabb.
elemIndex' :: (Eq b, Integral a) => [b] -> b -> Maybe a
elemIndex' xs x = lookup' (zip xs [0..]) x
-- Megj.: Az eredeti függvény a Data.List-ben van, de csak Int-et ad vissza tetszőleges szám helyett, így a használata nem javallott.

-----------------------------------------------------------

-- Legyen adott az alábbi data:
data SelectValue = First | Second

-- Definiáld a select függvényt, amelynek három paramétere van, az első eldönti, hogy a következő kettő közül melyiket adjuk vissza.
-- Mi lesz az eredmény típusa?
--               Ez a kettő maradjon a és b
--                       v    v
select :: SelectValue -> a -> b -> Either a b
select First x _ = Left x
select Second _ x = Right x

-- Mi lehet erre a megoldás?
-- Egy új típus kell rá definiálni olyan formában, amely tudja magáról, hogy az értékei között vagy "a" típusú érték vagy "b" típusú érték lehet.
-- Definiáljunk egy ilyen datát; ezt a datát Either-nek szokás nevezni, továbbá két konstruktora van, Left és Right!

data Either' a b = Left' a | Right' b

-- Most már meg tudjuk csinálni a fenti feladatot.
{-
Az előbb definiált Either típusban több információ elfér, mint egy Maybe-ben hibakezelés szempontjából.
Először nézzük a naív módját a hibakezelésnek:
-}
type ErrorOr a = Either String a
{-
A lényeg annyi, hogy ha hibás eredményünk van, akkor egy String-et adunk vissza és abba írhatunk valamilyen szöveget
tájékoztatva a felhasználót a hibáról. Nem túl struktúrált, de kezdetben megfelel.
-}

-- Definiáljuk újra a doubleHead függvényt, csak most az eredménye egy "ErrorOr a" típusú érték legyen
doubleHeadErrorOr :: [[a]] -> ErrorOr a
doubleHeadErrorOr [] = Left "Outer list is empty"
doubleHeadErrorOr ([] : _) = Left "Inner list is empty"
doubleHeadErrorOr ((x : _) : _) = Right x

type Maybe'' a = Either () a

-- Mint ahogy látható, a String-be lényegében azt írunk, amit szeretnénk, ami nem feltétlenül túl segítőkész, főleg ha viccesek és lusták vagyunk,
-- és azt adjuk vissza hibaként, hogy "találd ki!".
-- Egy kicsit kultúráltabban is lehet hibát kezelni, ahogy a nagyvilágban is történik.
-- Egy új típust lehet definiálni, amely a lehetséges hibákat reprezentálja.
-- Ez a módszer leginkább akkor érdekes, ha több hibaforrás lehetséges, mint pl. a doubleHead-ben, divHead-ben, meg majd a háziban.

-- Definiáld az Error saját típust! A konstruktorai olyanok legyenek, hogy a doubleHead függvény két hibáját tudja jelezni.

data Error = OuterEmpty | InnerEmpty deriving Show

-- Definiáld a doubleHeadError függvényt!
doubleHeadError :: [[a]] -> Either Error a
doubleHeadError [] = Left OuterEmpty
doubleHeadError ([] : _) = Left InnerEmpty
doubleHeadError ((x : _) : _) = Right x

-- Definiálj egy másik hibát jelző típust, amely a safeDiv műveletet kezeli.



-- Definiáld a divHead függvényt ezzel az új hibát jelző típussal!
divHeadError :: undefined
divHeadError = undefined

-- Mi lesz a probléma ezzel a módszerrel?
-- Válasz:

-- Természetesen ez is megoldható, de ezen eszközök megint csak túlmutatnak a tárgy keretein.
-- Konzultáción szintén tudunk róla beszélgetni.

---------------------------------------------------------------------------------------------------------

-- Feladatok:
-- Definiáld az add1OrNot függvényt, amely vagy egy számhoz hozzáad egyet vagy egy Bool-t negál.
add1OrNot :: Num a => Either a Bool -> Either a Bool
add1OrNot (Left a) = Left (a + 1)
add1OrNot (Right b) = Right (not b)

-- "Bizonyítsuk", hogy az Either típus asszociatív!
-- (Tehát ha van két Either típus egymásba ágyazva, akkor nem számít, hogy hogyan vannak egymásba ágyazva.)
eitherAssoc :: (a `Either` b) `Either` c -> a `Either` (b `Either` c)
eitherAssoc (Left (Left a)) = Left a
eitherAssoc (Left (Right b)) = Right (Left b)
eitherAssoc (Right c) = Right (Right c)

-- Megj.: A tényleges bizonyításhoz a másik irányban is meg kéne adni, de elhiszem, hogy ezen a ponton az menne mindenkinek.

---------------------------------
-- Rekurzív (Induktív) típusok
---------------------------------

{-
Nem csak függvények lehetnek rekurzívak, hanem maguknak a típusoknak a felépítése is lehet rekurzív, pontosabban induktív.
Vegyük példaként a listát? Hogy lehet végtelen listánk? Úgy, hogy a típusában valahol végtelen rekurziót lehet csinálni.

Próbáljuk meg definiálni mi magunk a lista adatszerkezetet. Szükség van két konstruktorra; egy, ami az üres listát reprezentálja, meg egy, ami a legalább egy eleműt.
Ezeket általában Nil-nek és Cons-nak szokás nevezni. A Cons konstruktor infixen használva kössön 5-ös erősséggel jobbra.
-}

data List a = Nil | Cons a (List a)

-- Definiáld az add1 függvényt, amely a lista minden eleméhez hozzáad egyet.

-- Példányosítsd a List típust Show-ra, Eq-ra.

instance Show a => Show (List a) where
  show Nil = "[]"
  show (Cons x xs) = "[" ++ show x ++ show' xs
    where
      show' Nil = "]"
      show' (Cons x xs) = "," ++ show x ++ show' xs

-- A lista ezen a ponton unalmas, pontosan ugyanazt tudja, mint az eredeti lista, amit eddig használtunk.
-- Definiáljunk eggyel érdekesebbet: bináris fákat.
-- A bináris fa olyan fa, amely minden csomópontban és levélben tartalmaz adatot, továbbá minden csomópontnak pontosan két gyereke van.
-- Reprezentáció szempontból nézzük az alábbi példát.
{-
        4
       / \
      /   \
     3     2
    / \   / \
   1   0 3   7
  / \       / \
10  20     5   9
-}

-- Definiáljuk a BinTree típust, ami egy ilyen fát tud reprezentálni.
-- Két konstruktora kell legyen, Leaf és Node.
-- Kérjük meg a fordítót, hogy példányosítsa nekünk a Show osztályra a típusunkat.

data BinTree a = Leaf a | Node a (BinTree a) (BinTree a) deriving Show

-- Adjuk meg a fenti példában látható fát lineáris jelöléssel (tehát Leaf-ek és Node-ok függvényében)!
t :: Num a => BinTree a
t = Node 4 (Node 3 (Node 1 (Leaf 10) (Leaf 20)) (Leaf 0)) (Node 2 (Leaf 3) (Node 7 (Leaf 5) (Leaf 9)))

-- Definiáld az add1Tree függvényt, amely egy bináris fa minden eleméhez hozzáad egyet.

add1Tree :: Num a => BinTree a -> BinTree a
add1Tree (Leaf a) = Leaf (a + 1)
add1Tree (Node a l r) = Node (a + 1) (add1Tree l) (add1Tree r)

-- Definiáld a sumTree függvényt, amely egy bináris fának az elemeit összeadja.

sumTree :: Num a => BinTree a -> a
sumTree (Leaf a) = a
sumTree (Node a l r) = a + (sumTree l) + (sumTree r)

-- Példányosítsd az Eq osztályt a bináris fára.
