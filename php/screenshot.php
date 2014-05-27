<?php 
$ch = curl_init() or die(curl_error()); 
curl_setopt($ch, CURLOPT_URL,"http://stackoverflow.com/questions/1077970/in-any-languages-can-i-capture-a-webpageno-install-no-activex-if-i-can-plz"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$data1=curl_exec($ch) or die(curl_error()); 
echo "<font color=black face=verdana size=3>".$data1."</font>"; 
echo curl_error($ch); 
curl_close($ch); 
?>