<?php
	include_once 'functionCheckLogin.php';

	$code_login = login_check($mysqli);	
	if($code_login <1) {
        	header('Location: /index.php');
	}

	if(isset($_REQUEST['shield_name'])){
		$mac = $_REQUEST['mac'];
		if($stmt2 = $mysqli->prepare("UPDATE shields SET name = ? WHERE mac = ?;")){
			$stmt2->bind_param("ss", $_REQUEST['shield_name'], $mac);
			$stmt2->execute();
		}
	}
	header('Location: /firstAdmin.php');
?>
