<?php
	require("constants.php");	
	if($_POST!=null){
		$backup = new Backup();
		if(isset($_POST["import"])){
			$tmp = explode(".", $_FILES["importfile"]["name"]);
		    $extension = end($tmp);
		    //$connect = mysqli_connect("localhost", "root", "", "igm");
		    $allowed_extension = array("sql");
		    if(in_array($extension, $allowed_extension)){
		    	$file = $_FILES["importfile"]["tmp_name"];
		    	$backup->importDB($file);
		    	// if(){
		    	// 	echo ("<SCRIPT LANGUAGE='JavaScript'>
		     //        window.alert('Imported')
		     //        window.location.href='../pages/roles/admin/inventory.html';
		     //        </SCRIPT>");
		    	// }
		    }
			
		}else if(isset($_POST["export"])){
			$backup->exportDB();
		}else if(isset($_POST["lastBackup"])){
			$backup->getLastBackup();
		}else if(isset($_POST["checkRootPass"])){
			$backup->checkPass($_POST["password"]);
		}
	}else{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Unauthorised Access!!')
	    window.location.href='../index.html';
	    </SCRIPT>");		
	}
	/**
	* Export Class
	*/
	class Backup{
		
		function exportDB(){
			$connection = "";
			if($_COOKIE["status"]=="Online"){
				$connection = new mysqli(HOST, USER, PASSWORD, DB);
			}else{
				@$link = mysql_connect("localhost".':'."3306", "root", "root");
				@$link1 = mysql_connect("localhost".':'."3306", "root", "");
				if($link){
			    	$connection = mysqli_connect('localhost','root','root','igm');
				}else{
					$connection = mysqli_connect('localhost','root','','igm');
				}				
			}
			//$connection = mysqli_connect('localhost','root','root','igm');
			// $connection = mysqli_connect('localhost','metroadmindb',' @28ksh@y','igm');
			//get all tables
			$tables = array();
			$result = mysqli_query($connection,"SHOW TABLES");
			while($row = mysqli_fetch_row($result)){
				$tables[] = $row[0];
			}
			$return = '';
			foreach($tables as $table){
				$result = mysqli_query($connection,"select * from ".$table);
				$num_fields = mysqli_num_fields($result);
				//$return .= 'DROP TABLE '.$table.';';
				$row2 = mysqli_fetch_row(mysqli_query($connection,'SHOW CREATE TABLE  '.$table));
				$return .= "

			".$row2[1].";
			";
				for($i=0;$i<$num_fields;$i++){
					while($row = mysqli_fetch_row($result)){
						$return .= "INSERT INTO ".$table." VALUES(";
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
			}
			$file = '../backup/backup_'.date('Y-m-d_H-i').'.sql';
			$handle = fopen('../backup/backup_'.date('Y-m-d_H-i').'.sql','w+');
			fwrite($handle,$return);
			fclose($handle);
			$writeFile = fopen('../backup/backup.txt','w');
			fwrite($writeFile, date('Y-m-d_H-i-s'));
			fclose($writeFile);
			//echo 'Successfully backed up';

			if (file_exists($file)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.basename($file).'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    readfile($file);
			    exit;
			}
		}

		function importDB($file){

			$connection ="";
			@$link = mysql_connect("localhost".':'."3306", "root", "root");
			@$link1 = mysql_connect("localhost".':'."3306", "root", "");
			if($link){
		    	$connection = mysqli_connect('localhost','root','root','igm');
			}else{
				$connection = mysqli_connect('localhost','root','','igm');
			}
			//$connection = mysqli_connect('localhost','root','root','igm');
			// $connection = mysqli_connect('localhost','metroadmindb',' @28ksh@y','igm');
			$filename = "../backup/backup_2017_09_10_17_18_50.sql";
			$handle = fopen($file,'r+');
			$contents = fread($handle,filesize($file));

			$sql = explode(';',$contents);
			foreach($sql as $query){
				$result = mysqli_query($connection,$query);
				if($result){
					echo '<tr><tr><br></td></tr>';
					echo '<tr><td>'.$query.'<b>SUCCESS</b></td></tr>';
					echo '<tr><tr><br></td></tr>';
				}
			}
			fclose($handle);
			echo "Successfully imported";
			exit;
		}

		function getLastBackup(){
			$filename = "../backup/backup.txt";
			$writeFile = fopen($filename,'r');
			$fcontent= fread($writeFile, filesize($filename));
			fclose($writeFile);
			echo $fcontent;
		}

		function checkPass($password){
			$file = "../backup/imp.txt";
			$handle = fopen($file,'r');
			$pass =  fread($handle, filesize($file));
			//$pass = "$2y$10$/HeVTBmiTh9EGYgoIB9HAezHPOAxEIF/orXBEOsauI8GsA9aVPQBu";
			if(password_verify($password, $pass)){
				echo "true";
			}else{
				echo "false";
			}
		}	
	}
?>