<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){


//receive form data.
		$id = intval($_POST['id']);
		

// server side validation.
	
	if (empty($id)) {
		echo "ID is required";
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

//delete data from player table.

	$myQuery = "delete from players where `Member ID` = $id";
	if(mysqli_query($link, $myQuery) === true)
		
		printf("Player information deleted.");
	else
		
		echo("Sorry you are unable to delete that player.");
		
	mysqli_close($link);
}else
	
	echo("Sorry page cannot be directly accessed");

?>