module RopZh where

filterRights :: [Either a b] -> [b]
filterRights xs = [y | Right y <- xs]
