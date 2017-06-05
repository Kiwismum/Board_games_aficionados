<?php
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
	
    <title>List Games</title>
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
            <h2>Games</h2>
<?php
// get data from database table.

	$query = "SELECT `game_id`, `game_name` FROM board_games ORDER BY `game_name`";
	
// creating the game table.
	
// output table tag and header row first:

	echo '<table border=1><tr><th>Game</th></tr>';	

// output data of each row
	
	if ($result = mysqli_query($link, $query)) {
		
		while($row = mysqli_fetch_array($result)){
		
			echo '<tr><td>';

			echo "<a href='game_info.php?id=".$row['game_id']."'>".htmlspecialchars($row['game_name'])."</a>";
			

		echo '</td></tr>';
		
		}
	}
		echo"</table>";
		echo "<br>";

			
	mysqli_close($link);	
?>
			<a href="game_info.php"><button>Add Game</button></a>
        </section>
    </main>
    <footer>
        <p>Board games aficionados</p><p>1970-2015</p>
    </footer>
</body>

</html>
