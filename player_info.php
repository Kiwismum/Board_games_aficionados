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
	$firstname = "";
	$lastname = "";
	$phoneNum = "";
	$email = "";
	$username = "";
	$password = "";
	$errmsg = "";
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){

// See if id has been provided

		$id = intval($_GET['id']);
		if($id != 0)
		{
			
	// get data from database table.

			$query = "SELECT * FROM players where `Member ID` = $id";
			if ($result = mysqli_query($link, $query)) {
				if($row = mysqli_fetch_array($result)){
					$firstname = $row['First Name'];
					$lastname = $row['Family Name'];
					$phoneNum = $row['Phone'];
					$email = $row['Email'];
					$username = $row['UserName'];
					$password = $row['Password'];
				}
			}
		}
	}else{
		
		$deleteId = intval($_POST['deleteid']);
		if($deleteId !=0){
			
			$errmsg = deletePlayer($deleteId);
			
		}
		else
			$errmsg = savePlayer();
		if ($errmsg == ""){
			$errmsg = "Player information saved.";
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
	
    <title>Player Information</title>
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
            <h2>Player Information</h2>
			<h3 id="error"><?php echo $errmsg; ?></h3>
			<form  name="joinUs" method = "POST" onsubmit="return validateForm()" id="form" 
			action="">
				<input type="hidden" id="deleteid" name="deleteid" value="">
				<fieldset class="textInputs">
					<div> 
						<label>Member ID:</label>
						<input type="text" id="id" name="id" value="<?php if($id==0) echo "New Player"; else echo $id  ?>" readonly>
					</div>
					<div>
						<label for="firstname">First Name:</label>
						<input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" 
						Placeholder="Please enter first name." title="Your first name eg John" tabindex="1" maxlength="20" pattern="[a-zA-Z \-']+" required>
					</div>
					<div>
						<label for="lastname">Surname:</label>
						<input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"Placeholder="Please enter surname." title="Your last name eg Smith" tabindex="2" maxlength="30" pattern="[a-zA-Z \-']+" required>
					</div>
					<div>
						<label for="phoneNum">Phone number:</label>
						<input type="tel" id="phoneNum" name="phoneNum" value="<?php echo $phoneNum; ?>"Placeholder="021 1234 56789" title="021 123 4567" tabindex="3" maxlength="15" pattern="[0-9 \-()]+" required>
					</div>
					<div>
						<label for="email">Email address:</label>
						<input type="email" id="email" name="email" value="<?php echo $email; ?>"
						Placeholder="eg.name@email.co.nz" title="Your email address eg name@email.co.nz" tabindex="4" maxlength="50" 
						pattern="^[a-zA-Z0-9\.\-'_%]+@[a-zA-Z0-9\-]+[\.[a-zA-Z0-9\-]+]*[\.[a-zA-Z]{2,}]+" required>
					</div>
					<div>
						<label for="username">Username:</label>
						<input type="text" id="username" name="username" value="<?php echo $username; ?>" 
						Placeholder="Please enter user name." title="Your user name eg JohnDoe" tabindex="5" maxlength="20" pattern="[a-zA-Z0-9 \-']+" required>
					</div>
					<div>
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" Placeholder="Please enter password." title="Six or more characters"tabindex="6" maxlength="50" pattern=".{6,}"<?php if($id==0) echo " required"; ?>>
					</div>
				</fieldset>
			
				
				<div>
					 <h2>Games </h2>
					<table>
						<tr>
							<th scope="col">Own</th>
							<th scope="col">Play</th>
							<th scope="col">Game</th>
						 </tr>

			
<?php
	//connect to database
	$count = 0;
	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if ($link) {
			// get data from database table.

			$query = "SELECT bg.game_id, bg.game_name, pg.own, pg.play FROM board_games bg LEFT OUTER JOIN player_games pg ON pg.game_id=bg.game_id AND pg.`Member ID`=$id ORDER BY bg.`game_name`, bg.`game_id`";
			if ($result = mysqli_query($link, $query)) {
				while($row = mysqli_fetch_array($result)){
					$count++;
					$game_id = $row['game_id'];
					$game = $row['game_name'];
					$own = intval($row['own']);
					$play = intval($row['play']);
					
					$ownChecked = "";
					$playChecked ="";
					if($own != 0){
						$ownChecked = " checked";
					
					}
					if($play != 0){
						$playChecked = " checked";
					}

					print <<<EOT
                <tr>
                    <td><input type="checkbox" name="own_$game_id"$ownChecked></td>
                    <td><input type="checkbox" name="play_$game_id"$playChecked></td>
                    <td><a href="game_info.php?id=$game_id">$game</a></td>
                </tr>
EOT;
				}
			}
	}
	
		if($count == 0){
					print <<<EOT
                <tr>
                    <td colspan="3">No games defined.</td>
                </tr>
EOT;

		}
?>
               
					</table>
				</div>
	
				<div>
					<button type="submit" id="submit" tabindex="7" onclick="return validateForm()">Save</button>
<?php if($id != 0 && isset ($_SESSION["id"]) && $id != $_SESSION["id"]) { ?>
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
	function savePlayer(){
	
		global $link;
		global $id;
		global $firstname;
		global $lastname;
		global $phoneNum;
		global $email;
		global $username;
		global $password;
	
//receive form data.
		$id = intval(clean_input($_POST['id']));
		$firstname= clean_input($_POST['firstname']);
		$lastname= clean_input($_POST['lastname']);
		$phoneNum= clean_input($_POST['phoneNum']);
		$email= clean_input($_POST['email']);
		$username= clean_input($_POST['username']);
		$password= clean_input($_POST['password']);

// server side validation.
	
	if (empty($firstname)) {
		return "Firstname is required";
	
	  }
	if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
		return  "Only letters allowed in first name"; 
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
	  if (empty($phoneNum)) {
		return "Phone number is required";
		
	  }
	if (!preg_match("/[0-9 \-()]+/",$phoneNum)) {
		return  "Only numbers allowed for phone number"; 
	 }
	if (strlen($phoneNum) > 15){
		
		return "Phone number must be no more than 15 characters.";
	}
	if (empty($email)) {
		return "Email is required";
		
	  }
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return "Invalid email format"; 
		
	}  
	if (empty($username)) {
		return "Username is required";
		
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username)) {
		return  "Only letters and numbers allowed for user name"; 
	 }
	if (strlen($username) > 20){
		
		return "User name must be no more than 20 characters.";
	}
	  
	 if ($id==0 && empty($password)) {
		return "Password is required";
		
	  }
	if (strlen($password) > 50){
		
		return "Password must be no more than 50 characters.";
	}
	
	if($id == 0){
//insert data into player table.

	$queryStart = "insert into players(`First Name`, `Family Name`, `Email`, `Phone`, `UserName`) values(";
	$queryEnd = ")";
	$myQuery = $queryStart
				. "'$firstname'"
				. ", '$lastname'"
				. ", '$email'"
				. ", '$phoneNum'"
				. ", '$username'"
				. $queryEnd;
	}else{
		
		//update players table.
		

	
	$myQuery = "UPDATE `players` SET 
	
				`First Name` = '$firstname',
				`Family Name` = '$lastname',
				`Phone` = '$phoneNum',
				`Email` = '$email' ,
				`UserName` = '$username'
				WHERE `Member ID` = $id";

	
	}
	if(mysqli_query($link, $myQuery) === true){
		$setpwd = ($id == 0) || !empty($password);

		if($id==0){
			
			$id=mysqli_insert_id($link);
		}
		
		if($setpwd){
		// encrypt password	
			$query = "UPDATE `players` SET password = '".md5(md5($id).$password)."' WHERE `Member ID` = $id";

			mysqli_query($link, $query);
		}
		saveGames();
		return "";
	}else
		
		return "Sorry player information has not been saved.$myQuery";
	
	}
	
	function saveGames()
	{
		global $link;
		global $id;
		
//	query board_games table for game id.
		
		$myQuery = "SELECT game_id FROM board_games";
		if ($result = mysqli_query($link, $myQuery)) {
			while($row = mysqli_fetch_array($result)){

				$game_id = $row['game_id'];
				
// retrieve values of check boxes

				$own= clean_input($_POST["own_$game_id"]);
				$play= clean_input($_POST["play_$game_id"]);

				if($own == ""){
					
					$own = 0;				
				}else{
					$own = 1;
				}
				if($play == ""){
					$play = 0;
				}else{
					$play = 1;
				}
				
// check if player and game exists in player_games.
				$gameExists = false;
				$myQuery = "SELECT * FROM player_games WHERE `Member ID` = $id AND game_id = $game_id";
// update player_games table
				if(($gameResult = mysqli_query($link, $myQuery)) !== false){
					$gameExists = mysqli_num_rows($gameResult) > 0;
				}
				if($gameExists){
					$myQuery = "UPDATE `player_games` SET 
						`own` = $own,
						`play` = $play
						WHERE `Member ID` = $id AND game_id = $game_id";
				}else{
//insert data into player_games table.
					$queryStart = "insert into `player_games`(`Member ID`, `game_id`, `own`, `play`, `highScore`) values(";
					$queryEnd = ")";
					$myQuery = $queryStart
								. "$id"
								. ", $game_id"
								. ", $own"
								. ", $play"
								. ", 0"
								. $queryEnd;
				}

// execute the update or insert query
				mysqli_query($link, $myQuery);
			}
		}
	}
	
	function deletePlayer($id)
	{
		global $link;
		
	//delete data from player table.

		$myQuery = "delete from players where `Member ID` = $id";
		if(mysqli_query($link, $myQuery) !== false)
			
			header("location: list_players.php");
		else
			
			return "Sorry you are unable to delete that player.";
			
		
	}
	
?>