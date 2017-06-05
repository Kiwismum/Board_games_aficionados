<?php

// There is an assumtion that not all competition players will be members.

//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	//Clear field values
	$event = 0;
	$firstname = "";
	$lastname = "";
	$tableNumber = "";
	$position = "";
	$errmsg = "";
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){

// See if id has been provided

		$id = intval($_GET['id']);
		if($id != 0)
		{
			
	// get data from database table.

			$query = "SELECT * FROM scoring where `Result_ID` = $id";
			if ($result = mysqli_query($link, $query)) {
				if($row = mysqli_fetch_array($result)){
					$event = $row['Event_ID'];
					$firstname = $row['First Name'];
					$lastname = $row['Family Name'];
					$tableNumber = $row['TableNumber'];
					$position = $row['Position'];
				}
			}
		}
	}else{
		
		$deleteId = intval($_POST['deleteid']);
		if($deleteId !=0){
			
			$errmsg = deleteScore($deleteId);
			
		}
		else
			$errmsg = saveScore();
		if ($errmsg == ""){
			$errmsg = "Results saved.";			
			//Clear field values
			$id = 0;
			$event = 0;
			$firstname = "";
			$lastname = "";
			$tableNumber = "";
			$position = "";

			
		}
		
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
	<script type="text/javascript" src="delete.js"></script>
    <meta charset="utf-8">
	
    <title>Scoring Form</title>
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
        <div id="wrapper">
		
		
            <h2>Result</h2>
			<h3 id="error"><?php echo $errmsg; ?></h3>
			<form  name="Scoring" method = "POST" onsubmit="return validateForm()" id="form" 
			action="">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="deleteid" name="deleteid" value="">
			<fieldset class="textInputs">
			<div>
				<label for="event">Event:</label>
				<select id="event" name="event">		
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
			</div>
			<div>
				<label for="firstname">First Name:</label>
				<input type="text" id="firstname" name="firstname" Placeholder="Please enter first name." value="<?php echo $firstname; ?>"
				title="Your first name eg John" tabindex="3" maxlength="20" pattern="[a-zA-Z \-']+" required>
			</div>
			<div>
				<label for="lastname">Surname:</label>
				<input type="text" id="lastname" name="lastname" Placeholder="Please enter surname." value="<?php echo $lastname; ?>"
				title="Your last name eg Smith" tabindex="4" maxlength="30" pattern="[a-zA-Z \-']+" required>
			</div>
			<div>
				<label for="tableNumber">Table Number:</label>
				<input type="text" id="tableNumber" name="tableNumber" Placeholder="Please enter a table identifier." value="<?php echo $tableNumber; ?>"
				title="A table number eg table 1" tabindex="5" maxlength="30" pattern="[a-zA-Z0-9 \-']+" required>
			</div>
			<div>
				<label for="position">Position:</label>
				<input type="text" id="position" name="position" Placeholder="Please enter player rank." value="<?php echo $position; ?>"
				title="A position eg 1st" tabindex="6" maxlength="30" pattern="[a-zA-Z0-9 \-']+" required>
			</div>
			</fieldset>
			<div>
				<button type="submit" id="submit" tabindex="7" onclick="return validateForm">Save</button>
<?php if($id != 0) { ?>
				<button type="submit" id="delete" tabindex="7" onclick="return validateDelete()">Delete</button>
<?php } ?>
			</div>
			
			</form>
           
        </div>
		   
    </main>
    <footer>
        <p class = "footerName">Board games aficionados</p>
		<p>1970-2015</p>
    </footer>
</body>
</html>

<?php

	// define function for removing invalid characters

	function clean_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}
	function saveScore(){
	
		global $link;
		global $id;
		global $event;
		global $firstname;
		global $lastname;
		global $tableNumber;
		global $position;
	
//receive form data.
		$id= intval(clean_input($_POST['']));
		$event= intval(clean_input($_POST['event']));
		$firstname= clean_input($_POST['firstname']);
		$lastname= clean_input($_POST['lastname']);
		$tableNumber= clean_input($_POST['tableNumber']);
		$position= clean_input($_POST['position']);

// server side validation.
	
	if ($event == 0) {
		return "Event is required";
	
	}
	if($event < 0) {
		return  "Invalid event selected"; 
	}

	if (empty($firstname)) {
		return "Firstname is required";
	
	  }
	if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
		return  "Only letters allowed in firstname"; 
	 }
	if (strlen($firstname) > 20){
		
		return "First name must be no more than 20 characters.";
	}
	if (empty($lastname)) {
		return "Lastname is required";
		
	  }
	if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
		return  "Only letters allowed in last name"; 
	 }
	if (strlen($lastname) > 30){
		
		return "Last name must be no more than 30 characters.";
	}
	  if (empty($tableNumber)) {
		return "Table number is required";
		
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$tableNumber)) {
		return  "Only letters and numbers allowed for table number"; 
	 }
	if (strlen($tableNumber) > 20){
		
		return "Table number must be no more than 20 characters.";
	}
	if (empty($position)) {
		return "Position is required";
		
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$position)) {
		return  "Only letters and numbers allowed for position"; 
	 }
	if (strlen($position) > 20){
		
		return "Position must be no more than 20 characters.";
	}
	

	
	$id = intval($_POST['id']);
	
	if($id == 0){
//insert data into scoring table.

	$queryStart = "insert into scoring(`Event_ID`, `First Name`, `Family Name`, `TableNumber`, `Position`) values(";
	$queryEnd = ")";
	$myQuery = $queryStart
				. "$event"
				. ", '$firstname'"
				. ", '$lastname'"
				. ", '$tableNumber'"
				. ", '$position'"
				. $queryEnd;
	}else{
		
		//update scoring table.
	
	$myQuery = "UPDATE `scoring` SET 
	
				Event_ID = $event, 
				`First Name` = '$firstname',
				`Family Name` = '$lastname',
				TableNumber = '$tableNumber',
				Position = '$position'
				WHERE `Result_ID` = $id";

	
	}
	if(mysqli_query($link, $myQuery) === true)
		
		return "";
	else
		
		return "Sorry score information has not been saved.";
	
	}
	
	function deleteScore($id)
	{
		global $link;
		
	//delete data from scoring table.

		$myQuery = "delete from scoring where `Result_ID` = $id";
		if(mysqli_query($link, $myQuery) === true)
			
			header("location: list_results.php");
		else
			
			return "Sorry you are unable to delete that result.";
			
		
	}
	
?>