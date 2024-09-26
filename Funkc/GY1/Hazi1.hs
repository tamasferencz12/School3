module Hazi1 where

intExpr1 :: Int
intExpr1 = 1

intExpr2 :: Int
intExpr2 = 2

intExpr3 :: Int
intExpr3 = 3

charExpr1 :: Char
charExpr1 = 'a'

charExpr2 :: Char
charExpr2 = 'b'

charExpr3 :: Char
charExpr3 = 'c'

boolExpr1 :: Bool
boolExpr1 = False

boolExpr2 :: Bool
boolExpr2 = (5 > 4) -- még egy megoldás: not False

boolExpr3 :: Bool
boolExpr3 = True

inc :: Integer -> Integer
inc x = x + 1

triple :: Integer -> Integer
triple x = x * 3

thirteen1 :: Integer
thirteen1 = inc (triple (inc (inc (inc (inc 0)))))

thirteen2 :: Integer
thirteen2 = inc ( triple (inc (triple (inc 0))))

thirteen3 :: Integer
thirteen3 = inc ( inc (inc ( inc (triple (triple (inc 0))))))

cmpRem5Rem7 :: Integer -> Bool
cmpRem5Rem7 x =  x `mod` 5 > x `mod` 7

foo :: Int -> Bool -> Bool 
foo x boolean = ( x > 0 && not boolean) || ( x <= 0 && boolean)

bar :: Bool -> Int -> Bool
bar boolean x = foo x boolean
