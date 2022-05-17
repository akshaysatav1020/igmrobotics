<?php
/*

machine

DELETE FROM machine WHERE 1

UPDATE machine SET machine_id=[value-1],machine_no=[value-2],machine_name=[value-3],location=[value-4],customer=[value-5] WHERE 1

INSERT INTO machine(machine_id, machine_no, machine_name, location, customer) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])

SELECT machine_id, machine_no, machine_name, location, customer FROM machine WHERE 1

*/
	require('db.php');
	require('data/machineObject.php');
	require_once "updateServerDBVersion.php";

	if($_POST!=null){
		$db = new DB();
		$machine = new Machine();
		if(isset($_POST["addMachine"])){
			$machineObject = new MachineObject($_POST["machineNo"],$_POST["machineName"],$_POST["machineLocation"],$_POST["machineCustomer"]);				
			//echo "<pre>";var_dump($machineObject);echo "</pre>";;
			if($machine->addMachine($db->getConnection(),$machineObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Machine Added!!')
		          window.location.href='../pages/machine.php';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error Adding machine!!!')
		          window.location.href='../pages/machine.php';
		          </SCRIPT>");
			}
		}else if(isset($_POST["editMachine"])){
			/*$drawing = $_POST["eMachineDrawingPath"];
			if(basename($_FILES['eMachineDrawing']['name'])!=""){
				$drawing = "machineDrawing/".$_FILES["eMachineDrawing"]["name"];
				if($machine->uploadMachineImage($_FILES,"update",$_POST["eMachineDrawingPath"])){
					$machineObject = new MachineObject($_POST["eId"],$_POST["eMachineNo"],$_POST["eMachineName"],$_POST["eMachineLocation"],$_POST["eMachineCustomer"]);
					if($machine->updateMachine($db->getConnection(),$machineObject)){
						echo ("<SCRIPT LANGUAGE='JavaScript'>
				          window.alert('Machine Updated!!')
				          window.location.href='../pages/machine.php';
				          </SCRIPT>");
					}else{
						echo ("<SCRIPT LANGUAGE='JavaScript'>
				          window.alert('Error updating machine!!!')
				          window.location.href='../pages/machine.php';
				          </SCRIPT>");
					}
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error updating machine!!!')
			          window.location.href='../pages/machine.php';
			          </SCRIPT>");
				}			
			}else{*/
				$machineObject = new MachineObject($_POST["eId"],$_POST["eMachineNo"],$_POST["eMachineName"],$_POST["eMachineLocation"],$_POST["eMachineCustomer"]);
				if($machine->updateMachine($db->getConnection(),$machineObject)){
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Machine Updated!!')
			          window.location.href='../pages/machine.php';
			          </SCRIPT>");
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('Error updating machine!!!')
			          window.location.href='../pages/machine.php';
			          </SCRIPT>");
				}
			//}							
		}else if(isset($_POST["deleteMachine"])){
			if($machine->deleteMachine($db->getConnection(),$_POST["machineId"])){
				echo "Deleted";
			}else{
				echo "Error Deleting";
			}			
		}else if(isset($_POST["getMachine"])){
			$machine->getMachine($db->getConnection(),$_POST["machineId"]);
		}else if(isset($_POST["getCustomerByMachine"])){
			$machine->getCustomerByMachine($db->getConnection(),$_POST["machineId"]);
		}else if(isset($_POST["getCustomerMachineByMachineNumber"])){
			$machine->getCustomerMachineByMachineNumber($db->getConnection(),$_POST["machineNo"]);
		}else if(isset($_POST["getAllMachine"])){
			$machine->getAllMachine($db->getConnection());
		}else if(isset($_POST["getMachineName"])){
			$machine->getMachineName($db->getConnection(),$_POST["number"]);
		}
	}else{

	}

	class Machine{
		function addMachine($connection,$machineObject){
			//echo "<pre>";var_dump($machineObject->getCustomer());echo "</pre>";;
			$success = false;
			$query = <<<EOD
    		INSERT INTO machine (machine_no, machine_name, location, customer) VALUES
    		(?, ?, ?, ?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("sssi", $machine_no, $machine_name, $location, $customer);
			$machine_no = $machineObject->getMachineNo();
			$machine_name = $machineObject->getMachineName();
			$location = $machineObject->getLocation();
			$customer = $machineObject->getCustomer();
			if($stmt->execute()){
				$success = true;
			}
			return $success;
		}

		function updateMachine($connection,$machineObject){
			$success = false;
			$query = <<<EOD
    		UPDATE machine SET 
    		machine_no=?,machine_name=?,location=?,customer=? 
    		WHERE machine_id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("sssii", $machine_no, $machine_name, $location, $customer, $machineId);
			$machine_no = $machineObject->getMachineNo();
			$machine_name = $machineObject->getMachineName();
			$location = $machineObject->getLocation();
			$customer = $machineObject->getCustomer();
			$machineId = $machineObject->getMachineId();
			if($stmt->execute()){
				$success = true;
			}
			return $success;
		}

		function deleteMachine($connection,$machineId){
			$success = false;
			$query = <<<EOD
    		DELETE FROM machine WHERE machine_id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("i", $machineId);
			$machineId = $machineId;
			if($stmt->execute()){
				$success = true;
			}else{
				echo $stmt->error;
			}
			return $success;
		}

		function getMachine($connection,$machineId){
			$query = <<<EOD
    		SELECT * FROM machine WHERE machine_id = $machineId
EOD;
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM customers WHERE id=".$row["customer"];
					$result1 = $connection->query($query1);
		      		$data1 = "";
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1 = $row1;
						}
					}
					$data = array('machineDetails' => $row, 'custDetails'=>$data1);
				}
			}
			echo json_encode($data);
		}

		function getCustomerMachineByMachineNumber($connection, $machineNo){
			$query = "SELECT m.customer, m.machine_name, c.company_name FROM machine m, customers c WHERE m.machine_no =$machineNo and m.customer=c.id";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){					
					$data = $row;
				}
			}
			echo json_encode($data); 
		}

		function getCustomerByMachine($connection, $machineId){
			
			$query = "SELECT m.customer, m.machine_name, c.company_name FROM machine m, customers c WHERE m.machine_id =$machineId and m.customer=c.id";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){					
					$data = $row;
				}
			}
			echo json_encode($data); 
		}

		function getMachineName($connection,$number){
			$query = "SELECT machine_name FROM machine WHERE machine_no = '".$number."'";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){					
					$data = $row["machine_name"];
				}
			}
			echo $data; 
		}

		function getAllMachine($connection){
			$query = <<<EOD
    		SELECT * FROM machine 
EOD;
			$result = $connection->query($query);
			$data = [];
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM customers WHERE id=".$row["customer"]."";
					$result1 = $connection->query($query1);
		      		$data1 = "";
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1 = $row1;
						}
					}
					$data[] = array('machineDetails' => $row, 'custDetails'=>$data1);
				}
			}
			echo json_encode($data);
		}

		function uploadMachineImage($file,$action,$path){
			$success = false;
			$drawing = "";
			if($action=="update"){
				$drawing = '@'. $file['eMachineDrawing']['tmp_name'].';filename=' . $file['eMachineDrawing']['name'];
			}else{
				$drawing = '@'. $file['machineDrawing']['tmp_name'].';filename=' . $file['machineDrawing']['name'];
			}
			$POST_DATA = array(
	            'action'=>$action,
	            'path'=>$path,
	            'machineDrawing'=>$drawing
	        );

	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/machineImage.php');
	        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
	        curl_setopt($curl, CURLOPT_POST, 1);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
	        $response = curl_exec($curl);
			if($errno = curl_errno($curl)) {
				$success = false;
			} else {
				$success = true;
			}
	        curl_close ($curl);
			return $success;
		}
	}
?>