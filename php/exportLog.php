<?php
	require_once('db.php');

if($_POST!=null){
	$db = new DB();
	if(isset($_POST["checkDBVersion"])){
		$data = file_get_contents("../data.xml");
		$xml = simplexml_load_string($data);
		if(($xml->currdbVersion-$xml->dbVersion)==0){
			echo "DB Version same";
		}else{
			echo "export";
		}
	}else if(isset($_POST["exportLog"])){
		$connection = mysqli_connect('localhost','root','root','igm');
		$tabs = array("customers_log", "vendors_log");
		$tables = array();
		$result = mysqli_query($connection,"SHOW TABLES");
		while($row = mysqli_fetch_row($result)){
			$tables[] = $row[0];
		}
		//print_r($tables);
		$return = '';
		foreach($tables as $table){
			if(in_array($table, $tabs)){
				$newTab = $table."_".time();
				$result = mysqli_query($connection,"create table ".$newTab."(select * from ".$table.")");
				$result = mysqli_query($connection,"select * from ".$newTab);
				$num_fields = mysqli_num_fields($result);
				//$return .= 'DROP TABLE '.$newTab.';';
				$row2 = mysqli_fetch_row(mysqli_query($connection,'SHOW CREATE TABLE  '.$newTab));
				$return .= "

				".$row2[1].";
				";
					for($i=0;$i<$num_fields;$i++){
						while($row = mysqli_fetch_row($result)){
							$return .= "INSERT INTO ".$newTab." VALUES(";
							for($j=0;$j<$num_fields;$j++){
								$row[$j] = addslashes($row[$j]);
								if(isset($row[$j])){ $return .='"'.$row[$j].'"';}else{ $return .= '""';}
								if($j<$num_fields-1){ $return .= ',';}
							}
							$return .= ");
				";
						}
					}
					$return .= "


				";			
				// echo $return;
				
				$result =  mysqli_query($connection,'DROP TABLE '.$newTab.';');
			}

		}
		$log = 'log_'.date('Y-m-d_H-i').'.sql';
		$file = '../log/'.$log;
		$handle = fopen('../log/'.$log,'w+');
		fwrite($handle,$return);
		fclose($handle);
		$feed = file_get_contents('../data.xml');
		$xml = simplexml_load_string($feed);
		$xml->exportlog = $log;
		$xml->asXML('../data.xml');

		$uploadRequest = array(
	        'fileName' => basename($log),
	        'fileData' => base64_encode(file_get_contents($file))
	    );

	    // Execute remote upload
	     $curl = curl_init();
	     curl_setopt($curl, CURLOPT_URL, 'http://localhost/igm-server/php/importClientData.php');
	     curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	     curl_setopt($curl, CURLOPT_POST, 1);
	     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	     curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
	     $response = curl_exec($curl);
	     curl_close($curl); 
	     unlink($file);
	     echo true;

		/*if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}*/
	}
	// $connection = $db->getConnection();
	
}else{
	echo "Err!!";
}
?>