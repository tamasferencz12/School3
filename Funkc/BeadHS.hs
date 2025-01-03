module Bea where

import Data.Either
import Data.Maybe
import Text.Read
import Data.Char (isDigit)

basicInstances = 0 -- Mágikus tesztelőnek kell ez, NE TÖRÖLD!

type OperatorTable a = [(Char, (a -> a -> a, Int, Dir))]

tAdd, tMinus, tMul, tDiv, tPow :: (Floating a) => Tok a
tAdd = TokBinOp (+) '+' 6 InfixL
tMinus = TokBinOp (-) '-' 6 InfixL
tMul = TokBinOp (*) '*' 7 InfixL
tDiv = TokBinOp (/) '/' 7 InfixL
tPow = TokBinOp (**) '^' 8 InfixR

data Dir = InfixL | InfixR
  deriving (Show, Eq, Ord)

data Tok a
   = BrckOpen
  | BrckClose
  | TokLit a
  | TokBinOp (a -> a -> a) Char Int Dir

instance Show a => Show (Tok a) where
  show BrckOpen = "BrckOpen"
  show BrckClose = "BrckClose"
  show (TokLit x) = "TokLit " ++ show x
  show (TokBinOp _ x y z) = "TokBinOp " ++ show x ++ " " ++ show y ++ " " ++ show z

instance Eq a => Eq (Tok a) where
  BrckOpen == BrckOpen = True
  BrckClose == BrckClose = True
  TokLit x == TokLit y = x == y
  TokBinOp _ x1 y1 z1 == TokBinOp _ x2 y2 z2 = x1 == x2 && y1 == y2 && z1 == z2
  _ == _ = False

operatorTable :: (Floating a) => OperatorTable a
operatorTable =
    [ ('+', ((+), 6, InfixL))
    , ('-', ((-), 6, InfixL))
    , ('*', ((*), 7, InfixL))
    , ('/', ((/), 7, InfixL))
    , ('^', ((**), 8, InfixR))
    ]

operatorFromChar :: OperatorTable a -> Char -> Maybe (Tok a)
operatorFromChar table c = case lookup c table of
  Just (f,p,d) -> Just (TokBinOp f c p d)
  Nothing -> Nothing

getOp :: (Floating a) => Char -> Maybe (Tok a)
getOp = operatorFromChar operatorTable

parseTokens :: Read a => OperatorTable a -> String -> Maybe [Tok a]
parseTokens opTable input
  | hasInvalidParentheses firstChunk = Nothing
  | otherwise = fmap concat (traverse toToken (tokenize firstChunk))
  where
    (firstChunk, _) = splitAt 100000 input

    hasInvalidParentheses :: String -> Bool
    hasInvalidParentheses [] = False
    hasInvalidParentheses (c1:c2:rest)
      | c1 == '(' && isDigit c2 = True
      | isDigit c1 && c2 == ')' = True
      | otherwise = hasInvalidParentheses (c2:rest)
    hasInvalidParentheses _ = False

    tokenize [] = []
    tokenize input =
      let (chunk, rest) = splitAt 100000 input
      in case chunk of
           [] -> []
           _  -> tokenizeChunk chunk ++ tokenize rest

    tokenizeChunk [] = []
    tokenizeChunk (c:cs)
      | c `elem` "()" = [c] : tokenizeChunk cs
      | c `elem` " \t\n" = tokenizeChunk cs
      | otherwise = let (word, rest) = span (\x -> x `notElem` " () \t\n") (c:cs)
                    in word : tokenizeChunk rest

    toToken "(" = Just [BrckOpen]
    toToken ")" = Just [BrckClose]
    toToken word
      | length word == 1 && head word `elem` map fst opTable =
          case operatorFromChar opTable (head word) of
            Just op -> Just [op]
            Nothing -> Nothing
      | otherwise = toLiteral word

    toLiteral w = case readMaybe w of
      Just x -> Just [TokLit x]
      Nothing -> Nothing


parse :: String -> Maybe [Tok Double]
parse = parseTokens operatorTable 

shuntingYardBasic :: [Tok a] -> ([a], [Tok a])
shuntingYardBasic = go [] []
  where
    go literals ops [] = (literals, ops)
    go literals ops (BrckOpen : ts) = go literals (BrckOpen : ops) ts
    go literals ops (BrckClose : ts) = 
        let (processedLiterals, processedOps) = handleClosingParen literals ops
        in go processedLiterals processedOps ts
    go literals ops (TokLit x : ts) = go (x : literals) ops ts
    go literals ops (op@(TokBinOp _ _ _ _) : ts) = go literals (op : ops) ts

    handleClosingParen literals (BrckOpen : ops) = (literals, ops)
    handleClosingParen (y:x:literals) (op@(TokBinOp f _ _ _) : ops) =
        handleClosingParen ((f x y) : literals) ops
    handleClosingParen _ _ = error "Unmatched parentheses or invalid state."

shuntingYardPrecedence :: [Tok a] -> ([a], [Tok a])
shuntingYardPrecedence = go [] []
  where
    go literals ops [] = ( literals, ops)
    go literals ops (TokLit x : ts) = go (x : literals) ops ts
    go literals ops (BrckOpen : ts) = go literals (BrckOpen : ops) ts
    go literals ops (BrckClose : ts) = 
        let (litStack, opStack) = processUntilOpen literals ops
        in go litStack opStack ts
    go literals ops (op@(TokBinOp _ _ p dir) : ts) = 
        let (litStack, opStack) = processOperators literals ops p dir
        in go litStack (op : opStack) ts

    processUntilOpen litStack (BrckOpen : ops) = (litStack, ops)
    processUntilOpen litStack (op : ops) = processUntilOpen (eval litStack op) ops
    processUntilOpen _ [] = error "Mismatched parentheses"

    processOperators litStack (op@(TokBinOp _ _ p' dir') : ops) p dir
        | p' > p || (p' == p && dir == InfixL) = 
            processOperators (eval litStack op) ops p dir
    processOperators litStack ops _ _ = (litStack, ops)

    eval (x:y:ys) (TokBinOp f _ _ _) = (f y x) : ys
    eval _ _ = error "Invalid operator evaluation"

syEvalPrecedence :: String -> Maybe ([Double], [Tok Double])
syEvalPrecedence = parseAndEval parse (\t -> shuntingYardPrecedence $ BrckOpen : (t ++ [BrckClose]))
--syEvalPrecedence "3 + 5 * ( 2 - 8 )" == Just ([-27.0],[])

parseAndEval :: (String -> Maybe [Tok a]) -> ([Tok a] -> ([a], [Tok a])) -> String -> Maybe ([a], [Tok a])
parseAndEval parse eval input = maybe Nothing (Just . eval) (parse input)

syNoEval :: String -> Maybe ([Double], [Tok Double])
syNoEval = parseAndEval parse shuntingYardBasic
--syNoEval "3 + 5 * ( 2 - 8 )" == Just ([-6.0,5.0,3.0],[TokBinOp '*' 7 InfixL,TokBinOp '+' 6 InfixL])

syEvalBasic :: String -> Maybe ([Double], [Tok Double])
syEvalBasic = parseAndEval parse (\t -> shuntingYardBasic $ BrckOpen : (t ++ [BrckClose]))
--syEvalBasic "3 + 5 * ( 2 - 8 )" == Just ([-27.0],[])