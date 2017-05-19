<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

// define functin for removing invalid characters

	function clean_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}

//receive form data.
		$firstname= clean_input($_POST['firstname']);
		$lastname= clean_input($_POST['lastname']);
		$phoneNum= clean_input($_POST['phoneNum']);
		$email= clean_input($_POST['email']);

// server side validation.
	
	if (empty($firstname)) {
		echo "Firstname is required";
		exit;
	  }
	if (empty($lastname)) {
		echo "Lastname is required";
		exit;
	  }
	  if (empty($phoneNum)) {
		echo "Phone number is required";
		exit;
	  }
	if (empty($email)) {
		echo "Email is required";
		exit;
	  }
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format"; 
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
//insert data into player table.

	$queryStart = "insert into players(`First Name`, `Family Name`, `Email`, `Phone`) values(";
	$queryEnd = ")";
	$myQuery = $queryStart
				. "'$firstname'"
				. ", '$lastname'"
				. ", '$email'"
				. ", '$phoneNum'"
				. $queryEnd;
	if(mysqli_query($link, $myQuery) === true)
		
		printf("Player information saved");
	else
		
		echo("Sorry player information has not been added to the table.");
		

}

?>