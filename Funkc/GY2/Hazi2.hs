module Hazi2 where

addV :: (Double,Double) -> (Double,Double) -> (Double,Double)
addV (x1, y1) (x2, y2) = (x1 + x2, y1 + y2)

subV :: (Double,Double) -> (Double,Double) -> (Double,Double)
subV (x1, y1) (x2, y2) = (x1 - x2, y1 - y2)

scaleV :: Double -> (Double,Double) -> (Double,Double)
scaleV s (x, y) = (s * x, s * y)

scalar :: (Double,Double) -> (Double,Double) -> Double
scalar (a1, b1) (a2, b2) = a1 * a2 + b1 * b2

divides :: Integral a => a -> a -> Bool
divides 0 0 = True
divides 0 _ = False
divides x y = y `mod` x == 0

add :: (Integral a, Integral b, Num c) => a -> b -> c
add x y = fromIntegral x + fromIntegral y