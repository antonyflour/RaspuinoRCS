<?php
include_once 'functionCheckLogin.php';
 
$admin_code = login_check($mysqli);
if ($admin_code >=0) {
	$ip = $_REQUEST['ip'];
	$port=$_REQUEST['port']; 
	$pin = $_REQUEST['pin'];
	$stato = $_REQUEST['stato'];
	if($stato==2){
		$url = 'http://'.$ip.':'.$port.'/toggle/PIN'.$pin;
	}
	else{
		$url = 'http://'.$ip.':'.$port.'/setout.php?PIN'.$pin.'='.$stato;
	}
	$curl = curl_init();
		curl_setopt_array($curl, array(
    		CURLOPT_RETURNTRANSFER => 1,
    		CURLOPT_URL => $url,
   		CURLOPT_USERAGENT => 'Raspberry'));
		$resp = curl_exec($curl);
		$curl_info = curl_getinfo($curl);
		curl_close($curl);
	if($curl_info['http_code']==200){
		http_response_code(200);
	}
	else{
		http_response_code(405);
	}
}else{
	http_response_code(405);
}

?>
