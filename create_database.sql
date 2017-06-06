
--
-- Table structure for table `board_games`
--

CREATE TABLE `board_games` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(50) NOT NULL,
  `min_players` int(11) NOT NULL,
  `max_players` int(11) NOT NULL
);

--
-- Indexes for table `board_games`
--
ALTER TABLE `board_games`
  ADD PRIMARY KEY (`game_id`);

--
-- AUTO_INCREMENT for table `board_games`
--
ALTER TABLE `board_games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- Populating `board_games` table
--

INSERT INTO `board_games` (`game_name`, `min_players`, `max_players`) VALUES
('Scrabble', 2, 4),
('Monopoly', 2, 8),
('Catan', 2, 6),
('Risk', 3, 6);
  
--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `Member ID` int(20) NOT NULL,
  `First Name` varchar(20) NOT NULL,
  `Family Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `admin` tinyint(4) NOT NULL
);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`Member ID`);
  
  
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `Member ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Populating players table
--

INSERT INTO `players` (`First Name`, `Family Name`, `Email`, `Phone`, `UserName`, `Password`, `admin`) VALUES
('Fred', 'Dagg', 'fred@email.com', '021 654897', 'fred01', '362f30d4cc3897b4af7b7f938dbda151', 1),
('George', 'Bell', 'georgieboy@gmail.com', '024 658 258', 'george', 'd4d5b3c6d954808361674100113779e9', 0),
('Carol', 'Robins', 'carol.robins@gmail.com', '012 345 6789', 'carol', '88599f0f139eb6e7bc6b0d14b2aaa2a6', 0),
('Nina', 'Smith', 'Nina@hotmail.com', '09 123 4567', 'nina', 'c67c2bd13856a8d8e836b79270e5d308', 0),
('Sharon', 'Edwards', 'sharon@dreamcrafts.co.nz', '021 479 603', 'sharon', '9fb77a55258c8ac73af5a7fdfe538e5d', 0),
('Mickey', 'Mouse', 'mickey@disney.com', '021 347639', 'mickey', 'ee979e447201c007275c2ad134c60793', 0),
('Minnie', 'Mouse', 'minnie@disney.com', '021 646-643', 'minnie', '0c63cf595c419c4f926a467c7814aded', 0);

--
-- Table structure for table `player_games`
--

CREATE TABLE `player_games` (
  `Member ID` int(20) NOT NULL,
  `game_id` int(11) NOT NULL,
  `own` tinyint(4) NOT NULL,
  `play` tinyint(4) NOT NULL,
  `highScore` int(11) NOT NULL
);

--
-- Indexes for table `player_games`
--
ALTER TABLE `player_games`
  ADD PRIMARY KEY (`Member ID`,`game_id`),
  ADD UNIQUE KEY `game_player` (`game_id`,`Member ID`);
  
---
-- Constraints for table `player_games`
--
ALTER TABLE `player_games`
  ADD CONSTRAINT `player_games_game_id` FOREIGN KEY (`game_id`) REFERENCES `board_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `player_games_member_id` FOREIGN KEY (`Member ID`) REFERENCES `players` (`Member ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Competion` int(11) NOT NULL,
  `GameID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Location` varchar(50) NOT NULL
);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Competion`),
  ADD KEY `schedule_gameid` (`GameID`);
  
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `Competion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_gameid` FOREIGN KEY (`GameID`) REFERENCES `board_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

  
--
-- Table structure for table `scoring`
--

CREATE TABLE `scoring` (
  `Result_ID` int(50) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `First Name` varchar(20) NOT NULL,
  `Family Name` varchar(30) NOT NULL,
  `TableNumber` varchar(20) NOT NULL,
  `Position` varchar(20) NOT NULL
);

--
-- Indexes for table `scoring`
--
ALTER TABLE `scoring`
  ADD PRIMARY KEY (`Result_ID`),
  ADD KEY `scoring_event_id` (`Event_ID`);

--
-- AUTO_INCREMENT for table `scoring`
--
ALTER TABLE `scoring`
  MODIFY `Result_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- Constraints for table `scoring`
--
ALTER TABLE `scoring`
  ADD CONSTRAINT `scoring_event_id` FOREIGN KEY (`Event_ID`) REFERENCES `schedule` (`Competion`) ON DELETE CASCADE ON UPDATE CASCADE;
  
  
  
  


