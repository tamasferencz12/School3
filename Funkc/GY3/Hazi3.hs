module Hazi3 where
import Data.List

isSingleton :: [a] -> Bool
isSingleton (x:[]) = True
isSingleton _ = False

exactly2OrAtLeast4 :: [a] -> Bool
exactly2OrAtLeast4 [_,_] = True
exactly2OrAtLeast4 (_:_:_:_:_) = True
exactly2OrAtLeast4 _ = False

firstTwoElements :: [a] -> [a]
firstTwoElements (x:y:_) = [x,y]
firstTwoElements _ = []

withoutThird :: [a] -> [a]
withoutThird (x:y:z:xs) = (x:y:xs)
withoutThird xs = xs

onlySingletons :: [[a]] -> [[a]]
onlySingletons xs = [x | x <- xs, case x of [_] -> True; _ -> False]

compress :: (Eq a, Num b) => [a] -> [(a,b)]
compress xs = [(head g, fromIntegral (length g)) | g <- group xs]

decompress :: Integral b => [(a,b)] -> [a]
decompress xs = [c | (c, n) <- xs, _ <- [1..n]]