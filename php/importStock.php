<?php
include 'includes/session.php';
include "../phpexcel/PHPExcel/IOFactory.php";
if($_POST!=null){
	if(isset($_POST["importstock"])){
			$extension = explode(".", $_FILES["file"]["name"])[1];
			$allowed_extension =  array("xls", "xlsx", "csv");
			if(in_array($extension, $allowed_extension)){
				ini_set('max_execution_time', 0);
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES["file"]["tmp_name"]);
			$r = 1;
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestDataRow();
		        for($row=1; $row<=$highestRow; $row++){
		          $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		          if($p!=""){
		            $r++;
		          }
		        }
        		$stmt = $conn->prepare("INSERT INTO product_stock(product, bar_code, sold) VALUES (:product, :bar_code, :sold)");
		        for($i=1;$i<=$r;$i++){
            		$prodName = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue());            		
            		$product = getId($prodName, $i, 0);
            		$bar_code = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue());
            		$sold =0;
            		
            		if($stmt->execute(["product"=>$product, "bar_code"=>$bar_code, "sold"=>$sold])){
            			$success = true;
            		}else{
            			$success = false;
            		}					
            	}
			}
		}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			          window.alert('File type not readable!!');
			          window.location.href='../pages/error.php';
			          </SCRIPT>");
		}
	}
}

function getId($value,$rowCount,$columnCount){
	$conn = $pdo->open();
	if($colCount==0){
		$stmt = $conn->prepare("SELECT  name FROM products WHERE id=:id");
		$stmt->execute(['id'=>$value]);
	}else{

	}
	mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue())
}

?>