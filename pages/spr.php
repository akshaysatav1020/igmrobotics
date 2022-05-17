<?php
  require_once("../php/db.php");
  $db=new DB();
  $connection=$db->getConnection();
?>
<!DOCTYPE html>
<head>
    <meta name="charset" content="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Control System|Edit Spare Part Request</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">

</head>
<style media="screen">
    textarea.form-control{
        height: 34px;
      }
    main {
        min-width: 320px;
        max-width: 100%;
        padding: 50px;
        margin: 0 auto;
        background: #fff;
    }
    
    input[type=radio] {
        display: none;
    }
    
    section {
        display: none;
        padding: 20px 0 0;
        border-top: 1px solid #ddd;
    }
    
    label[for*='1'],
    label[for*='2'],
    label[for*='3'],
    label[for*='4'] {
        display: inline-block;
        padding: 15px 25px;
        font-weight: 600;
        border: 1px solid transparent;
    }
    
    label:before {
        font-family: fontawesome;
        font-weight: normal;
        margin-right: 10px;
    }
    
    label[for*='1']:before {
        content: '\f1c1';
    }
    
    label[for*='2']:before {
        content: '\f06e';
    }
    
    label:hover {
        color: #888;
        cursor: pointer;
    }
    
    input:checked+label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid orange;
        border-bottom: 1px solid #fff;
    }
    
    #tab1:checked~#content1,
    #tab2:checked~#content2,
    #tab3:checked~#content3,
    #tab4:checked~#content4 {
        display: block;
    }
    
    @media screen and (max-width: 650px) {
        label[for*='1'],
        label[for*='2'],
        label[for*='3'],
        label[for*='4'] {
            font-size: 0;
        }
        label[for*='1']:before,
        label[for*='2']:before,
        label[for*='3']:before,
        label[for*='4']:before {
            margin: 0;
            font-size: 18px;
        }
    }
    
    @media screen and (max-width: 400px) {
        label[for*='1'],
        label[for*='2'],
        label[for*='3'],
        label[for*='4'] {
            padding: 15px;
        }
    }

    .btn-group{
        position: relative;
        display: block;
        vertical-align: middle;
    }
    .blink_me {
    color:red;
    animation: blinker 1s linear infinite;
  }

  @keyframes blinker {
    50% { opacity: 0; }
  }
</style>

<body>
    <?php include "menu.php"; ?>

        <div class="container-fluid content">
            <div class="row">
                <main>
                    <input id="tab1" type="radio" name="tabs" checked>
                    <label for="tab1">Generate SPR</label>
                    <input id="tab2" type="radio" name="tabs">
                    <label for="tab2">View List</label>
                    <input id="tab3" type="radio" name="tabs">
                    <label for="tab3">SPR Tracking</label>
                    <section id="content1">
                        <form class="add" action="../php/spr.php" method="POST">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>SPR Date</label>
                                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                        <input class="form-control" name="sprdate" type="text">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Spr No.</label>
                                    <input class="form-control" name="sprno" value="SPR-<?php echo Date(" Ymd ");?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input class="form-control" type="text" value="" name="customer"/>
                                    <!-- <select class="form-control" name="customer">
                                        <option value="">Select Customer</option>               
                                        <?php                    
                                          // $query="SELECT * FROM customers";
                                          // $result = $connection->query($query);
                                          // $data = array();
                                          // if($result->num_rows>0){
                                          //   while($row=$result->fetch_assoc()){                 
                                          //     echo "<option value='".$row["id"]."'>".$row["company_name"]
                                          //     ." - ".$row["city"]."</option>";
                                          //   }
                                          // }                     
                                        ?>
                                    </select> -->
                                </div>
                            </div>

                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <label>Machine No</label>
                                    <select class="form-control" name="machino">
                                        <option value="">Select Machine</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Machine No</label>
                                    <select class="form-control" name="machino">
                                    <option value="">Select</option>
                                      <?php
                                          $query="SELECT * FROM machine";
                                          $result = $connection->query($query);
                                          $data = array();
                                          if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){
                                              echo "<option value='".$row["machine_no"]."'>".$row["machine_no"]."</option>";
                                            }
                                          }                                     
                                        ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Machine Name</label>
                                <input type="text" class="form-control" name="machiname" readonly />                                
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Igm Order No</label>
                                    <input class="form-control number" name="ordreno" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Request Date</label>
                                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                        <input class="form-control" name="reqdate" type="text">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Reference Email</label>
                                    <input class="form-control" name="refEmail" maxlength="28"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Non Accountable Reason</label>
                                    <select class="form-control" name="nonAccountableReason">
                                        <option value="">Select</option>
                                        <option value="For set in operation / programming">For set in operation / programming</option>
                                        <option value="For short/wrong supply replacement">For short/wrong supply replacement</option>
                                        <option value="For demonstration/others">For demonstration/others</option>
                                        <option value="For warranty">For warranty</option>
                                        <option value="As good will">As good will</option>
                                        <option value="To transfer to consignment stock K14">To transfer to consignment stock K14</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Shipment By</label>
                                    <select class="form-control" name="shpimentBy">
                                        <option value="">Select</option>
                                        <option value="TNT/DHL">TNT/DHL</option>
                                        <option value="Air freight">Air freight</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Error </label>
                                    <textarea class="form-control" name="error" placeholder="Enter error here" maxlength="70"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remark" placeholder="Enter Remarks here" maxlength="58"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding:2%;">
                                <button class="btn btn-default addpart" type="button">Add Part</button>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed or">
                                            <thead>
                                                <tr>
                                                    <th>Part No.</th>
                                                    <th>Description</th>
                                                    <th>Serial number</th>
                                                    <th>Quantity</th>
                                                    <th>Remarks</th>
                                                    <th>Part used from</th>
                                                </tr>
                                            </thead>
                                            <tbody id="parts">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding:2%;">
                                <button type="submit" name="addSPR" class="btn btn-info">Generate</button>
                            </div>
                        </form>
                    </section>
                    <section id="content2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Spr No.</th>
                                        <th>Spr Date</th>
                                        <th>Customer</th>
                                        <th>Machine No</th>
                                        <th>Machine Name</th>
                                        <th>IGM Order No.</th>
                                        <th>Request Date</th>
                                        <th>Reference Email</th>
                                        <th>Non Accountable Reason</th>
                                        <th>Shipment By</th>
                                        <th>Error</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Spr No.</th>
                                        <th>Spr Date</th>
                                        <th>Customer</th>
                                        <th>Machine No</th>
                                        <th>Machine Name</th>
                                        <th>IGM Order No.</th>
                                        <th>Request Date</th>
                                        <th>Reference Email</th>
                                        <th>Non Accountable Reason</th>
                                        <th>Shipment By</th>
                                        <th>Error</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <!-- <tbody id="sprList"> -->
                                <tbody>
                                    <?php
                              $query="SELECT sp.*, cust.company_name cname FROM spr sp LEFT JOIN customers cust on sp.customer=cust.id";
                              $result = $connection->query($query);
                              $data = array();
                              if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){                    
                                  echo "<tr>";
                                  echo "<td>".$row["spr_no"]."</td>";
                                  echo "<td>".parseDate($row["spr_date"])."</td>";                          
                                  echo "<td>".$row["cname"]."</td>";
                                  echo "<td>".$row["machine"]."</td>";
                                  echo "<td>".$row["machine_name"]."</td>";
                                  echo "<td>".$row["igm_order_no"]."</td>";
                                  echo "<td>".$row["request_date"]."</td>";
                                  echo "<td>".$row["ref_email"]."</td>";
                                  echo "<td>".$row["non_accountable_reason"]."</td>";
                                  echo "<td>".$row["shipment_by"]."</td>";
                                  echo "<td>".$row["error"]."</td>";
                                  echo "<td>".$row["remarks"]."</td>";
                                  echo "<td>";
                                  if($_COOKIE["status"]=="Online"){
                                    echo "<button class='btn btn-sm btn-success' onclick='printFunction(".$row["spr_id"].")'>Print</button>&emsp;";
                                    echo "<button class='btn btn-sm btn-warning' onclick='editSpr(".$row["spr_id"].")'>Edit</button>&emsp;";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteSpr(".$row["spr_id"].")'>Delete</button></td>";
                                  }else{                        
                                    echo "<button class='btn btn-sm btn-success' onclick='printFunction(".$row["spr_id"].")'>Print</button>&emsp;";
                                    echo "<button class='btn btn-sm btn-warning' onclick='editSpr(".$row["spr_id"].")' disabled>Edit</button>&emsp;";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteSpr(".$row["spr_id"].")'disabled>Delete</button></td>";
                                  }
                                  echo "</tr>";
                                }
                              } 

                              function getCustomer($connection, $id){
                                $query="SELECT * FROM customers WHERE id=".$id;
                                $result = $connection->query($query);
                                $data = "";
                                if($result->num_rows>0){
                                  while($row=$result->fetch_assoc()){          
                                    $data = $row['company_name']." - ".$row['city'];
                                  }
                                }      
                                return $data;
                              } 

                              function parseDate($date){
                                $date=explode("-", explode(" ", $date)[0]);                        
                                return $date[2]."-".$date[1]."-".$date[0];
                              }
                        ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section id="content3">
                      <div class="tableresponsive">
                        <table class="table table-bordered table-striped table-condensed" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>Spr No.</th>
                                        <th>Part No</th>
                                        <th>Description</th>
                                        <th>Requested</th>
                                        <th>Received</th>
                                        <th>Faulty</th>
                                        <th>Serial No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Spr No.</th>
                                        <th>Part No</th>
                                        <th>Description</th>
                                        <th>Requested</th>
                                        <th>Received</th>
                                        <th>Faulty</th>
                                        <th>Serial No.</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <!-- <tbody id="sprTrackList"> -->
                                <tbody>
                                    <?php
                              $query="SELECT spt.*, s.spr_no sprno, ip.part_number as partno,ip.description as description FROM spr_tracking spt LEFT JOIN spr s on spt.spr_no=s.spr_id LEFT JOIN inventory_parts ip on spt.part_no=ip.id";
                              $result = $connection->query($query);
                              $data = array();
                              if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){ 

                                  echo "<tr>";
                                  echo "<td>".$row["sprno"]."</td>";
                                  echo "<td>".$row["partno"]."</td>";
                                  echo "<td>".$row["description"]."</td>";
                                  echo ($row["requested"]>$row["received"])?"<td class='blink_me'>".$row["requested"]."</td>":"<td>".$row["requested"]."</td>";
                                  echo ($row["requested"]>$row["received"])?"<td class='blink_me'>".$row["received"]."</td>":"<td>".$row["received"]."</td>";
                                  echo "<td>".$row["faulty"]."</td>";
                                  echo "<td>".$row["serial_no"]."</td>";                          
                                  echo "<td>";
                                  if($_COOKIE["status"]=="Online"){
                                    echo "<button class='btn btn-sm btn-warning' onclick='editSprTrack(".$row["spr_track_id"].")'>Edit</button>&nbsp;";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteSprTrack(".$row["spr_track_id"].")'>Delete</button></td>";
                                  }else{                        
                                    echo "<button class='btn btn-sm btn-warning' onclick='editSprTrack(".$row["spr_track_id"].")' disabled>Edit</button>&nbsp;";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteSprTrack(".$row["spr_track_id"].")' disabled>Delete</button></td>";
                                  }
                                  echo "</tr>";
                                }
                              } 

                            function getSPRNo($connection, $id){
                                $data = "";
                                $query = "SELECT * FROM spr WHERE spr_id=".$id;
                                $result = $connection->query($query);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                                        $data = $row["spr_no"];
                                    }
                                }
                                return $data;

                            }
                            function getPartNo($connection, $id, $col){
                                $data = "";
                                $query = "SELECT $col FROM inventory_parts WHERE id=".$id;
                                $result = $connection->query($query);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){                    
                                        $data = $row["$col"];
                                    }
                                }                                
                                return $data;
                            }


                    ?>
                                </tbody>
                            </table>
                      </div>
                    </section>
                </main>
            </div>

        </div>
        <?php include("footer.php");?>
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

            <div class="modal fade" id="updateSPRTrackModal" role="dialog">          
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update</h4>
                  </div>
                  <div class="modal-body">
                    <form  action="../php/spr.php" method="post">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="Quantity">Id</label>
                          <input type="text" class="form-control" name="sprTrackId" readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="Quantity">SPR No.</label>
                          <input type="text" class="form-control" name="sprNo" readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="partno">Part No</label>
                          <select class="form-control" name="partNo" readonly></select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="discription">Requested</label>
                          <input class="form-control" name="requested"/>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="remark">Received</label>
                          <input class="form-control" name="received"/>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="newserial">Faulty</label>
                          <input class="form-control" name="faulty"/>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="newpartused">Serial No</label>
                          <textarea class="form-control" name="serialNo"></textarea>
                        </div>
                      </div>
                    
                      <div class="col-md-3" style="padding:2%;">
                        <div class="form-group">
                          <button class="btn btn-success" type="submit" name="updateSPRTrack">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer" ></div>
                </div>
              </div>
              </div>
<script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
<script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
<script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
<script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
<script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
<script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
<script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
<script src="../js/bootstrap-datepicker.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/custom.js" charset="utf-8" type="text/javascript"></script>
<script type="text/javascript">
    $("header,.container-fluid,footer").hide();
    $(".loader").show();
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem('parts');       
    var customers;
    var prefix = "";
    $(window).bind("load", function() {
        checkNetworkStatus();
        getPrefix();
        getMachines();
        $("select[name='machino'],select[name='nonAccountableReason'],select[name='shpimentBy']").select2({"width":"100%"});
        getAllSPRTrack();
        if ($.cookie("status") == "Offline") {
            $("button[name='generateQuot']").attr("disabled", "disabled");
        }

        

        if($.cookie("userrole")=="spares"){
            $("input[id='tab2']").attr("checked","checked");
            $("input[id='tab1'],label[for='tab1'],input[id='tab3'],label[for='tab3']").hide();     
        }
    });
    $(document).ready(function() {
        /*$("select[name='nonAccountableReason']").multiselect({
            numberDisplayed: 1
        });*/

        
        $("select[name='machino']").on("change",function(){
            $.ajax({
              method:"POST",
              type:"json",
              data:{"machineNo":$(this).val(),
              "getCustomerMachineByMachineNumber":"getCustomerMachineByMachineNumber"},
              url:"../php/machine.php",
              success:function(data){
                console.log(data);
                var info = JSON.parse(data);
                $("input[name='customer']").val(info.customer+"-"+info.company_name);
                $("input[name='machiname']").val(info.machine_name);
              },error:function(){

              }
            });
        });
        $("input[name='sprdate'],input[name='reqdate']").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        //$(".addpart").attr("disabled", "disabled");
        $("button[name='addSPR']").attr("disabled", "disabled");
        var $select = $("select[name='customer']");
        $select.on("change", function() {
            //$(".addpart").removeAttr("disabled");
        });

        getPart();

        $(".addpart").click(function() {
            partIndex++;
            $("button[name='addSPR']").removeAttr("disabled");
            addPartIds.push(partIndex);
            addPart();
           
        });

        $("table.or").on("click", ".removepart", function(event) {
            //alert($(this).attr("id"));
            removePartIds.push(parseInt($(this).attr("id")));
            $(this).closest("tr").remove();
             //$("button[name='addSPR']").attr("disabled", "disabled");
        });

        $("table.or").on(".part]").on("change",function(){
          var v= $(this).val();
          var id=$(this).attr("id");
          $.each(JSON.parse(partsData),function(i,pa){
             if(pa.id == v){
              $("textarea[name='description"+id+"']").val(pa.desc);
             }
          });
      });

        $("table.or").on("input", ".qty", function(event) {
            $("input[name='tax" + $(this).attr("id") + "']").val("0");
            $("input[name='amount" + $(this).attr("id") + "']").val("0");
        });
        $("table.or").on("input", ".tax", function(event) {
            var qty = parseInt($("input[name='quantity" + $(this).attr("id") + "']").val());
            var unitPrice = parseFloat($("input[name='unitprice" + $(this).attr("id") + "']").val());
            var discount = parseFloat(parseFloat($("select[name='discount" + $(this).attr("id") + "']").val()) / 100);
            var tax = parseFloat(parseFloat($("input[name='tax" + $(this).attr("id") + "']").val() / 100) * (qty * (unitPrice - (unitPrice * discount))));

            var actualprice = (qty * (unitPrice - (unitPrice * discount))) + tax;
            $("input[name='amount" + $(this).attr("id") + "']").val(parseFloat(actualprice));
        });

                    $("table.or").on("change", ".part", function(event) {
                        var id = $(this).attr("id");
                        var val = $(this).val().split('-');
                        $("select[name='discount" + id + "']").val("");
                        $("input[name='discprice" + id + "']").val("0");
                        $.each(JSON.parse(partsData), function(i, part) {
                            if (part.partno == val[1]) {
                                //console.log(part);
                                $("textarea[name='description" + id + "']").val(part.desc);
                                //$("input[name='unitprice" + id + "']").val(part.unitprice);
                                //$("input[name='quantity" + id + "']").val("0");
                                //$("input[name='tax" + id + "']").val("0");
                                //$("input[name='amount" + id + "']").val("0");
                            }
                        });
                    });

                    $("table.or").on("change", ".discount", function(event) {
                        var up = 0;
                        var id = $(this).attr("id");
                        var val = $("select[name='partno" + id + "']").val().split("-");
                        $.each(JSON.parse(partsData), function(i, part) {
                            if (part.partno == val[1]) {
                                up = parseFloat(part.unitprice);
                            }
                        });
                        var dis = parseFloat($(this).val() / 100);
                        $("input[name='quantity" + id + "']").val(0);
                        $("input[name='tax" + id + "']").val(0);
                        $("input[name='discprice" + id + "']").val(up - (up * dis));
                        $("input[name='amount" + id + "']").val("0");
                    });

                    $("form.add").submit(function(event) {

                        $("select[name='customer']").removeAttr("disabled");
                        var formData = $(this).serializeArray();
                        var diff = $(addPartIds).not(removePartIds).get();
                        $(this).append("<input type='hidden' name='ids' value='" + diff + "'/>");
                        location.reload();
                    });
                });

    function getPrefix() {
        preEnter("IGM");

    }

    function getMachineName(no){
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "number":no,
                "getMachineName": "getMachineName"
            },
            url: "../php/machine.php",
            success: function(data) {
                //console.log(data);
                $("input[name='machiname']").val(data);
            },
            error: function(err) {
                console.log("Error getting customers!!");
            }
        });
    }

    function preEnter(val) {
        if (val != "" && val.length <= 14) {
            prefix = val;
            getCustomers();
        } else {
            alert("Please Enter prefix less than or equals to 14 chars!!Cannot Proceed");
            location.reload();
        }
    }

    function addPart() {
        var element = "";
        element = "<tr>" 
            + "<td>"
            +"<select class='form-control part' name='partno" + partIndex + "' id=" + partIndex + "><option value='default'>Select part</option></select>" 
            +"</td>"
            +"<td>"
            +"<textarea class='form-control' name='description" + partIndex + "'></textarea>" 
            +"</td>"
            +"<td>"
            +"<textarea class='form-control' name='serialNo" + partIndex + "'></textarea>" 
            +"</td>" 
            + "<td>"
            +"<input type='text' class='form-control number qty' name='quantity"+partIndex+"' id="+partIndex+">" 
            + "</td>" 
            +"<td>"
            +"<textarea class='form-control' name='remark" + partIndex + "'></textarea>" 
            +"</td>" 
            +"<td>"
            +"<select class='form-control' name='usedFrom" + partIndex + "'>" + "<option value=''>Select</option>" + "<option value='Customers stock'>Customers stock</option>" + "<option value='Consignment Stock'>Consignment Stock</option>" + "<option value='igm India stock'>igm India stock</option>" + "</select>" 
            +"</td>"
            +"<td>" 
            +"<button type='button' class='btn btn-sm btn-warning removepart' id=" + partIndex + ">-</button>" 
            +"</td>"
            +"</tr>";
        $("#parts").append(element);
        $.each(JSON.parse(partsData), function(i, part) {
            //if(part.landedcost!="0.00"){                                       
                $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"</option>");
            //}
        });
        $("select[name='partno" + partIndex + "']").select2();
    }

    function getCustomers() {
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "viewAll": "getAllCustomers"
            },
            url: "../php/customer.php",
            success: function(data) {
                //console.log(data);
                customers = data;
                if (JSON.parse(data).length > 0) {
                    $.each(JSON.parse(data), function(i, vendor) {
                        if (i == 0) {
                            $("select[name='customer']").append("<option value='" + vendor.id + "'>" + vendor.company + "</option>");
                        } else {
                            $("select[name='customer']").append("<option value='" + vendor.id + "'>" + vendor.company + "</option>");
                        }
                    });
                }
                getSpr();
            },
            error: function(err) {
                console.log("Error getting customers!!");
            }
        });

    }

    function getPart() {
        // if(partsData==null){
            $.ajax({
                method: "POST",
                type: "json",
                data: {
                    "getAllInventory": "getAllInventory"
                },
                url: "../php/inventory.php",
                success: function(data) {
                    //console.log(data);
                    partsData = data;
                    localStorage.setItem("parts", partsData);
                    $.each(JSON.parse(partsData), function(i, part) {
                      $("select[name='partNo']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
                    });
                }
            });
        // }
    }

    function getAllSPRTrack(){
      $.ajax({
            method: "POST",
            type: "json",
            data: {"getAllSPRTrack": "getAllSPRTrack"},
            url: "../php/spr.php",
            success: function(data) {
              //console.log(data);
              console.log(data);
              $("tbody#sprTrackList").html();
              if (JSON.parse(data).length > 0) { 
                $.each(JSON.parse(data), function(i, sprTrack){                              
                  $("tbody#sprTrackList").append("<tr>"
                  +"<td>"+sprTrack.spr_no+"</td>"
                  +"<td>"+sprTrack.part_no+"</td>"
                  +"<td>"+sprTrack.requested+"</td>"
                  +"<td>"+sprTrack.received+"</td>"
                  +"<td>"+sprTrack.faulty+"</td>"
                  +"<td>"+sprTrack.serial_no+"</td>"
                  +"<td><button class='btn btn-warning' onClick='editSprTrack(" +sprTrack.spr_track_id+ ")' id='" +sprTrack.spr_track_id+ "'>Edit</button></td>"
                  +"</tr>");  
                });
              }else{

              }
              var buttonCommon = {
                    exportOptions: {
                        format: {
                            body: function(data, row, column, node) {
                                // Strip $ from salary column to make it numeric
                                return column === 5 ?
                                    data.replace(/[$,]/g, '') :
                                    data;
                            }
                        }
                    }
                };
                $('#myTable1').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        $.extend(true, {}, buttonCommon, {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5,6]
                            }
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'excelHtml5',
                            title: "Quotation List",
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5,6]
                            }
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdfHtml5',
                            title: "Quotation List",
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5,6]
                            }
                        })
                    ]
                });
            }
        });
    }

    function editSprTrack(id){  
        console.log(id);
        $.ajax({
            method: "POST",
            type: "json",
            data: {"id":id,"getSPRTrack": "getSPRTrack"},
            url: "../php/spr.php",
            success: function(data) {
              //console.log(data);
              if(data!=""){
                var info = JSON.parse(data);
                $("input[name='sprTrackId']").val(info.spr_track_id);
                $("input[name='sprNo']").val(info.spr_no);
                $("select[name='partNo']").val(info.part_no);
                $("input[name='requested']").val(info.requested);
                $("input[name='received']").val(info.received);
                $("input[name='faulty']").val(info.faulty);
                $("textarea[name='serialNo']").val(info.serial_no);
                $("#updateSPRTrackModal").modal();
              }
            },error:function(){

            }});
    }

    function deleteSprTrack(id){  
        $.ajax({
            method: "POST",
            type: "json",
            data: {"id":id,"deleteSPRTrack": "deleteSPRTrack"},
            url: "../php/spr.php",
            success: function(data) {              
                console.log(data);
              if(data=="Deleted"){
                location.reload();                                
              }
            },error:function(){

            }});
    }

    function getSpr() {
        var lastQuoNo = "";
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "getAllSPR": "getAllSPR"
            },
            url: "../php/spr.php",
            success: function(data) {
                console.log(data);
                if (JSON.parse(data).length > 0) {
                    var to = "";
                    $.each(JSON.parse(data), function(i, spr) {

                        var editBtn = "";
                        var deleteBtn = "";
                        var printBtn = "";
                        if ($.cookie("status") == "Offline") {
                            printBtn = "<button class='btn btn-success' onClick='printFunction(" + spr.sprDetails.spr_id + ")' >Print</button>&emsp;";
                            editBtn = "<button class='btn btn-warning' onClick='editSpr(" + spr.sprDetails.spr_id + ")' id='" + spr.sprDetails.spr_id + "' disabled>Edit</button>&emsp;";
                            deleteBtn = "<button class='btn btn-danger' onClick='deleteSpr(" + spr.sprDetails.spr_id + ")' id='" + spr.sprDetails.spr_id + "' disabled>Delete</button>";
                        } else {
                            printBtn = "<button class='btn btn-success' onClick='printFunction(" + spr.sprDetails.spr_id + ")' >Print</button>&emsp;";
                            editBtn = "<button class='btn btn-warning' onClick='editSpr(" + spr.sprDetails.spr_id + ")' id='" + spr.sprDetails.spr_id + "' >Edit</button>&emsp;";
                            deleteBtn = "<button class='btn btn-danger' onClick='deleteSpr(" + spr.sprDetails.spr_id + ")' id='" + spr.sprDetails.spr_id + "' >Delete</button>";
                        }
                        if (i == 0) {
                            $("#sprList").html("<tr>" + "<td>" + spr.sprDetails.spr_no + "</td>" + "<td>" + spr.customerDetails.company + "</td>" + "<td>" + spr.sprDetails.request_date + "</td>" + "<td>" + printBtn + editBtn + deleteBtn + "</td>" + "</tr>");
                        } else {
                            $("#sprList").append("<tr>" + "<td>" + spr.sprDetails.spr_no + "</td>" + "<td>" + spr.customerDetails.company + "</td>" + "<td>" + spr.sprDetails.request_date + "</td>" + "<td>" + printBtn + editBtn + deleteBtn + "</td>" + "</tr>");
                        }
                    });

                } else {

                }
                var buttonCommon = {
                    exportOptions: {
                        format: {
                            body: function(data, row, column, node) {
                                // Strip $ from salary column to make it numeric
                                return column === 5 ?
                                    data.replace(/[$,]/g, '') :
                                    data;
                            }
                        }
                    }
                };
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        $.extend(true, {}, buttonCommon, {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11]
                            }
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'excelHtml5',
                            title: "SPR List",
                            exportOptions: {
                                columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11]
                            }
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdfHtml5',
                            title: "SPR List",
                            exportOptions: {
                                columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11]
                            }
                        })
                    ],"columnDefs": [
                        {
                          "targets": [3,4,5,6,7,8,9,10,11],
                          "visible": false                
                        }
                    ]
                });
                getPart();
                $("header,.container-fluid,footer").show();
                $(".loader").hide();
            }
        });
    }

    function printFunction(id) {
        console.log(id);
        window.open("../php/spr.php?id=" + id + "", "_blank");
    }

    function editSpr(id) {
        window.open("editSpr.php?id=" + id + "", "_self");
    }

    function deleteSpr(id) {
        var c = confirm("Do you really want to delete " + id + "?");
        if (c) {
            $.ajax({
                method: "POST",
                type: "json",
                data: {
                    "deleteSPR": "deleteSPR",
                    "sprId": id
                },
                url: "../php/spr.php",
                success: function(data) {
                    alert("Deleted");
                    location.reload();
                },
                error: function(error) {
                    alert("Error Deleting");
                }
            });
        }
    }

    function getMachines() {
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "getAllMachine": "getAllMachine"
            },
            url: "../php/machine.php",
            success: function(data) {
                /*console.log(data);
                if (JSON.parse(data).length > 0) {
                    $.each(JSON.parse(data), function(i, machine) {
                        $("select[name='machino']").append("<option value='" + machine.machineDetails.machine_id + "'>" + machine.machineDetails.machine_no + "</option>");
                    });
                }*/
            }
        });
    }
</script>
</body>

</html>