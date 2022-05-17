<?php  
  require_once("../php/db.php");
  $db=new DB();
  $connection=$db->getConnection();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="charset" content="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Control System</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/datepicker.css">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
    <style media="screen">
    main {
      min-width: 320px;
      max-width: 100%;
      padding: 50px;
      margin: 0 auto;
      background: #fff;
    }
    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #ddd;
    }

    label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
      display: inline-block;
      /*margin: 0 0 -1px;
      text-align: center;      */
      padding: 15px 25px;
      font-weight: 600;
      border: 1px solid transparent;
    }

    label:before {
      font-family: fontawesome;
      font-weight: normal;
      margin-right: 10px;
    }

    label[for*='1']:before { content: '\f055'; }
    label[for*='2']:before { content: '\f06e'; }
    label[for*='3']:before { content: '\f016'; }
    label[for*='4']:before { content: '\f06e'; }
    label[for*='5']:before { content: '\f067'; }
    label[for*='6']:before { content: '\f1cb'; }

    label:hover {
      color: #888;
      cursor: pointer;
    }

    input:checked + label {
      color: #555;
      border: 1px solid #ddd;
      border-top: 2px solid orange;
      border-bottom: 1px solid #fff;
    }

    #tab1:checked ~ #content1,
    #tab2:checked ~ #content2,
    #tab3:checked ~ #content3,
    #tab4:checked ~ #content4,
    #tab5:checked ~ #content5,
    #tab6:checked ~ #content6 {
      display: block;
    }

    @media screen and (max-width: 650px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
        font-size: 0;
      }
      label[for*='1']:before, label[for*='2']:before, label[for*='3']:before, label[for*='4']:before, label[for*='5']:before, label[for*='6']:before {
        margin: 0;
        font-size: 18px;
      }
    }

    @media screen and (max-width: 400px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
        padding: 15px;
      }
    }

  .blink_me {
    animation: blinker 1s linear infinite;
  }

  .datepicker{ z-index: 9999 !important;}

  @keyframes blinker {  
    50% { opacity: 0; }
  }
    </style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid" >
      <div class="row">
        <div class="col-md-2">
          <a href="adminhome.php"><img src="../images/logo.png" alt="igm-logo" class="img-responsive"></a>
        </div>
        <div class="col-md-9">
          <!-- <h1>Inventory Control System</h1> -->
        </div>
      </div>
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Add Parts</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View Parts</label>
          <input id="tab5" type="radio" name="tabs">
          <label for="tab5">Add Stock</label>
          <input id="tab6" type="radio" name="tabs">
          <label for="tab6">View Stock</label>
          <input id="tab3" type="radio" name="tabs">
          <label for="tab3">Import Parts</label>        
          <section id="content1">
            <form class="" action="../php/inventory.php" method="post">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="partnumber">Part Number</label>
                  <input type="text" class="form-control" name="partno" placeholder="Enter name" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unitprice">Unit Price (Euro)</label>
                  <input type="text" class="form-control number" name="unitpriceeuro" maxlength="8" placeholder="Enter unit price" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unitprice">Unit Price (INR)</label>
                  <input type="text" class="form-control number" name="unitpriceinr" maxlength="8" placeholder="Enter unit price" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Location(Rack)</label>
                  <select class="form-control" name="rack" required="required">
                    <option value="R1">Rack1</option>
                    <option value="R2">Rack2</option>
                    <option value="R3">Rack3</option>
                    <option value="R4">Rack4</option>
                    <option value="R5">Rack5</option>
                    <option value="R6">Rack6</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Location(Floor)</label>
                  <select class="form-control" name="column" required="required">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Minimum Stock</label>
                  <input type="text" class="form-control number" name="min" maxlength="3" placeholder="Enter min stock" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Part Description</label>
                  <textarea class="form-control" name="description" placeholder="Enter description" required="required"></textarea>
                </div>
              </div>
                  <div class="col-md-3">
                <div class="form-group">
                  <label for="Country">Country</label>
                  <select class="form-control" name="country" required="required">
                    <option value="India">India</option>
                    <option value="Austria">Austria</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-success add" type="submit" value="addpart" name="addInventory">Add part</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>Part No.</th>
                    <th>Description</th>
                    <th>UnitPrice (Euro)</th>
                    <th>UnitPrice (INR)</th>
                    <th>Landed Cost</th>                    
                    <th>Location (Rack - Column)</th>
                    <th>Min Quantity</th>
                    <th>Available Quantity</th>
                     <th>Country</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Part No.</th>
                    <th>Description</th>
                    <th>UnitPrice (Euro)</th>
                    <th>UnitPrice (INR)</th>
                    <th>Landed Cost</th>                   
                    <th>Location</th>
                     <th>Min Quantity</th>
                    <th>Available Quantity</th>
                     <th>Country</th>
                    <th>Action</th>
                  </tr>
                </tfoot>                
                <tbody>
                <?php                    
                    $query = "SELECT * FROM inventory_parts";
                    $result = $connection->query($query);
                    $data = array();                
                    if($result->num_rows>0){
                      while($row=$result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["part_number"]."</td>";
                        echo "<td>".$row["description"]."</td>";
                        echo "<td>".$row["unit_price_euro"]."</td>";
                        echo "<td>".$row["unit_price_inr"]."</td>";
                        echo "<td>".$row["landed_cost"]."</td>";
                        echo "<td>".$row["location"]."</td>";
                        echo "<td>".$row["min"]."</td>";
                        echo "<td>".$row["total"]."</td>";
                        echo "<td>".$row["country"]."</td>";
                        if($_COOKIE["status"]=="Online"){
                            if($_COOKIE["userrole"]=="admin"||$_COOKIE["userrole"]=="superadmin"){
                            echo "<td><button class='btn btn-xs btn-warning edit' onClick='editPart(".$row["id"].")' id='".$row["id"]."' >Edit/View</button>&emsp;";
                        echo "<button class='btn btn-xs btn-danger delete' onClick='deletePart(".$row["id"].")' id='".$row["id"]."'>Delete</button></td>";

                            }else{
                              echo "<td><button class='btn btn-xs btn-warning edit' onClick='editPart(".$row["id"].")' id='".$row["id"]."' disabled>Edit/View</button>&emsp;";
                        echo "<button class='btn btn-xs btn-danger delete' onClick='deletePart(".$row["id"].")' id='".$row["id"]."' disabled>Delete</button></td>"; 
                            }
                          }else{
                            echo "<td><button class='btn btn-xs btn-warning edit' onClick='editPart(".$row["id"].")' id='".$row["id"]."' disabled>Edit/View</button>&emsp;";
                        echo "<button class='btn btn-xs btn-danger delete' onClick='deletePart(".$row["id"].")' id='".$row["id"]."'disabled>Delete</button></td>";
                          }
                                     
                        echo "</tr>";
                      }
                    }

                  ?>
                </tbody>
              </table>
            </div>
          </section>
          <section id="content3">
            <div class="col-md-6">
              <form action="../php/inventory.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description">Choose File</label>
                    <input type="file" class="form-control" name="partsexcel" required="required"/>
                  </div>
                </div>
                <div class="col-md-6" style="padding:2%;">
                  <button type="submit" class="btn btn-lg btn-success" name="importparts">Import Parts</button>
                </div>
              </form>
            </div>
            <div class="col-md-6">
              <form action="../php/warehouseStock.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description">Choose File</label>
                    <input type="file" class="form-control import" name="stocksexcel" required="required"/>
                  </div>
                </div>
                <div class="col-md-6" style="padding:2%;">
                  <button type="submit" class="btn btn-lg btn-success import" name="importstocks">Import Stock</button>
                </div>
              </form>
            </div>
          </section>
          <section id="content4">
            <div class="col-md-12">
              <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable2">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Part No.</th>
                    <th>Challan No.</th>
                    <th>Out Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Part No.</th>
                    <th>Challan No.</th>
                    <th>Out Date</th>
                    <th>Action</th>
                  </tr>
                </tfoot>                
                <?php                      
                    $query = "SELECT * FROM inventory WHERE returnable=1 AND used=1";
                    $result = $connection->query($query);
                    $data = array();                
                    if($result->num_rows>0){
                      while($row=$result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["serial_number"]."</td>";
                        echo "<td>".$row["part_number"]."</td>";                        
                        echo "<td>".$row["ch_no"]."</td>";
                        echo "<td>".$row["modified_on"]."</td>";
                        echo "<td><button class='btn btn-xs btn-warning' onClick='changeReturnStatus(".$row["id"].",0)'>Change Status</button></td>";                        
                        echo "</tr>";
                      }
                    }

                  ?>
                </tbody>
              </table>
              </div>
            </div>
          </section>
          <section id="content5">
            <form method="POST" action="../php/warehouseStock.php">
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Serial No</label>
                    <input type="text" class="form-control" maxlength="10" name="serno"/>
                  </div>
                </div>
               <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Part No</label>
                    <select class="form-control" name="partno">
                      <option>Select Part</option>
                      <?php                      
                        $query = "SELECT * FROM inventory_parts";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["id"]."'>".$row["part_number"]."</option>";                                                  
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Inward No.</label>
                    <select class="form-control" name="inwardno">
                      <option value="">Select</option>
                      <?php                      
                        $query = "SELECT * FROM duty";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["duty_id"]."'>".$row["inward_no"]."</option>";                                                  
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="desc" ></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <label for="description">Purchase Order No</label>
                  <select class="form-control"  name="pono" required="required">
                    <option>Select Purchase Order</option>
                    <?php                      
                        $query = "SELECT * FROM purchaseorder";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["id"]."'>".$row["po_no"]."</option>";
                          }
                        }
                      ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <label for="description">Vendor Challan No</label>
                  <input type="text" class="form-control" maxlength="10" placeholder="Enter challan number" name="chno" required="required"/>
                </div>
                <div class="col-md-2">
                  <label for="description">Vendor Challan Date</label>
                  <input type="text" class="form-control" name="chdate" required="required"/>
                </div>
                <div class="col-md-2">
                  <label for="description">Import Date</label>
                  <input type="text" class="form-control" name="importDate" required="required"/>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="description">Clearing Charges</label>
                    <input type="text" class="form-control" name="clearingCharges"/>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="description">Bill Entry No.</label>
                    <input type="text" class="form-control" name="billEntryNo"/>
                  </div>
                </div>
                <div class="col-md-3" style="padding:2%;">
                  <button type="submit" class="btn btn-sm btn-success add" name="addstock">Add Stock</button>
                </div>
            </form>
          </section>
          <section id="content6">
            <table class="table table-bordered table-striped table-condensed" id="myTable1">
                <thead>
                  <tr>
                    <th>Serial No.</th>
                    <th>Part No.</th>
                    <th>Purchase Order No.</th>
                    <th>Challan</th>
                    <th>Challan Date</th>
                    <th>Used</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Serial No.</th>
                    <th>Part No.</th>
                    <th>Purchase Order No.</th>
                    <th>Challan</th>
                    <th>Challan Date</th>
                    <th>Used</th>
                    <th>Action</th>
                  </tr>
                </tfoot>                
                <tbody>
                  <?php                      
                      $query = "SELECT * FROM inventory";
                      $result = $connection->query($query);
                      $data = array();                
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                          echo "<tr>";
                          echo "<td>".$row["serial_number"]."</td>";
                          echo "<td>".$row["part_number"]."</td>";
                          echo "<td>".getPO($connection,$row["po_id"])."</td>";
                          echo "<td>".$row["ch_no"]."</td>";
                          // echo "<td>".parseDate($row["ch_date"])."</td>";
                          echo "<td>".$row["ch_date"]."</td>";
                          if($row["used"]){
                            echo "<td>Used</td>";
                          }else{
                            echo "<td>Not used</td>";
                          }
                          if($_COOKIE["status"]=="Online"){
                            if($_COOKIE["userrole"]=="admin"||$_COOKIE["userrole"]=="superadmin"){
                            echo "<td><button class='btn btn-xs btn-warning edit' onClick='editStockPart(".$row["id"].")' id='".$row["id"]."' >Edit/View</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger delete' onClick='deleteStockPart(".$row["id"].")' id='".$row["id"]."'>Delete</button></td>";

                            }else{
                              echo "<td><button class='btn btn-xs btn-warning edit' onClick='editStockPart(".$row["id"].")' id='".$row["id"]."'  disabled>Edit/View</button>&emsp;";
                              echo "<button class='btn btn-xs btn-danger delete' onClick='deleteStockPart(".$row["id"].")' id='".$row["id"]."' disabled>Delete</button></td>";  
                            }
                          }else{
                            echo "<td><button class='btn btn-xs btn-warning edit' onClick='editStockPart(".$row["id"].")' id='".$row["id"]."'  disabled>Edit/View</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger delete' onClick='deleteStockPart(".$row["id"].")' id='".$row["id"]."' disabled>Delete</button></td>";
                          }
                            echo "</tr>";
                        }
                      }

                      function getPO($connection, $id){
                        $pono="";
                        $query = "SELECT * FROM purchaseorder WHERE id=$id";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            $pono=$row["po_no"];
                          }
                        }
                        return $pono;
                      }

                      function parseDate($date){
                        // $date=explode("-", explode(" ", $date)[0]);                        
                        // return $date[2]."-".$date[1]."-".$date[0];
                        return $date;
                      }

                    ?>
                </tbody>
              </table>
          </section>
        </main>
      </div>
    </div>
    <?php include("footer.php");?>
      
      <div class="modal fade" id="myModal1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit/View Inventory Part</h4>
      </div>
      <div class="modal-body">
        <form class="" action="../php/inventory.php" method="post">

              <div class="col-md-4">
                <div class="form-group">
                  <label for="partnumber">Id</label>
                  <input type="text" class="form-control" name="eid" required="required" readonly="readonly" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="partnumber">Part Number</label>
                  <input type="text" class="form-control" name="epartno" placeholder="Enter name" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="description">Part Description</label>
                  <textarea class="form-control" name="edesc" placeholder="Enter description" required="required"></textarea>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unitprice">Unit Price (Euro)</label>
                  <input type="text" class="form-control number" name="erateeuro" maxlength="8" placeholder="Enter unit price" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unitprice">Unit Price</label>
                  <input type="text" class="form-control number" name="erateinr" placeholder="Enter unit price" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unitprice">Landed Cost</label>
                  <input type="text" class="form-control number" name="elandedCost" placeholder="Enter Landed Cost" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Location(Rack)</label>
                  <select class="form-control" name="erack" required="required">
                    <option value="R1">Rack1</option>
                    <option value="R2">Rack2</option>
                    <option value="R3">Rack3</option>
                    <option value="R4">Rack4</option>
                    <option value="R5">Rack5</option>
                    <option value="R6">Rack6</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Location(Floor)</label>
                  <select class="form-control" name="ecolumn" required="required">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Minimum Stock</label>
                  <input type="text" class="form-control number" name="emin" placeholder="Enter min stock" required="required"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Available Stock</label>
                  <input type="text" class="form-control number" name="eavail" placeholder="Enter min stock" required="required"/>
                </div>
              </div>   
              <div class="col-md-3">
                <div class="form-group">
                  <label for="Country">Country</label>
                  <select class="form-control" name="country" required="required">
                    <option value="india">India</option>
                    <option value="austria">Austria</option>
                  </select>
                </div>
                </div>            
              <div class="col-md-6" style="padding:2%;">
                <div class="form-group">
                  <button class="btn btn-success" type="submit" value="addpart" name="editInventory">Update part</button>
                </div>
              </div>
            </form>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
  </div>

      <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit/View Stock Part</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="../php/warehouseStock.php">
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Id</label>
                    <input type="text" class="form-control" name="eid" required="required" readonly="readonly" />
                  </div>
                </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Serial No</label>
                    <input type="text" class="form-control" name="eserno" required="required"/>
                  </div>
                </div>                
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Part No</label>
                    <select class="form-control" name="epartno">
                      <option>Select Part</option>
                      <?php                      
                        $query = "SELECT * FROM inventory_parts";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["id"]."'>".$row["part_number"]."</option>";                                                  
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="edesc" required="required"></textarea>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">                    
                    <label for="description">Inward No</label>
                    <select class="form-control" name="einwardno">
                      <option value="">Select</option>
                      <?php                      
                        $query = "SELECT * FROM duty";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["inward_no"]."'>".$row["inward_no"]."</option>";                                                  
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                  <label for="description">Purchase Order No</label>
                  <select class="form-control"  name="epono" required="required">
                    <option>Select Purchase Order</option>
                    <?php                      
                        $query = "SELECT * FROM purchaseorder";
                        $result = $connection->query($query);
                        $data = array();                
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){                            
                            echo "<option value='".$row["id"]."'>".$row["po_no"]."</option>";
                          }
                        }
                      ?>
                  </select>
                  </div>
                </div>                
                <div class="col-md-3">
                  <div class="form-group">
                  <label for="description">Challan No</label>                  
                  <input type="text" class="form-control" name="echno" required="required"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                  <label for="description">Challan Date</label>                  
                  <input type="text" class="form-control" name="echdate" required="required"/>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Import Date</label>
                  <input type="text" class="form-control" name="eImportDate" required="required"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="description">Clearing Charges</label>
                    <input type="text" class="form-control" name="eClearingCharges"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="description">Bill Entry No.</label>
                    <input type="text" class="form-control" name="eBillEntryNo"/>
                  </div>
                </div>
                <div class="col-md-4" >
                  <div class="form-group">
                  <label for="description">Used</label><br/>
                  <input type="radio" name="eused" value="yes" required="required"/> Yes&emsp;
                  <input type="radio" name="eused" value=no required="required"/> No
                  </div>
                </div>
                <div class="col-md-4" >
                  <div class="form-group">
                  <label for="description">Returnable</label><br/>
                  <input type="radio" name="ereturnable" value="yes" required="required"/> Yes&emsp;
                  <input type="radio" name="ereturnable" value=no required="required"/> No
                  </div>
                </div>
                <div class="col-md-4" style="padding-top: 2%;">
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success" name="editstock">Update</button>
                  </div>
                </div>
            </form>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
  </div>
  <div class="loader">
    <div class="wrap">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
      <div class="bar4"></div>
      <div class="bar5"></div>
      <div class="bar6"></div>
      <div class="bar7"></div>
      <div class="bar8"></div>
      <div class="bar7"></div>
      <div class="bar8"></div>
      <div class="bar9"></div>
      <div class="bar10"></div>
    </div>
  </div>

    <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/select2.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
    <script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
    <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
    <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
    <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
    <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
    <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
    <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
    <script type="text/javascript">
    var parts = localStorage.getItem('parts');   
    var poList = "";    
    $(".loader").hide();
    $(window).bind("load", function() {      
          checkNetworkStatus();
          if($.cookie("status")=="Offline"){                      
            $("button[name='addInventory']").attr("disabled","disabled");
            $("button[name='addstock']").attr("disabled","disabled");
            $("button[name='importparts']").attr("disabled","disabled");
            $("button[name='importstocks']").attr("disabled","disabled");
          }
        });    
    $(document).ready(function(){ 
      getPart();    
      $("select[name='partno']").select2({width:"100%"}); 
      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node ) {
              // Strip $ from salary column to make it numeric
              return column === 5 ?
              data.replace( /[$,]/g, '' ) :
              data;
            }
          }
          }
      };
      if($.cookie("userId")!="15"){
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                $.extend( true, {}, buttonCommon, {
                    extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3,4,5,6,7,8]}
                } ),
                $.extend( true, {}, buttonCommon, {
                    extend: 'excelHtml5',title:"Inventory Parts List",exportOptions:{columns:[0,1,2,3,4,5,6,7,8]}
                } ),
                $.extend( true, {}, buttonCommon, {
                    extend: 'pdfHtml5',title:"Inventory Parts List",exportOptions:{columns:[0,1,2,3,4,5,6,7,8]}
                } )
            ]
        });
        $('#myTable1').DataTable({
          dom: 'Bfrtip',
            buttons: [
                $.extend( true, {}, buttonCommon, {
                    extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3,4]}
                } ),
                $.extend( true, {}, buttonCommon, {
                    extend: 'excelHtml5',title:"Stock Parts List",exportOptions:{columns:[0,1,2,3,4]}
                } ),
                $.extend( true, {}, buttonCommon, {
                    extend: 'pdfHtml5',title:"Stock Parts List",exportOptions:{columns:[0,1,2,3,4]}
                } )
            ]
        });
      }

      $('#myTable2').DataTable({
        dom: 'Bfrtip',
          buttons: [
              $.extend( true, {}, buttonCommon, {
                  extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'excelHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'pdfHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
              } )
          ]
      });

      if($.cookie("userrole")=="viewer"||$.cookie("userrole")=="service"||$.cookie("userrole")=="finance"){
        $("input[id='tab1'],label[for='tab1']").hide();
        $("input[id='tab3'],label[for='tab3']").hide();     
        $("input[id='tab4'],label[for='tab4']").hide(); 
        $("input[id='tab5'],label[for='tab5']").hide();
        $("input[id='tab2']").attr("checked","checked"); 
      }

      $("input[name='chdate'],input[name='echdate'],input[name='importDate'],input[name='eImportDate']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
      });
      
      $("select[name='partno']").on("change",function(){
          var v= $(this).val();
          //alert(JSON.parse(parts).length);
          $.each(JSON.parse(parts),function(i,pa){
             if(pa.id == v){
              $("textarea[name='desc']").val(pa.desc);
             }
          });
      });
      $("select[name='epartno']").on("change",function(){
          var v= $(this).val();
          //alert(JSON.parse(parts).length);
          $.each(JSON.parse(parts),function(i,pa){
             if(pa.id == v){
              $("textarea[name='edesc']").val(pa.desc);
             }
          });
      });     
    });
    // inventoryId getInventory  getAllInventory  deleteInventory
    //id partno desc unitprice location cb co mb mo
    function getPart(){
      //  console.log('parts',parts); 
      if(parts == null){
        $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllInventory":"getAllInventory"},
        url:"../php/inventory.php",
        success:function(data){ 
          //console.log(data);         
          parts=data;
          localStorage.setItem('parts', parts);
          console.log('parts saved on local');
        },error:function(){
          alert('Some Error Occured');
        }
      });
      }
      
    }

    function getPO(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllPO":"getAllPO"},
        url:"../php/po.php",
        success:function(data){
          //console.log(data);
          if(JSON.parse(data).length>0){
            poList = JSON.parse(data);
            $("select[name='pono']").html("<option value=''>Select Purchase Order No</option>");              
            $.each(JSON.parse(data),function(i,po){
            $("select[name='pono'],select[name='epono']").append("<option value='"+po.id+"-"+po.pono+"'>"+po.pono+"</option>");                            
            });

          }else{
            
          }                    
        },error:function (err) {
          console.log("Error getting PO!!");
        }
      });
    }

    function getStocks(){      
      getInvoice();
    }


    function editStockPart(id){      
      $.ajax({
        method:"POST",
        type:"json",
        data:{"stockId":id,"getstock":"getstock"},
        url:"../php/warehouseStock.php",
        success:function(data){
            console.log(data);
          if(JSON.parse(data).length>0 && JSON.parse(data).length==1){            
            $.each(JSON.parse(data), function(i, stock){
              $("input[name='eid']").val(stock.id);
              var partDesc = "";
              $.each(JSON.parse(parts), function(i, part){
                 // console.log(part.partno);
                if(part.partno==stock.partno){
                  $("select[name='epartno']").val(part.id);
                  $("textarea[name='edesc']").val(part.desc);
                }
              });              
              $("input[name='eserno']").val(stock.srno);
              $("select[name='einvno']").val(stock.invid);
              $("select[name='epono']").val(stock.poid.split("-")[0]);
              $("input[name='echno']").val(stock.ch_no);
              $("input[name='echdate']").val(stock.ch_date.split(" ")[0]);
              $("input[name='eImportDate']").val(stock.import_date.split(" ")[0]);
              $("input[name='eClearingCharges']").val(stock.clearing_charges);
              $("input[name='eBillEntryNo']").val(stock.bill_entry_no);
              if(stock.returnable==1){
                $("input[name='ereturnable'][value='yes']").attr('checked', 'checked');
              }else{
                $("input[name='ereturnable'][value='no']").attr('checked', 'checked');
              }
              if(stock.used==1){
                $("input[name='eused'][value='yes']").attr('checked', 'checked');
              }else{
                $("input[name='eused'][value='no']").attr('checked', 'checked');
              }
              $("#myModal").modal();
            });
          }
        }});
    }

    function deleteStockPart(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"stockId":id,"deletestock":"deletestock"},
        url:"../php/warehouseStock.php",
        success:function(data){
            console.log(data);
            if(data=="Deleted"){
              alert("Deleted");
              location.reload();
            }          
        }});
      }
    }

    function getInvoice(){
      var lastInvNo = "";
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllInv":"getAllInv"},
        url:"../php/invoice.php",
        success:function(data){
          //console.log(data);
          if(JSON.parse(data).length>0){
            $("select[name='einvno']").html("<option value=''>Select Invoice</option>");
            $.each(JSON.parse(data),function(i,inv){                            
                $("select[name='einvno']").append("<option value='"+inv.id+"'>"+inv.invno+"</option>");
            });
          }  
          getChallan();
              
        },error:function (err) {
          console.log("Error getting invoice!!");
        }
      });
    }

    function getChallan(){
      // var lastInvNo = "";
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllDC":"getAllDC"},
        url:"../php/dc.php",
        success:function(data){
          //console.log(data);
          if(JSON.parse(data).length>0){
            $("select[name='echno']").html("<option value=''>Select Invoice</option>");
            $.each(JSON.parse(data),function(i,ch){                            
                $("select[name='echno']").append("<option value='"+ch.chno+"'>"+ch.chno+"</option>");
            });
          }          
          getReturnableStock();
        },error: function(){          
          console.log("Error getting challans!!");
        }
            
      });
    }

    function editPart(id){      
        $.ajax({
          method:"POST",
          type:"json",
          data:{"inventoryId":id,"getInventory":"getInventory"},
          url:"../php/inventory.php",
          success:function(data){
            console.log(data);
            if(JSON.parse(data).length>0 && JSON.parse(data).length==1){
              $.each(JSON.parse(data), function(i, part){
                $("input[name='eid']").val(part.id);
                $("input[name='epartno']").val(part.partno);
                $("input[name='erateeuro']").val(part.unitpriceeuro);
                $("input[name='erateinr']").val(part.unitpriceinr);
                $("input[name='elandedCost']").val(part.landedcost);
                $("input[name='emin']").val(part.min);
                $("input[name='eavail']").val(part.avail);
                $("textarea[name='edesc']").val(part.desc);
                $("select[name='erack']").val(part.location.split('-')[0]);
                $("select[name='ecolumn']").val(part.location.split('-')[1]);

              });
              $("#myModal1").modal();
            }
          }
        });

    }

    function deletePart(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"inventoryId":id,"deleteInventory":"deleteInventory"},
          url:"../php/inventory.php",
          success:function(data){
            console.log(data);
            if(data=="Deleted"){
              alert("Deleted");
              location.reload();
            }else{
              alert("Unable to delete Contact Admin");
            }
          },error: function(error){
            alert("Unable to delete Contact Admin");
          }});
      }
    }

    function getReturnableStock(){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"getAllReturnableStock":"getAllReturnableStock"},
          url:"../php/warehouseStock.php",
          success:function(data){
            //console.log("Returnable Stocks   "+data);
            var element = "";
            var returnableStocks = JSON.parse(data);
            $.each(returnableStocks, function(i, stock){
              var last = stock.mo.split(" ");
              var date1 = new Date(last[0]);
              var date2 = new Date();
              var timeDiff = Math.abs(date2.getTime() - date1.getTime());
              var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
              var statBtn = "";
              if($.cookie("status")=="Offline"){
                statBtn = "<button class='btn btn-sm btn-warning' onClick='changeReturnStatus("+stock.id+",0)' disabled='disabled'>Change Status</button>";
              }else{
                statBtn = "<button class='btn btn-sm btn-warning' onClick='changeReturnStatus("+stock.id+",0)'>Change Status</button>";
              }
              if(diffDays>=30){
                element = "<tr>"
                +"<td class='blink_me' style='color:red;'>"+stock.srno+"</td>"          
                +"<td>"+stock.part+"</td>"          
                +"<td>"+stock.ch_no+"</td>"
                +"<td class='blink_me' style='color:red;'>"+stock.mo.split(" ")[0]+"</td>"        
                +"<td>"+statBtn+"</td>"
                +"</tr>";
              }else{
                element = "<tr>"
                +"<td>"+stock.srno+"</td>"          
                +"<td>"+stock.part+"</td>"          
                +"<td>"+stock.ch_no+"</td>"
                +"<td>"+stock.mo.split(" ")[0]+"</td>"        
                +"<td>"+statBtn+"</td>"
                +"</tr>";
              }
              
              $("#returnableList").append(element);
            });
            var buttonCommon = {
                exportOptions: {
                    format: {
                      body: function ( data, row, column, node ) {
                        // Strip $ from salary column to make it numeric
                        return column === 5 ?
                            data.replace( /[$,]/g, '' ) :
                            data;
                      }
                    }
                }
            };
            $('#myTable2').DataTable({
              dom: 'Bfrtip',
                buttons: [
                  $.extend( true, {}, buttonCommon, {
                    extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3]}
                  }),
                  $.extend( true, {}, buttonCommon, {
                    extend: 'excelHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
                  }),
                  $.extend( true, {}, buttonCommon, {
                    extend: 'pdfHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
                  })
                ]
            });
            //$("header,.container-fluid,footer").show();
            //$(".loader").hide();
          },error: function(error){
            console.log("Unable to get returnable stocks");
          }
      });
    }
    function changeReturnStatus(id,status){
      var c = confirm("Do you really want to change status "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"stockId":id,"changeReturnStatus":"changeReturnStatus"},
          url:"../php/warehouseStock.php",
          success:function(data){
            console.log(data);
            if(data=="Changed"){
              alert("Changed");
              location.reload();
            }else{
              alert("Unable to change status Contact Admin");
            }
          },error: function(error){
            console.log("Unable to change status Contact Admin");
          }});
      }
    }

    function getWareHouseInfo(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getWareHouseInfo":"getWareHouseInfo"},
        url:"../php/dataSettings.php",
        success:function(data){
          if(data!="" || data!=null){
            var k = "0";
            var racks = parseInt(data.split("-")[0]);
            var floors = parseInt(data.split("-")[1]);
            $("select[name='rack'],select[name='erack']").empty();            
            $("select[name='column'],select[name='ecolumn']").empty();
            for(var i=1; i<=racks; i++){
              $("select[name='rack'],select[name='erack']").append("<option value='R"+i+"'>Rack"+i+"</option>");
            }
            for(var i=1; i<=floors; i++){
              $("select[name='column'],select[name='ecolumn']").append("<option value='"+i+"'>"+i+"</option>");
            }
          }else{
            $("input[name='rack']").val("Error getting info!!");
            $("input[name='floor']").val("Error getting info!!");
          }                      
        },error: function(error){
          console.log("Error getting Info Contact Admin");
        }
      });
    }
    </script>
  </body>
</html>


