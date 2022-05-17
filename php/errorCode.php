<?php
/*

error

SELECT error_id, error_code, error_description, action, root_cause FROM error WHERE 1

INSERT INTO error(error_id, error_code, error_description, action, root_cause) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])

UPDATE error SET error_id=[value-1],error_code=[value-2],error_description=[value-3],action=[value-4],root_cause=[value-5] WHERE 1

DELETE FROM error WHERE 1

*/
	require('db.php');
	require('data/errorCodeObject.php');
	require_once("updateServerDBVersion.php");
	require_once ("../phplibraries/phpexcel/PHPExcel/IOFactory.php");

	if($_POST!=null){
		$db = new DB();
		$errorCode = new ErrorCode();
		if(isset($_POST["addErrorCode"])){
			$errorCodeObject = new ErrorCodeObject($_POST["errorCode"],$_POST["errorCodeDescription"],$_POST["errorCodeAction"],$_POST["rootCause"]);
			if($errorCode->addErrorCode($db->getConnection(),$errorCodeObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error Code Added!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error adding Error Code!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
			}
		}else if(isset($_POST["editErrorCode"])){
			$errorCodeObject = new ErrorCodeObject($_POST["eErrorCodeId"],$_POST["eErrorCode"],$_POST["eErrorCodeDescription"],$_POST["eErrorCodeAction"],$_POST["eRootCause"]);			
			if($errorCode->updateErrorCode($db->getConnection(),$errorCodeObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error Code Updated!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error updating Error Code!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
			}
		}else if(isset($_POST["deleteErrorCode"])){
			if($errorCode->deleteErrorCode($db->getConnection(),$_POST["errorCodeId"])){
				echo ("Deleted");
			}else{
				echo ("Error deleting");
			}
		}else if(isset($_POST["getErrorCode"])){
			$errorCode->getErrorCode($db->getConnection(),$_POST["errorCodeId"]);
		}else if(isset($_POST["getAllErrorCode"])){
			$errorCode->getAllErrorCode($db->getConnection());
		}else if(isset($_POST["importErrorCode"])){
			$extension = explode(".", $_FILES["codeList"]["name"])[1];
			$allowed_extension =  array("xls", "xlsx", "csv");
			if(in_array($extension, $allowed_extension)){
				if($errorCode->importErrorCode($db->getConnection(),$_FILES["codeList"]["tmp_name"])){
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('List Imported!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error!!! Importing List');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
				}
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('File type not supported!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
			}
		}
	}else{

	}

	class ErrorCode{
		function addErrorCode($connection,$errorCodeObject){
			$success = false;
			$query = <<<EOD
    		INSERT INTO error(error_code, error_description, action,root_cause) VALUES (?, ?, ?,?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("ssss", $error_code, $error_description, $action,$root_cause);
			$error_code = $errorCodeObject->getErrorCode();
			$error_description = $errorCodeObject->getErrorDescription();
			$action = $errorCodeObject->getAction();
			$root_cause = $errorCodeObject->getRootCause();
			if($stmt->execute()){
				$success = true;
			}
			return $success;
		}

		function updateErrorCode($connection,$errorCodeObject){
			$success = false;
			$query = <<<EOD
    		UPDATE error SET error_code=?,error_description=?,action=?,root_cause=? 
    		WHERE error_id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("ssssi", $error_code, $error_description, $action,$root_cause,$errorCodeId);
			$error_code = $errorCodeObject->getErrorCode();
			$error_description = $errorCodeObject->getErrorDescription();
			$action = $errorCodeObject->getAction();
			$root_cause = $errorCodeObject->getRootCause();
			$errorCodeId = $errorCodeObject->getErrorId();
			if($stmt->execute()){
				$success = true;
			}
			return $success;
		}

		function deleteErrorCode($connection,$errorCodeId){
			$success = false;
			$query = <<<EOD
    		DELETE FROM error WHERE error_id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("i", $errorCodeId);
			$errorCodeId = $errorCodeId;
			if($stmt->execute()){
				$success = true;
			}
			return $success;
		}

		function getErrorCode($connection,$errorCodeId){
			$query = <<<EOD
    		SELECT * FROM error WHERE error_id = $errorCodeId
EOD;
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data = $row;
				}
			}
			echo json_encode($data);
		}

		function getAllErrorCode($connection){
			$query = <<<EOD
    		SELECT * FROM error
EOD;
			$result = $connection->query($query);
			$data = [];
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row;
				}
			}
			echo json_encode($data);
		}

		function importErrorCode($connection,$file){
			$success = false;
			ini_set('max_execution_time', 0);
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$r = 1;
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestDataRow();
		        for($row=2; $row<=$highestRow; $row++){
		          $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		          if($p!=""){
		            $r++;
		          }
		        }
		        for($i=2;$i<=$r;$i++){
            		$errorCode = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue());
            		$errorDesc = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue());
            		$errorAction = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue());
            		$rootCause = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue());
            		$errorCodeObject = new ErrorCodeObject($errorCode,$errorDesc,$errorAction,$rootCause);
            		if(self::addErrorCode($connection,$errorCodeObject)){
            			$success = true;
            		}else{
            			$success = false;
            		}
            	}
			}
			return $success;
		}
	}
?>