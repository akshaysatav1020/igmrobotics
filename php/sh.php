<?php

 
require('db.php');
require('invoicetemplate.php');
require('data/serviceObject.php');
require('data/machineObject.php');
require('data/servicePartObject.php');
require('data/servicePhotoObject.php');
require_once "updateServerDBVersion.php";


if($_POST!=null){
	$db = new DB();
	$service = new Service();
	if(isset($_POST["addService"])){
		if($_FILES['photos']['name'][0]!=""){			
			$servicePhotos = new ArrayObject();
			if($_FILES['photos']['name'][0]!=""){		
				foreach($_FILES["photos"]["name"] as $file){
					$url = "errorImages/".$file;
					$servicePhotos[] = new ServicePhoto(0,$url);
				}
			}
			$serviceObject = new ServiceObject($_POST["machine"],explode("-", $_POST["customer"])[0],
				$_POST["engineer"],$_POST["costType"],$_POST["serviceDate"],
				$_POST["reportDate"],$_POST["closedDate"],$_POST["status"],
				$_POST["workingHrs"],$_POST["repetitive"],$_POST["downHour"],
				$servicePhotos,$_POST["errorCode"],$_POST["errorDescription"],$_POST["action"],
				$_POST["rootCause"],$_POST["remarks"],$_POST["spareParts"]);

			if($service->uploadServicePhoto($_FILES)){
				if($service->addService($db->getConnection(), $serviceObject)){					
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		                window.alert('Service Added!!!')
		                window.location.href='../pages/sh.php';
		                  </SCRIPT>");      
		        }else{		        	
		            echo ("<SCRIPT LANGUAGE='JavaScript'>
	                	window.alert('Error Adding Service!!!')
		                window.location.href='../pages/sh.php';
	                  	</SCRIPT>");
		        }
			}
		}else{			
			$serviceObject = new ServiceObject($_POST["machine"],$_POST["customer"],
				$_POST["engineer"],$_POST["costType"],$_POST["serviceDate"],
				$_POST["reportDate"],$_POST["closedDate"],$_POST["status"],
				$_POST["workingHrs"],$_POST["repetitive"],$_POST["downHour"],
				$_POST["errorCode"],$_POST["errorDescription"],$_POST["action"],
				$_POST["rootCause"],$_POST["remarks"],$_POST["spareParts"]);

			if($service->addService($db->getConnection(), $serviceObject)){				
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	                  window.alert('Service Added!!!')
	                  window.location.href='../pages/sh.php';
	                  </SCRIPT>");      
	        }else{	        	
	            echo ("<SCRIPT LANGUAGE='JavaScript'>
	                window.alert('Error Adding Service!!!')
	                window.location.href='../pages/sh.php';
	                </SCRIPT>");
	        }
		}
	}else if(isset($_POST["updateService"])){
		//echo "<pre>";var_dump($_POST);echo "</pre>";
		$serviceObject = new ServiceObject($_POST["id"],$_POST["machine"],$_POST["customer"],
				$_POST["engineer"],$_POST["costType"],$_POST["serviceDate"],
				$_POST["reportDate"],$_POST["closedDate"],$_POST["status"],
				$_POST["workingHrs"],$_POST["repetitive"],$_POST["downHour"],
				$_POST["errorCode"],$_POST["errorDescription"],$_POST["action"],
				$_POST["rootCause"],$_POST["remarks"],$_POST["spareParts"]);
		if($service->updateService($db->getConnection(), $serviceObject)){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
              	window.alert('Service Updated!!!')
              	window.location.href='../pages/editSh.php?id=$_POST[id]';
              	</SCRIPT>");
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
              	window.alert('Error Updating Service!!!')
              	window.location.href='../pages/editSh.php?id=$_POST[id]';
              	</SCRIPT>");
        }
	}else if(isset($_POST["deleteService"])){
		if($service->deleteService($db->getConnection(), $_POST["serviceId"])){
            echo "Deleted";            
        }else{
            echo 'Error Deleting';
        }
	}else if(isset($_POST["getService"])){
		$service->getService($db->getConnection(), $_POST["serviceId"]);
	}else if(isset($_POST["getAllServices"])){
		$service->getAllServices($db->getConnection());
	}else if(isset($_POST["getServicePhotos"])){
		$service->getServicePhotos($db->getConnection(), $_POST["serviceId"]);
	}else if(isset($_POST["importService"])){
		if($service->importService($db->getConnection(),  $_FILES["serviceexcel"]["tmp_name"])){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Service History Imported');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Error Importing Service!!!');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}
	}else if(isset($_POST["getServicesByParam"])){
		$service->getServicesByParam($db->getConnection(),$_POST["customer"],$_POST["errorCode"]);
	}else if(isset($_POST["uploadPhotos"])){
		//var_dump($_FILES);
		$service->uploadServicePhoto($_FILES);
	}else if(isset($_POST["addServiceP"])){
		$service->addServiceP($db->getConnection(),$_POST["id"],$_POST["url"]);
	}else if(isset($_POST["addServicePhotos"])){
		$service->addServicePhotos($db->getConnection(),$_POST, $_FILES);
	}else if(isset($_POST["updateServicePhotos"])){
		$service->updateServicePhotos($db->getConnection(),$_POST, $_FILES);
	}else if(isset($_POST["removeServicePhotos"])){
		$service->removeServicePhotos($db->getConnection(),$_POST);
	}else if(isset($_POST["exportService"])){
		include("../phplibraries/phpexcel/PHPExcel.php");
		$phpExcel = new PHPExcel;
		// Setting font to Arial Black
		$phpExcel->getDefaultStyle()->getFont()->setName('Arial Black');
		// Setting font size to 14
		$phpExcel->getDefaultStyle()->getFont()->setSize(11);
		//Setting description, creator and title
		$phpExcel ->getProperties()->setTitle("Service list");
		$phpExcel ->getProperties()->setCreator("IGM");
		$phpExcel ->getProperties()->setDescription("Excel SpreadSheet in PHP");
		// Creating PHPExcel spreadsheet writer object
		// We will create xlsx file (Excel 2007 and above)
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
		// When creating the writer object, the first sheet is also created
		// We will get the already created sheet
		$sheet = $phpExcel ->getActiveSheet();
		// Setting title of the sheet
		$sheet->setTitle('Services');
		// Creating spreadsheet header
		$sheet ->getCell('A1')->setValue('Machine Name');
		$sheet ->getCell('B1')->setValue('Customer');
		$sheet ->getCell('C1')->setValue('Service Date');
		$sheet ->getCell('D1')->setValue('Date of report');
		$sheet ->getCell('E1')->setValue('Closed Date');
		$sheet ->getCell('F1')->setValue('Working Hours');
		$sheet ->getCell('G1')->setValue('Engineer');
		$sheet ->getCell('H1')->setValue('Repetitive');
		$sheet ->getCell('I1')->setValue('Down hours');
		$sheet ->getCell('J1')->setValue('Cost');
		$sheet ->getCell('K1')->setValue('Error code');
		$sheet ->getCell('L1')->setValue('Error Description');
		$sheet ->getCell('M1')->setValue('Action Taken');
		$sheet ->getCell('N1')->setValue('Root cause');
		$sheet ->getCell('O1')->setValue('Status');
		$sheet ->getCell('P1')->setValue('Remarks');
		$sheet ->getCell('Q1')->setValue('Spare parts replace');
		// Making headers text bold and larger
		$sheet->getStyle('A1:Q1')->getFont()->setSize(11);
		// Insert product data	
		
		/*$db = new DB();
		$connection = $db->getConnection();
		$service = new Service();*/
		$query = "SELECT * FROM service";
		$result = $db->getConnection()->query($query);
		$i=2;
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$machine = $service->getMachineNameById($db->getConnection(),$row["machine"]);
				$cust = $service->getCustomerNameById($db->getConnection(),$row["customer"]);
				$engineer = $service->getEngineerNameById($db->getConnection(),$row["engineer"]);
				$errorCode=$service->getErrorCodeById($db->getConnection(),$row["error_code"]);
				$sheet ->getCell('A'.$i)->setValue($machine);
				$sheet ->getCell('B'.$i)->setValue($cust);
				$sheet ->getCell('C'.$i)->setValue($row["service_date"]);
				$sheet ->getCell('D'.$i)->setValue($row["reported_date"]);
				$sheet ->getCell('E'.$i)->setValue($row["closed_date"]);
				$sheet ->getCell('F'.$i)->setValue($row["working_hrs"]);
				$sheet ->getCell('G'.$i)->setValue($engineer);
				$sheet ->getCell('H'.$i)->setValue($row["repetitive"]);
				$sheet ->getCell('I'.$i)->setValue($row["down_hrs"]);
				$sheet ->getCell('J'.$i)->setValue($row["cost_type"]);
				$sheet ->getCell('K'.$i)->setValue($errorCode);
				$sheet ->getCell('L'.$i)->setValue($row["error_description"]);
				$sheet ->getCell('M'.$i)->setValue($row["action"]);
				$sheet ->getCell('N'.$i)->setValue($row["root_cause"]);
				$sheet ->getCell('O'.$i)->setValue($row["status"]);
				$sheet ->getCell('P'.$i)->setValue($row["remarks"]);
				$sheet ->getCell('Q'.$i)->setValue($row["spare_part_replace"]);
				$sheet->getStyle('A'.$i.':Q'.$i)->getFont()->setSize(11);
				$i+=1;
			}
		}	
		// Insert product data
		// Autosize the columns
		$sheet ->getColumnDimension('A')->setAutoSize(true);
		$sheet ->getColumnDimension('B')->setAutoSize(true);
		$sheet ->getColumnDimension('C')->setAutoSize(true);
		$sheet ->getColumnDimension('D')->setAutoSize(true);
		$sheet ->getColumnDimension('E')->setAutoSize(true);
		$sheet ->getColumnDimension('F')->setAutoSize(true);
		$sheet ->getColumnDimension('G')->setAutoSize(true);
		$sheet ->getColumnDimension('H')->setAutoSize(true);
		$sheet ->getColumnDimension('I')->setAutoSize(true);
		$sheet ->getColumnDimension('J')->setAutoSize(true);
		$sheet ->getColumnDimension('K')->setAutoSize(true);
		$sheet ->getColumnDimension('L')->setAutoSize(true);
		$sheet ->getColumnDimension('M')->setAutoSize(true);
		$sheet ->getColumnDimension('N')->setAutoSize(true);
		$sheet ->getColumnDimension('O')->setAutoSize(true);
		$sheet ->getColumnDimension('P')->setAutoSize(true);
		$sheet ->getColumnDimension('Q')->setAutoSize(true);
		// Save the spreadsheet
		$deskPath ="";
		if(get_current_user()=="SYSTEM"){
			$deskPath = "../";
		}else{
			$deskPath = sprintf("C:\users\%s\Desktop\\", get_current_user());
		}				
		$writer->save($deskPath.'services.xlsx');
		$file = $deskPath.'services.xlsx';
		if (file_exists($file)) {
		   	header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$deskPath.'services.xlsx"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');
			$service->SaveViaTempFile($writer);
		    exit;
		}
	}
}else{
	
}
class Service{

	function SaveViaTempFile($objWriter){
	    $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
	    $objWriter->save($filePath);
	    readfile($filePath);
	    unlink($filePath);
	}


	function addService($connection, $serviceObject){
		$success = false;
		//var_dump($serviceObject);
		$query = <<<EOD
		   	INSERT INTO service
		   	(machine, customer, engineer, cost_type, service_date, reported_date, closed_date,
		   	status, working_hrs, repetitive, down_hrs, error_code, error_description, action,
		   	root_cause, remarks, spare_part_replace, created_by, created_on, modified_by,
		   	modified_on)
		   	VALUES 
		   	(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()))
EOD;
	    $stmt = $connection->prepare($query);
	    $stmt->bind_param("iiisssssisissssssss", $machine,$customer,$engineer,$costType,
	    	$serviceDate,$reportDate,$closedDate,$status,$workingHrs,$repetitive,$downHrs,
	    	$errorCode,$errorDescription,$action,$rootCause,$remarks,$getSparePartReplaced,
	    	$cb,$mb);
    	$machine=$serviceObject->getMachine();
    	$customer=$serviceObject->getCustomer();
    	$engineer=$serviceObject->getEngineer();
    	$costType=$serviceObject->getCostType();
    	$serviceDate=$serviceObject->getServiceDate();
    	$reportDate=$serviceObject->getReportedDate();
    	$closedDate=$serviceObject->getClosedDate();
    	$status=$serviceObject->getStatus();
    	$workingHrs=$serviceObject->getWorkingHrs();
    	$repetitive=$serviceObject->getRepetitive();
    	$downHrs=$serviceObject->getDownHrs();
    	$errorCode=$serviceObject->getErrorCode();
    	$errorDescription=$serviceObject->getErrorDescription();
    	$action=$serviceObject->getAction();
    	$rootCause=$serviceObject->getRootCause();
    	$remarks=$serviceObject->getRemarks();
    	$getSparePartReplaced=$serviceObject->getSparePartReplace();
		$cb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
		$mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";		
		if($stmt->execute()){
			$query = "select service_id as id from service ORDER BY service_id desc LIMIT 1";
			$serviceId = 0;
			$result = $connection->query($query);
			if($result->num_rows>0){
				while ($row=$result->fetch_assoc()) {
					$serviceId = $row["id"];	
				}
			}
			
		 	$success = true;		 		 
		 	if(sizeof($serviceObject->getPhotos())!=0){
		 		foreach ($serviceObject->getPhotos() as $servicePhoto) {
			 		$servicePhoto->setService($serviceId);
			 		if(self::addServicePhoto($connection, $servicePhoto)){
						$success = true;
					}
		 		}
		 	}
		}else{
			echo $stmt->error;
		}
		return $success;
		
	}
	function updateService($connection, $serviceObject){
		//var_dump($serviceObject);
		$success = false;		
		$query = <<<EOD
		   	UPDATE service
		    SET 
		    machine=?,customer=?,engineer=?,cost_type=?,service_date=?,reported_date=?,
		    closed_date=?,status=?,working_hrs=?,repetitive=?,down_hrs=?,error_code=?,
		    error_description=?,action=?,root_cause=?,remarks=?,spare_part_replace=?,
		    modified_by=?,modified_on=(SELECT NOW())
		   	WHERE service_id=?
EOD;
	    $stmt = $connection->prepare($query);
	    $stmt->bind_param("iiisssssisisssssssi", $machine,$customer,$engineer,$costType,
	    	$serviceDate,$reportDate,$closedDate,$status,$workingHrs,$repetitive,$downHrs,
	    	$errorCode,$errorDescription,$action,$rootCause,$remarks,$getSparePartReplaced,
	    	$mb, $serviceId);
	    $machine=$serviceObject->getMachine();
    	$customer=$serviceObject->getCustomer();
    	$engineer=$serviceObject->getEngineer();
    	$costType=$serviceObject->getCostType();
    	$serviceDate=$serviceObject->getServiceDate();
    	$reportDate=$serviceObject->getReportedDate();
    	$closedDate=$serviceObject->getClosedDate();
    	$status=$serviceObject->getStatus();
    	$workingHrs=$serviceObject->getWorkingHrs();
    	$repetitive=$serviceObject->getRepetitive();
    	$downHrs=$serviceObject->getDownHrs();
    	$errorCode=$serviceObject->getErrorCode();
    	$errorDescription=$serviceObject->getErrorDescription();
    	$action=$serviceObject->getAction();
    	$rootCause=$serviceObject->getRootCause();
    	$remarks=$serviceObject->getRemarks();
    	$getSparePartReplaced=$serviceObject->getSparePartReplace();
		$mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
		$serviceId =$serviceObject->getServiceId();
		//$serviceObject->getPhotos()
		if($stmt->execute()){
			$success = true;
		}else{
			$stmt->error;
		}
		return $success;
	}

	function deleteService($connection, $serviceId){
		$success = false;
		$query = <<<EOF
		DELETE FROM service WHERE service_id=?
EOF;
		$stmt = $connection->prepare($query);
		$stmt->bind_param("i",$serviceId);
		$serviceId = $serviceId;
		if($stmt->execute()){
			$success = true;
		}
		return $success;
	}

	function getService($connection, $serviceId){
		$data = array();
		$query = <<<EOF
		SELECT * FROM service WHERE service_id=$serviceId
EOF;
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){				
				$data = $row;

			}
		}
		echo json_encode($data);
	}

	
	
	function getServicePhotos($connection, $id){
		$data = array();
		$query = <<<EOF
		SELECT * FROM service_photo WHERE service=$id
EOF;
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){				
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}

	
	function getAllServices($connection){
		$data = array();
		$query = <<<EOF
		SELECT * FROM service
EOF;
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}

	function getServicesByParam($connection,$customer,$errorCode){
		//echo $customer."  ".$errorCode;
		$data = array();
		$w="";
		if($customer && $errorCode){
			$w="WHERE s.customer=$customer AND s.error_code='$errorCode'";
		}
		//$query = "SELECT * FROM service $w";
		$query = "SELECT s.*,m.machine_no,m.machine_name,c.company_name,c.city,u.name as eng_name FROM service s LEFT JOIN machine m on s.machine=m.machine_id LEFT JOIN customers c on s.customer=c.id LEFT JOIN user u on u.id=s.engineer $w";
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data[] = array('service_id' => $row["service_id"],
					'machineNo' => $row["machine_no"],
					'machineName' => iconv(mb_detect_encoding($row['machine_name'], mb_detect_order(), true), "UTF-8//IGNORE", $row['machine_name']),
					'customer' => iconv(mb_detect_encoding($row['company_name']."-".$row['city'], mb_detect_order(), true), "UTF-8//IGNORE", $row['company_name']."-".$row['city']),
					'engineer' => iconv(mb_detect_encoding($row['eng_name'], mb_detect_order(), true), "UTF-8//IGNORE", $row['eng_name']),
					'cost' => $row["cost_type"],
					'service_date' => $row["service_date"],
					'reported_date' => $row["reported_date"],
					'closed_date' => $row["closed_date"],
					'status' => $row["status"],
					'working_hrs' => $row["working_hrs"],
					'repetitive' => $row["repetitive"],
					'down_hrs' => $row["down_hrs"],
					//'error_code' => self::getErrorCodeById($connection,$row["error_code"]),
					'error_code' => iconv(mb_detect_encoding($row['error_code'], mb_detect_order(), true), "UTF-8//IGNORE", $row['error_code']),
					'error_description' => iconv(mb_detect_encoding($row['error_description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['error_description']),
					'action' => iconv(mb_detect_encoding($row['action'], mb_detect_order(), true), "UTF-8//IGNORE", $row['action']),
					'root_cause' => iconv(mb_detect_encoding($row['root_cause'], mb_detect_order(), true), "UTF-8//IGNORE", $row['root_cause']),
					'remarks' => iconv(mb_detect_encoding($row['remarks'], mb_detect_order(), true), "UTF-8//IGNORE", $row['remarks']),
					'spare_part_replace' => iconv(mb_detect_encoding($row['spare_part_replace'], mb_detect_order(), true), "UTF-8//IGNORE", $row['spare_part_replace']));
			}
		}
		echo json_encode($data);
	}

	function getErrorCodeById($connection,$id){
		$query="SELECT * FROM error WHERE error_id=".$id;
        $result = $connection->query($query);
        $data = "";
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){          
            $data = $row['error_code'];
          }
        }      
        return $data;
	}

	function getMachineNoById($connection,$id){
		$data = "";
		$query = "SELECT machine_no FROM machine WHERE machine_id=".$id."";
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data=$row["machine_no"];
			}
		}
		return $data;
	}

	function getMachineNameById($connection,$id){
		$data = "";
		$query = "SELECT machine_name FROM machine WHERE machine_id=".$id."";
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data=$row["machine_name"];
			}
		}
		return $data;
	}

	function getCustomerNameById($connection,$id){
		$data = "";
		$query = "SELECT company_name FROM customers WHERE id=".$id."";
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data=$row["company_name"];
			}
		}
		return $data;
	}

	function getEngineerNameById($connection,$id){
		$data = "";
		$query = "SELECT name FROM user WHERE id=".$id;
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$data=$row["name"];
			}
		}
		return $data;
	}

	
	function addServicePhoto($connection, $servicePhoto){
		$success = false;
		$query = <<<EOF
		INSERT INTO service_photo
		(service, url)
		VALUES (?,?)
EOF;
		$stmt = $connection->prepare($query);
		$stmt->bind_param("is",$service,$url);
		$service = $servicePhoto->getService();
		$url = $servicePhoto->getUrl();
		if($stmt->execute()){
			$success = true;
		}
		return $success;
	}

	function addServicePhotos($connection, $params,$files){
		//var_dump($params);		
		//echo sizeof($files["photos"]["name"]);
		$success = false;
		foreach ($files["photos"]["name"] as $name) {
			$url =  "errorImages/".$name;			
			$query = "INSERT INTO service_photo (service, url) VALUES (?,?)";
			$stmt = $connection->prepare($query);
			$stmt->bind_param("is",$service,$url);
			$service = $params["serviceId"];
			$url = $url;
			if($stmt->execute()){
				$success = true;
			}
		}
		if(self::uploadServicePhoto($files)){
			$success = true;
		}else{
			$success = false;
		}
		if($success){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Photos Added');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Error Adding Photos!!!');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}
	}

	function removeServicePhotos($connection, $params){
		//var_dump($params);
		$success = false;
		$url = "";
		$query = "SELECT url FROM service_photo WHERE service_photo_id=".$params["servicePhotoId"]."";
		$result = $connection->prepare($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$url=$row["url"];
			}
		}
		

		if(self::removeServerPhoto($url)){
			$data = array();
			$query = "DELETE from service_photo  WHERE service_photo_id=$params[servicePhotoId]";
			$stmt = $connection->prepare($query);
			if($stmt->execute()){
				$success = true;
			}else{
				$success = false;
			}
			
		}else{
			$success = false;
		}

		if($success){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Photo Removed');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Error Removing Photo!!!');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}
	}

	function updateServicePhotos($connection, $params, $files){
		//var_dump($files);
		$url = "";
		$query = "SELECT url FROM service_photo WHERE service_photo_id=".$params["servicePhotoId"]."";
		$result = $connection->query($query);
		if ($result->num_rows>0) {
			while($row = $result->fetch_assoc()){
				$url=$row["url"];
			}
		}
		

		if(self::removeServerPhoto($url)){
			if(self::uploadServicePhoto($files)){
				$data = array();
				$url = "";
				foreach ($files["photos"]["name"] as $name) {
					$url = "errorImages/".$name;
				}
				$query = "UPDATE service_photo SET url='$url' WHERE service_photo_id=$params[servicePhotoId]";
				$stmt = $connection->prepare($query);
				if($stmt->execute()){
					$success = true;
				}else{
					$success = false;
				}
			}else{
				$success = false;
			}
			
		}else{
			$success = false;
		}

		if($success){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Photo Removed');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
               	window.alert('Error Removing Photo!!!');
               	window.location.href='../pages/sh.php';
                </SCRIPT>");
		}
	}

	function removeServerPhoto($url){
		$POST_DATA = array("url"=>$url,"removePhoto"=>"removePhoto");
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/serviceImageCrud.php');
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
        $response = curl_exec($curl);
        echo $response;        
		if($errno = curl_errno($curl)) {
			$success = false;
		} else {
			$success = true;
		}
        curl_close ($curl);
        return $success;
	}

	function addServiceP($connection, $id,$url){
		$success = false;
		$query = <<<EOF
		INSERT INTO service_photo
		(service, url)
		VALUES (?,?)
EOF;
		$stmt = $connection->prepare($query);
		$stmt->bind_param("is",$service,$url);
		$service = $id;
		$url = $url;
		if($stmt->execute()){
			$success = true;
		}
		echo "Added";
		return $success;
	}

	function uploadServicePhoto($files){		
		//var_dump($files["photos"]);
		$success = false;
		if(phpversion()=="5.4.33"){
			$images = array();
			$imageNames = $files["photos"]["name"];
			$imageTmpNames = $files["photos"]["tmp_name"];
			foreach ($files["photos"]["name"] as $key => $file) {
				$images[] = '@'. $imageTmpNames[$key].';filename=' . $imageNames[$key];
			}
						
			foreach ($images as $key => $image) {
				$POST_DATA = array('errorImages'=>$image);
		        $curl = curl_init();
		        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/serviceImage.php');
		        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
		        curl_setopt($curl, CURLOPT_POST, 1);
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
		        $response = curl_exec($curl);
		        //var_dump($response);
				if($errno = curl_errno($curl)) {
					$success = false;
				} else {
					$success = true;
				}
		        curl_close ($curl);
		        return $success;
			}
		}else{			
			$images = array();
			$imageNames = $files["photos"]["name"];
			$imageTmpNames = $files["photos"]["tmp_name"];
			foreach ($files["photos"]["name"] as $key => $file) {
				$images[] = '@'. $imageTmpNames[$key].';filename=' . $imageNames[$key];
			}
			
			foreach ($imageNames as $key => $image) {				
		        $curl = curl_init();
		        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/serviceImage.php');
		        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
		        curl_setopt($curl, CURLOPT_POST, 1);
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		        $args['errorImages'] = new CURLFile($files["photos"]["tmp_name"][$key],$files["photos"]["type"][$key],$files["photos"]["name"][$key]);		
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
		        $response = curl_exec($curl);
		        //var_dump(curl_exec($curl));
				if($errno = curl_errno($curl)) {
					$success = false;
				} else {
					$success = true;
				}
		        curl_close ($curl);

			}
			return $success;
		}
		/*
		for single file
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/serviceImage.php');
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $args['errorImages'] = new CURLFile($files["photos"]["tmp_name"][0],$files["photos"]["type"][0],$files["photos"]["name"][0]);
		//new CURLFile('cats.jpg','image/jpeg','test_name');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
        $response = curl_exec($curl);
        var_dump(curl_exec($curl));
		if($errno = curl_errno($curl)) {
			$success = false;
		} else {
			$success = true;
		}
        curl_close ($curl);
		*/
	}	


	function importService($connection, $file){
		include("../phplibraries/phpexcel/PHPExcel/IOFactory.php");
		$objPHPExcel = PHPExcel_IOFactory::load($file); 
		$success = false;
		ini_set('max_execution_time', 0);
		$worksheetCount = 0;
		$rows = array();
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
			$r=0;
			$worksheetCount+=1;
			$highestRow = $worksheet->getHighestDataRow();
			for($row=2; $row<=$highestRow; $row++){
			  $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $row)->getValue());			 
			  if($p!=""){
			    $r+=1;
			  }
			}
			$rows[]=$r;			
		}
		$index=0;
		$query = <<<EOD
			INSERT INTO service
		   	(machine, customer, engineer, cost_type, service_date, reported_date, closed_date,
		   	status, working_hrs, repetitive, down_hrs, error_code, error_description, action,
		   	root_cause, remarks, spare_part_replace, created_by, created_on, modified_by,
		   	modified_on)
		   	VALUES 
		   	(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()))
EOD;
	    $stmt = $connection->prepare($query);
	    $stmt->bind_param("iiisssssisissssssss",  $machine,$customer,$engineer,$costType,
	    	$serviceDate,$reportDate,$closedDate,$status,$workingHrs,$repetitive,$downHrs,
	    	$errorCode,$errorDescription,$action,$rootCause,$remarks,$getSparePartReplaced,
	    	$cb,$mb);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
			$last = "";
			for($i=2;$i<$rows[$index];$i++){				
			//for($i=2;$i<$rows[$index]+2;$i++){
			    $machine = self::getMachineByNo($connection,mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue()));
				
			    //$customer = self::getCustomerByName($connection,mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue()));
				$customer = explode('-',mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue()))[0];
			    //$engineer = self::getEngineerByName($connection,mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue()));
				$engineer = explode('-',mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue()))[0];
			    $costType = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(9, $i)->getValue());
				$d= ($worksheet->getCellByColumnAndRow(2, $i)->getValue()-25569)*86400;
			   	$serviceDate = date("Y-m-d", $d);			    
			   	//$serviceDate = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue());
			    
			    $d= ($worksheet->getCellByColumnAndRow(3, $i)->getValue()-25569)*86400;
			    $reportDate = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue());
			    $reportDate=date("Y-m-d", $d);

			    $d= ($worksheet->getCellByColumnAndRow(4, $i)->getValue()-25569)*86400;
				$closedDate=mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $i)->getValue());
				$closedDate=date("Y-m-d", $d);

				$status=mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(14, $i)->getValue());
				$workingHrs = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $i)->getValue());
			    $repetitive = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $i)->getValue());
				$downHrs = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $i)->getValue());
			    //$errorCode = self::getErrorByCode($connection, mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(11, $i)->getValue()));
			    $errorCode = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(10, $i)->getValue());
			    $errorDescription = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(11, $i)->getValue());
			    $action = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(12, $i)->getValue());
			    $rootCause = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(13, $i)->getValue());
				$remarks = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(15, $i)->getValue());				
			    $getSparePartReplaced = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(16, $i)->getValue());			    
				$cb=isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
				$mb=isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
			   	
			    if($stmt->execute()){
			    	$success = true;
			    }else{	
			    	echo $stmt->error;		                 
			    	$success = false;
			    }
			}
			$index+=1;
		}
		echo $worksheetCount;		
		return $success;		
	}

	function getCustomerByName($connection, $name){				
		$query = "SELECT id FROM customers WHERE company_name='".$name."'";
		$result = $connection->query($query);
		$data = "";
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){				
				$data= $row["id"];
			}
		}
		return $data;

	}

	function getMachineByNo($connection, $number){
		$query = "SELECT machine_id FROM machine WHERE machine_no = '".$number."'";
		$result = $connection->query($query);
		$data = "";
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){				
				$data= $row["machine_id"];
			}
		}
		if(intval($data)!==0||intval($data)>0){
			return $data;
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Error importing data.Check your excel machine numbers!!')
			window.location.href='../pages/sh.php';
			</SCRIPT>");
			die();
		}
		
	}

	function getEngineerByName($connection, $name){
		$query = "SELECT id FROM user WHERE name='".$name."'";
		$result = $connection->query($query);
		$data = "";
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){				
				$data= $row["id"];
			}
		}
		return $data;
	}

	function getErrorByCode($connection, $code){
		$query = "SELECT error_id FROM error WHERE error_code='".$code."'";
		$result = $connection->query($query);
		$data = "";
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){				
				$data= $row["error_id"];
			}
		}
		return $data;
	}

}

?>