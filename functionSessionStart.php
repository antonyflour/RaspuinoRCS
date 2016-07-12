<?php
include_once 'dbConnect.php';

function sec_session_start($mysqli, $username, $admin) {
  	//delete old cookies
	$stmt = $mysqli->prepare("DELETE from sessions;");
	$stmt->execute();

	//insert new cookie	
	$key=md5(time());
	if(strlen($key)>50){
		$key=substr($key,50);
	}

	$stmt = $mysqli->prepare("INSERT INTO sessions (key_cookie, user, isadmin, creation_date, creation_time) VALUES (?, ?, ?, ?, ?);");
	$date = date("Y-m-d");
	$time = date("G:i");
	$stmt->bind_param('sssss', $key, $username, $admin, $date, $time);        
	$stmt->execute();    // Execute the prepared query.
	setcookie("raspuino_cookie",$key,time()+600,"/",false);
}
?>
