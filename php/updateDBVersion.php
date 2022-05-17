<?php
	/**
	* 
	*/
	class UpdateDBVersion{
		
		function __construct(){						
		}
		function updateDBVersion(){
			$data = file_get_contents("../data.xml");
			$xml = simplexml_load_string($data);
			$xml->dbVersion=$xml->currdbVersion;
			$xml->currdbVersion = $xml->currdbVersion+1;
			$xml->asXML('../data.xml');
			return true;
		}
	}	
?>