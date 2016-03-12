<?php
include_once 'dbConnect.php';
include_once 'functionLogin.php';
include_once 'functionSessionStart.php';

if (isset($_POST['username'], $_POST['pass'])) {
    $username = $_POST['username'];
    $password = $_POST['pass']; // The hashed password.	 	
    if (login($username, $password, $mysqli) == true) {
        // Login success
	if($username=="admin"){
		sec_session_start($mysqli, $username, "YES");
    header('Location: /firstAdmin.php');
	}
	else{
		sec_session_start($mysqli, $username, "NO");
		header('Location: /firstUser.php');
	}
    } else {
        // Login failed 
        header('Location: /index.php');
    }
} else {
	echo $_POST['username'];
	echo "pass: ". $_POST['pass'];
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}

?>
