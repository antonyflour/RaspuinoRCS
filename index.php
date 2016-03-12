<?php
include_once 'functionCheckLogin.php';
 
$admin_code = login_check($mysqli);
if ($admin_code >=0) {
	if($admin_code==1){
   	 	header('Location: /firstAdmin.php');
	}
	else{
		header('Location: /firstUser.php');
	}
} 
?>
<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width">
        <title>Login</title>
        <link rel="stylesheet" href="css/style_login.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
	<div class="container">
	<div id="login-form">
	<h3>Raspuino System</h3>
	<fieldset>
        <form action="/processLogin.php" method="post" name="login_form" id="login_form">                      
        	<input type="text" name="username" required value="Username" onBlur="if(this.value=='')this.value='Username'" onFocus="if(this.value=='Username')this.value='' "> 
			<input type="password" name="password" required value="Password" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value='' "> 
			<input type="button" value="Login" onclick="formhash(this.form, this.form.password);" /> 
        </form>
	</fieldset>
	</div>
	</div>
    </body>
</html>
