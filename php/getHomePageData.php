<?php
include("../php/constants.php");
ini_set("display_errors",0);
//var_dump($_POST);
$fetchAll = (isset($_GET['page']))?($_GET['page']=='all'):"";
/*$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page*/
$draw = ($fetchAll) ? 0 : $_POST['draw'];
$row = ($fetchAll) ? 0 : $_POST['start'];
$rowperpage = ($fetchAll)? 999999999 : $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (part_number like '%".$searchValue."%' or 
   description like '%".$searchValue."%' or 
   country like'%".$searchValue."%' ) ";
}
$connection = new mysqli(HOST, USER, PASSWORD, DB);               

//Total number of records without filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM view_parts_details_new");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

//Total number of record with filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM view_parts_details_new WHERE 1  ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

$limitPart = ($fetchAll)?'':" limit ".$row.",".$rowperpage;

$orderBy = !empty($columnName)?' order by '.$columnName.' '. $columnSortOrder : '';

//Fetch records

  $partQuery = "SELECT * from view_parts_details_new where 1 ".$searchQuery.$orderBy.$limitPart;

$partRecords = mysqli_query($connection, $partQuery);
// echo $partQuery;
$data = array();
if($fetchAll){
   while ($row = mysqli_fetch_assoc($partRecords)) {
     $data[] = array( 
        iconv(mb_detect_encoding($row['part_number'], mb_detect_order(), true), "UTF-8//IGNORE", $row['part_number']),
        iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
        //$row['count'],
        $row['min'],
		$row['mtot'],
        iconv(mb_detect_encoding($row['location'], mb_detect_order(), true), "UTF-8//IGNORE", $row['location']),
        iconv(mb_detect_encoding($row['country'], mb_detect_order(), true), "UTF-8//IGNORE", $row['country']),
    );    
  }    

}else{

   while ($row = mysqli_fetch_assoc($partRecords)) {
     $data[] = array( 
        "part_number"=>iconv(mb_detect_encoding($row['part_number'], mb_detect_order(), true), "UTF-8//IGNORE", $row['part_number']),
        "description"=>iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']),
        "count"=>$row['count'],
        "min"=>$row['min'],
		 "mtot"=>$row['mtot'],
        "location"=>iconv(mb_detect_encoding($row['location'], mb_detect_order(), true), "UTF-8//IGNORE", $row['location']),
        "country"=>iconv(mb_detect_encoding($row['country'], mb_detect_order(), true), "UTF-8//IGNORE", $row['country']),
     );
  }
//Response
}
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
  );
  
  echo json_encode($response);