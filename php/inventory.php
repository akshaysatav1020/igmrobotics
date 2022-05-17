<?php
/**
 *
 */
  require_once "db.php";
  require "data/inventoryPartObject.php";
  require "data/inventoryWarehouseObject.php";
  require "updateServerDBVersion.php";
  class InventoryOperation{
    function addPart($connection, $inventoryObject){
      //var_dump($inventoryObject);
      $q = <<<EOD
      INSERT INTO inventory_parts
      (part_number, description, unit_price_euro, unit_price_inr, landed_cost, location, min, total, created_by, created_on, modified_by, modified_on, country)
      VALUES
      (?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()),?)
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssdddsiisss", $partno, $desc, $unitpriceeuro,$unitpriceinr,$landedcost, $location, $min, $total, $cb, $mb, $country);
      $partno = $inventoryObject->getPartNo();
      $desc = $inventoryObject->getDescription();
      $unitpriceeuro = $inventoryObject->getUnitPriceEuro();
      $unitpriceinr = $inventoryObject->getUnitPriceInr();
      $landedcost = $inventoryObject->getLandedCost();
      $location = $inventoryObject->getLocation();
      $min = $inventoryObject->getMin();
      $total = $inventoryObject->getTotal();
      $cb = $mb =  $_COOKIE["usermail"];
      $country = $inventoryObject->getCountry();
      if($stmt->execute()){
        //echo "Added todb";
        return true;
        /*$upSDB = new UpdateServerDBVersion();
            if($upSDB->updateDBVersion()){
          return true;
        }else{
              return false;
        }*/
      }else{
        echo $stmt->error;
        return false;
        
      }

    }
    function editPart($connection, $params){
        if($params["stockValue"]>0){
            self::stockChanges($connection, $params);
        }
        $q = "UPDATE inventory_parts SET part_number=?, description=?, unit_price_euro=?, unit_price_inr=?, landed_cost=?,location=?, modified_by=?, 
	        modified_on=(SELECT NOW()),country=? WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ssdddsssi", $partno, $desc, $unitpriceeuro,$unitpriceinr,$landedcost, $location, $mb, $country, $id);
        $partno = $params["epartno"];
        $desc = $params["edesc"];
        $unitpriceeuro = $params["erateeuro"];
        $unitpriceinr = $params["erateinr"];
        $landedcost = $params["elandedCost"];
        $location = $params["location"];
        $mb = $_COOKIE["usermail"];
        $country= $params["ecountry"];
        $id = $params["eid"];
        if($stmt->execute()){
            return true;        
        }else{
		    error_log(date("Y-m-d h:m:s")." Message==> ".$stmt->error."\n", 3, "../log/php_error.log");          
            return false;
        }
    }
    
    function stockChanges($connection, $params){
        $stockQty = $params["stockValue"];
        $partNo = $params["epartno"];
        $partId = $params["eid"];
        $returnable = ($params["location"]=="HPR-1")?0:1;
        $success = false;
        if($params["operation"]=="inc"){
            $qty=0;
            while($qty<$stockQty){
                $q = "INSERT INTO inventory (part_id,part_number,serial_number,timestamp,used,po_id,inward_no,ch_no,ch_date,import_date,
                    clearing_charges,bill_entry_no,returnable,created_by,created_on,modified_by,modified_on) VALUES
                    (?,?,'',(SELECT NOW()),0,0,0,'','','',0.00,'',0,?,(SELECT NOW()),?,(SELECT NOW()))";
                $stmt = $connection->prepare($q);
                $stmt->bind_param("isss", $part_id, $part_number, $cb, $mb);
                $part_id = $partId;
                $part_number = $partNo;
                $cb = $mb = $_COOKIE["usermail"];
                if($stmt->execute()){
                    $success = true;
                }else{
                    $success = false;
    		       error_log(date("Y-m-d h:m:s")." Message==> Error Decreasing stock".$stmt->error."\n", 3, "../log/php_error.log");          
                    
                }
                $qty+=1;
            }
            if($success){
                return true;
            }else{
                return false;
            }
        }else{
            $q = "UPDATE inventory SET used=1, returnable=?, modified_by=?, modified_on=(SELECT NOW()) WHERE part_id=? AND part_number=? AND used=0 LIMIT ?";
            //echo $q."-".$partNo."--".$partId."---".$stockQty;
            $stmt = $connection->prepare($q);
            $stmt->bind_param("isisi", $returnable, $mb, $partId, $partNo, $stockQty);
            $returnable = $returnable;
            $mb = $_COOKIE["usermail"];
            $partId = $partId;
            $partNo = $partNo;
            $stockQty = $stockQty;
            if($stmt->execute()){
               return true;        
            }else{
		       error_log(date("Y-m-d h:m:s")." Message==> Error Decreasing stock".$stmt->error."\n", 3, "../log/php_error.log");          
                return false;
            }  
        }
    }

  function editStockPart($connection, $stockpart){

      // getId getPo getTimestamp getUsed getPartNo getInvoiceNo getCb getCo
      $q = <<<EOD
      UPDATE inventory SET
      part_number=?,serial_number=?,timestamp=?,used=?,po_id=?,
      inv_id=?,modified_by=?,modified_on=?
      WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("sssisissi", $part_number,$serial_number,$timestamp,$used,$po_id,$inv_id,$mb,$mo, $id);
      $part_number = $stockpart->getPartNo();
      $serial_number = $stockpart->getSerialNo();
      $timestamp = $stockpart->getTimestamp();
      $used = $stockpart->getUsed();
      $po_id = $stockpart->getPo();
      $inv_id = $stockpart->getInvoiceNo();
      $mb = $stockpart->getMb();
      $mo = $stockpart->getMo();
      $id = $stockpart->getId();
      if($stmt->execute()){
        return true;
        /*$upSDB = new UpdateServerDBVersion();
        if($upSDB->updateDBVersion()){
          return true;
        }else{
          return false;
        }*/
      }else{
        return false;
      }
    }

    function getPartByPartNo($connection, $partId){
      $query="SELECT * FROM inventory_parts WHERE part_number=".$partId;
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'partno'=>$row['part_number'],
            'desc'=>$row['description'],'unitpriceeuro'=>$row['unit_price_euro'],
          'unitpriceinr'=>$row['unit_price_inr'],'location'=>$row['location'],
          'min'=>$row['min'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
        }
      }
     echo json_encode($data);

    }

    function getStockPart($connection, $id){
      $query="SELECT * FROM inventory WHERE id=".$id;
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'srno'=>$row['serial_number'],
            'partno'=>$row['part_number'],
          'time'=>$row['timestamp'],'used'=>$row['used'],
          'poid'=>$row['po_id'],'invid'=>$row['inv_id'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
        }
      }
      echo json_encode($data);

    }

    function getPart($connection, $id){
      $query="SELECT * FROM inventory_parts WHERE id=".$id;
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'partno'=>$row['part_number'],
            /*'desc'=>$row['description'],*/
			'desc'=>iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
						  'unitpriceeuro'=>$row['unit_price_euro'],
          'unitpriceinr'=>$row['unit_price_inr'],"landedcost"=>$row["landed_cost"],
          'location'=>$row['location'],'country'=>$row['country'],
          'min'=>$row['min'],'avail'=>$row['total'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
        }
      }
      echo json_encode($data);
    }    
	
	function getItemForParticular($connection,$params){
		if($params["for"]==="po"){
            $query="SELECT id,part_number,description,unit_price_euro,unit_price_inr FROM inventory_parts WHERE part_number LIKE '".$params['term']['term']."%' 
            AND (unit_price_euro!=0 OR unit_price_inr!=0)";      
            $result = $connection->query($query);
            $data = array();
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){			  
                    $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
                    $data[] = array('id'=>$row['id'],'text'=>$row['part_number'],'description'=>$desc,
                    "upe"=>$row["unit_price_euro"],"upi"=>$row["unit_price_inr"]);
                }
            }
            echo json_encode($data);
        }else{
            $query="SELECT * FROM inventory_parts WHERE part_number LIKE '".$params['term']['term']."%'";      
      	$result = $connection->query($query);
      	$data = array();
      	if($result->num_rows>0){
        	while($row=$result->fetch_assoc()){
				//echo $row['id'];
				$desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
				$data[] = array('id'=>$row['id'],'text'=>$row['part_number'],'description'=>$desc);
			}
	  	}
		echo json_encode($data);
        }
	}
	function getItemForParticularDC($connection,$params){
		//echo $params['term']['term'];
		$query="SELECT * FROM inventory_parts WHERE part_number LIKE '".$params['term']['term']."%'";      
      	$result = $connection->query($query);
      	$data = array();
      	if($result->num_rows>0){
        	while($row=$result->fetch_assoc()){
				//echo $row['id'];
				$desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
				$data[] = array('id'=>$row['id'],'text'=>$row['part_number'],'description'=>$desc,'country'=>$row['country']);
			}
	  	}
		echo json_encode($data);
	}
    function getAllPart($connection){
      ini_set('display_errors',1);
     $query="SELECT * FROM inventory_parts;";      
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          //echo $row['description']."<br/>";
        //   $data[] = array(
        //     'id'=>$row['id'],
        //     'partno'=>iconv(mb_detect_encoding($row['part_number'], mb_detect_order(), true), "UTF-8//IGNORE", $row['part_number']),
        //     'desc'=>iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
        //     'unitpriceeuro'=>$row['unit_price_euro'],
        //     'unitpriceinr'=>$row['unit_price_inr'],
        //     "landedcost"=>$row["landed_cost"],
        //     'location'=>iconv(mb_detect_encoding($row['location'], mb_detect_order(), true), "UTF-8//IGNORE", $row['location']),
        //     'min'=>$row['min'],
        //     'avail'=>$row['total'],
        //     'cb'=>iconv(mb_detect_encoding($row['created_by'], mb_detect_order(), true), "UTF-8//IGNORE", $row['created_by']),
        //     'co'=>$row['created_on'],
        //     'mb'=>iconv(mb_detect_encoding($row['modified_by'], mb_detect_order(), true), "UTF-8//IGNORE", $row['modified_by']),
        //     'mo'=>$row['modified_on'], 
        //     'country'=>iconv(mb_detect_encoding($row['country'], mb_detect_order(), true), "UTF-8//IGNORE", $row['country']),
        //   );
        // }
        $data[] = array(
          'id'=>$row['id'],
          'partno'=>$row['part_number'],
          'desc'=>iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
          'unitpriceeuro'=>$row['unit_price_euro'],
          'unitpriceinr'=>$row['unit_price_inr'],
          "landedcost"=>$row["landed_cost"],
          'location'=>$row['location'],
          'min'=>$row['min'],
          'avail'=>$row['total'],
          'cb'=>$row['created_by'], 
          'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],
          'mo'=>$row['modified_on'], 
          'country'=>$row['country'],
        );
      }
      }
      // $data=array('hi'=>'hello');
      // print_r($data);
      echo json_encode($data,JSON_ERROR_NONE);
      //echo json_last_error_msg();
      //die;
    }

    function getStocks($connection){
      //$query = "SELECT a.part_number, COUNT(*) as count, b.location,b.description, b.min FROM inventory a, inventory_parts b WHERE a.part_number = b.part_number AND a.used=0 GROUP BY  a.part_number LIMIT 50";
      //$query = "SELECT * FROM inventory_parts";
      $query = "SELECT SUM(total) as avail,SUM(min) as minimum, part_number, description, GROUP_CONCAT(location) as Location,country FROM inventory_parts GROUP BY part_number";
        $result = $connection->query($query);
        $data = array();
        //echo $result->num_rows;
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            // $data[] = array('id'=>$row['id'],'partno'=>$row['part_number'],'desc'=>$row['description'],
            // 'unitprice'=>$row['unit_price'],'location'=>$row['location'],
            // 'min'=>$row['min'],'avail'=>$row['min'],
            // 'cb'=>$row['created_by'],'co'=>$row['created_on'],
            // 'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
            // $data[] = array("part"=>$row["part_number"],"total"=>$row["total"], "location"=>$row["location"], 
            // "desc"=>$row["description"],"min"=>$row["min"]);
            $data[] = array("part"=>$row["part_number"], "avail"=>$row["avail"], 
            "desc"=>$row["description"],"min"=>$row["minimum"],"location"=>$row["Location"],"country"=>$row["country"]);
          }
        }
        echo json_encode($data);
      }

    function getWarehouseStocks($connection){
      $query = "SELECT * FROM inventory";
        $result = $connection->query($query);
        $data = array();
        //echo $result->num_rows;
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            // $data[] = array('id'=>$row['id'],'partno'=>$row['part_number'],'desc'=>$row['description'],
            // 'unitprice'=>$row['unit_price'],'location'=>$row['location'],
            // 'min'=>$row['min'],'avail'=>$row['min'],
            // 'cb'=>$row['created_by'],'co'=>$row['created_on'],
            // 'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
            $data[] = array("id"=>$row["id"],"part"=>$row["part_number"],"srno"=>$row["serial_number"],"po"=>$row["po_id"],"inv"=>$row["inv_id"]);
          }
        }
        echo json_encode($data);
    }

    function deletePart($connection, $inventoryId){
      $q = <<<EOD
      DELETE FROM inventory_parts WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("i", $id);
      $id = $inventoryId;
      if($stmt->execute()){
        return true;        
      }else{
        return false;
      }
    }

   function importParts($connection, $file,$time){
      include("../phplibraries/phpexcel/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
      $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
      ini_set('max_execution_time', 0);
      $success = false;
      $r = 1;
      $cb = $mb = $_COOKIE["usermail"];
      $query = <<<EOD
      INSERT INTO
      inventory_parts
      (part_number, description, unit_price_euro,unit_price_inr,landed_cost, location, min, total, created_by, created_on, modified_by, modified_on, country)
      VALUES
      ( ?, ?, ?, ?,?, ?,?, ?, '$cb', (SELECT NOW()), '$cb', (SELECT NOW()), ?)
EOD;
      $stmt = $connection->prepare($query);
      $stmt->bind_param("ssdddsiis", $partno, $description, $unitPriceEuro,
        $unitPriceInr,$landedCost,  $location, $min,$total,$country);
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
        $highestRow = $worksheet->getHighestDataRow();
        for($row=2; $row<=$highestRow; $row++){
          $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
          if($p!=""){
            $r++;
          }
        }
        // echo $r;
        for($i=2;$i<=$r;$i++){        
            $partno = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue()));

            $description = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue()));

            $unitPriceEuro = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue()));

            $unitPriceInr = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue()));

            $landedCost = floatval(ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $i)->getValue())));

            $location = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $i)->getValue()));

            $min = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue()));

            $total = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $i)->getValue()));

            //$avg = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue()));
            
            $country = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $i)->getValue()));
            
            // echo $partno." ".$description." ".$unitPrice." ".$location." ".$qty." ".$avg." ".$country;
            $partno = ltrim($partno);
            $description = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $description);
            $unitPriceEuro = ltrim($unitPriceEuro);
            $unitPriceInr = ltrim($unitPriceInr);
            $avg = ltrim($avg);
            //$min = $min; 
            $location = ltrim($location);
            $country = ltrim($country);
            if($stmt->execute()){
              $partid=0;
              $query = "SELECT id FROM inventory_parts ORDER BY id DESC LIMIT 1";
              $result = $connection->query($query);              
              if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                  $partid = $row["id"];
                }
              }
              if(self::addStock($connection, $partid, $partno, $total)){
                $success = true;
              }
            }else{
                          
              $success = false;
            }
            // mysqli_query($connection, $query);
          }
      }
      if($r>=2 && $success){
        return true;        
      }else{
        echo $stmt->error;
        return false;
      }
    }
	  
	function wipeimportParts($connection, $file,$time){
		echo "Wiped and imported";
      /*include("../phplibraries/phpexcel/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
      $objPHPExcel = PHPExcel_IOFactory::load($file); 
      ini_set('max_execution_time', 0);
      $success = false;
      $r = 1;
      $cb = $mb = $_COOKIE["usermail"];
	  //DELETE Previous Records
		$q = "DELETE FROM inventory_parts WHERE 1";
      $stmt = $connection->prepare($q);      
      
      if($stmt->execute()){
        $success = true;        
      }else{
        $success = false;
      }
	  //SET Auto Increment to previous
      $query ="ALTER table inventory_parts AUTO_INCREMENT=5349";
      $stmt = $connection->prepare($query);      
      
      if($stmt->execute()){
        $success = true;        
      }else{
        $success = false;
      }
      $idinc = 5349;
	  //IMPORT New List
      $query = <<<EOD
      INSERT INTO
      inventory_parts
      (part_number, description, unit_price_euro,unit_price_inr,landed_cost, location, min, total, created_by, created_on, modified_by, modified_on, country)
      VALUES
      ( ?, ?, ?, ?,?, ?,?, ?, '$cb', (SELECT NOW()), '$cb', (SELECT NOW()), ?)
EOD;
      $stmt = $connection->prepare($query);
      $stmt->bind_param("ssdddsiis", $partno, $description, $unitPriceEuro,
        $unitPriceInr,$landedCost,  $location, $min,$total,$country);
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
        $highestRow = $worksheet->getHighestDataRow();
        for($row=2; $row<=$highestRow; $row++){
          $p = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
          if($p!=""){
            $r++;
          }
        }
        
        for($i=2;$i<=$r;$i++){        
            $partno = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $i)->getValue()));

            $description = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $i)->getValue()));

            $unitPriceEuro = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $i)->getValue()));

            $unitPriceInr = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $i)->getValue()));

            $landedCost = floatval(ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $i)->getValue())));

            $location = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $i)->getValue()));

            $min = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $i)->getValue()));

            $total = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $i)->getValue()));
            
            
            $country = ltrim(mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $i)->getValue()));
            
            $partno = ltrim($partno);
            $description = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $description);
            $unitPriceEuro = ltrim($unitPriceEuro);
            $unitPriceInr = ltrim($unitPriceInr);
            $min = $min;            
            $location = ltrim($location);
            $country = ltrim($country);
            if($stmt->execute()){              
              if(self::addStock($connection, $idinc;, $partno, $total)){
                $success = true;
				$idinc++;
              }
            }else{                          
              $success = false;
            }            
          }
      }
      if($r>=2 && $success){
        return true;        
      }else{
        echo $stmt->error;
        return false;
      }*/
    }

    function addStock($connection, $partid, $part, $qty){
      $count=0;
      $success=false;
      $user=$_COOKIE["usermail"];
      while($count<$qty){
        $query = <<<EOD
      INSERT INTO inventory (part_id, part_number, serial_number, timestamp, used, po_id, inward_no, ch_no, ch_date, import_date, clearing_charges, 
      bill_entry_no, returnable, created_by, created_on, modified_by, modified_on) 
      VALUES (?,?,'',(SELECT NOW()),0,0,0,0,'','','0.00','',0,'$user',(SELECT NOW()),'$user',(SELECT NOW()))
EOD;
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $partid, $part);
        $partid=$partid;
        $part=$part;
        if($stmt->execute()){
          $success = true;
        }else{
          $success = false;
        }
        $count++;
      }
      if($success){
        return true;
      }else{
        return false;
      }
    }

  }

if($_POST!=null){
  $db = new DB();
  $d = new DateTime();
  $inventory = new InventoryOperation();
  $cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
  //partno unitprice rack column description addInventory
  if(isset($_POST["addInventory"])){
    $partNo = $_POST['partno'];
    $description = $_POST['description'];
    $unitPriceEuro = $_POST['unitpriceeuro'];
    $unitPriceInr = $_POST['unitpriceinr'];
    $landedcost = $_POST["landedcost"];
    $min = $_POST['min'];
    $location = $_POST['rack']."-".$_POST['column'];
    $country = $_POST['country'];
    $inventoryObject=new InventoryPart($partNo,$description,$unitPriceEuro,
      $unitPriceInr, $landedcost,$location,$min,0,$country);
    if($inventory->addPart($db->getConnection(), $inventoryObject)){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      localStorage.removeItem('parts');
              window.alert('Added');
              window.location.href='../pages/parts.php';
              </SCRIPT>");
    }else{
      echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Adding')
              window.location.href='../pages/parts.php';
              </SCRIPT>");
    }
  }else if(isset($_POST["editInventory"])){
	  //echo "<pre>";var_dump($_POST);echo "</pre>";
	  if($inventory->editPart($db->getConnection(), $_POST)){
      		echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Edited')
              window.location.href='../pages/parts.php';
              </SCRIPT>");
		}else{
		  echo ("<SCRIPT LANGUAGE='JavaScript'>
		  		window.alert('Error Editing')
				window.location.href='../pages/parts.php';
				</SCRIPT>");
		}
  }else if(isset($_POST["getInventory"])){
    $inventory->getPart($db->getConnection(), $_POST['inventoryId']);
  }else if(isset($_POST["getAllInventory"])){    
    $inventory->getAllPart($db->getConnection());
  }else if(isset($_POST['getItemForParticular'])){
	$inventory->getItemForParticular($db->getConnection(),$_POST);  
  }else if(isset($_POST['getItemForParticularDC'])){
	$inventory->getItemForParticularDC($db->getConnection(),$_POST);  
  }else if(isset($_POST["deleteInventory"])){
    if($inventory->deletePart($db->getConnection(), $_POST['inventoryId'])){
      echo "Deleted";
    }else{
      echo "Error Deleting";
    }
  }else if(isset($_POST["importparts"])){
    $tmp = explode(".", $_FILES["partsexcel"]["name"]);
    $extension = end($tmp); // For getting Extension of selected file
    $connect = $db->getConnection();//mysqli_connect("localhost", "root", "root", "igm1");
    $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
    $time = $d->format('Y-m-d H:i:s');
    if(in_array($extension, $allowed_extension)){
      $file = $_FILES["partsexcel"]["tmp_name"]; // getting temporary source of excel file      
      if($inventory->importParts($db->getConnection(), $file, $time)){
       echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Imported')
            window.location.href='../pages/parts.php';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Importing!! Contact Admin')
            window.location.href='../pages/parts.php';
            </SCRIPT>");
      }
      
    }
    else{
     echo "Error importing<br/><a href='../../../pages/parts.php'>Back to Dashboard</a>";
    }
  }else if(isset($_POST["wipeimportparts"])){
    $tmp = explode(".", $_FILES["partsexcel"]["name"]);
    $extension = end($tmp); // For getting Extension of selected file
    $connect = $db->getConnection();//mysqli_connect("localhost", "root", "root", "igm1");
    $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
    $time = $d->format('Y-m-d H:i:s');
    if(in_array($extension, $allowed_extension)){
      $file = $_FILES["partsexcel"]["tmp_name"]; // getting temporary source of excel file      
      if($inventory->wipeimportParts($db->getConnection(), $file, $time)){
       echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Imported')
            window.location.href='../pages/parts.php';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Importing!! Contact Admin')
            window.location.href='../pages/parts.php';
            </SCRIPT>");
      }
      
    }
    else{
     echo "Error importing<br/><a href='../../../pages/parts.php'>Back to Dashboard</a>";
    }
  }else if(isset($_POST['importstocks'])){
    $tmp = explode(".", $_FILES["stocksexcel"]["name"]);
    $extension = end($tmp); // For getting Extension of selected file
    $connect = mysqli_connect("localhost", "root", "", "igm");
    $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
    $time = $d->format('Y-m-d H:i:s');
    if(in_array($extension, $allowed_extension)){
      $file = $_FILES["stocksexcel"]["tmp_name"]; // getting temporary source of excel file
      include("../phplibraries/phpexcel/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
      $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
        $highestRow = $worksheet->getHighestDataRow();
        $r = 1;
        for($row=2; $row<=$highestRow; $row++){
          $p = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
          if($p!=""){
            $r++;
          }
        }
        for($i=2;$i<=$r;$i++){
            $partno = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $i)->getValue());
            $serialno = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $i)->getValue());
            $poId = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $i)->getValue());
            $invId = 0;
            $query = <<<EOD
            INSERT INTO
            inventory
            (part_number, serial_number, timestamp, used, po_id, inv_id, created_by, created_on, modified_by, modified_on)
            VALUES
            ( '$partno', '$serialno', '$time',0,$poId, $invId, '$cb', '$time', '$cb', '$time' )
EOD;
            echo $query;
            mysqli_query($connect, $query);
          }
      }
      echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Imported')
            window.location.href='../pages/inventory.php';
            </SCRIPT>");
    }
    else{
     echo "Error importing<br/><a href='../pages/inventory.php'>Back to Dashboard</a>";
    }
  }else if(isset($_POST["getStocks"])){
    $inventory->getStocks($db->getConnection());    
      //echo json_encode($data);
    // SELECT id,part_number, COUNT(*) FROM inventory WHERE used=0 GROUP BY part_number
    // SELECT a.part_number, COUNT(*), b.location,b.description, b.min FROM inventory a, inventory_parts b WHERE a.part_number = b.part_number AND a.used=0 GROUP BY a.part_number
    // SELECT a.part_number, COUNT(a.*), b.location FROM inventory  a, inventoy_parts  b WHERE a.part_number= b.part_nummber AND a.used=0 GROUP BY a.part_number
  }else if(isset($_POST["getWarehouseStocks"])){
    $inventory->getWarehouseStocks($db->getConnection());
  }else if(isset($_POST["getstock"])){
    $inventory->getStockPart($db->getConnection(),$_POST["stockId"]);
  }else if(isset($_POST["editstock"])){
    // eserno epartno epono  einvno
    $stockPart = new InventoryWarehouse($_POST["eid"], $_POST["eserno"], $_POST["epono"], $d->format('Y-m-d H:i:s'), $_POST["eused"], $_POST["epartno"], $_POST["einvno"], "agsatav@gamail.com", $d->format('Y-m-d H:i:s'));
    if($inventory->editStockPart($db->getConnection(),$stockPart)){
      echo "Part Updated";
    }else{
      echo "Error Updating Part";
    }
  }  

}




/*

$connect = mysqli_connect("localhost", "root", "", "test");
$output = '';
if(isset($_POST["import"]))
{
 $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<label class='text-success'>Data Inserted</label><br /><table class='table table-bordered'>";
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {
    $output .= "<tr>";
    $name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
    $query = "INSERT INTO tbl_excel(excel_name, excel_email) VALUES ('".$name."', '".$email."')";
    mysqli_query($connect, $query);
    $output .= '<td>'.$name.'</td>';
    $output .= '<td>'.$email.'</td>';
    $output .= '</tr>';
   }
  }
  $output .= '</table>';

 }
 else
 {
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}

*/
?>
