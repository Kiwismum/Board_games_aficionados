<?php

// validate if user is admin for security

	session_start();

	if(array_key_exists("id", $_COOKIE)){
		
		$_SESSION['id'] = $_COOKIE['id'];
	}

	$_SESSION["admin"] = 0;

	if(array_key_exists("id", $_SESSION) && $_SESSION["id"]){
	
	//connect to database

		$link = mysqli_connect("localhost", "root", "root", "boardgamers");

		if ($link) {
		
		//check if user id is valid
			$query = "SELECT admin FROM players WHERE `Member ID`=".$_SESSION['id'];
			
			$result = mysqli_query($link, $query);
			if($result != false) {
				
				$isloggedin = true;
				$row = mysqli_fetch_array($result);
			
				if ($row && isset($row["admin"])){
					
					if(intval($row ["admin"]) != 0){
						
						$_SESSION["admin"] = 1;
					}
					
				}else{
					
					$_SESSION["id"] = 0;
				}		
			}else{
				
				$_SESSION["id"] = 0;
			}
		}else{
			
			$_SESSION["id"] = 0;
		}
	}

	?>