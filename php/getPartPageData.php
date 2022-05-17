<?php
include("../php/constants.php");
ini_set("display_errors",0);
//var_dump($_POST);
$fetchAll = ($_GET['page']=='all');
$draw = ($fetchAll) ? 0 : $_POST['draw'];
//$row = $_POST['start'];
$row = ($fetchAll) ? 0 : $_POST['start'];
$rowperpage = ($fetchAll)? 999999999 : $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchQuery = " ";
if($searchValue != ''){
	$col = explode(' ', $searchValue);
   //echo is_array($col);
	if(is_array($col)){
      $column_name = "";
      switch($col[0]){
        case 'part':
          $column_name = "part_number";
          break;
        case 'location':
          $column_name = "location";
		  $columnName="location";
		  $columnSortOrder="asc";
          break;
        case 'country':
          $column_name = "country";
          break;
		 case 'desc':
          $column_name = "description";			  
          break;
      }	   
      $searchQuery = " WHERE  (ip.".$column_name." like '%".$col[1]."%') "; 
	  //echo $searchQuery;
   }/*else{    
     $searchQuery = " and (ip.part_number like '%".$searchValue."%' or 
     ip.description like '%".$searchValue."%' or 
     ip.location like '%".$searchValue."%' or 
     ip.unit_price_euro like '%".$searchValue."%' or 
     ip.unit_price_inr like '%".$searchValue."%' or 
     ip.landed_cost like '%".$searchValue."%' or 
     ip.country like'%".$searchValue."%' ) ";
	   //echo $searchQuery;
   }*/
   /*$searchQuery = " and (part_number like '%".$searchValue."%' or 
   description like '%".$searchValue."%' or 
   location like '%".$searchValue."%' or 
   unit_price_euro like '%".$searchValue."%' or 
   unit_price_inr like '%".$searchValue."%' or 
   landed_cost like '%".$searchValue."%' or 
   country like'%".$searchValue."%' ) ";*/
}
$connection = new mysqli(HOST, USER, PASSWORD, DB);               

//Total number of records without filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM inventory_parts ip");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

//Total number of record with filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM inventory_parts ip WHERE 1  ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

//Fetch records
$limitPart = ($fetchAll) 
               ?'' 
               : " limit ".$row.",".$rowperpage;
$orderBy = !empty($columnName)?' order by '.$columnName.' '. $columnSortOrder : ' ';
$partQuery="SELECT ip.id, ip.part_number, ip.description, ip.min, (select 
count(i.id) from inventory i Where i.part_id=ip.id and i.used=0 group by i.part_id) as act, ip.location, ip.country from `inventory_parts` ip".$searchQuery." ".$orderBy;
//$partQuery = "select ip.*, COUNT(i.id) as act from u373423713_igm_test.inventory_parts ip LEFT JOIN u373423713_igm_test.inventory i ON ip.part_number=i.part_number
//AND ip.id=i.part_id  ". $searchQuery . " GROUP BY ip.id ". $orderBy;
//$partQuery = "select ip.*, COUNT(i.id) as act from igm_test.inventory_parts ip LEFT JOIN igm_test.inventory i ON ip.part_number=i.part_number
//AND ip.id=i.part_id  ". $searchQuery . " GROUP BY ip.part_number ". $orderBy;
$partRecords = mysqli_query($connection, $partQuery);
$data = array();
$totalRecords = $totalRecordwithFilter = 0;
if($fetchAll){
   while ($row = mysqli_fetch_assoc($partRecords)) {
   		$totalRecords = $totalRecordwithFilter +=1;
   }
}else{
	while ($row = mysqli_fetch_assoc($partRecords)) {
   		$totalRecords = $totalRecordwithFilter +=1;
	}
}
$partQuery="SELECT ip.id, ip.part_number, ip.description, ip.unit_price_euro, ip.unit_price_inr, ip.landed_cost, ip.min, ip.total, (select count(i.id) from inventory i Where i.part_id=ip.id and i.used=0 group by i.part_id) as act, ip.location, ip.country from `inventory_parts` ip".$searchQuery." ".$orderBy.$limitPart;
//$partQuery = "SELECT * from inventory_parts where 1 " . $searchQuery . $orderBy . $limitPart;
//$partQuery = "select ip.*, COUNT(i.id) as act from igm_test.inventory_parts ip LEFT JOIN igm_test.inventory i ON ip.part_number=i.part_number
//AND ip.id=i.part_id   ". $searchQuery . " GROUP BY ip.part_number ". $orderBy ." ". $limitPart;
//$partQuery = "select ip.*, COUNT(i.id) as act from u373423713_igm_test.inventory_parts ip LEFT JOIN u373423713_igm_test.inventory i ON ip.part_number=i.part_number
//AND ip.id=i.part_id   ". $searchQuery . " GROUP BY ip.id ". $orderBy ." ". $limitPart;
$partRecords = mysqli_query($connection, $partQuery);
$data = array();
//echo $partQuery;
if($fetchAll){
   while ($row = mysqli_fetch_assoc($partRecords)) { 
       $avQty=0;
       if($row['act']!=""){
           $avQty=$row['act'];
       }
      $data[] = array(
               iconv(mb_detect_encoding($row['part_number'], mb_detect_order(), true), "UTF-8//IGNORE", $row['part_number']),
               iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
               //$row['unit_price_euro'],
               //$row['unit_price_inr'],
               //$row["landed_cost"],
               iconv(mb_detect_encoding($row['location'], mb_detect_order(), true), "UTF-8//IGNORE", $row['location']),
               //$row['min'],
               $row['total'],
		       $avQty,
               iconv(mb_detect_encoding($row['country'], mb_detect_order(), true), "UTF-8//IGNORE", $row['country']),
           );
   }

} else {
	
   while ($row = mysqli_fetch_assoc($partRecords)) {
   	  $avQty=0;
       if($row['act']!=""){
           $avQty=$row['act'];
       }
      $data[] = array(
               'id'=>$row['id'],
               'part_number'=>iconv(mb_detect_encoding($row['part_number'], mb_detect_order(), true), "UTF-8//IGNORE", $row['part_number']),
               'description'=>iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
               'unitprice_euro'=>$row['unit_price_euro'],
               'unitprice_inr'=>$row['unit_price_inr'],
               "landed_cost"=>$row["landed_cost"],
               'location'=>iconv(mb_detect_encoding($row['location'], mb_detect_order(), true), "UTF-8//IGNORE", $row['location']),
               'min'=>$row['min'],
               'total'=>$row['total'],
		       'act'=>$avQty,
               'cb'=>iconv(mb_detect_encoding($row['created_by'], mb_detect_order(), true), "UTF-8//IGNORE", $row['created_by']),
               'co'=>$row['created_on'],
               'mb'=>iconv(mb_detect_encoding($row['modified_by'], mb_detect_order(), true), "UTF-8//IGNORE", $row['modified_by']),
               'mo'=>$row['modified_on'], 
               'country'=>iconv(mb_detect_encoding($row['country'], mb_detect_order(), true), "UTF-8//IGNORE", $row['country']),
           );
   }

}

//Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
  );
  
  echo json_encode($response);