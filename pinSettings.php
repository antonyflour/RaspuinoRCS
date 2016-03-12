<?php
	include_once 'functionCheckLogin.php';	
	
	$code_login = login_check($mysqli); 
	if($code_login <1) {
        	header('Location: /index.php');
	}
	
	$mac=$_POST['mac'];
	
	if ($stmt = $mysqli->prepare("SELECT pin_number FROM pins WHERE mac_shield = ? AND type = ? ORDER BY pin_number ASC;")) { 
       		$tipo="I";
		$stmt->bind_param("ss",$mac,$tipo);
		if($stmt->execute()){
        		$stmt->store_result();
			if($stmt->num_rows>0){
				$stmt->bind_result($numero_pin);
				while($stmt->fetch()){
					$str = "usato".$numero_pin;
					if($_POST[$str]!=null){
						if($stmt2 = $mysqli->prepare("UPDATE pins SET isused = ? WHERE mac_shield = ? AND pin_number = ?")){
							$stmt2->bind_param("ssi", $_POST[$str], $mac, $numero_pin);
							$stmt2->execute();
						}
					}
					$str = "input_type".$numero_pin;
					if($_POST[$str]!=null){
						if($stmt2 = $mysqli->prepare("UPDATE pins SET in_mode= ? WHERE mac_shield = ? AND pin_number = ?")){
							$stmt2->bind_param("ssi", $_POST[$str], $mac, $numero_pin); 
							$stmt2->execute(); 
						}
					}			
				}
        		}
    		}
	}
	
	if ($stmt = $mysqli->prepare("SELECT pin_number FROM pins WHERE mac_shield = ? AND type = ? ORDER BY pin_number ASC;")) { 
       		$tipo="O";
		$stmt->bind_param("ss",$mac,$tipo);
		if($stmt->execute()){
        		$stmt->store_result();
			if($stmt->num_rows>0){
				$stmt->bind_result($numero_pin);
				while($stmt->fetch()){
					$str = "usato".$numero_pin;
					if($_POST[$str]!=null){
						if($stmt2 = $mysqli->prepare("UPDATE pins SET isused = ? WHERE mac_shield = ? AND pin_number = ?")){
							$stmt2->bind_param("ssi", $_POST[$str], $mac, $numero_pin);
							$stmt2->execute();
						}
					}
					$str = "out_mode".$numero_pin;
					if($_POST[$str]!=null){
						if($stmt2 = $mysqli->prepare("UPDATE pins SET out_mode = ? WHERE mac_shield = ? AND pin_number = ?")){
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
