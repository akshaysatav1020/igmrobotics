<?php 
require("constants.php");	
ini_set('max_execution_time', 300);
$connection = "";
	if($_COOKIE["status"]=="Online"){
		$connection = new mysqli("148.72.214.115", "admin_igm", "admin_igm#123", "igm_test");
	}else{
		@$link = mysql_connect("localhost".':'."3306", "root", "root");
		@$link1 = mysql_connect("localhost".':'."3306", "root", "");
		if($link){
	    	$connection = mysqli_connect('localhost','root','root','igm');
		}else{
			$connection = mysqli_connect('localhost','root','','igm');
		}				
	}
	
	$tables = array();
	$result = mysqli_query($connection,"SHOW TABLES");
	while($row = mysqli_fetch_row($result)){
		$tables[] = $row[0];
	}
	$return = '';
	foreach($tables as $table){		
		if($table!="inventory_parts_copy" && $table!="inventory_parts_copy_1_1" && $table!="inventory_parts_new_data"
			&& $table!="inventory_parts_old" && $table!="purchaseorder_old" && $table!="service_n" && $table!="service_old"
			&& $table!="service_spare_parts_n"){
			//$return.="select * from ".$table.";</br/>";
			$result = mysqli_query($connection,"select * from ".$table);
			$num_fields = mysqli_num_fields($result);
			//$return .= 'DROP TABLE '.$table.';';
			$row2 = mysqli_fetch_row(mysqli_query($connection,'SHOW CREATE TABLE  '.$table));
			$return .= "
			".$row2[1].";";
			for($i=0;$i<$num_fields;$i++){
				while($row = mysqli_fetch_row($result)){
					$return .= "INSERT INTO ".$table." VALUES(";
					for($j=0;$j<$num_fields;$j++){
						$row[$j] = addslashes($row[$j]);
						if(isset($row[$j])){ $return .='"'.$row[$j].'"';}else{ $return .= '""';}
						if($j<$num_fields-1){ $return .= ',';}
					}
					$return .= ");<br/>
					";
		
				}
			}
			$return .= "
			";
		}
	}
	echo $return;
	/*$connection ="";
	@$link = mysql_connect("localhost".':'."3306", "root", "root");
	@$link1 = mysql_connect("localhost".':'."3306", "root", "");
	if($link){
    	$connection = mysqli_connect('localhost','root','root','igm');
	}else{
		$connection = mysqli_connect('localhost','root','','igm');
	}
	$result = $connection->query("DROP DATABASE IF EXISTS igm;");  */       
    /*$result = $connection->query("CREATE DATABASE igm;");
    $result = $connection->query("USE igm;");
    $connection->query("FLUSH PRIVILEGES;");
	$sql = explode(';',$return);
	foreach($sql as $query){
		$result = mysqli_query($connection,$query);
		if($result){
			echo '<tr><tr><br></td></tr>';
			echo '<tr><td>'.$query.'<b>SUCCESS</b></td></tr>';
			echo '<tr><tr><br></td></tr>';
		}
	}*/

?>