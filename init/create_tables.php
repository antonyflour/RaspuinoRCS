<?php
	include_once '../dbConnect.php';
	
	//create users table
	$users_table_ok=false;
	if ($stmt = $mysqli->prepare("CREATE TABLE users(
															 username VARCHAR(50) PRIMARY KEY,
															 password VARCHAR(128) NOT NULL);")) {
					if($stmt->execute()){
						$users_table_ok=true;
					}
	}
	
	//create sessions table
	$sessions_table_ok=false;
	if ($stmt = $mysqli->prepare("CREATE TABLE sessions(
															 key_cookie VARCHAR(50) PRIMARY KEY,
															 user VARCHAR(50) NOT NULL,
															 isadmin VARCHAR(3) NOT NULL,
															 creation_date DATE NOT NULL,
															 creation_time TIME NOT NULL,
															 FOREIGN KEY (user) REFERENCES users(username)
																	ON UPDATE CASCADE
																	ON DELETE CASCADE);")) {
					if($stmt->execute()){
						$sessions_table_ok=true;
					}
	}
	
	//create shields table
	$shields_table_ok=false;
	if ($stmt = $mysqli->prepare("CREATE TABLE shields(
															 mac CHAR(17) PRIMARY KEY,
															 name VARCHAR(50) NOT NULL,
															 ip VARCHAR(17) NOT NULL,
															 port INTEGER NOT NULL);")) {
					if($stmt->execute()){
						$shields_table_ok=true;
					}
	}
	
	//create pins table
	$pins_table_ok=false;
	if ($stmt = $mysqli->prepare("CREATE TABLE pins(
															 mac_shield CHAR(17),
															 pin_number INTEGER,
															 type CHAR(1) NOT NULL,
															 name VARCHAR(50) NOT NULL,
															 isused VARCHAR(3) NOT NULL,
															 out_mode VARCHAR(10),
															 in_mode VARCHAR(2),
															 PRIMARY KEY(mac_shield, pin_number),
															 FOREIGN KEY (mac_shield) REFERENCES shields(mac)
																	ON UPDATE CASCADE
																	ON DELETE CASCADE);")) {
					if($stmt->execute()){
						$pins_table_ok=true;
					}
	}
	
	//insert 'admin' user 
	$insert_admin_ok=false;
	if ($stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?);")) {
					$username="admin";
					$stmt->bind_param("ss",$username, hash('sha512',"admin"));
					if($stmt->execute()){
						$insert_admin_ok=true;
					}
	}
	
	//insert 'user' user 
	$insert_user_ok=false;
	if ($stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?);")) {
					$username="user";
					$stmt->bind_param("ss",$username, hash('sha512',"user"));
					if($stmt->execute()){
						$insert_user_ok=true;
					}
	}
	
	
	if($users_table_ok==true){
		echo "users table: ok<br>";
	}
	else{
		echo "users table: error<br>";
	}

	if($sessions_table_ok==true){
		echo "sessions table: ok<br>";
	}
	else{
		echo "sessions table: error<br>";
	}
	
	if($shields_table_ok==true){
		echo "shields table: ok<br>";
	}
	else{
		echo "shields table: error<br>";
	}
	
	if($pins_table_ok==true){
		echo "pins table: ok<br>";
	}
	else{
		echo "pins table: error<br>";
	}
	
	if($insert_admin_ok==true){
		echo "insert admin: ok<br>";
	}
	else{
		echo "insert admin: error<br>";
	}
	
	if($insert_user_ok==true){
		echo "insert user: ok<br>";
	}
	else{
		echo "insert user: error<br>";
	}
?>