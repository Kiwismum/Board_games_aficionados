<?php
session_start();

if(array_key_exists("id", $_COOKIE)){
	
	$_SESSION['id'] = $_COOKIE['id'];
}
$profileText = "Join Us";
$profilePage = "player_info.php";
$loginText = "Log in";
$loginPage = "login.php";
$isAdmin = false;
$isloggedin = false;
if(array_key_exists("id", $_SESSION)){
//connect to database

	$link = mysqli_connect("localhost", "root", "root", "boardgamers");

	if ($link) {
	//check if user id is valid
		$query = "SELECT admin FROM players WHERE `Member ID`=".$_SESSION['id'];
		
		$result = mysqli_query($link, $query);
		if($result != false) {
			
			$loginText = "Log out";
			$loginPage = "login.php?logout=1";
			$profileText = "Profile";
			$profilePage = "player_info.php?id=".$_SESSION['id'];
			$isloggedin = true;
			$row = mysqli_fetch_array($result);
		
			if (isset($row["admin"])){
				
				if(intval($row ["admin"]) != 0){
					
					$isAdmin = true;
					$_SESSION["admin"] =1;
				}
				
			}		
		}
	}
}
?>

        <nav>
            <ul class="topnav" id="myTopnav">
				<li class="icon" onclick="myFunction()"><a href="javascript:void(0);" style="font-size:15px;" >&#9776;</a></li>
				<li><a href="index.php">Home</a></li>
                <li><a href="Events.php">Calender</a></li>
				<li><a href="about.php">About Us</a></li>

				<li><a href="<?php echo $profilePage; ?>"><?php echo $profileText;?></a></li>
			 
				<li><a href="<?php echo $loginPage; ?>"><?php echo $loginText;?></a></li>
<?php
if($isAdmin == true) {
?>
				<li><a href="list_Schedule.php">Events</a></li>
				<li><a href="list_results.php">Results </a></li>
				<li><a href="list_players.php">Players</a></li>
				<li><a href="list_games.php">Games</a></li>

<?php
}
?>
            </ul>
        </nav>
