<?php
  require_once("../php/db.php");
  $db=new DB();
  $connection=$db->getConnection();
?>
<html>
<head>
  <meta name="charset" content="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Control System|Edit Service History</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link href="../css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/custom.css">
    <style type="text/css">
      textarea.form-control{
        height: 34px;
      }
    </style>
</head>
<body>
  <?php include "menu.php"; ?>  
  <div class="container-fluid content" >
    <div class="row">
      <div class="col-md-12">
        <form class="" action="../php/sh.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="companyname">Id</label>
              <input type="text" class="form-control" name="id" placeholder="Enter customer no" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Machine</label>
              <select class="form-control" name="machine">
                <option value="">Select</option>
                  <?php
                      $query="SELECT * FROM machine";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<option value='".$row["machine_id"]."'>".$row["machine_no"]."</option>";                          
                        }
                      }                                     
                    ?>  
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Customer</label>
              <select class="form-control" name="customer">
                <option value="">Select</option>
                  <?php
                      $query="SELECT * FROM customers";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<option value='".$row["id"]."'>".$row["company_name"]
                          ." - ".$row["city"]."</option>";
                        }
                      }                                     
                    ?>  
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Date of Service</label>
              <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="serviceDate" type="text" >
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Date of Report</label>
              <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="reportDate" type="text" >
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Engineer</label>
            <select class="form-control" name="engineer">
                <option value="">Select</option>
                  <?php
                      $query="SELECT * FROM user WHERE role='service' OR role='engineer'";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<option value='".$row["id"]."'>".$row["name"]."</option>";                          
                        }
                      }                                     
                    ?>  
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Cost</label>
            <select class="form-control" name="costType">
              <option value="">Select</option>
              <option value="Good will">Good will</option>
              <option value="Chargeable">Chargeable</option>
              <option value="Under warranty">Under warranty</option>
            </select>
          </div>
        </div>         
          
          <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Closed Date</label>
            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                <input class="form-control" name="closedDate" type="text" >
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Working Hrs.</label>
            <input class="form-control" name="workingHrs"></input>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Status</label>
            <select class="form-control" name="status">
              <option>Select</option>
              <option value="Pending">Pending</option>
              <option value="Completed">Completed</option>
            </select>            
          </div>
        </div>        
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Repetitve</label>
            <input class="form-control" name="repetitive"/>
          </div>
        </div>        
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Down Hrs.</label>
            <input class="form-control" name="downHour"/></input>
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Error Code</label>
            <input type="text" class="form-control" name="errorCode"/>
            <!-- <select class="form-control" name="errorCode">
                <option value="">Select</option>
                  <?php
                      /*$query="SELECT * FROM error";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<option value='".$row["error_id"]."'>".$row["error_code"]."</option>";                          
                        }
                      } */                                    
                    ?>  
              </select> -->
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Error Description</label>
            <textarea class="form-control" name="errorDescription"/></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Action Taken</label>
            <textarea class="form-control" name="action"/></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Root Cause</label>
            <textarea class="form-control" name="rootCause"/></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Remarks</label>
            <textarea class="form-control" name="remarks"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Spare Parts Replaced</label>
            <textarea class="form-control" name="spareParts"></textarea>
          </div>
        </div>        
        <div class="col-md-6" style="padding:2%;">
            <button class="btn btn-success" type="submit" name="updateService">Edit Service</button>
            <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
          </div>
        </form>
      </div>     
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


<div class="modal fade" id="addPartModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Replaced Part</h4>
      </div>
      <div class="modal-body">
        <form class="editForm" action="../php/sh.php" method="post">
          <div class="col-md-4">
            <div class="form-group">
              <label for="custid">Service Id</label>
              <input type="text" class="form-control" value="<?php echo $_GET["id"];?>" name="serviceId" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyname">Part</label>
              <select class="form-control" name="partNo" ></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyaddress">Serial No</label>
              <textarea class="form-control" name="serialNo"></textarea>
            </div>
          </div>          
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addServiceSparePart">Add Part</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" ></div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="editPartModal" role="dialog">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Update Part</h4>
    </div>
    <div class="modal-body">
      <form class="editForm" action="../php/sh.php" method="post">
          <div class="col-md-4">
            <div class="form-group">
              <label for="custid">Id</label>
              <input type="text" class="form-control" name="eId" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="custid">Service Id</label>
              <input type="text" class="form-control" name="eServiceId" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyname">Part</label>
              <select class="form-control" name="ePartNo" ></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyaddress">Serial No</label>
              <textarea class="form-control" name="eSerialNo"></textarea>
            </div>
          </div>          
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="updateServiceSparePart">Update</button>
            </div>
          </div>
        </form>
    </div>
    <div class="modal-footer" ></div>
  </div>
</div>
</div>

  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
  <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
  <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
  <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
  <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
    <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
    <script src="../js/select2.min.js"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
	$("header,.content,footer").hide();
	$(document).ready(function(){
		checkNetworkStatus();    
		$("header,.content,footer").hide();
		$(".loader").show();
    $("input[name='closedDate'],input[name='reportDate'],input[name='eClosedDate'],input[name='eReportDate'],input[name='serviceDate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });
    getServiceHistory();
    $("select[name='machine'],select[name='customer'],select[name='engineer'],select[name='costType'],select[name='status']").select2({"width":"100%"});
    $(".loader").hide();
    $("header,.content,footer").show();
    $(".addpart").click(function(){
      addPart();
    });
    if($.cookie("userrole")=="viewer"){
      $("button[name='updateService']").attr("disabled","disabled");
      $(".addpart").attr("disabled","disabled");
    }
	});

  function addPart(){        
    $.each(JSON.parse(partsData),function(i,part){
      $("select[name='partNo']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
    });
    $("#addPartModal").modal();
  } 

  function getMachines(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllMachine":"getAllMachine"},
        url:"../php/machine.php",
        success:function(data){         
          //console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,machine){
              $("select[name='machine']").append("<option value='"+machine.machineDetails.machine_id+"'>"+machine.machineDetails.machine_no+"</option>");              
            });
          }
          getUsers();
      }});
    }

    function getUsers(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"viewAll":"getAllUsers"},
        url:"../php/register.php",
        success:function(data){          
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,user){              
              if(user.approved!=0&&user.active!=0){
                $("select[name='engineer']").append("<option value='"+user.id+"'>"+user.name+"</option>");
              }
            });
          } 
          getParts();                          
        }
      });
    }

    function getParts() {
      if(partsData==null){
        $.ajax({
        method: "POST",
        type: "json",
        data: { "getAllInventory": "getAllInventory" },
        url: "../php/inventory.php",
        success: function (data) {        
          partsData = data;
          localStorage.setItem("parts",partsData);
        }
      });
      }
      getServiceHistory();
    }

  function getServiceHistory(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"serviceId":<?php echo $_GET['id']; ?>,"getService":"getService"},
        url:"../php/sh.php",
        success:function(data){         
          console.log(data);
          var service = JSON.parse(data);
          $("input[name='id']").val(service.service_id);
          $("select[name='machine']").val([service.machine]).trigger("change");
          $("input[name='serviceDate']").val(service.service_date);
          $("select[name='customer']").val([service.customer]).trigger("change");
          $("select[name='status']").val([service.status]).trigger("change");
          $("input[name='reportDate']").val(service.reported_date);
          $("input[name='closedDate']").val(service.closed_date);
          $("textarea[name='errorDescription']").val(service.error_description);
          $("textarea[name='action']").val(service.action);
          $("input[name='dayOnSite']").val(service.days_on_site);
          $("textarea[name='status']").val(service.status);
          $("input[name='errorCode']").val(service.error_code);
          $("select[name='engineer']").val([service.engineer]).trigger("change");
          $("input[name='downHour']").val(service.down_hrs);
          $("input[name='repetitive']").val(service.repetitive);
          $("input[name='workingHrs']").val(service.working_hrs);
          $("textarea[name='remarks']").val(service.remarks);
          $("textarea[name='rootCause']").val(service.root_cause);
          $("textarea[name='spareParts']").val(service.spare_part_replace);
          $("input[name='cost']").val(service.cost);
          $("select[name='costType']").val([service.cost_type]).trigger("change");
          $(".loader").hide();
          $("header,.content,footer").show();
      }});
    }

    function getServicePart(id){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"serviceSparePartId":id,"getServiceSparePart":"getServiceSparePart"},
          url:"../php/sh.php",
          success:function(data){
            $.each(JSON.parse(partsData),function(i,part){              
              $("select[name='ePartNo']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
            });            
            var servicePart = JSON.parse(data);
            $("input[name='eId']").val(servicePart.service_spare_parts_id);
            $("input[name='eServiceId']").val(servicePart.service);
            $("select[name='ePartNo']").val(servicePart.part_no);
            $("textarea[name='eSerialNo']").val(servicePart.serial_no);
            $("#editPartModal").modal();
          }
      });
    }

  </script>
</body>
</html>
