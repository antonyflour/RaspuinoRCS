<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <1) {
        header('Location: /index.php');
}

$mac = $_REQUEST['mac'];
if ($stmt = $mysqli->prepare("SELECT name FROM shields WHERE mac = ?;")) {
	$stmt->bind_param("s",$mac);
        $stmt->execute();   
        $stmt->store_result();
	
        if ($stmt->num_rows == 1) {
					$stmt->bind_result($nome_scheda);
					$stmt->fetch();
				}
}
?>
		
<html>
<head>
	<meta name='viewport' content='width=device-width'>
		<title><?php echo $nome_scheda?></title>
		<link rel='stylesheet' href='css/style_shield_settings.css'>
</head>
<body>
	<div class='container'>
		<div id='settings-div'>
			<h3>Impostazioni <?php echo $nome_scheda ?></h3>
			<fieldset>
				<table align=center cellpadding=5>
					<tr><td><button onClick="location.assign('formShieldName.php?mac=<?php echo $mac?>')">Cambia nome alla scheda</button></td></tr>
					<tr><td><button onClick="location.assign('formPinName.php?mac=<?php echo $mac?>')">Cambia nome ai pin</button></td></tr>
					<tr><td><button onClick="location.assign('formPinSettings.php?mac=<?php echo $mac?>')">Modifica impostazioni pin</button></td></tr>
					<tr><td><button onClick="location.assign('shieldAdmin.php?mac=<?php echo $mac ?>')">Torna a <?php echo $nome_scheda ?></button></td></tr>
				</table>
			</fieldset>
		</div>
	</div>
</body>
</html>
