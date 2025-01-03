module RopZh where
    
solution :: Bool -> Bool -> Bool
solution = \x y -> case (x, y) of
    (True, True) -> True
    (True, False) -> True
    (False, True) -> True
    (False, False) -> False

solution2 :: Bool -> Bool -> Bool
solution2 x y = if solution x y then True else False