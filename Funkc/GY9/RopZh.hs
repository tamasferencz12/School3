module RopZh where

data Musician = Musician String Int Int String

instance Show Musician where
    show (Musician name birthYear startYear instrument)
        | instrument == "" = name ++ " was born in " ++ show birthYear ++ ", and has been singing since " ++ show startYear
        | otherwise = name ++ " was born in " ++ show birthYear ++ ", and has been playing the " ++ instrument ++ " since " ++ show startYear