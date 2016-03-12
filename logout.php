<?php
	include 'dbConnect.php';
	$stmt = $mysqli->prepare("DELETE from sessions;");
	$stmt->execute();
	header('Location: /index.php');
?>
