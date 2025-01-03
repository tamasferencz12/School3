module RopZh12 where

import Data.Char

f :: String -> Bool
f xs = any (\word -> isLower (head word)) (words xs)