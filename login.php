<?php

	session_start();
	
	$error ="";
	
	if(array_key_exists("logout", $_GET)){
		
		unset($_SESSION);
		setcookie("id", mysqli_insert_id($link), time() - 60*60*24);
		$_COOKIE["id"] = "";
		
	}else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) 
			OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])){
		
		header("Location: events.php");
		return;
	}
	
	if(array_key_exists("submit", $_POST)){
		$error = ValidateUser();
		if($error ==""){
			header("Location: events.php");
			return;
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
    <meta charset="utf-8">
	
    <title>Log in form</title>
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

		
		
            <h2>Log In</h2>
			<h3 id="error"><?php echo $error; ?></h3>
			<form  name="login" method = "POST" onsubmit="return validateForm()" id="form" 
			action="">
			<input type="hidden" id="deleteid" name="deleteid" value="">
			
			<fieldset class="textInputs">

		

		  
		  <div>
			<label for="username">Username</label>
			<input type="text" id="username" name="username" <?php echo $username; ?>placeholder="Enter UserName" name="username" tabindex="1" maxlength="20" pattern="[a-zA-Z0-9 \-']+" required>
		</div>
		<div>
			<label for="password"><b>Password</b></label>
			<input type="Password" id="password" name="password" placeholder="Enter Password" name="Password" tabindex="2" maxlength="50"  pattern=".{6,}" title="Six or more characters" required>
		</div>

			
			</fieldset>
			<div>
			<button type="submit" name="submit">Login</button>
			</div>
			<div>
			<input type="checkbox" name="stayLoggedIn" checked="checked"> Remember me
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

function ValidateUser() {
	
		
//receive form data.

		$username= clean_input($_POST['username']);
		$password= clean_input($_POST['password']);		
		
	if (empty($username)) {
		return "Username is required";
		
	  }
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username)) {
		return  "Only letters and numbers allowed"; 
	 }
	if (strlen($username) > 20){
		
		return "User name must be no more than 20 characters.";
	}
	  
	 if (empty($password)) {
		return "Password is required";
		
	  }
	if (strlen($password) > 50){
		
		return "Password must be no more than 50 characters.";
	}
		
			//connect to database
			$link = mysqli_connect("localhost", "root", "root", "boardgamers");

			if (!$link) {
				echo "Error: Unable to connect to MySQL." . PHP_EOL;
				echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
				echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
				exit;
			}
			
			//check if user exixts
		
			$query = "SELECT `Member ID`, `Password` FROM `players` 
				WHERE UserName = '".mysqli_real_escape_string($link, $_POST['username'])."'";
			
			$result = mysqli_query($link, $query);
			
			$row = mysqli_fetch_array($result);
			
			if (isset($row["Member ID"])){
				
				$hashedPassword = md5(md5($row["Member ID"]).$_POST['password']);

				if ($hashedPassword == $row['Password']){
					
					$_SESSION['id'] = $row["Member ID"];
					if($_POST['stayLoggedIn'] != ''){
				
						setcookie("id", $row["Member ID"], time() +60*60*24);
					}

					return "";
				}else{
					
					$error = "That user/password combination could not be found.";
				}
			}else {
				
				$error = "That user/password combination could not be found.";
			}

}
?>
