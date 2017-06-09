<?php

// link to validateUser for security

	include("validateUser.php");
	if(!isset ($_SESSION["admin"]) || !$_SESSION["admin"]){
		
		echo "This page is only available to administrators.";
		exit;
	}

//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	$event = intval($_GET['id']);	
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
	
    <title>List Results</title>
</head>

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
            <h2>Results</h2>
			
<div>
				<label for="event">Event:</label>
				<select id="event" name="event" onchange = "window.location = 'list_results.php?id='+this.value">		
					<option value="0">-- Select Event --</option>			

<?php
	if ($link) {
		// get data from database table.

		$query = "SELECT s.Competion, s.Date, s.Time, bg.game_name Game  FROM schedule s LEFT OUTER JOIN board_games bg ON bg.game_id=s.gameid ORDER BY s.Date, s.Time, bg.game_name, s.Competion";
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

			echo "<a href='scoring_info.php?id=".$row['Result_ID']."'>".htmlspecialchars($row['First Name'])." ".htmlspecialchars($row['Family Name'])."</a>";
			
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
			<a href="scoring_info.php"><button>Add Result</button></a>
        </section>
    </main>
    <footer>
        <p>Board games aficionados</p><p>1970-2015</p>
    </footer>
</body>

</html>
