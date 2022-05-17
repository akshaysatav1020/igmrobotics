<?php

	/*
	SELECT * FROM `invoice` WHERE date between "2018-02-03" AND "2019-06-13"

	SELECT SUM(qty) FROM `invoice_products` WHERE partId="4085" AND invId IN (SELECT id FROM `invoice` WHERE date between "2018-02-03" AND "2019-06-13")

	SELECT SUM(qty), partId FROM `invoice_products` WHERE partId IN (SELECT id FROM inventory_parts) AND invId IN (SELECT id FROM `invoice` WHERE date between "2018-02-03" AND "2019-06-13") GROUP BY partId
	*/

include("db.php");
if($_POST!=null){
	$db = new DB();
	$report = new Report();
	$connection = $db->getConnection();
	if(isset($_POST["getReport"])){
		$report->getReport($connection,$_POST["startDate"],$_POST["endDate"],$_POST["type"]);
	}
}else{

}
	
	class Report{
		
		function getReport($connection, $startDate,$endDate,$type){
			
			$allParts = array();
			/*$query="SELECT id FROM inventory_parts";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row;
					$allParts[] = $row["id"];
				}
			}*/			
			$consumedQty = array();
			$consumedParts = array();
			$query="SELECT SUM(qty) as c, partId FROM `invoice_products` WHERE partId IN (SELECT id FROM inventory_parts) AND invId IN (SELECT id FROM `invoice` WHERE date between '".$startDate."' AND '".$endDate."') GROUP BY partId";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row;
					$consumedParts[] = $row["partId"];
					$consumedQty[$row["partId"]] = $row["c"];
				}
			}

			if($type=="Tabular"){
				$report = array();
				$query="SELECT id,part_number,total,unit_price_inr, landed_cost FROM inventory_parts";
				$result = $connection->query($query);
				$data = array();
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						if(in_array($row["id"], $consumedParts)){
							$profit = floatval((floatval($row["landed_cost"])-floatval($row["unit_price_inr"]))*$consumedQty[$row["id"]]);
							$available = intval($row["total"])-intval($consumedQty[$row["id"]])>0?intval($row["total"])-intval($consumedQty[$row["id"]]):0;
							$report[] = array("partNo" => $row["part_number"],
							"available"=>$available,"consumed"=>$consumedQty[$row["id"]],"profit"=>$profit);
						}else{
							$profit = floatval((floatval($row["landed_cost"])-floatval($row["unit_price_inr"]))*$row["total"]);
							$report[] = array("partNo" => $row["part_number"],
							 "available"=>$row["total"], "consumed"=>0,"profit"=>$profit);
						}
					}
				}
				echo json_encode($report);
			}else{
				$data=[];
	            $query = <<<EOD
	            SELECT id,part_number,total,unit_price_inr, landed_cost FROM inventory_parts	            
EOD;
				$categories=[];
	            //echo $query;
	            $stmt = $connection->prepare($query);            
	            if($stmt->execute()){           
	                $result = $stmt->get_result();
	                if($result->num_rows>0){
	                    $info=new stdClass();
	                    $info->name= "Consumption";
	                    $info->colorByPoint= true;
	                    $info->data= array();
	                    while($row=$result->fetch_assoc()){
	                        if(in_array($row["id"], $consumedParts)){
								/*$profit = floatval((floatval($row["landed_cost"])-floatval($row["unit_price_inr"]))*$consumedQty[$row["id"]]);
								$available = intval($row["total"])-intval($consumedQty[$row["id"]])>0?intval($row["total"])-intval($consumedQty[$row["id"]]):0;
								$report[] = array("partNo" => $row["part_number"],
								"available"=>$available,"consumed"=>$consumedQty[$row["id"]],"profit"=>$profit);*/
								$categories[]=array(floatval(floatval($consumedQty[$row["id"]])));	                        
		                        $info->data[]=array("name"=>$row["part_number"],"y"=>floatval($consumedQty[$row["id"]]));	                        
							}else{
								/*$profit = floatval((floatval($row["landed_cost"])-floatval($row["unit_price_inr"]))*$row["total"]);
								$report[] = array("partNo" => $row["part_number"],
								 "available"=>$row["total"], "consumed"=>0,"profit"=>$profit);*/
							 	//$categories[]=$row["part_number"];
							 	//$data["barGraph"] = array(floatval(floatval(0.00)));	                        
		                        //$info->data[]=array("name"=>$row["part_number"],"y"=>floatval("0"));	                        
							}
		                    $data["barGraph"] = $categories;
	                        $data["pieGraph"] =array($info);
	                    }
	                    $data["barCategories"]=$categories;
	                }
	                echo json_encode($data);
	            }else{
	                echo $stmt->error();
	            }
				//echo json_encode("");
			}

			
		}
	}
?>