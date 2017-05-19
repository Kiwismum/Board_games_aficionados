<?php
//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

// get data from database table.

	$query = "SELECT * FROM players";
	
// creating the players table.
	echo "Players ";
	
// output table tag and header row first:

	echo '<table border=1><tr><th>Member ID</th><th>First Name</th><th>Last Name</th>
			<th>Email</th><th>Phone</th></tr>';	

// output data of each row
	
	if ($result = mysqli_query($link, $query)) {
		
		while($row = mysqli_fetch_array($result)){
		
			echo '<tr><td>';

			echo htmlspecialchars($row['Member ID']);

			echo '</td><td>';

			echo "<a href='player_info.php?id=".$row['Member ID']."'>".htmlspecialchars($row['First Name'])."</a>";
			
			echo '</td><td>';

			echo htmlspecialchars($row['Family Name']);
			
			echo '</td><td>';

			echo htmlspecialchars($row['Email']);
			
			echo '</td><td>';

			echo htmlspecialchars($row['Phone']);

		echo '</td></tr>';
		
		}
	}
		echo"</table>";
		echo "<br>";

			
	mysqli_close($link);	

	
		
?>

<a href="player_info.php"><button>Add Player</button></a>
