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
			
			header('location: list_players.php');
			return;
			
		}
		
	}
?>

<!DOCTYPE html>
<html>
<!-- BIT695 Web Technologies -->
<head>
    <link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="script.js"></script>
	
    <meta charset="utf-8">
    <title>Forms</title>
</head>

<body>
    <header>
        <h1>Board games aficionados</h1>
        <nav id="follow_me">
            <ul>
                <li><a href="Events.html">Weekly Calender</a></li>
				<li><a href="player_info.htm">Join Us</a></li>
                <li><a href="about.html">About Us</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <img id="left_bar" src="index_sidebar.gif" alt = "sidebar left">
        <img id="right_bar" src="index_sidebar-r.gif" alt = "sidebar right">
        <div id="wrapper">

		
            <h2>Player Information</h2>
			<h3 id="error"><?php echo $errmsg; ?></h3>
			<form  name="joinUs" method = "POST" onsubmit="return validateForm()" id="form" 
			action="player_info.php">
			<input type="hidden" id="deleteid" name="deleteid" value="">
			<fieldset class="textInputs">
			
				<label>Member ID</label>
				<input type="text" id="id" name="id" value="<?php if($id==0) echo "New Player"; else echo $id  ?>" readonly>
			
				<label for="firstname">Firstname:</label>
				<input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" 
				Placeholder="Please enter first name." title="Your first name eg John" tabindex="1" maxlength="20" pattern="[a-zA-Z \-']+" required>

				<label for="lastname">Surname:</label>
				<input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"Placeholder="Please enter surname." title="Your last name eg Smith" tabindex="2" maxlength="30" pattern="[a-zA-Z \-']+" required>

				<label for="phoneNum">Phone number:</label>
				<input type="tel" id="phoneNum" name="phoneNum" value="<?php echo $phoneNum; ?>"Placeholder="(021) 1234 56789" title="021 123 4567" tabindex="3" maxlength="15" pattern="[0-9 \-()]+" required>

				<label for="email">Email address:</label>
				<input type="email" id="email" name="email" value="<?php echo $email; ?>"
				Placeholder="eg.name@email.co.nz" title="Your email address eg name@email.co.nz" tabindex="4" maxlength="50" 
				pattern="^[a-zA-Z0-9\.\-'_%]+@[a-zA-Z0-9\-]+[\.[a-zA-Z0-9\-]+]*[\.[a-zA-Z]{2,}]+" required>
			
			</fieldset>
			<div>
				<button type="submit" id="submit" tabindex="6" onclick="return validateForm()">Save</button>
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
	function savePlayer(){
	
		global $link;
		global $firstname;
		global $lastname;
		global $phoneNum;
		global $email;
	
//receive form data.
		$firstname= clean_input($_POST['firstname']);
		$lastname= clean_input($_POST['lastname']);
		$phoneNum= clean_input($_POST['phoneNum']);
		$email= clean_input($_POST['email']);

// server side validation.
	
	if (empty($firstname)) {
		return "Firstname is required";
	
	  }
	if (empty($lastname)) {
		return "Lastname is required";
		
	  }
	  if (empty($phoneNum)) {
		return "Phone number is required";
		
	  }
	if (empty($email)) {
		return "Email is required";
		
	  }
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return "Invalid email format"; 
		
	}  
	
	$id = intval($_POST['id']);
	
	if($id == 0){
//insert data into player table.

	$queryStart = "insert into players(`First Name`, `Family Name`, `Email`, `Phone`) values(";
	$queryEnd = ")";
	$myQuery = $queryStart
				. "'$firstname'"
				. ", '$lastname'"
				. ", '$email'"
				. ", '$phoneNum'"
				. $queryEnd;
	}else{
		
		//update players table.
	
	$myQuery = "UPDATE `players` SET 
	
				firstname = '$firstname'
				lastname = '$lastname'
				phone = '$phoneNum'
				email = '$email' 
				WHERE `Member ID` = $id";

	
	}
	if(mysqli_query($link, $myQuery) === true)
		
		return "";
	else
		
		return "Sorry player information has not been added to the table.";
	
	}
	
	function deletePlayer($id)
	{
		global $link;
		
	//delete data from player table.

		$myQuery = "delete from players where `Member ID` = $id";
		if(mysqli_query($link, $myQuery) === true)
			
			return "";
		else
			
			return "Sorry you are unable to delete that player.";
			
		
	}
	
?>