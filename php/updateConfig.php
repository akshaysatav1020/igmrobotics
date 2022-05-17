<?php 
	require_once("constants.php");	
	if($_POST!=null){
		if(isset($_POST["updateConfig"])){
			$ch = curl_init();        
	        curl_setopt($ch, CURLOPT_URL, SERVERDATAXMLLINK);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        if(curl_exec($ch) === FALSE) {
	             echo "Error: " . curl_error($ch);
	        } else {              
	            //echo curl_exec($ch);
             	$xml = simplexml_load_string(curl_exec($ch));
			    $xml->asXML('../config.xml');
			    touch('../config.xml');
			    chmod('../config.xml', 0777);
			    echo "Updated";
	        }	        
		}
	}

?>