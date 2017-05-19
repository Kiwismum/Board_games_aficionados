SELECT *
FROM players
INNER JOIN board_games ON players.`Member ID` = board_games.`Member ID` 
WHERE email LIKE '%gmail%';