<?php 

	class UpdateServerDBVersion{
		
		function __construct(){
			
		}

		function updateDBVersion(){
			$success = false;
			$curl = curl_init();
		    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/data.xml');
		    //curl_setopt($curl, CURLOPT_URL, 'http://114.143.189.106/igm-server/data.xml');
		    curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/data.xml');
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    $response = curl_exec($curl);		    
		    curl_close($curl);
		    $xml = simplexml_load_string($response);
		    /*Send Request To server Update Version*/
		    $uploadRequest = array(
	        	'dbversion' => $xml->dbversion+1,
		        'updateVersion' => 'updateVersion'
		    );
		    $curl = curl_init();
		    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/php/updateDBVersion.php');
		    //curl_setopt($curl, CURLOPT_URL, 'http://114.143.189.106/igm-server/php/updateDBVersion.php');
		    curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/updateDBVersion.php');
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
		    $response = curl_exec($curl);
		    curl_close($curl); 		    
		    if($response == "Updated"){
		    	return true;
		    }else{
		    	return false;
		    }
					
		}
	}
?>