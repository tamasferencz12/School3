module RopZh where

partialReverse :: Integral a => a -> [b] -> [b]
partialReverse n xs
    | n <= 0 = xs
    | null xs = []
    | n >= length xs = reverseN (n- (n - (lenght xs))) xs []
    | otherwise = reverseN n xs []

        where
            reverseN 0 ys acc = acc ++ ys
            reverseN _ [] acc = acc
            reverseN n (y:ys) acc = reverseN (n-1) ys (y:acc)