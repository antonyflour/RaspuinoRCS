<?php
	include_once 'functionCheckLogin.php';

	$code_login = login_check($mysqli);	
	if($code_login <1) {
    header('Location: /index.php');
	}
	$mac = $_POST['mac'];
	if ($stmt = $mysqli->prepare("SELECT pin_number FROM pins WHERE mac_shield = ? ORDER BY pin_number ASC;")) {
       		$stmt->bind_param("s",$mac);
		if($stmt->execute()){   
        		$stmt->store_result();
			if($stmt->num_rows>0){
				$stmt->bind_result($numero_pin);
				while($stmt->fetch()){
					$str = "namepin".$numero_pin;
					if($_POST[$str]!=null){
						if($stmt2 = $mysqli->prepare("UPDATE pins SET name= ? WHERE mac_shield = ? AND pin_number = ?")){
							$stmt2->bind_param("ssi", $_POST[$str], $mac, $numero_pin);
							$stmt2->execute();
						}
					}
				}
			}
        	}
    	}
	header('Location: /firstAdmin.php');
?>
