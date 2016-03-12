<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <0) {
        echo "<html><head></head><body><script>alert('Non sei loggato! Password non cambiata!'); location.assign('/index.php');</script></body></html>";
}
if(isset($_POST['username'], $_POST['oldpass'], $_POST['pass'])){
  if ($stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?;")) {
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();   
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
      echo "<html><head></head><body><script>alert('Utente non trovato! Password non cambiata!'); location.assign('/index.php');</script></body></html>";
    }
    else{
      $stmt->bind_result($password);
      $stmt->fetch();
      if($password==$_POST['oldpass']){
        if ($stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?;")) {
          $stmt->bind_param("ss", $_POST['pass'], $_POST['username']);
          $stmt->execute();   
          $stmt->store_result();
          //effettuo il logout
          $stmt = $mysqli->prepare("DELETE from sessions;");
          $stmt->execute();
          echo "<html><head></head><body><script>alert('Password cambiata con successo!'); location.assign('/index.php');</script></body></html>";
        }
        else{
          echo "<html><head></head><body><script>alert('Impossibile accedere al database per il cambio della password! Password non cambiata!'); location.assign('/index.php');</script></body></html>";
        }
      }
      else{
        echo "<html><head></head><body><script>alert('La vecchia password non coincide con quella salvata nel database! Password non cambiata!'); location.assign('/index.php');</script></body></html>";
      }
    }
	}
	else{
    echo "<html><head></head><body><script>alert('Impossibile accedere al database per il cambio della password! Password non cambiata!'); location.assign('/index.php');</script></body></html>";
	}
}
else{
    echo "<html><head></head><body><script>alert('Impossibile cambiare la password!'); location.assign('/index.php');</script></body></html>";
}
?>


