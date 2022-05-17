<?php

/*UPDATE inventory_parts
SET total = Case
When total > 0 Then total-1 
When total = 0 Then total
End
WHERE part_number = '45E008'*/

	require_once "db.php";
	require "data/inventoryWarehouseObject.php";
	require_once "updateServerDBVersion.php";

	if($_POST!=null){

		$db = new DB();
  		$date = new DateTime();
		$warehouse = new Warehouse();				
		//$date->format('Y-m-d H:i:s')
		if(isset($_POST["addstock"])){
			//print_r($_POST);
			$chDate = new DateTime($_POST['chdate']);
			$impDate=new DateTime($_POST["importDate"]);
			
			if($warehouse->addStock($db->getConnection(),$_POST)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Added')
	            window.location.href='../pages/stock.php';
	            </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Error Adding')
	            window.location.href='../pages/stock.php';
	            </SCRIPT>");
			}
		}else if(isset($_POST["importstocks"])){
			$tmp = explode(".", $_FILES["stocksexcel"]["name"]);
		    $extension = end($tmp);
		    //$connect = mysqli_connect("localhost", "root", "", "igm");
		    $allowed_extension = array("xls", "xlsx", "csv");
		    $time = $date->format('Y-m-d H:i:s');
		    if(in_array($extension, $allowed_extension)){
		    	$file = $_FILES["stocksexcel"]["tmp_name"];
		    	if($warehouse->importStock($db->getConnection(),$file,$time)){
		    		echo ("<SCRIPT LANGUAGE='JavaScript'>
		            window.alert('Imported')
		            window.location.href='../pages/stock.php';
		            </SCRIPT>");
		    	}else{
				    echo ("<SCRIPT LANGUAGE='JavaScript'>
				        window.alert('Error Importing!! Contact Admin')
				        window.location.href='../pages/stock.php';
				        </SCRIPT>");
			  	}
		    }

		}else if(isset($_POST["editstock"])){
			$echDate = new DateTime($_POST['echdate']);
			$impDate=new DateTime($_POST["eImportDate"]);

			$stock = new InventoryWarehouse($_POST["eid"], $_POST["eserno"], $_POST["epono"],
			 $_POST["eused"], $_POST["epartno"],$_POST['echno'],$echDate->format('Y-m-d H:i:s'),$impDate->format("Y-m-d H:i:s"),$_POST["eClearingCharges"],
			 	$_POST["eBillEntryNo"], $_POST['ereturnable']);

			if($warehouse->editStock($db->getConnection(),$stock)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Edited')
	            window.location.href='../pages/stock.php';
	            </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Error Editing')
	            window.location.href='../pages/stock.php';
	            </SCRIPT>");
			}
		}else if(isset($_POST["deletestock"])){
			if($warehouse->deleteStock($db->getConnection(),$_POST["stockId"])){
				echo "Deleted";
			}else{
				echo "Err deleting";
			}
		}else if(isset($_POST["getstock"])){			
			//$connection = new mysqli(HOST, USER, PASSWORD, DB);			
			$warehouse->getStock($db->getConnection(),$_POST["stockId"]);
		}else if(isset($_POST["getStocks"])){
			$warehouse->getStockReport($db->getConnection());
		}else if(isset($_POST["getStocksAll"])){
			$warehouse->getStockReportAll($db->getConnection());
		}else if(isset($_POST["getWarehouseStocks"])){
			$warehouse->getAllStock($db->getConnection());
		}else if(isset($_POST["getWarehouseStocksUnused"])){
			$warehouse->getAllStockUnused($db->getConnection());
		}else if(isset($_POST['getAllReturnableStock'])){
			$warehouse->getAllReturnableStock($db->getConnection());
		}else if(isset($_POST["changeReturnStatus"])){
			if($warehouse->changeReturnStatus($db->getConnection(),$_POST["stockId"],$date->format('Y-m-d H:i:s'))){
				echo "Changed";
			}else{
				echo "Err Changing";
			}			
		}else if(isset($_POST["stockByPart"])){
			$warehouse->getAllStockByPart($db->getConnection(), $_POST["part"]);
		}


	}else{

	}
	/**
	* 
	*/
	class Warehouse{

		function addStock($connection, $stockpart){
			// getId getPo getTimestamp getUsed getPartNo getInvoiceNo getCb getCo
			//var_dump($stockpart);
	     	$q = <<<EOD
	     	INSERT INTO inventory(part_id,part_number, serial_number, timestamp, used, 
	     	po_id,inward_no, ch_no, ch_date, import_date, clearing_charges, bill_entry_no, 
	     	returnable, created_by, created_on, modified_by, modified_on)
	      	VALUES
			(?,?,?,(SELECT NOW()),0,?,?,?,?,?,?,?,0,?,(SELECT NOW()),?,(SELECT NOW()))	      	
EOD;
			mysqli_query($connection, $q);
	      	$stmt = $connection->prepare($q);
	      	$stmt->bind_param("isssisssdsss", $part_id,$part_number,$serial_number,$po_id,$inward_no,$ch_no,$ch_date,
	      	 $importDate, $clearingCharges, $billEntryNo, $cb,$mb);
	      	$part_id=$stockpart["partno"];
	      	$part_number = self::getPartNo($connection,$stockpart["partno"]);
	      	$serial_number = $stockpart["serno"];	      	
	      	$po_id = $stockpart["pono"];
	      	$inward_no = $stockpart["inwardno"];
	      	$ch_no = $stockpart["chno"];
	      	$ch_date = $stockpart["chdate"];
	      	$importDate = $stockpart["importDate"];
	      	$clearingCharges = $stockpart["clearingCharges"]; 
	      	$billEntryNo = $stockpart["billEntryNo"];
	      	$cb = $mb = $_COOKIE["usermail"];	      	
	      	if($stmt->execute()){	      		
		        $result=mysqli_query($connection,"UPDATE inventory_parts SET total=total+1 WHERE id='$stockpart[partno]'");
		        if($result){
		        	return true;		        	
		        }
	      	}else{
	      		echo $stmt->error;
		        return false;
	      	}      	
		}

		function getPartNo($connection, $id){
			$data = "";
			$query="SELECT * FROM inventory_parts WHERE id='$id'";
	      	$result = $connection->query($query);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data = $row["part_number"];
				}
			}
			return $data;
		}

		function importStock($connection, $file,$time){
			include("../phplibraries/phpexcel/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
	      	$objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
	      	ini_set('max_execution_time', 0);
	      	$r = 1;
	      	$success = false;
	      	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
	        	$highestRow = $worksheet->getHighestDataRow();
	        	
            	$cb = $mb = $_COOKIE["usermail"];
            	$query = <<<EOD
            	INSERT INTO inventory
            	(part_number, serial_number, timestamp, used, po_id, inward_no, ch_no,ch_date,
            	import_date, clearing_charges, bill_entry_no, returnable,
            	created_by, created_on, modified_by, modified_on)
            	VALUES
            	(?,?,(SELECT NOW()),0,?,?,?,?,(SELECT NOW()), ?,?, 0,
            	'$cb',(SELECT NOW()),'$cb',(SELECT NOW()))
EOD;
				$stmt = $connection->prepare($query);
		     	$stmt->bind_param("ssiissdd", $partno,$serialno,$poId,$inwardNo,$chNo,$ichDate,
		     		$clearingCharges,$billEntryNo);
	        	for($row=2; $row<=$highestRow; $row++){
	          		$p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
	          		if($p!=""){
	            		$r++;
	          		}
	        	}
	        	for($i=2;$i<=$r;$i++){					
	            	$partno = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue());
	            	
	            	$serialno = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue());
	            	
	            	$pono = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue());
	            	
	            	$poId = self::getPoId($connection, $pono);
	            	
	            	
	            	$inward = self::getInwardId($connection, mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue()));
	            	$inwardNo = $inward;            	
	            	
	            	$chNo = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $i)->getValue());
	            	
	            	$ichDate = date('Y-m-d H:i:s', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(5, $i)->getValue()));	            	
	            	
	            	$clearingCharges = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue());;
	            	
	            	$billEntryNo = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $i)->getValue());;
			     	
			     	$partno = $partno;
				  	
				  	$serialno = $serialno;
				  	
				  	$poId = $poId;				  	
			      	if($stmt->execute()){				        
				        $result = mysqli_query($connection,"UPDATE inventory_parts SET total=total+1 WHERE part_number='".$partno."';");
				        if($result){
				        	$success = true;	
				        }
			      	}else{
			        	$success = false;
			      	}	            	
	          	}
	      	}

	      	if($r>=2 && $success){
				return true;	      		
	      	}else{
	      		return false;
	      	}

		}

		function getInwardId($connection, $inwardNo){
			$data = "";
			$query="SELECT * FROM duty WHERE inward_no='$inwardNo'";
	      	$result = $connection->query($query);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data = $row["duty_id"];
				}
			}
			return $data;
		}

		function getPoId($connection, $poNo){
			$data = "";
			$query="SELECT * FROM purchaseorder WHERE po_no='$poNo'";
	      	$result = $connection->query($query);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data = $row["id"];
				}
			}
			return $data;
		}


		function editStock($connection, $stockpart){
			// getId getPo getTimestamp getUsed getPartNo getInvoiceNo getCb getCo
	     	$q = <<<EOD
	     	UPDATE inventory 
	     	SET
	      	part_number=?,serial_number=?,used=?,po_id=?,
	      	ch_no=?,ch_date = ?, import_date=?, clearing_charges=?,
	      	bill_entry_no=?, returnable=?,
	      	modified_by=?,modified_on=(SELECT NOW())
	      	WHERE
	      	id=?
EOD;
	      	$stmt = $connection->prepare($q);
	      	$stmt->bind_param("sssisssdsisi", $part_number,$serial_number,$used,$po_id,
	      		$ch_no,$ch_date, $importDate, $clearingCharges,$billEntryNo,$returnable,$mb,$id);
	      	$part_number = $stockpart->getPartNo();
	      	$serial_number = $stockpart->getSerialNo();
	      	if($stockpart->getUsed()=="on"){
	      		$used = 0;
	      	}else{
	      		$used = 1;
	      	}
	      	$po_id = $stockpart->getPo();
	      	$ch_no = $stockpart->getChno();
	      	$ch_date = $stockpart->getChdate();
	      	$importDate = $stockpart->getImportDate();
	      	$clearingCharges = $stockpart->getClearingCharges(); 
	      	$billEntryNo = $stockpart->getBillEntryNo();
	      	if($stockpart->getReturnable()=="on"){
	      		$returnable = 0;
	      	}else{
	      		$returnable = 1;
	      	}
	      	$mb = $_COOKIE["usermail"];
	      	$id = $stockpart->getId();
	      	if($stmt->execute()){
				return true;
		        /*$upSDB = new UpdateServerDBVersion();
				if($upSDB->updateDBVersion()){
				}else{
					return false;
				}*/
	      	}else{
		        return false;
	      	}
		}

		function deleteStock($connection, $id){
			$success=false;
			$query="SELECT part_number FROM inventory WHERE id=".$id;
	      	$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){							 
				  $result1 = mysqli_query($connection,"UPDATE inventory_parts SET total = total-1 WHERE part_number='".$row['part_number']."';");
				  if($result1){				  	
				  	$success=true;
				  }else{
				  	echo $stmt->error;
				  }
				}
			}
			if($success){
				$q = "DELETE FROM inventory WHERE id=?";
				$stmt = $connection->prepare($q);
				$stmt->bind_param("i",$id);
				$id=$id;
				if($stmt->execute()){
					return true;
					/*$upSDB = new UpdateServerDBVersion();
					if($upSDB->updateDBVersion()){
					}else{
						return false;
					}*/				         								
		      	}else{
			       	echo $stmt->error;				  
			 //       return false;
		      	}
			}
		}

		function getStock($connection, $id){
			$data = array();
			$query="SELECT * FROM inventory WHERE id=".$id;
	      	$result = $connection->query($query);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data[] = array('id'=>$row['id'],'srno'=>$row['serial_number'],
				  	'partid'=>self::getPartId($connection, $row['part_number']),
				  	'partno'=>$row['part_number'],
				  'description'=>self::getPartDetails($connection, $row['part_number']),
				  'time'=>$row['timestamp'],'used'=>$row['used'],
				  'poid'=>$row['po_id'],				  
	  			  'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],
				  'ch_no'=>$row['ch_no'],"ch_date"=>$row['ch_date'],'returnable'=>$row['returnable'],
				  'cb'=>$row['created_by'],'co'=>$row['created_on'],
				  'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			echo json_encode($data);

		}		

		function getPartId($connection, $id){
	      $query="SELECT id FROM inventory_parts WHERE part_number='".$id."'";
	      $result = $connection->query($query);
	      $data = "";
	      if($result->num_rows>0){
	        while($row=$result->fetch_assoc()){
	          $data = $row['id'];
	        }
	      }
	      return $data;
    	}

		function getPartDetails($connection, $id){
	      $query="SELECT description FROM inventory_parts WHERE part_number='".$id."'";
	      $result = $connection->query($query);
	      $data = "";
	      if($result->num_rows>0){
	        while($row=$result->fetch_assoc()){
	          $data = $row['description'];
	        }
	      }
	      return $data;
    	}

		function getStockReport($connection){
			$query = "SELECT a.part_number, COUNT(*) as count, b.location,b.description, b.min FROM inventory a, inventory_parts b WHERE a.part_number = b.part_number AND a.used=0 GROUP BY  a.part_number ";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){
	            $data[] = array("part"=>$row["part_number"],"count"=>$row["count"], "location"=>$row["location"], 
	            "desc"=>$row["description"],'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],"min"=>$row["min"],);
	          }
	        }
	        echo json_encode($data);
		}

		function getStockReportAll($connection){
			$query = "SELECT a.part_number, COUNT(*) as count, b.location,b.description, b.min FROM inventory a, inventory_parts b WHERE a.part_number = b.part_number GROUP BY  a.part_number ";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){
	            $data[] = array("part"=>$row["part_number"],"count"=>$row["count"], "location"=>$row["location"], 
	            "desc"=>$row["description"],'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],"min"=>$row["min"]);
	          }
	        }
	        echo json_encode($data);
		}

		function getAllStock($connection){
			$query = "SELECT * FROM inventory";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){            
	            $data[] = array("id"=>$row["id"],"part"=>$row["part_number"],"srno"=>$row["serial_number"],
	            	"po"=>$row["po_id"],"inv"=>$row["inv_id"],"ch_no"=>$row['ch_no'],"ch_date"=>$row['ch_date'],
	            	'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],
	            	"returnable"=>$row['returnable']);
	          }
	        }
	        echo json_encode($data);
		}

		function getAllReturnableStock($connection){
			$query = "SELECT * FROM inventory WHERE returnable=1 AND used=1";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){            
	            $data[] = array("id"=>$row["id"],"part"=>$row["part_number"],"srno"=>$row["serial_number"],
	            	"po"=>$row["po_id"],"inv"=>$row["inv_id"],"ch_no"=>$row['ch_no'],"ch_date"=>$row['ch_date'],
					'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],
	            	"returnable"=>$row['returnable'],
	            	"mo"=>$row['modified_on']);
	          }
	        }
	        echo json_encode($data);
		}

		function changeReturnStatus($connection, $stockId,$mo){
			$result = mysqli_query($connection,"UPDATE inventory_parts SET total=total+1 WHERE id='".$stockId."';");
	        if($result){

	        }
			$q = <<<EOD
	     	UPDATE inventory
	     	SET 
	     	used=0,returnable=0,modified_on=?
	      	WHERE
	      	id=?
EOD;
			$stmt = $connection->prepare($q);
			$stmt->bind_param("si",$mo,$stockId);
			$mo = $mo;
			$stockId=$stockId;
			if($stmt->execute()){

		        $upSDB = new UpdateServerDBVersion();
				if($upSDB->updateDBVersion()){
					return true;
				}else{
					return false;
				}
	      	}else{
		        return false;
	      	}
		}

		function getAllStockUnused($connection){
			$query = "SELECT * FROM inventory WHERE used=0";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){            
	            $data[] = array("id"=>$row["id"],"part"=>$row["part_number"],"srno"=>$row["serial_number"],
	            	'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],
	            	"po"=>$row["po_id"]/*,"inv"=>$row["inv_id"]*/);
	          }
	        }
	        echo json_encode($data);
		}

		function getAllStockByPart($connection, $part){
			echo $part;
			$query = "SELECT * FROM inventory WHERE part_number='".$part."'";
	        $result = $connection->query($query);
	        $data = array();
	        if($result->num_rows>0){
	          while($row=$result->fetch_assoc()){            
	            $data[] = array("id"=>$row["id"],"part"=>$row["part_number"],"srno"=>$row["serial_number"],
	            	'import_date'=>$row['import_date'],"clearing_charges"=>$row['clearing_charges'],'bill_entry_no'=>$row['bill_entry_no'],
	            	"po"=>$row["po_id"],"inv"=>$row["inv_id"]);
	          }
	        }
	        echo json_encode($data);
		}
		
	}
?>