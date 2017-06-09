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

	//Clear field values
	$game = 0;
	$date = "";
	$time = "";
	$location = "";
	$errmsg = "";
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){

// See if id has been provided

		$id = intval($_GET['id']);
		if($id != 0)
		{
			
	// get data from database table.

			$query = "SELECT * FROM schedule where `Competion` = $id";
			if ($result = mysqli_query($link, $query)) {
				if($row = mysqli_fetch_array($result)){
					$game = $row['GameID'];
					$date = date("Y-m-d", strtotime($row['Date']));
					$time = date("H:i", strtotime($row['Time']));
					$location = $row['Location'];

				}
			}
		}
	}else{

		$deleteId = intval($_POST['deleteid']);
		if($deleteId !=0){
			
			$errmsg = deleteSchedule($deleteId);
			
		}
		else
			$errmsg = saveSchedule();
			if ($errmsg == ""){
				
				$game = 0;
				$date = "";
				$time = "";
				$location = "";
				$errmsg = "Event Information Saved";
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
	<script type="text/javascript" src="delete.js"></script>
	<script type="text/javascript" src="responsive.js"></script>
    <meta charset="utf-8">
	
    <title>Schedule form</title>
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
		
		
            <h2>Event</h2>
			<h3 id="error"><?php echo $errmsg; ?></h3>
			<form  name="Schedule" method = "POST" onsubmit="return validateForm()" id="form" 
			action="">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="deleteid" name="deleteid" value="">			
			<fieldset class="textInputs">
			<div>
				<label for="game">Game:</label>
			<select id="game" name="game">
				<option value="0">-- Select Game --</option>
<?php
			// get data from database table.

				$query = "SELECT `game_id`, `game_name` FROM board_games ORDER BY `game_name`";
				if ($result = mysqli_query($link, $query)) {
					
					while($row = mysqli_fetch_array($result)){
						$sel = ($row['game_id']==$game) ? " selected" : "";
						echo "<option$sel value='".$row['game_id']."'>".htmlspecialchars($row['game_name'])."</option>";
					}
				}
?>
				
			</select>
			</div>
			<div>
				<label for="date">Date:</label>
				<input type="date" id="date" name = 'date' value="<?php echo $date; ?>" placeholder="dd/mm/yyyy" tabindex="2" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required>
			</div>
			<div>
				<label for="time">Time:</label>
				<input type="time" id="time" name="time" Placeholder="Please enter a time." value="<?php echo $time; ?>" 
				title="A time eg 4.00pm" tabindex="3" maxlength="20" pattern="^(0[1-9]|1[0-2]):[0-5][0-9] (am|pm|AM|PM)$" required>
			</div>
			<div>
				<label for="location">Location:</label>
				<input type="text" id="location" name="location" Placeholder="Please enter a location." value="<?php echo $location; ?>" 
				title="a location eg Club House." tabindex="4" maxlength="50" pattern="[a-zA-Z0-9 \-']+" required>
			</div>

			</fieldset>
			<div>
				<button type="submit" id="submit" tabindex="5" onclick="return validateForm">Save</button>
<?php if($id != 0) { ?>
				<button type="submit" id="delete" tabindex="6" onclick="return validateDelete()">Delete</button>
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

	function saveSchedule(){
	
		global $link;
		global $game;
		global $date;
		global $time;
		global $location;
	
	
	//receive form data.
		$game= intval(clean_input($_POST['game']));
		$date= clean_input($_POST['date']);
		$time= clean_input($_POST['time']);
		$location= clean_input($_POST['location']);

		// server side validation.
	
	if ($game == 0) {
		return "Game is required";
	
	}
	if($game < 0) {
		return  "Invalid game selected"; 
	}
	if (empty($date)) {
		return "Date is required";
		
	  }
	if (!preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$date,$parts)) {
		return  "Date format must be dd/mm/yyyy"; 
	 }
	 if(!checkdate(intval($parts[2]),intval($parts[3]),intval($parts[1]))){
		 return "Invalid date.";
	 }
	 date_default_timezone_set("Pacific/Auckland");
	 $dtevent = mktime(0,0,0,$parts[2],$parts[3],$parts[1]);
	 if($dtevent < strtotime("today midnight")){
		return "Date must not be before today.";
	 }
	 if (empty($time)) {
		return "Time is required";
		
	  }
	if (!preg_match("/^([0-1][0-9]|2[0-3]):[0-5][0-9](:00)?$/",$time)) {
		return  "Time format ($time) must be hh:mm am/pm"; 
	 }
	$tmevent = strtotime($time);
	 if (($dtevent-time()) < 86400 && $tmevent < time()){
		 return "The date and time must be in the future.";
	 }

	 if (empty($location)) {
		return "Location is required";
		
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$location)) {
		return  "Only letters and numbers allowed in location"; 
	 }

	if (strlen($location) > 50){
		
		return "Location must be no more than 50 characters.";	
	}	


	  	$id = intval($_POST['id']);
		
	if($id == 0){
	//insert data into schedule table.

		$queryStart = "insert into schedule(`GameID`, `Date`, `Time`, `Location`) values(";
		$queryEnd = ")";
		$myQuery = $queryStart
					. "$game"
					. ", from_unixtime($dtevent)"
					. ", from_unixtime($tmevent)"
					. ", '$location'"
					. $queryEnd;
		}else{
			
			//update schedule table.
		
		$myQuery = "UPDATE `schedule` SET 
		
					GameID = $game,
					Date = from_unixtime($dtevent),
					Time = from_unixtime($tmevent),
					Location = '$location' 
					WHERE `Competion` = $id";

	
	}
	
	if(mysqli_query($link, $myQuery) === true)
	{

		
			return "";
	}else{
			
			return "Sorry event information has not been saved.";
		}
	
	}
		function deleteSchedule($id)
	{
		global $link;
		
	//delete data from schedule table.

		$myQuery = "delete from schedule where `Competion` = $id";
		if(mysqli_query($link, $myQuery) === true)
			
			header("location: list_Schedule.php");
		else
			
			return "Sorry you are unable to delete that event.";
			
		
	}
?>

