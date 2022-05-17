<?php
	ini_set('max_execution_time', 300);
	require_once("db.php");
	require_once("constants.php");	
	class SyncServerData{
		
		function __construct(){
			
		}
		function readServerFile(){
			$success = false;
			$curl = curl_init();
			$uploadRequest = array(
				'dbversion' => 0,
		        'updateVersion' => 'updateVersion'
		    );
		    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/php/updateDBVersion.php');
			curl_setopt($curl, CURLOPT_URL, SERVERDATADB);			
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
		    $response = curl_exec($curl);
		    curl_close($curl);
			//echo $response; 
			echo $response;		    
		    if($response == "Updated"){
				
		    	$success = false;
				$curl = curl_init();
			    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/pushClient/igm.sql');				
				curl_setopt($curl, CURLOPT_URL, SERVERSQL);
			    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			    curl_setopt($curl, CURLOPT_POST, 1);
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			    $response = curl_exec($curl);
			    curl_close($curl);			    
			    //$connection = mysqli_connect('localhost','root','root','igm');
				
			    $sql = explode(';',$response);
			    $result = false;
			    //$result = mysqli_query($connection,"DROP DATABASE IF EXISTS igm;");
				$conn = mysqli_connect("localhost", "root", "root");
			    $result = $conn->query("DROP DATABASE IF EXISTS igm;");			    
			    $result = $conn->query("CREATE DATABASE igm;");
			    $result = $conn->query("USE igm;");
				$conn->query("CREATE USER 'metroadmin'@'localhost' IDENTIFIED BY 'metroadmin';");
				$conn->query("GRANT ALL PRIVILEGES ON igm . * TO 'metroadmin'@'localhost';");
				$conn->query("FLUSH PRIVILEGES;");	
				$connection ="";
				@$link = mysql_connect("localhost".':'."3306", "root", "root");
				@$link1 = mysql_connect("localhost".':'."3306", "root", "");
				if($link){
			    	$connection = mysqli_connect('localhost','root','root','igm');
				}else{
					$connection = mysqli_connect('localhost','root','','igm');
				}			
			    foreach($sql as $query){
					//echo $query.";";
					$result = mysqli_query($connection,$query.";");
					if($result){
						$success = true;				
					}else{
						$success = false;
					}
				}

				$curl = curl_init();
			    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/data.xml');
				curl_setopt($curl, CURLOPT_URL, SERVERDATAXMLLINK);				
			    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			    curl_setopt($curl, CURLOPT_POST, 1);
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			    $response = curl_exec($curl);		    
			    curl_close($curl);
			    $xml = simplexml_load_string($response);
			    $feed = file_get_contents('../data.xml');
			    //echo $response;
			    $xml1 = simplexml_load_string($feed);
			    $xml1->serverDB =  $xml->dbversion;
			    $xml->asXML('../data.xml');
				return $success;
		    }else{
		    	return false;
		    }
			
				
		}
		function checkDBVersion(){
			$success = false;
			$curl = curl_init();
		    //curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/data.xml');
			curl_setopt($curl, CURLOPT_URL, "http://igmrobotics.com/data.xml");
			//curl_setopt($curl, CURLOPT_URL, SERVERDATAXMLLINK);
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    $response = curl_exec($curl);		    
		    curl_close($curl);
		    $xml = simplexml_load_string($response);
		    $feed = file_get_contents('../data.xml');
			//echo $feed;
		    $xml1 = simplexml_load_string($feed);
		    // echo "Akshay";
		    if(($xml->dbversion - $xml1->dbversion)!=0){
				$diff = $xml->dbversion - $xml1->dbversion;					
		    	$success = true;
		    }else{
		    	$success = false;
		    }		    
			return $success;		
		}	
	}
    if($_POST!=null){
    	$db = new DB();
    	$connection = $db->getConnection();
    	$syncData = new SyncServerData();
    	if(isset($_POST["updateDB"])){
			
			if($syncData->checkDBVersion()){
				$syncData->readServerFile();
				echo "Data Synced";
				
			}else{
				echo "Data Already Synced";
			}
		}
	}
    
?>