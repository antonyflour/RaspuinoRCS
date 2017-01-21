<?php

function event_log($message){
    $filename = "log.txt";
    $filesize = filesize($filename);    
    if($filesize > 20000){
        $filelog = fopen($filename, "w"); 
        fwrite($filelog,"");
        fclose($filelog);
    }
    $date = date('[d/m/Y H:i:s]', time());
    error_log($date." ".$message."\n",3,$filename);
}
?>

