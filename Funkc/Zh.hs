module Zh where

import Data.List

points :: Integral a => [(String, a, a)] -> [(String, a)]
points competitors = 
  [ (name, score) 
  | (name, time, penalty) <- competitors
  , let score = 100 - (time `div` 2) - penalty
  , penalty /= 100
  , score > 0
  ]

rank :: [(String, Int, Int, Int)] -> [(String, Int, Int, Int)]
rank competitors = 
  [ (name, h , m , s)
  | (name, h, m, s) <- sortBy compareTime competitors ]
  where
    compareTime (_, h1, m1, s1) (_, h2, m2, s2) = compare (h1 * 3600 + m1 * 60 + s1) (h2 * 3600 + m2 * 60 + s2)

type Apple = (Bool, Int)
type Tree = [Apple]
type Garden = [Tree]

ryuksApples :: Garden -> Int
ryuksApples garden = sum [1 | tree <- garden, (ripe, height) <- tree, ripe, height <= 3]

doesContain :: String -> String -> Bool
doesContain [] _ = True
doesContain _ [] = False
doesContain (x:xs) (y:ys)
  | x == y    = doesContain xs ys
  | otherwise = doesContain (x:xs) ys


barbie :: [String] -> String
barbie [] = "farmer"
barbie (x:xs) = findSkirt 1 (x:xs)
  where
    findSkirt _ [] = "farmer"
    findSkirt idx (y:ys)
      | idx `mod` 2 == 0 && y /= "fekete" = y
      | y == "rozsaszin" = "rozsaszin"
      | otherwise = findSkirt (idx + 1) ys

firstValid :: [a -> Bool] -> a -> Maybe Int
firstValid ps x = go 0 ps
  where
    go _ [] = Nothing
    go i (p:ps')
      | p x       = Just i
      | otherwise = go (i + 1) ps'


data Line = Tram Integer [String] | Bus Integer [String]
  deriving (Eq, Show)

whichBusStop :: String -> [Line] -> [Integer]
whichBusStop stopName lines = [n | Bus n stops <- lines, stopName `elem` stops]

isReservable :: Int -> String -> Bool
isReservable n row = n == 0 || check row 0
  where
    check :: String -> Int -> Bool
    check _ count | count >= n = True
    check [] count = count >= n
    check (x:xs) count
      | x == 'x'  = check xs (count + 1)
      | otherwise = check xs 0 


data Plant = Flower String Int | Tree String Int
  deriving (Eq, Show)

type Land = [Plant]


filterPlantsByWatering :: [Land] -> Int -> [String]
filterPlantsByWatering [] _ = []
filterPlantsByWatering (land : lands) inputWater = 
  filterPlantsByWateringInLand land inputWater ++ filterPlantsByWatering lands inputWater
  where
    filterPlantsByWateringInLand :: Land -> Int -> [String]
    filterPlantsByWateringInLand [] _ = []
    filterPlantsByWateringInLand (Flower name water : ps) inputWater
      | water <= inputWater = name : filterPlantsByWateringInLand ps inputWater
      | otherwise = filterPlantsByWateringInLand ps inputWater
    filterPlantsByWateringInLand (Tree name water : ps) inputWater
      | water <= inputWater = name : filterPlantsByWateringInLand ps inputWater
      | otherwise = filterPlantsByWateringInLand ps inputWater

filterWordsByLength :: String -> Int -> [String]
filterWordsByLength text maxLength = filterByLength (words text)
  where
    filterByLength [] = []
    filterByLength (w:ws)
      | length w <= maxLength = w : filterByLength ws
      | otherwise = filterByLength ws

filterWordsByLengths :: String -> [Int] -> [String]
filterWordsByLengths text lengths = 
    zipWith (\word maxLen -> if length word <= maxLen then word else "") (words text) lengths