<?php
require_once ("../phplibraries/phpexcel/PHPExcel/IOFactory.php");
include("../php/constants.php");
if(isset($_POST['update'])){
	$connection = new mysqli(HOST, USER, PASSWORD, DB);
	//var_dump($_FILES);
	$file = $_FILES["file"]["tmp_name"];			
            $success=false;
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$r = 1;
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestDataRow();
		        for($row=2; $row<=$highestRow; $row++){
		          $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		          //echo $p."<br/>";
					if($p!=""){
		            $r++;
					
		          }					
		        }
				//echo $r;
		        for($i=2;$i<=$r;$i++){
					
            		$euro = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue());            		
					$inr = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue());
            		$landed_cost = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $i)->getValue());
                    $part_number = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue());
                    $query = <<<EOD
		    		UPDATE inventory_parts SET unit_price_euro=?, unit_price_inr=?, landed_cost=? WHERE part_number=? AND location=''
EOD;
					$stmt = $connection->prepare($query);
					$stmt->bind_param("ddds", $euro, $inr, $landed_cost, $part_number);
					
					$euro = $euro;
                    $inr = $inr;
                    $landed_cost = $landed_cost;
                    $part_number = $part_number;
					
					//echo $euro." ".$inr." ".$landed_cost." ".$part_number."<br/>";
					if($stmt->execute()){
						$success = true;
					}
            		else{
            			$success = false;
            		}
            	}
			}			
		echo $success;
}
?>
<form method="post" action="#" enctype="multipart/form-data">
<input type="file" name="file"/>
	<button type="submit" name="update">Submit</button>	
</form>