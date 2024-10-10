module RopZh where 

replaceEs :: String -> String
replaceEs "" = ""
replaceEs ('e':xs) = 'o' : replaceEs xs
replaceEs (x:xs) = x : replaceEs xs
