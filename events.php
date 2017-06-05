<?php
	$link = mysqli_connect("localhost", "root", "root", "boardgamers");
?>

<!DOCTYPE html>
<html>
<!-- BIT695 Web Technologies -->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="responsive.css">
	<script type="text/javascript" src="responsive.js"></script>
    <meta charset="utf-8">
	
    <title>Events Calender</title>
</head>
>

<body>

    <header>

        <h1>Board games aficionados</h1>
		
<?php include("menu.php");?>
		
    </header>
	
    <main>
			<div class="sidebar">
        <img id="left_bar" src="index_sidebar.gif" alt = "sidebar left">
		
        <img id="right_bar" src="index_sidebar-r.gif" alt = "sidebar right">
		</div>
		<section>
            <h2>Club Nights</h2>
            <table>
                <tr>
                    <th colspan="3">Weekly Games</th>
                </tr>
                <tr>
                    <th scope="col">Weekday</th>
                    <th scope="col">Time</th>
                    <th scope="col">Location</th>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td>no game</td>
                    <td>no game</td>
                </tr>
                <tr class="set_date_input" onclick="tuesday()">
                    <td id="tgame_date">Tuesday</td>
                    <td id="tgame_time">7:00pm</td>
                    <td id="tgame_room">Clubs and Socs room 2.14</td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td>no game</td>
                    <td>no game</td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td>no game</td>
                    <td>no game</td>
                </tr>
                <tr class="set_date_input" onclick="friday()">
                    <td id="fgame_date">Friday</td>
                    <td id="fgame_time">8:00pm</td>
                    <td id="fgame_room">Cavern Tavern</td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td>no game</td>
                    <td>no game</td>
                </tr>
                <tr>
                    <td>Sunday</td>
                    <td>no game</td>
                    <td>no game</td>
                </tr>
            </table>
        </section>
<?php
	if(isset($_SESSION["id"]) && $_SESSION["id"]){
		
	
?>		
		<section>
		 <h2>Upcoming Events </h2>
            <table>

                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
					<th scope="col">Game</th>
                    <th scope="col">Location</th>
                </tr>
<?php
	//connect to database
	$count = 0;


	if ($link) {
			// get data from database table.

			$query = "SELECT s.Date, s.Time, bg.game_name Game, s.Location FROM schedule s LEFT OUTER JOIN board_games bg ON bg.game_id=s.gameid WHERE s.Date >= CURDATE() ORDER BY s.Date, s.Time, bg.game_name, s.Location";
			if ($result = mysqli_query($link, $query)) {
				while($count < 10 && $row = mysqli_fetch_array($result)){
					$count++;
					$date = date("d M Y", strtotime($row['Date']));
					$time = date("h:i a", strtotime($row['Time']));
					$game = $row['Game'];
					$location = $row['Location'];

					print <<<EOT
                <tr>
                    <td>$date</td>
                    <td>$time</td>
                    <td>$game</td>
					<td>$location</td>
                </tr>
EOT;
				}
			}
	}
	
		if($count == 0){
					print <<<EOT
                <tr>
                    <td colspan="4">No events planned at this time.</td>
                </tr>
EOT;

		}
?>
               
            </table>
		</section>
<?php
	}
?>
		<section>
            <h2>Recent Results</h2>
			
<div>
				<label for="event">Event:</label>
				<select id="event" name="event" onchange = "window.location = 'events.php?id='+this.value">
					<option value="0">-- Select Event --</option>			

<?php
	$event = intval($_GET['id']);	
	if ($link) {
		// get data from database table.

		$query = "SELECT s.Competion, s.Date, s.Time, bg.game_name Game  FROM schedule s LEFT OUTER JOIN board_games bg ON bg.game_id=s.gameid WHERE s.Date< CURDATE() ORDER BY s.Date, s.Time, bg.game_name, s.Competion";
		if ($result = mysqli_query($link, $query)) {
			while($row = mysqli_fetch_array($result)){
					$sel = ($row['Competion'] == $event) ? " selected" : "";
				$date = date("d/m/y", strtotime($row['Date']));
				$time = date("h:ia", strtotime($row['Time']));
				$game = htmlspecialchars($row['Game']);
				$competion = $row['Competion'];

				echo "<option$sel value ='$competion'>$date $time $game</option>";

			}
		}
	}
?>
				</select>
				<br><br>
			</div>
			
<?php
// get data from database table.

	$query = "SELECT `Result_ID`, `First Name`, `Family Name`, `TableNumber`, `Position` FROM scoring WHERE Event_ID = $event ORDER BY TableNumber, Position, `First Name`, `Family Name`, Result_ID";
	
	
// creating the schedule table.
	
// output table tag and header row first:

	echo '<table border=1><tr><th>Name</th><th>Table</th><th>Position</th></tr>';	

// output data of each row

	$count = 0;
	
	if ($result = mysqli_query($link, $query)) {
		
		while($row = mysqli_fetch_array($result)){
			$count++;
			echo '<tr><td>';

			echo htmlspecialchars($row['First Name'])." ".htmlspecialchars($row['Family Name']);
			
			echo '</td><td>';

			echo htmlspecialchars($row['TableNumber']);
			
			echo '</td><td>';

			echo htmlspecialchars($row['Position']);

		echo '</td></tr>';
		
		}
	}
		if($count == 0){
					print <<<EOT
                <tr>
                    <td colspan="4">There are no results for this event.</td>
                </tr>
EOT;

		}		
		echo"</table>";
		echo "<br>";

			
	mysqli_close($link);	
?>

        </section>
    </main>
    <footer>
        <p>Board games aficionados</p><p>1970-2015</p>
    </footer>
</body>

</html>