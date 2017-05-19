delete from board_games
where `member id` in (select `member id` from players where `Member ID` = 5);



DELETE FROM players
WHERE `Member ID` = 5;
