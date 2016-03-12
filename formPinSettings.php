<?php 
	include_once 'functionCheckLogin.php';
	
	$code_login = login_check($mysqli); 
	if($code_login <1) {
        	header('Location: /index.php');
	}
	
	$mac = $_REQUEST['mac']; 
	if ($stmt = $mysqli->prepare("SELECT * FROM shields WHERE mac = ?;")) {
		$stmt->bind_param("s",$mac);
        	$stmt->execute();
        	$stmt->store_result();
	
        if ($stmt->num_rows == 1) {
		$stmt->bind_result($mac,$nome_scheda,$ip,$port);
		$stmt->fetch();
		
		//costruisco l'intestazione della pagina
		echo "<html>";
		echo "<head><meta name='viewport' content='width=device-width'><title>".$nome_scheda."</title><link rel='stylesheet' 
href='css/style_form_pin_settings.css'></script> </head>";
  		echo "<body><div class='container' align=center><div id='setting-div'><h3>".$nome_scheda."</h3><fieldset>"; //costruisco la tabella html
				echo "<form name='form_settings' action='/pinSettings.php' method='post'>";
				echo "<input type='hidden' name='mac' value='".$mac."'>";
				echo "<table border=1 align=center cellpadding=5 cellspacing=0>";
        			echo "<tr class='boldtr'><td colspan=4>INPUT";
        			echo "<tr class='boldtr'><td>N.<td>NOME<td>USATO<td>TIPO";
				//recupero le informazioni sui pin di input
				if ($stmt = $mysqli->prepare("SELECT pin_number, name, isused, in_mode FROM pins WHERE mac_shield = ? AND type = ? ORDER BY 
pin_number ASC;")) {
       					$tipo="I";
					$stmt->bind_param("ss",$mac,$tipo);
					$stmt->execute();
        				$stmt->store_result();
					if($stmt->num_rows>0){
						$stmt->bind_result($numero_pin, $nome, $usato, $input_type);
						
        					while($stmt->fetch()){
							echo "<tr>";
							echo "<td>".$numero_pin."<td>".$nome;
							echo "<td><div align=left>";
							if($usato=="YES"){
								echo "<input type='radio' name='usato".$numero_pin."' value='YES' checked>SI<br>";
								echo "<input type='radio' name='usato".$numero_pin."' value='NO'>NO";
							}
							else{
								echo "<input type='radio' name='usato".$numero_pin."' value='YES'>SI<br>";
								echo "<input type='radio' name='usato".$numero_pin."' value='NO' checked>NO";
							}
							echo "</div>";
							echo "<td><div align=left>";
							if($input_type=="NL"){
								echo "<input type='radio' name='input_type".$numero_pin."' value='NL' checked>NORM.LOW<br>";
								echo "<input type='radio' name='input_type".$numero_pin."' value='NH'>NORM.HIGH";
							}
							else{
								echo "<input type='radio' name='input_type".$numero_pin."' value='NL'>NORM.LOW<br>";
								echo "<input type='radio' name='input_type".$numero_pin."' value='NH' checked>NORM.HIGH";
							}
							echo "</div>";
						}
					}
					else{
						echo "<tr><td colspan=6>Pin di input non trovati nel database";
					}
				}
				else{
					echo "<tr><td colspan=6>Impossibile accedere al database per il recupero dei pin di input";
				}
				
				//tabella html
				echo "<tr class='boldtr'><td colspan=4>OUTPUT";
        			echo "<tr class='boldtr'><td>N.<td>NOME<td>USATO<td>TIPO";
				//recupero le informazioni sui pin di output
				if ($stmt = $mysqli->prepare("SELECT pin_number, name, isused, out_mode FROM pins WHERE mac_shield = ? AND type = ? ORDER BY 
pin_number ASC;")) {
       					$tipo="O";
					$stmt->bind_param("ss",$mac,$tipo);
					$stmt->execute();
        				$stmt->store_result();
					if($stmt->num_rows>0){
						$stmt->bind_result($numero_pin, $nome, $usato, $out_mode);
						while($stmt->fetch()){
							echo "<tr>";
							echo "<td>".$numero_pin."<td>".$nome;
							echo "<td><div align=left>";
							if($usato=="YES"){
								echo "<input type='radio' name='usato".$numero_pin."' value='YES' checked> SI<br>";
								echo "<input type='radio' name='usato".$numero_pin."' value='NO'> NO";
							}
							else{
								echo "<input type='radio' name='usato".$numero_pin."' value='YES'> SI<br>";
								echo "<input type='radio' name='usato".$numero_pin."' value='NO' checked> NO";
							}
							echo "</div>";
							echo "<td><div align=left>";
							if($out_mode=="HL"){
								echo "<input type='radio' name='out_mode".$numero_pin."' value='HL' checked> HIGH-LOW<br>";
								echo "<input type='radio' name='out_mode".$numero_pin."' value='TOGGLE'> TOGGLE";
							}
							else{
								echo "<input type='radio' name='out_mode".$numero_pin."' value='HL'> HIGH-LOW<br>";
								echo "<input type='radio' name='out_mode".$numero_pin."' value='TOGGLE' checked> TOGGLE";
							}	
							echo "</div>";
						}
						//concludo la tabella
						echo "<tr><td colspan=4><button onClick='document.form_settings.submit();'>Salva</button>";
						echo "</table></form>";
						echo "<br><br><br>";
					}
					else{
						echo "<tr><td colspan=5>Pin di output non trovati nel database</table>";
					}
				}
				else{
					echo "<tr><td colspan=5>Impossibile accedere al database per il recupero dei pin di output</table>";
				}
	}
	else{
		echo "<div align=center>Scheda non registrata</div>";
	}
}
else{
	echo "<div align=center>Impossibile accedere al database per il recupero della scheda</div>";
}
?> 
	<table align=center><tr><td><button onClick="location.assign('/firstAdmin.php')">Torna a Schede</button></table>
	</fieldset>
 	</div> </div> </body> </html>
