<?php
include_once 'dbConnect.php';

function login($username, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT username, password  FROM users WHERE username = ? LIMIT 1")) {
        $stmt->bind_param('s', $username);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
	 
        // get variables from result.
        $stmt->bind_result($username_found, $password_found);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
                // Check if the password in the database matches
                // the password the user submitted. 
                if ($password_found == $password) {
                    return true;
                } else {
                    // Password is not correct
                    return false;
                }
        } else {
            // No user exists.
            return false;
        }
    }
}

?>

