<?php

//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	//Clear field values
	$game = "";
	$minplayers = "";
	$maxplayers= "";
	$errmsg = "";
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){

// See if id has been provided

		$id = intval($_GET['id']);
		if($id != 0)
		{
			
	// get data from database table.

			$query = "SELECT * FROM board_games where `game_id` = $id";
			if ($result = mysqli_query($link, $query)) {
				if($row = mysqli_fetch_array($result)){
					$game = $row['game_name'];
					$minplayers = $row['min_players'];
					$maxplayers = $row['max_players'];
				}
			}
		}
	}else{
		
		$deleteId = intval($_POST['deleteid']);
		if($deleteId !=0){
			
			$errmsg = deleteGame($deleteId);
			
		}
		else
			$errmsg = saveGame();
		if ($errmsg == ""){
			
			$game = "";
			$minplayers = "";
			$maxplayers = "";
			$errmsg = "Game Information Saved";
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
	
    <title>Game Information</title>
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

		
            <h2>Game Information</h2>
			<h3 id="error"><?php echo $errmsg; ?></h3>
			<form  name="game_info" method = "POST" onsubmit="return validateForm()" id="form" 
			action="">
			<input type="hidden" id="deleteid" name="deleteid" value="">
			<input type="hidden" id="id" name="id" value="<?php echo $id  ?>" >
			<fieldset class="textInputs">

			
			<div>

				<label for="game">Game Name:</label>
				<input type="text" id="game" name="game" value="<?php echo $game; ?>" 
				Placeholder="Please enter game name." title="Your game name eg Monopoly" tabindex="1" maxlength="50" pattern="[a-zA-Z0-9 \-']+" required>
			</div>
			<div>
				<label for="minplayers">Min. Players:</label>
				<input type="text" id="minplayers" name="minplayers" value="<?php echo $minplayers; ?>"Placeholder="Please enter min players." title="Minimum players eg.4" tabindex="2" pattern="[0-9]*" maxlength = "4">
			</div>
			<div>
				<label for="maxplayers">Max. Players:</label>
				<input type="text" id="maxplayers" name="maxplayers" value="<?php echo $maxplayers; ?>"Placeholder="Please enter max players" title="maximum players eg 6" tabindex="3"  pattern="[0-9]*" maxlength = "4">
			</div>
			
			</fieldset>
			<div>
				<button type="submit" id="submit" tabindex="4" onclick="return validateForm()">Save</button>
<?php if($id != 0) { ?>
				<button type="submit" id="delete" tabindex="7" onclick="return validateDelete()">Delete</button>
<?php } ?>
			</div>
			
			</form>
			
			<div>
				 <h2>Owners</h2>
				<table>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Phone</th>
					 </tr>

			
<?php
	//connect to database
	$count = 0;
	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if ($link) {
			// get data from database table.

			$query = "SELECT p.`Member ID`, p.`First Name`, p.`Family Name`, p.Email, p.Phone FROM players p INNER JOIN player_games pg ON pg.`Member ID`=p.`Member ID` AND pg.`game_id`=$id WHERE IFNULL(own, 0)<>0 ORDER BY p.`First Name`, p.`Family Name`, p.`Member ID`";
			if ($result = mysqli_query($link, $query)) {
				while($row = mysqli_fetch_array($result)){
					$count++;
					$player_id = $row['Member ID'];
					$firstname = $row['First Name'];
					$lastname = $row['Family Name'];
					$email = $row['Email'];
					$phone = $row['Phone'];
					

					print <<<EOT
                <tr>
                    <td><a href="player_info.php?id=$player_id">$firstname $lastname</a></td>
                    <td>$email</td>
                    <td>$phone</td>
                </tr>
EOT;
				}
			}
	}
	
		if($count == 0){
					print <<<EOT
                <tr>
                    <td colspan="3">No owners.</td>
                </tr>
EOT;

		}
?>
		   
				</table>
			</div>

			<div>
				 <h2>Players</h2>
				<table>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Phone</th>
					 </tr>

			
<?php
	//connect to database
	$count = 0;
	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if ($link) {
			// get data from database table.

			$query = "SELECT p.`Member ID`, p.`First Name`, p.`Family Name`, p.Email, p.Phone FROM players p INNER JOIN player_games pg ON pg.`Member ID`=p.`Member ID` AND pg.`game_id`=$id WHERE IFNULL(play, 0)<>0 ORDER BY p.`First Name`, p.`Family Name`, p.`Member ID`";
			if ($result = mysqli_query($link, $query)) {
				while($row = mysqli_fetch_array($result)){
					$count++;
					$player_id = $row['Member ID'];
					$firstname = $row['First Name'];
					$lastname = $row['Family Name'];
					$email = $row['Email'];
					$phone = $row['Phone'];
					

					print <<<EOT
                <tr>
                    <td><a href="player_info.php?id=$player_id">$firstname $lastname</a></td>
                    <td>$email</td>
                    <td>$phone</td>
                </tr>
EOT;
				}
			}
	}
	
		if($count == 0){
					print <<<EOT
                <tr>
                    <td colspan="3">No players.</td>
                </tr>
EOT;

		}
?>
		   
				</table>
			</div>
           
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
	function saveGame(){
	
		global $link;
		global $game;
		global $minplayers;
		global $maxplayers;
	
//receive form data.
		$game = clean_input($_POST['game']);
		$minplayers = clean_input($_POST['minplayers']);
		$maxplayers = clean_input($_POST['maxplayers']);

// server side validation.
	
	if (empty($game)) {
		return "Game is required";
	
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$game)) {
		return  "Only letters and numbers allowed in game name"; 
		
	 }
	if (strlen($game) > 50){
		
		return "Game name must be no more than 50 characters.";
	}
	if (!preg_match("/[0-9]*/",$minplayers)) {
		return  "Only numbers allowed for minimum players"; 
	 }

	if (!preg_match("/[0-9]*/",$maxplayers)) {
		return  "Only numbers allowed for maximum players"; 
	 }

	$id = intval($_POST['id']);
	
	if($id == 0){
//insert data into board_games table.

	$queryStart = "insert into board_games(`game_name`, `min_players`, `max_players`) values(";
	$queryEnd = ")";
	$myQuery = $queryStart
				. "'$game'"
				. ", $minplayers"
				. ", $maxplayers"
				. $queryEnd;
	}else{
		
		//update board_games table.
		

	
	$myQuery = "UPDATE `board_games` SET 
	
				game_name = '$game',
				min_players = '$minplayers',
				max_players = '$maxplayers'

				WHERE `game_id` = $id";

	
	}
	if(mysqli_query($link, $myQuery) === true){
				return "";
	}else
		
		return "Sorry game information has not been saved.";
	
	}
	
	function deleteGame($id)
	{
		global $link;
		
	//delete data from board_games table.

		$myQuery = "delete from board_games where `game_id` = $id";
		if(mysqli_query($link, $myQuery) === true)
			
			header("location: list_games.php");
		else
			
			return "Sorry you are unable to delete that game.";
			
		
	}
	
?>