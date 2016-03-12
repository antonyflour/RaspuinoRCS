<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <1) {
        header('Location: /index.php');
}

$ip = $_REQUEST['ip'];
$port = $_REQUEST['port'];

//Mi collego per ottenere il MAC address
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://'.$ip.':'.$port.'/mac.php',
    CURLOPT_USERAGENT => 'Raspberry'));
$resp = curl_exec($curl);
$curl_info = curl_getinfo($curl);
curl_close($curl);
if($curl_info['http_code']==200){
	if(preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $resp) == 1){
		$mac = $resp;
    	//Mi collego per ottenere i pin di input
    	$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://'.$ip.':'.$port.'/input_pin.php',
				CURLOPT_USERAGENT => 'Raspberry'));
		$resp = curl_exec($curl);
		$curl_info = curl_getinfo($curl);
		curl_close($curl);
    if($curl_info['http_code']==200){
			$input_pin = json_decode($resp,true);
			//Mi collego per ottenere i pin di output
			$curl = curl_init();
			curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://'.$ip.':'.$port.'/output_pin.php',
					CURLOPT_USERAGENT => 'Raspberry'));
			$resp = curl_exec($curl);
			$curl_info = curl_getinfo($curl);
			curl_close($curl);
			if($curl_info['http_code']==200){
				$output_pin = json_decode($resp,true);
				if ($stmt = $mysqli->prepare("INSERT INTO shields (mac, name, ip, port) values (? , ?, ?, ?);")) {
					$nome = "Nuova Scheda";
					$stmt->bind_param('sssi', $mac, $nome, $ip, $port);
					if($stmt->execute()){
						foreach ($input_pin as $pin){
							if ($stmt = $mysqli->prepare("INSERT INTO pins (mac_shield, pin_number, type, name, isused, out_mode, in_mode) values (?, ?, ?, ?, ?, ?, ?);")){
								$tipo="I";
								$nome="Pin".$pin;
								$usato="YES";
								$out_mode=null;
								$input_type="NL";
								$stmt->bind_param('sisssss', $mac, $pin, $tipo, $nome, $usato, $out_mode, $input_type);
								$stmt->execute();
							}
						}
						foreach ($output_pin as $pin){
							if ($stmt = $mysqli->prepare("INSERT INTO pins (mac_shield, pin_number, type, name, isused, out_mode, in_mode) values (?, ?, ?, ?, ?, ?, ?);")){
       					$tipo="O";
								$nome="Pin".$pin;
								$usato="YES";
								$out_mode="HL";
								$input_type=null;
								$stmt->bind_param('sisssss', $mac, $pin, $tipo, $nome, $usato, $out_mode, $input_type);
        				$stmt->execute();
							}
						}
						echo "<html><head></head><body><script>alert('Configurazione completata correttamente');location.assign('/index.php');</script></body></html>";
					}
					else{
						echo "<html><head></head><body><script>alert('Impossibile salvare la configurazione della scheda');location.assign('/formAddShield.php');</script></body></html>";
					}	
				}	
				else{
					echo "<html><head></head><body><script>alert('Impossibile salvare la configurazione della scheda.');location.assign('/formAddShield.php');</script></body></html>";
				}
      }
      else{
       	echo "<html><head></head><body><script>alert('Impossibile accedere ai pin della scheda. Configurazione annullata.');location.assign('/formAddShield.php');</script></body></html>";
      }
    }
    else{
			echo "<html><head></head><body><script>alert('Impossibile salvare la configurazione della scheda.');location.assign('/formAddShield.php');</script></body></html>";
    }    
  }
  else{
    echo "<html><head></head><body><script>alert('Scheda non supportata.');location.assign('/formAddShield.php');</script></body></html>";
  }

}
else{
	echo "<html><head></head><body><script>alert('Impossibile collegarsi alla scheda.');location.assign('/formAddShield.php');</script></body></html>";
}
?>
