module Hazi4 where

mountain :: Integral i => i -> String
mountain 0 = ""
mountain n = mountain (n - 1) ++ replicate (fromIntegral n) '#' ++ "\n"

countAChars :: Num i => String -> i
countAChars "" = 0
countAChars ('a':xs) = 1 + countAChars xs
countAChars (_:xs) = countAChars xs

lucas :: (Integral a, Num b) => a -> b
lucas 0 = 2
lucas 1 = 1
lucas n = lucas (n - 1) + lucas (n - 2)

longerThan :: Integral i => [a] -> i -> Bool
longerThan [] n = n < 0
longerThan (_:xs) 0 = True
longerThan (_:xs) n = n < 0 || longerThan xs (n - 1)

format :: Integral i => i -> String -> String
format 0 s = s
format n [] = ' ' : format (n - 1) []
format n (x:xs) = x : format (n - 1) xs

merge :: [a] -> [a] -> [a]
merge [] ys = ys
merge xs [] = xs
merge (x:xs) (y:ys) = x : y : merge xs ys
