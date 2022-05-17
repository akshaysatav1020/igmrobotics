<?php
include("../php/constants.php");
// print_r($_POST);
ini_set("display_errors",0);

$draw = $_POST['draw'];
$fetchAll = (isset($_GET['page']) && $_GET['page']=='all');
$row = ($fetchAll) ? 0 : $_POST['start'];
$rowperpage = ($fetchAll)? 999999999 : $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (part_number = '".$searchValue."' or 
  location like '%".$searchValue."%' or 
   country like'%".$searchValue."%' ) ";
}
$connection = new mysqli(HOST, USER, PASSWORD, DB);               

//Total number of records without filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM view_stock_inventory_new");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

//Total number of record with filtering
$sel = mysqli_query($connection,"SELECT COUNT(*) as allcount FROM view_stock_inventory_new WHERE 1  ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];
//prepare limit
$limitPart = ($fetchAll) 
               ?'' 
               : " limit ".$row.",".$rowperpage;
//Fetch records
$orderBy = !empty($columnName)?' order by '.$columnName : '';
$partQuery = "SELECT * from view_stock_inventory_new where 1 ".$searchQuery.$orderBy." ".$columnSortOrder . $limitPart;
//echo $partQuery;
$partRecords = mysqli_query($connection, $partQuery);
$data = array();
if($fetchAll){
   while ($row = mysqli_fetch_assoc($partRecords)) {
      $data[] = array( 
         $row['part_number'],
         $row['count'],
         $row['min'],
         $row['location'],
         $row['country']
      );
   }
} else {
   while ($row = mysqli_fetch_assoc($partRecords)) {
      $data[] = array( 
         "part_number"=>$row['part_number'],
         "count"=>$row['count'],
         "min"=>$row['min'],
         "location"=>$row['location'],
         "country"=>$row['country']
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


