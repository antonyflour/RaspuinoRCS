<?php
include_once 'functionCheckLogin.php';
 
$admin_code = login_check($mysqli);
if ($admin_code <0) {
  header('Location: /index.php');
}

if($admin_code==1) $utente="admin";
else $utente="user";
?>

<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width">
        <title>Cambia Password</title>
        <link rel="stylesheet" href="css/style_form_change_password.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/changepass.js"></script> 
    </head>
    <body>
	<div class="container">
	<div id="changepass-form">
	<h3>Cambia password per l'utente: <?php echo $utente ?></h3>
	<fieldset>
        <form action="/changePassword.php" method="post" name="change_form" id="change_form">
          <input type="hidden" name="username" value="<?php echo $utente?>">
        <table align=center border=0 cellpadding=5>
        	<tr><td>Vecchia password</td><td><input type="password" name="oldpass"></td> 
        	<tr><td>Nuova password</td><td><input type="password" name="pass1"></td>
          <tr><td>Conferma password</td><td><input type="password" name="pass2"></td> 
          <tr><td colspan=2><input type="button" value="Cambia" onclick="sendnewpass(this.form, this.form.oldpass, this.form.pass1, this.form.pass2)"></td> 
        </table>
        </form>
	</fieldset>
	</div>
	</div>
    </body>
</html>
