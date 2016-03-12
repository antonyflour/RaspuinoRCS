<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <1) {
        header('Location: /index.php');
}
?>

<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <title>Schede collegate</title>
    <link rel="stylesheet" href="css/style_first.css"> 
  </head>
  <body>

	 <div class="container">
 	 <div id="div-first">
    	<h3>Schede collegate</h3>
    	<fieldset>	
	<?php 
	if ($stmt = $mysqli->prepare("SELECT * FROM shields")) {
        $stmt->execute();   
        $stmt->store_result();
	
        if ($stmt->num_rows == 0) {
		echo " Non ci sono schede collegate ";
        }
	else{
		echo "<table border=1 align=center cellpadding=5 cellspacing=0>";
		echo "<tr class='boldtr'><td>MAC<td>NOME<td>IP<td>PORTA";
		$stmt->bind_result($mac,$nome,$ip,$port);
		while($stmt->fetch()){
			echo "<tr><td><a href='/shieldAdmin.php?mac=".$mac."'>".$mac."</a><td class='boldtd'>".$nome."<td>".$ip."<td>".$port;
		}
		echo "</table>";
	}
	}
	else{
		echo "Impossibile recuperare le schede";
	}
	?>
	<br>
	<table align=center border=0 cellpadding=3>
	<tr>
    <td><button onClick="location.assign('/generalSettings.php');">Impostazioni</button>
    <td><button onClick="location.assign('/formAddShield.php');">Aggiungi Scheda</button>
		<td><button onClick="location.assign('/logout.php');">Logout</button>
	</table>
    </fieldset>
  </div>
  </div>

  </body>

</html>
