<?php
	include 'dbConnect.php';
	include 'log_function.php';
	
	if ($stmt = $mysqli->prepare("SELECT * FROM sessions")){
		
		$stmt->execute();   
    	$stmt->store_result();

		if ($stmt->num_rows == 1){
			$stmt = $mysqli->prepare("DELETE from sessions;");
			$stmt->execute();
			event_log("Logout");
		}
	}
	header('Location: /index.php');
?>
