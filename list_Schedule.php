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
	
    <title>List Schedule</title>
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
            <h2>Events</h2>
			

<?php
// get data from database table.

	$query = "SELECT s.Competion, s.Date, s.Time, bg.game_name Game, s.Location FROM schedule s LEFT OUTER JOIN board_games bg ON bg.game_id=s.gameid ORDER BY s.Date, s.Time, bg.game_name";
	
	
// creating the schedule table.
	
// output table tag and header row first:

	echo '<table border=1><tr><th>Date/Time</th><th>Game</th><th>Location</th></tr>';	

// output data of each row


	
	if ($result = mysqli_query($link, $query)) {
		
		while($row = mysqli_fetch_array($result)){
		
			echo '<tr><td>';

			echo "<a href='schedule.php?id=".$row['Competion']."'>".htmlspecialchars(date("d M Y", strtotime($row['Date'])))." ".htmlspecialchars(date("h:i a", strtotime($row['Time'])))."</a>";
			
			echo '</td><td>';

			echo htmlspecialchars($row['Game']);
			
			echo '</td><td>';

			echo htmlspecialchars($row['Location']);

		echo '</td></tr>';
		
		}
	}
		echo"</table>";
		echo "<br>";

			
	mysqli_close($link);	
?>
			<a href="schedule.php"><button>Add Event</button></a>
        </section>
    </main>
    <footer>
        <p>Board games aficionados</p><p>1970-2015</p>
    </footer>
</body>

</html>
