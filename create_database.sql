
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


