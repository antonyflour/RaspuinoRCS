<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <0) {
        header('Location: /index.php');
}
else{
	echo exec("sudo shutdown -h now");
}
?>
		
