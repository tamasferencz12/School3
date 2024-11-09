splitOn :: Eq a => a -> [a] -> [[a]]
splitOn _ [] = [[]]
splitOn x (y:ys)
    | y == x    = [] : splitOn x ys
    | otherwise = let (z:zs) = splitOn x ys
                  in (y:z) : zs

emptyLines :: Num a => String -> [a]
emptyLines = findEmptyLines 1 . lines
  where
    findEmptyLines _ [] = []
    findEmptyLines n (x:xs)
      | null x    = n : findEmptyLines (n + 1) xs
      | otherwise = findEmptyLines (n + 1) xs


csv :: String -> [[String]]
csv = map (splitOn ',') . lines
  where
    splitOn :: Eq a => a -> [a] -> [[a]]
    splitOn _ [] = [[]]
    splitOn x (y:ys)
      | y == x    = [] : splitOn x ys
      | otherwise = let (z:zs) = splitOn x ys
                    in (y:z) : zs
