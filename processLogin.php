<?php
include_once 'dbConnect.php';
include_once 'functionLogin.php';
include_once 'functionSessionStart.php';
include_once 'log_function.php';

if (isset($_POST['username'], $_POST['pass'])) {

	// mysql è case INSENSITIVE sui varchar per default (per correttezza, porto comunque lo username a lowercase)

    $username = strtolower($_POST['username']);
    $password = $_POST['pass']; // The hashed password.	 
	
	event_log("Tentato accesso da ".$_SERVER['REMOTE_ADDR']."\t username: ".$username);

    if (login($username, $password, $mysqli) == true) {
        // Login success
	if($username=="admin"){
	    event_log("Accesso consentito a ".$_SERVER['REMOTE_ADDR']."\t username: ".$username);
		sec_session_start($mysqli, $username, "YES");
        header('Location: /firstAdmin.php');
	}
	else{
	    event_log("Accesso consentito a ".$_SERVER['REMOTE_ADDR']."\t username: ".$username);
		sec_session_start($mysqli, $username, "NO");
		header('Location: /firstUser.php');
	}
    } else {
        // Login failed 
	    event_log("Login fallito da ".$_SERVER['REMOTE_ADDR']."\t username: ".$username);
        header('Location: /index.php');
    }
} else {
	echo $_POST['username'];
	echo "pass: ". $_POST['pass'];
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}

?>
