<?php
	include_once 'functionCheckLogin.php';

	$code_login = login_check($mysqli);	
	if($code_login <1) {
		header('Location: /index.php');
	}
	$mac = $_REQUEST['mac'];
	$stmt = $mysqli->prepare("DELETE FROM shields WHERE mac = ?;");
	$stmt->bind_param("s",$mac);
	$stmt->execute();
	header('Location: /firstAdmin.php');   
?>
