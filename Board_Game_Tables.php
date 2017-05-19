<?php
//connect to database
	

//recieve form data.


var_dump($_POST);
echo "<br><br>";

	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$phoneNum=$_POST['phoneNum'];
	$email=$_POST['email'];
	$game=$_POST['email'];

// creating the players table.
	echo "Players ";
	
	$member = array();

	// output table tag and header row first:

	echo '<table border=1><tr><th>Member ID</th><th>First Name</th><th>Last Name</th>
			<th>Email</th><th>Phone</th></tr>';

	// for each array element write the key and value as table data:

	foreach ($member as $firstname => $firtname)

	{

	echo '<tr><td>';

	echo htmlspecialchars(print_r($name, true));

	echo '</td><td>';

	echo htmlspecialchars(print_r($time, true));

	echo '</td></tr>';

	}
	echo"</table>";
	echo "<br>";
	
// creating the boardgames table.	
	
	echo "Board Games";
	
	$times = array();

	// output table tag and header row first:
	

	echo '<table border=1><tr><th>Member ID</th><th>Board Game</th><th>Position</th>
			<th>Notes</th><th>Date</th><th>Event</th></tr>';

	// for each array element write the key and value as table data:

	foreach ($times as $name => $time)

	{

	echo '<tr><td>';

	echo htmlspecialchars(print_r($name, true));

	echo '</td><td>';

	echo htmlspecialchars(print_r($time, true));

	echo '</td></tr>';

	}
		echo"</table>";
		
?>