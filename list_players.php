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
	
    <title>List Players</title>
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
            <h2>Players</h2>
<?php
// get data from database table.

	$query = "SELECT * FROM players ORDER BY `First Name`, `Family Name`, `Member ID`";
	
// creating the players table.
	
// output table tag and header row first:

	echo '<table border=1><tr><th>Name</th><th>Email</th><th>Phone</th></tr>';	

// output data of each row
	
	if ($result = mysqli_query($link, $query)) {
		
		while($row = mysqli_fetch_array($result)){
		
			echo '<tr><td>';

			echo "<a href='player_info.php?id=".$row['Member ID']."'>".htmlspecialchars($row['First Name'])." ".htmlspecialchars($row['Family Name'])."</a>";
			
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
        </section>
    </main>
    <footer>
        <p>Board games aficionados</p><p>1970-2015</p>
    </footer>
</body>

</html>
