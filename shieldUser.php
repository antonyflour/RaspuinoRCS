<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <0) {
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
		echo "<head><meta name='viewport' content='width=device-width'><title>".$nome_scheda."</title><link rel='stylesheet' href='css/style_shield.css?".(date('l jS \of F Y h:i:s A'))."'><script type='text/JavaScript' src='js/change_state.js'></script> </head>";
  		echo "<body><div class='container' align=center><div id='shield-div'><h3>".$nome_scheda."</h3><fieldset>";

		//recupero lo stato dei pin di input della scheda
		$curl = curl_init();
		curl_setopt_array($curl, array(
    		CURLOPT_RETURNTRANSFER => 1,
    		CURLOPT_URL => 'http://'.$ip.':'.$port.'/input_status.php',
   		CURLOPT_USERAGENT => 'Raspberry',
		CURLOPT_TIMEOUT => 5));
		$resp = curl_exec($curl);
		$curl_info = curl_getinfo($curl);
		curl_close($curl);
		if($curl_info['http_code']==200){
			$input_status = json_decode($resp,true);
			
			//recupero lo stato dei pin di output della scheda
			$curl = curl_init();
			curl_setopt_array($curl, array(
    			CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => 'http://'.$ip.':'.$port.'/output_status.php',
   			CURLOPT_USERAGENT => 'Raspberry',
			CURLOPT_TIMEOUT => 5));
			$resp = curl_exec($curl);
			$curl_info = curl_getinfo($curl);
			curl_close($curl);
			if($curl_info['http_code']==200){
				$output_status = json_decode($resp,true);
				
				//costruisco la tabella html
				echo "<table border=1 align=center cellpadding=5 cellspacing=0>";
        			echo "<tr class='boldtr'><td colspan=3>INPUT";
        			echo "<tr class='boldtr'><td>NOME<td colspan=2>STATO";

				//recupero le informazioni sui pin di input
				if ($stmt = $mysqli->prepare("SELECT pin_number, name, isused, in_mode FROM pins WHERE mac_shield = ? AND type = ?  ORDER BY pin_number ASC;")) {
       					$tipo="I";
					$stmt->bind_param("ss",$mac,$tipo);
					$stmt->execute();   
        				$stmt->store_result();
					if($stmt->num_rows>0){
						$stmt->bind_result($numero_pin, $nome, $usato, $input_type);
						$i=0;
        					while($stmt->fetch()){
							if($usato=="YES"){
								if($input_status[$i]==1){
									if($input_type=="NL"){
										$str_status="ON";
									}
									else{
										$str_status="OFF";
									}
								}
								else{
									if($input_type=="NL"){
										$str_status="OFF";
									}
									else{
										$str_status="ON";
									}
							}
								echo "<tr>";
								echo "<td class='boldtd'>".$nome;
								if($str_status=="OFF"){
									echo "<td colspan=2 class='offtd'>";
								}
								else{
									 echo "<td colspan=2 class='ontd'>";
								}
								echo $str_status;
							}
							$i++;
						}
					}
					else{
						echo "<tr><td colspan=3>Pin di input non trovati nel database";
					}
				}
				else{
					echo "<tr><td coslpan=3>Impossibile accedere al database per il recupero dei pin di input";
				}
				
				//tabella html
				echo "<tr class='boldtr'><td colspan=3>OUTPUT";
        echo "<tr class='boldtr'><td>NOME<td>STATO<td>AZIONE";

				//recupero le informazioni sui pin di output
				if ($stmt = $mysqli->prepare("SELECT pin_number, name, isused, out_mode FROM pins WHERE mac_shield = ? AND type = ? ORDER BY pin_number ASC;")) {
       					$tipo="O";
					$stmt->bind_param("ss",$mac,$tipo);
					$stmt->execute();   
        				$stmt->store_result();
					if($stmt->num_rows>0){
						$stmt->bind_result($numero_pin, $nome, $usato, $out_mode);
						$i=0;        					
						while($stmt->fetch()){
							if($usato=="YES"){
								if($out_mode=="HL"){
									if($output_status[$i]==1){
										$str_status="ON";
										$str_azione="SPEGNI";
										$cmd_azione=0;
									}
									else{
										$str_status="OFF";
										$str_azione="ACCENDI";
										$cmd_azione=1;
									}
								}
								else{
									$str_status = "ND";
									$str_azione="TOGGLE";
									$cmd_azione=2;
								}
								echo "<tr>";
								echo "<td class='boldtd'>".$nome;
								if($str_status=="OFF"){
									echo "<td class='offtd'>";
								}
								else if($str_status=="ON"){
									echo "<td class='ontd'>";
								}
								else{
									echo "<td>";
								}
								echo $str_status;
								echo "<td align=center><button onClick='changeState(\"".$ip."\",".$port.",".$numero_pin.",".$cmd_azione.")'>".$str_azione."</button>";
							}
							$i++;
						}

						//concludo la tabella
						echo "</table>";
					}
					else{
						echo "<tr><td colspan=3>Pin di output non trovati nel database</table>";
					}
				}
				else{
					echo "<tr><td colspan=3>Impossibile accedere al database per il recupero dei pin di output</table>";
				}
			}
			else{
				echo "<div align=center>Impossibile collegarsi alla scheda per il recupero dei pin</div>";
			}
					
		}	
		else{
			echo "<div align=center>Impossibile collegarsi alla scheda per il recupero dei pin</div>";		
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
	<br>
		<table align=center><tr><td><button onClick="location.reload();">Ricarica</button></table>
		<br>
		<br>
		<table align=center><tr><td><button onClick="location.assign('/firstUser.php');">Torna a Schede</button></table>
	</fieldset>
 	</div>
</div>
</body>
</html>
