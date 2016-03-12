<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <0) {
        header('Location: /index.php');
}
?>
		
<html>
<head>
	<meta name='viewport' content='width=device-width'>
		<title>Impostazioni generali</title>
		<link rel='stylesheet' href='css/style_general_settings.css'>
</head>
<body>
	<div class='container'>
		<div id='settings-div'>
			<h3>Impostazioni generali</h3>
			<fieldset>
				<table align=center cellpadding=5>
					<tr><td><button onClick="location.assign('formChangePassword.php')">Cambia Password</button></td></tr>
					<tr><td><button onClick="location.assign('<?php if($code_login==1){echo "firstAdmin.php";} else{echo "firstUser.php";}?>')">Torna a Schede</button></td></tr>
				</table>
			</fieldset>
		</div>
	</div>
</body>
</html>
