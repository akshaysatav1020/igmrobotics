<?php
	include("db.php");  
  	require("data/dutyObject.php");
  	require("data/dutyParticularObject.php");
	if($_POST!=null){
		$db = new DB();
      	$duty = new Duty();
      	$cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
		if(isset($_POST["addDuty"])){			
			//echo "<pre>";var_dump($_POST);echo "</pre>";
			
			$po = 0;
			$inward_type = "Under Warranty and other reason";
			if($_POST["againstPo"]=="true"){				;
				$po = $_POST["po"];
				$inward_type = "Against PO";	
			}
			 
			$particulars = explode(",",$_POST["ids"]);
			$dutyObjectParticulars = new ArrayObject();
			
			foreach ($particulars as $p) {
				
				$part = $duty->getPartForDutyParticular($db->getConnection(), $_POST["partno$p"]);				
				$dutyObjectParticulars[] = new DutyParticularObject($inward_type,$_POST["inwardNo"],
					$part,$_POST["unitRateEuro$p"],$_POST["unitRateInr$p"],
					$_POST["quantity$p"],$_POST["duty$p"],$_POST["clearing$p"],
					$_POST["packging$p"],$_POST["forwarding$p"],
					$_POST["Landedcostper$p"],$_POST["landedcost$p"]);
			}
			
			$dutyObject = new DutyObject($inward_type, $po,$_POST["billOfEntryNo"],$_POST["billOfEntryDate"],
				$_POST["invoiceNo"],$_POST["vendor"],$_POST["euroRate"],$_POST["inwardDate"],
				$_POST["inwardNo"],$_POST['discount'],$dutyObjectParticulars);			
			//echo "<pre>";var_dump($dutyObject);echo "</pre>";
			if($duty->addDuty($db->getConnection(), $dutyObject)){
				//now add part to inventory
				$duty->addInventory($db->getConnection(),$_POST);
				$duty->updatePartQty($db->getConnection(), $_POST);
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	              window.alert('Added');
	              window.location.href='../pages/duty.php';
	              </SCRIPT>");			
			}else{
				die;
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	              window.alert('Error Adding');
	              window.location.href='../pages/duty.php';
	              </SCRIPT>");
			}
		}else if(isset($_POST["updateDuty"])){
			$duty->editDuty($db->getConnection(), $_POST);			
		}else if(isset($_POST["deleteDuty"])){
			if($duty->deleteDuty($db->getConnection(), $_POST["id"])){
				echo "Deleted";
			}else{
				echo "Error Deleting";
			}
		}else if(isset($_POST["getDuty"])){
			$duty->getDuty($db->getConnection(), $_POST["id"]);
		}else if(isset($_POST["getAllDuty"])){
			$duty->getAllDuty($db->getConnection());
		}else if(isset($_POST["getLastInwardNo"])){
			$duty->getLastInwardNo($db->getConnection());
		}else if(isset($_POST["getDutyParticulars"])){
			$duty->getDutyParticulars($db->getConnection(),$_POST["inward_no"]);
		}else if(isset($_POST["getDutyParticularsPrice"])){
			$duty->getDutyParticularsPrice($db->getConnection(),$_POST["inward_no"],$_POST["part"]);
		}else if(isset($_POST["addDutyParticular"])){
			$duty->addDutyParticular($db->getConnection(),$_POST);
		}else if(isset($_POST["getDutyParticular"])){
			$duty->getDutyParticular($db->getConnection(),$_POST["id"]);
		}else if(isset($_POST["updateDutyParticular"])){
			$duty->updateDutyParticular($db->getConnection(),$_POST);
		}else if(isset($_POST["deleteDutyParticular"])){
			$duty->deleteDutyParticular($db->getConnection(),$_POST["id"]);
		}else if(isset($_POST["dutyPartsList"])){
			echo explode(".", $_FILES["excelFile"]["name"]);;
			$duty->dutyPartsList($db->getConnection(),$_POST);
		}
		
	}else{		
	}

	/**
	 * 
	 */
	class Duty{

		function getPartForDutyParticular($connection, $partno){			
			$part="";
			$query="SELECT * FROM `inventory_parts` WHERE `part_number`='".$partno."'";// AND `location`!=''";
			$result = $connection->query($query);			
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$part = $row["id"]."-".$partno;
				}
			}
			return $part;
		}

		function addDuty($connection, $dutyObj){
			$q = "INSERT INTO duty
			(inward_type,po,bill_of_entry_no, bill_of_entry_date, invoice_no, vendor, euro_rate, inward_date, inward_no,discount, created_by, created_on, modified_by, modified_on)
			VALUES
			(?,?,?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()))";					
			$stmt = $connection->prepare($q);
			$stmt->bind_param("sissssdssdss", $inward_type, $po,$billEntryNo,$billEntryDate,$invoiceNo,$vendor,
				$euroRate,$inwardDate,$inwardNo,$discount,$cb,$mb);
			$inward_type = $dutyObj->getDutyType();
			$po = $dutyObj->getPo();
			$billEntryNo = $dutyObj->getBillOfEntryNo();
			$billEntryDate = $dutyObj->getBillOfEntryDate();
			$invoiceNo = $dutyObj->getInvoiceNo();
			$vendor = $dutyObj->getVendor();
			$euroRate = $dutyObj->getEuroRate();
			$inwardDate = $dutyObj->getInwardDate();
			$inwardNo = $dutyObj->getInwardNo();
			$discount = $dutyObj->getDiscount();
			$cb = $_COOKIE["userrole"];
			$mb = $_COOKIE["userrole"];
			if($stmt->execute()){
				if(self::addDutyParticulars($connection, $dutyObj->getDutyParticulars())){
					if($dutyObj->getDutyType()!="Under Warranty and other reason"){
						if(self::updatePOTracking($connection, $dutyObj->getPo(), $dutyObj->getDutyParticulars())){
							return true;
						}
					}else{
						return true;
					}
				}else{
					return false;
				}
			}else{
				echo $stmt->error;
				return false;
			}
		}

		function editDuty($connection, $duty){
			//var_dump($duty);
			$inward_type = "Under Warranty and other reason";
			$po = 0;
			if($duty["againstPo"]=="true"){				;
				$po = $duty["po"];
				$inward_type = "Against PO";	
			}
			$q = "UPDATE duty SET inward_type=?, po=?,bill_of_entry_no=?,bill_of_entry_date=?,invoice_no=?,vendor=?,
			euro_rate=?,inward_date=?,discount=?,modified_by=?,modified_on=(SELECT NOW())
			WHERE duty_id=?";
			$stmt = $connection->prepare($q);
			$stmt->bind_param("sisssidsdsi", $inward_type,$po,$billEntryNo,$billEntryDate,$invoiceNo,$vendor,$euroRate,$inwardDate,$discount,$mb,$id);
			$inward_type = $inward_type;
			$po = $po;
			$billEntryNo = $duty["billOfEntryNo"];
			$billEntryDate = $duty["billOfEntryDate"];
			$invoiceNo = $duty["invoiceNo"];
			$vendor = $duty["vendor"];
			$euroRate = $duty["euroRate"];
			$inwardDate = $duty["inwardDate"];
			$discount = $duty["discount"];
			$mb = $_COOKIE["userrole"];
			$id = $duty["id"];
			if($stmt->execute()){
				if($inward_type!="Against PO"){
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Edited');
		              window.location.href='../pages/editDuty.php?type=duty&id=$duty[id]';
		              </SCRIPT>");	

				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Edited');
		              window.location.href='../pages/editDutyPo.php?type=duty&id=$duty[id]';
		              </SCRIPT>");
				}		
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	              window.alert('Error editing'+".$stmt->error.");
	              window.location.href='../pages/editDutyPo.php?type=duty&id=$duty[id]';
	              </SCRIPT>");
			}
		}

		function updateDutyParticular($connection, $particular){
			//var_dump($particular);
			$inward_type = "Under Warranty and other reason";
			if($particular["eAgainstPo"]=="true"){				;
				//$po = $particular["po"];
				$inward_type = "Against PO";	
			}
			//echo "$inward_type";
			$q = "UPDATE duty_particulars SET
			qty=?,duty=?, clearing_charges=?, packaging=?, forwarding_charges=?, landed_cost_per_part=?,
			total_landed_cost=?
			WHERE duty_particluar_id=?";
			$stmt = $connection->prepare($q);
			$stmt->bind_param("iddddddi", $qty, $duty, $clearing, $packaging, $forwarding, 
				$landedCostPerPart, $landedCost, $eId);	
			$qty = $particular["eQty"];		
			$duty = $particular["eDuty"];
			$clearing = $particular["eClearing"];
			$packaging = $particular["ePackaging"];
			$forwarding = $particular["eForwarding"];
			$landedCostPerPart = $particular["eLandedPerPart"];
			$landedCost = $particular["eTotalLanded"];
			$eId = $particular["eId"];
			if($stmt->execute()){
				if($inward_type == "Against PO"){
					$q = "UPDATE po_tracking SET received=? WHERE po_no=? AND part_no=?";
					$stmt = $connection->prepare($q);
					$stmt->bind_param("iii", $received, $po, $part);	
					$received = $particular["eQty"];		
					$po = $particular["eDutyPO"];
					$part = explode("-", $particular["ePart"])[0];
					if($stmt->execute()){
						echo ("<SCRIPT LANGUAGE='JavaScript'>
			              window.alert('Updated');
			              window.location.href='../pages/editDutyPo.php?type=duty&id=$particular[eDutyId]';
			              </SCRIPT>");	
					}else{
						echo ("<SCRIPT LANGUAGE='JavaScript'>
			              window.alert('Error updating PO Tracking'+".$stmt->error.");
			              window.location.href='../pages/editDutyPo.php?type=duty&id=$particular[eDutyId]';
			              </SCRIPT>");	
					}
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Updated');
		              window.location.href='../pages/editDuty.php?type=duty&id=$particular[eDutyId]';
		              </SCRIPT>");
				}			
			}else{				
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	              window.alert('Error '+".$stmt->error.");
	              window.location.href='../pages/editDuty.php?type=duty&id=$particular[eDutyId]';
	              </SCRIPT>");
				
			}
		}



		function deleteDuty($connection, $id){
			$success=false;
			$inwardNo="";
			$query="SELECT * FROM duty WHERE duty_id = ".$id."";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$inwardNo = $row["inward_no"];
				}
			}
			// $q = "DELETE FROM duty_particulars WHERE duty_inward_no=?";
			// $stmt = $connection->prepare($q);
			// $stmt->bind_param("i", $inwardNo);
			// $inwardNo = $inwardNo;
			// if($stmt->execute()){
			// 	$success= true;       
			// }else{
			// 	echo $stmt->error;
			// 	$success= false;
			// }

			$q = "DELETE FROM duty WHERE duty_id=?";
			$stmt = $connection->prepare($q);
			$stmt->bind_param("i", $id);
			$id = $id;
			if($stmt->execute()){
				$success= true;            
			}else{
				echo $stmt->error;
				$success= false;
			}

			return ($success)?true:false;
		}

		function deleteDutyParticular($connection,$id){
			$q = "DELETE FROM duty_particulars WHERE duty_particluar_id=?";
			$stmt = $connection->prepare($q);
			$stmt->bind_param("i", $id);
			$id = $id;
			if($stmt->execute()){
				echo "Deleted";
			}else{				
				echo "Error Deleting";
				
			}
		}

		function getDuty($connection, $id){
		    $dutyDetails="";
		    $partDetails=[];
		    $query = "select d.duty_id, d.bill_of_entry_no, d.bill_of_entry_date, d.invoice_no, d.euro_rate, d.inward_no, d.inward_date, d.inward_type,
                dp.duty_particluar_id,dp.part_no,dp.unit_rate_euro, dp.unit_rate_inr, dp.qty, dp.clearing_charges, dp.duty, dp.packaging, dp.forwarding_charges,
                dp.landed_cost_per_part, dp.total_landed_cost, v.company_name as vendor
                from duty d  LEFT JOIN duty_particulars dp on d.inward_no=dp.duty_inward_no
                LEFT JOIN vendors v on d.vendor=v.id
                WHERE d.duty_id=".$id;
            $result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$dutyDetails=array("duty_id"=>$row["duty_id"],"bill_of_entry_no"=>$row["bill_of_entry_no"],"bill_of_entry_date"=>$row["bill_of_entry_date"],
					"invoice_no"=>$row["invoice_no"],"euro_rate"=>$row["euro_rate"],"inward_no"=>$row["inward_no"],"inward_date"=>$row["inward_date"],
					"inward_type"=>$row["inward_type"],"vendor"=>$row["vendor"]);
		            $partDetails[]= array("duty_particluar_id"=>$row["duty_particluar_id"],"part_no"=>$row["part_no"],"unit_rate_euro"=>$row["unit_rate_euro"],
		            "unit_rate_inr"=>$row["unit_rate_inr"],"qty"=>$row["qty"],"clearing_charges"=>$row["clearing_charges"],"duty"=>$row["duty"],
		            "packaging"=>$row["packaging"],"forwarding_charges"=>$row["forwarding_charges"],"landed_cost_per_part"=>$row["landed_cost_per_part"],
		            "total_landed_cost"=>$row["total_landed_cost"]);
				}
			}
			echo json_encode(array("dutyDetails"=>$dutyDetails,"partDetails"=>$partDetails));
			
			/*$inwardNo="";
			$query="SELECT * FROM duty WHERE duty_id = ".$id."";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$inwardNo = $row["inward_no"];
				}
			}
			$parts=[];
			$q = "SELECT * FROM duty_particulars WHERE duty_inward_no='$inwardNo'";
			$result = $connection->query($q);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$parts[]= $row;
				}
			}

			$query="SELECT * FROM duty WHERE duty_id = ".$id."";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data= array('dutyDetails'=>$row,"partDetails"=>$parts);
				}
			}

			echo json_encode($data);*/
		}

		function getAllDuty($connection){
			$query="SELECT * FROM duty";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row;
				}
			}
			echo json_encode($data);
		}

		function getLastInwardNo($connection){
			$query="SELECT * FROM duty ORDER BY duty_id DESC LIMIT 1";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data = $row["inward_no"];
				}
			}
			echo $data;
		}

		function addDutyParticulars($connection, $particulars){
			$success=false;
			foreach ($particulars as $particular) {				
				$q = "INSERT INTO duty_particulars
				(duty_inward_no, part_no, unit_rate_euro, unit_rate_inr, qty, duty,
				clearing_charges, packaging, forwarding_charges, landed_cost_per_part,
				total_landed_cost)
				VALUES
				(?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $connection->prepare($q);
				$stmt->bind_param("ssddidddddd", $dutyInwaredNo, $partNo, $unitRateEUR,
					$unitRateINR, $qty, $duty, $clearing, $packaging, $forwarding, 
					$landedCostPerPart, $landedCost);
				$dutyInwaredNo = $particular->getDutyInwardNo();
				$partNo = $particular->getPartNo();
				$unitRateEUR = $particular->getUnitRateEuro();
				$unitRateINR = $particular->getUnitRateInr();
				$qty = $particular->getQty();
				$duty = $particular->getDuty();
				$clearing = $particular->getClearingCharges();
				$packaging = $particular->getPackaging();
				$forwarding = $particular->getForwardingCharges();
				$landedCostPerPart = $particular->getLandedCostPerPart();
				$landedCost = $particular->getTotalLandedCost();
				if($stmt->execute()){
					$success = true;
				}else{
					echo $stmt->error;
					$success = false;
				}
			}
			if($success){
				return true;       
			}else{
				return false;
			}
		}

		function updatePOTracking($connection, $po, $particulars){
			$success=false;
			//var_dump($po);//." ".$particulars);

			foreach ($particulars as $particular) {				
				$q = "UPDATE po_tracking SET received=? WHERE po_no=? AND part_no=?";
				$stmt = $connection->prepare($q);
				$stmt->bind_param("iii", $qty, $po,$partNo);
				$qty = $particular->getQty();
				$po = $po;
				$partNo = explode("-", $particular->getPartNo())[0];				
				if($stmt->execute()){
					$success = true;
				}else{
					echo $stmt->error;
					$success = false;
				}
			}
			if($success){
				return true;       
			}else{
				return false;
			}
		}

		function addDutyParticular($connection, $particular){				
			//var_dump($particular);
			$inward_type = "Under Warranty and other reason";
			$po = 0;
			if($duty["eAgainstPo"]=="true"){				;
				$po = $duty["po"];
				$inward_type = "Against PO";	
			}
			$q = "INSERT INTO duty_particulars
			(duty_inward_no, part_no, unit_rate_euro, unit_rate_inr, qty, duty,
			clearing_charges, packaging, forwarding_charges, landed_cost_per_part,
			total_landed_cost)
			VALUES
			(?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $connection->prepare($q);
			$stmt->bind_param("ssddidddddd", $dutyInwaredNo, $partNo, $unitRateEUR,
				$unitRateINR, $qty, $duty, $clearing, $packaging, $forwarding, 
				$landedCostPerPart, $landedCost);
			$dutyInwaredNo = $particular["inwardnoParticular"];
			$partNo = $particular["part"];
			$unitRateEUR = $particular["unitRateEuro"];
			$unitRateINR = $particular["unitRateInr"];
			$qty = $particular["qty"];
			$duty = $particular["duty"];
			$clearing = $particular["clearing"];
			$packaging = $particular["packaging"];
			$forwarding = $particular["forwarding"];
			$landedCostPerPart = $particular["landedPerPart"];
			$landedCost = $particular["totalLanded"];
			if($stmt->execute()){
				if($inward_type=="Against PO"){
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Added');
		              window.location.href='../pages/editDutyPo.php?type=duty&id=$particular[dutyId]';
		              </SCRIPT>");
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Added');
		              window.location.href='../pages/editDuty.php?type=duty&id=$particular[dutyId]';
		              </SCRIPT>");
				}
			}else{				
				if($inward_type=="Against PO"){
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Added');
		              window.location.href='../pages/editDutyPo.php?type=duty&id=$particular[dutyId]';
		              </SCRIPT>");
				}else{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
		              window.alert('Added');
		              window.location.href='../pages/editDuty.php?type=duty&id=$particular[dutyId]';
		              </SCRIPT>");
				}
				
			}
			
		}

		function getDutyParticulars($connection,$inward_no){
			$query="SELECT * FROM duty_particulars WHERE duty_inward_no='$inward_no'";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row;
				}
			}
			echo json_encode($data);
		}

		function getDutyParticular($connection,$id){
			$query="SELECT * FROM duty_particulars WHERE duty_particluar_id=$id";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data = $row;
				}
			}
			echo json_encode($data);
		}

		function getDutyParticularsPrice($connection,$inward_no,$part){
			$query="SELECT * FROM duty_particulars WHERE duty_inward_no='$inward_no' AND part_no='$part'";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data = $row;
					$data = array('duty_particluar_id' => $row["duty_particluar_id"],
						'duty_inward_no' => $row["duty_inward_no"],'part_no' => $row["part_no"],
						'desc'=>self::getPartDescription($connection, explode("-", $row["part_no"])[0]),
						'unit_rate_euro' => $row["unit_rate_euro"],'unit_rate_inr' => $row["unit_rate_inr"],
						'qty' => $row["qty"],'duty' => $row["duty"],
						'clearing_charges' => $row["clearing_charges"],'packaging' => $row["packaging"],
						'forwarding_charges' => $row["forwarding_charges"],'landed_cost_per_part' => $row["landed_cost_per_part"],
						'total_landed_cost' => $row["total_landed_cost"]);
				}
			}
			echo json_encode($data);
		}

		function getPartDescription($connection, $part){
			$query="SELECT * FROM inventory_parts WHERE id=$part";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data = $row["description"];
				}
			}
			return $data;
		}

		function updateLandedCost($connection,$parts){
			$success=false;
			foreach ($parts as $part) {				
				$q ="UPDATE inventory_parts SET landed_cost=? WHERE part_number=?";
				$stmt = $connection->prepare($q);
				$stmt->bind_param("ds", $landedCost,$partNo);
				$landedCost = $part->getLandedCostPerPart();
				$partNo = explode("-", $part->getPartNo())[1];
				if($stmt->execute()){
					$success = true;
				}else{
					echo $stmt->error;
					$success = false;
				}
			}
			if($success){
				return true;       
			}else{
				return false;
			}
		}
		function getDutyParticularId($connection,$invardNo){			
			$query="SELECT duty_id FROM duty WHERE inward_no='".$invardNo."'";
			$result = $connection->query($query);			
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					return $row['duty_id'];
				}
			}else{
				return 0;
			}
		}


		function updatePartQty($connection, $data){			
			$ids = explode(',',$data['ids']);
			foreach ($ids as $key=>$index) {
				$query="UPDATE `inventory_parts` SET `total`= total+".$data['quantity'.$index]." WHERE `part_number`= '".$data['partno'.$index]."' AND `location`!=''";
				$result = $connection->query($query);			
				/*if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						$partId = $row["id"];
					}
				}*/
			}
		}

		function addInventory($connection,$data){
			
			$mbs = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
			$ids = explode(',',$data['ids']);
			if(count($ids)>0){
				$dutyPerticularId = $this->getDutyParticularId($connection,$data['inwardNo']);
				$q ="INSERT INTO inventory (part_id, part_number, serial_number, timestamp, used, po_id, inward_no, ch_no, ch_date, import_date, clearing_charges, 
				bill_entry_no, returnable, created_by, created_on, modified_by, modified_on) VALUES(?,?,'',now(),0,?,?,0,'',?,?,?,?,?,now(),?,now())";
					$stmt = $connection->prepare($q);
				foreach ($ids as $key=>$index) {
					$total =(int) $data['quantity'.trim($index)];
					while($total > 0){
						if($data["againstPo"]=="true"){				
							$po = $_POST["po"];							
							/*$partid = $data['partid'.$index];
							$partNo = $data['partno'.$index];*/
						}else{												
							$po = 0;
							/*$partid = explode("-", $data['partno'.$index])[0];
							$partNo = explode("-", $data['partno'.$index])[1];*/							
						}
						$part = explode("-", $this->getPartForDutyParticular($connection,$data['partno'.$index]));
						$partid = $part[0];
						$partNo = $part[1];
						$stmt->bind_param("isiissdiss",$partid,$partNo,$po, $dutyPerticularId,$inwardDate, $clearing,
							$billEntryNo, $returnable, $cb, $mb);
						$partid = $partid;
						$partNo = $partNo;
						$po = $po;
						$dutyPerticularId=$dutyPerticularId;
						$inwardDate = $data['inwardDate'];
						$clearing = $data['clearing'.$index];
						$billEntryNo = $data['billOfEntryNo'];
						$returnable = 0;
						$cb = $mb = $mbs;
						if(!$stmt->execute()){
							die('Error:'.$connection->error);
						}
						$total--;
					}
				
				}
			}
		}
	}
?>