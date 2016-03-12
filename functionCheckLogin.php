<?php
include_once 'dbConnect.php';

//restituisce 
//-1 se l'utente non è loggato
//0 se è loggato come user
//1 se è loggato come admin
function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SERVER["HTTP_COOKIE"])) {
	
	if ($stmt = $mysqli->prepare("SELECT key_cookie, isadmin FROM sessions WHERE key_cookie = ?")){
		$cookie = $_COOKIE["raspuino_cookie"];
		$stmt->bind_param('s', $cookie);
	       	$stmt->execute();   
        	$stmt->store_result();
		
    if ($stmt->num_rows == 1){
			$stmt->bind_result($cookie_key, $admin);
        		$stmt->fetch();
			if($admin=="YES"){
				return 1;
			}
      else{
				return 0;
			}
    } else{
		    return -1;
		}
	}else{
		return -1;
	}
    } else {
	return -1;
    }
}

?>
