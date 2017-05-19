<?php
//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
//update players table.
	
	$query = "UPDATE `players` SET email = 'sharon@dreamdolls.co.nz' WHERE id = 9";

	mysqli_close($link);

?>