<?php
include("../php/constants.php");
ini_set("display_errors",0);
$fetchAll = (isset($_GET['page']) && $_GET['page']=='all');
$draw = $_POST['draw'];
$row = ($fetchAll) ? 0 : $_POST['start'];
$rowperpage = ($fetchAll)? 999999999 : $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (part_number like '%".$searchValue."%' or part_number like '%".$searchValue."%' or ch_date like '%".$searchValue."%') ";
}
$connection = new mysqli(HOST, USER, PASSWORD, DB);               

//Total number of records without filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM inventory");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

//Total number of record with filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM inventory WHERE 1  ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

//Fetch records
$limitPart = ($fetchAll) 
               ?'' 
               : " limit ".$row.",".$rowperpage;
$orderBy = !empty($columnName)?' order by '.$columnName.' '. $columnSortOrder.' ' : ' ';
$partQuery = "SELECT * from inventory where 1 ".$searchQuery . $orderBy  . $limitPart;
$partRecords = mysqli_query($connection, $partQuery);
$data = array();
if ($fetchAll) {
   while ($row = mysqli_fetch_assoc($partRecords)) {
      $data[] = array( 
         $row['serial_number'],
         $row['part_number'],
         $row['po_id'],
         $row['ch_no'],
         $row['ch_date'],
         $row['used']
      );
   }
} else {
   while ($row = mysqli_fetch_assoc($partRecords)) {
      $data[] = array( 
         "serial_number"=>$row['serial_number'],
         "part_number"=>$row['part_number'],
         "po"=>$row['po_id'],
         "challan"=>$row['ch_no'],
         "challandate"=>$row['ch_date'],
         'used'=>$row['used'],
         "id"=>$row['id']
      );
   }
}

while ($row = mysqli_fetch_assoc($partRecords)) {
   $data[] = array( 
      "serial_number"=>$row['serial_number'],
      "part_number"=>$row['part_number'],
      "po"=>$row['po_id'],
      "challan"=>$row['ch_no'],
      "challandate"=>$row['ch_date'],
      "id"=>$row['id']
   );
}
//Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
  );
  
  echo json_encode($response);