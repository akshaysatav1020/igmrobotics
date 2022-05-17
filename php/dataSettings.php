<?php
	//require_once("constants.php"); 
	require_once("db.php"); 
	if($_POST!=null){
		$db = new DB();
		/*$feed = file_get_contents('../config.xml');
		$xml = simplexml_load_string($feed);
		$xml = simplexml_load_file('../config.xml');*/
		if(isset($_POST['getRate'])){
		    $rate=0;
			$q = "SELECT * FROM euro_rate where id=1";
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rate=$row["rate"];		          
		    	}
		    }        
			echo $rate;
		}else if(isset($_POST['getWareHouseInfo'])){			
			$q = "SELECT * FROM warehouse where id=1";
		    $rack=0;
	        $floor=0;
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rack=$row["rack"];
		          $floor=$row["floor"];
		    	}
		    }        
			echo $rack."-".$floor;
		}else if(isset($_POST['updaterate'])){
			//$xml->eurorate = $_POST['eurorate'];
			//$xml->asXML('../config.xml');
			$q = "UPDATE euro_rate SET rate=? where id=1";
	        $stmt = $db->getConnection()->prepare($q);
	        $stmt->bind_param("d",$rate);      		      		
			$rate=$_POST['eurorate'];
		    if($stmt->execute()){		       
				echo "Updated";
		    }else{
		    	echo "Error updating rate!!";
		    }
		}else if(isset($_POST['updatewarehouse'])){
			/*$xml->rack = $_POST['rack'];
			$xml->floor = $_POST['floor'];
			$xml->asXML('../config.xml');
			echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Warehouse updated')
            window.location.href='http://localhost/igm/pages/roles/admin/backup.php';
            </SCRIPT>");*/
            $q = "UPDATE warehouse SET rack=?, floor=? where id=1";
	        $stmt = $db->getConnection()->prepare($q);
	        $stmt->bind_param("ii",$rack,$floor);      		      		
			$rack = $_POST['rack'];
			$floor = $_POST['floor'];
		    if($stmt->execute()){		       
				echo "Updated";
		    }else{
		    	echo "Error updating warehouse!!";
		    }
		}else if(isset($_POST['resetsysadmin'])){
			//$xml->password = $_POST['password'];
			$curl = curl_init();
	      	$uploadRequest = array('sysPassword' => $_POST['password'],
	      		'updatePassword' => 'updatePassword');
	      	curl_setopt($curl, CURLOPT_URL, "http://www.igmrobotics.com/php/config.php");      
	      	curl_setopt($curl, CURLOPT_TIMEOUT, 3);
	      	curl_setopt($curl, CURLOPT_POST, 1);
	      	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	      	curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
	      	$response = curl_exec($curl);
	      	echo $response;
	      	curl_close($curl);
			/*$xml->asXML('../config.xml');
			echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Password Changed')
            window.location.href='http://localhost/igm/pages/roles/admin/backup.php';
            </SCRIPT>");*/
		}else if(isset($_POST["checkRootPass"])){
			$xml = simplexml_load_file('../config.xml');
			$updated="outdated";
			$ch = curl_init();        
	      	curl_setopt($ch, CURLOPT_URL, SERVERDATAXMLLINK);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    if(curl_exec($ch) === FALSE) {
		    	echo "Error: " . curl_error($ch);
	      	}else {              
		    	//echo curl_exec($ch);
		        $remotexml = simplexml_load_string(curl_exec($ch));		        
		        $updated=(intval($remotexml->appversion)!=intval($xml->appversion))?"outdated":"updated";        
		      }
			if($_POST["password"]==$xml->password && $updated=="updated"){
				echo "true";
			}else{
				echo "false";
			}
		}else if(isset($_POST['getAllData'])){
			//Getting Euro Rate Details
			$rate=0;
			$q = "SELECT * FROM euro_rate where id=1";
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rate=$row["rate"];		          
		    	}
		    }   
		    //Getting Warehouse Details
		    $rack=0;
			$q = "SELECT * FROM warehouse where id=1";
	        $floor=0;
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rack=$row["rack"];
		          $floor=$row["floor"];
		    	}
		    }        
			setcookie('eurorate',$rate,time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
		    setcookie('rack',$rack,time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
		    setcookie('floor',$floor,time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
		    
		}else if(isset($_POST["getAllDetails"])){
			//Getting Euro Rate Details
			$rate=0;
			$q = "SELECT * FROM euro_rate where id=1";
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rate=$row["rate"];		          
		    	}
		    }   
		    //Getting Warehouse Details
		    $rack=0;
	        $floor=0;
			$q = "SELECT * FROM warehouse where id=1";
	        $stmt = $db->getConnection()->prepare($q);      
      		$stmt->execute();
      		$result = $stmt->get_result();
		    if($result->num_rows>0){
		       while($row=$result->fetch_assoc()){
		          $rack=$row["rack"];
		          $floor=$row["floor"];
		    	}
		    }		    
			echo json_encode(array('rate'=>$rate,'rack'=>$rack,'floor'=>$floor));
		    
		}
	}else{
		
	}

 ?>