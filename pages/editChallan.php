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
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/datepicker.css">
    <link rel="stylesheet" href="../css/multiselect/bootstrap-multiselect.css">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
    <title></title>
  <style media="screen">
      textarea.form-control{
        height: 34px;
      }</style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid">
      
      <form class="edit" action="../php/dc.php" method="POST">
        <div class="col-md-3" style="display: none;">
          <div class="form-group">
            <label for="to">Id</label>
            <input class="form-control" name="id" readonly/>
          </div>
        </div>
        <div class="col-md-3">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="eprojectno" />                  
                </div>
              </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="to">To</label>
            <select class="form-control" name="to" required>
              <option value="default">Select Customer</option>
              <?php                      
                $query = "SELECT * FROM customers";
                $result = $connection->query($query);
                $data = array();                
                if($result->num_rows>0){
                  while($row=$result->fetch_assoc()){                            
                    echo "<option value='".$row["id"]."'>".$row["company_name"]."-".$row["city"]."</option>";                                                  
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="challannumber">Challan No.</label>
            <input type="text" name="challannumber" class="form-control" />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="date">Issue Date</label>
            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                <input class="form-control" name="issuedate" type="text" >
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="date">Refrence No.</label>
            <input class="form-control" name="referencenumber" />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="valid">Reference Date</label>
            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                <input class="form-control" name="refdate" type="text" >
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Mode of transport</label>
            <select class="form-control" name="mode">
              <option value="default">Select</option>
              <option value="byhand">By Hand</option>
              <option value="road">Road</option>
              <option value="rail">Rail</option>
              <option value="air">Air</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">L.R. / R, R, NO.</label>
            <input type="text" name="lr" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Freight</label><br/>
            <input type="radio" name="freight" value="yes">Yes&emsp;
            <input type="radio" name="freight" value="no">No
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Returnable</label><br/>
            <input type="radio" name="returnable" value="yes">Yes&emsp;
            <input type="radio" name="returnable" value="no">No
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Shipment Date</label>
            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                <input class="form-control" name="shipdate" type="text" >
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Vehicle No.</label>
            <input type="text" name="vehicle" class="form-control">
          </div>
        </div>        
        <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Courier Service</label><br/>
                  <input type="text" class="form-control" name="ecourier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Dispatch No</label><br/>
                  <input type="text" class="form-control" name="edispatchno" placeholder="Dispatch No." />
                </div>
              </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="note">Terms &amp; Condition</label>
            <textarea class="form-control" name="terms" placeholder="Enter terms"></textarea>
          </div>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <button type="submit" name="updateDC" class="btn btn-info">Update Challan Details</button>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button>
        </div>
        <div class="col-md-11">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-condensed or">
                <thead>
                  <tr>
                    <!-- <th>Inward No.</th> -->
                    <th>Part No.</th>
                    <th>Description</th>
                    <th>Serials</th>
                    <th>Quantity</th>
                    <!-- <th>Part Discount</th>
                    <th>Rate</th>
                    <th>Landed Cost</th>
                    <th>Selling Cost</th>-->
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="parts">
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </form>
    </div>
    <?php include("footer.php");?>
    <div class="modal fade" id="addPartModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Part</h4>
      </div>
      <div class="modal-body">
        <form class="editForm" action="../php/dc.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="custid">Challan Id</label>
              <input type="text" class="form-control" name="challanId"  required="required" readonly />
            </div>
          </div>
          <input type="text" name="returnableStatusNewPart" style="display: none;" />
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Part</label><br/>
              <select class="form-control" name="part" >
                <option value="">Select</option>
                <?php                      
                  $query = "SELECT * FROM inventory_parts";
                  $result = $connection->query($query);
                  $data = array();                
                  if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){                            
                      echo "<option value='".$row["id"]."~".$row["part_number"]."'>".$row["part_number"]."</option>";                                                  
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Serial No.</label>              
              <input type="text" class="form-control" name="serial"/>              
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Quantity</label>
              <input type="text" class="form-control number" name="qty"  required="required"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Amount</label>
              <input type="text" class="form-control" name="amount"  />
            </div>
          </div>
          <div class="col-md-3" style="margin-top:2.5%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addDCPart">Add Part</button>
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
      <form class="editForm" action="../php/dc.php" method="post">
        <div class="col-md-3" style="display: none;">
          <div class="form-group">
            <label for="custid" >Id</label>
            <input type="text" class="form-control" name="eid" readonly />
          </div>
        </div>
        <div class="col-md-3" style="display: none;">
          <div class="form-group">
            <label for="custid">Challan Id</label>
            <input type="text" class="form-control" name="echallanId" readonly />
          </div>
        </div>
        <!-- <div class="col-md-3">
            <div class="form-group">
              <label for="custid">Inward No.</label>
              <select  class="form-control" name="eInwardNo">
                <option value="">Select</option>
                <?php                      
                /*$query = "SELECT * FROM duty";
                $result = $connection->query($query);
                $data = array();                
                if($result->num_rows>0){
                  while($row=$result->fetch_assoc()){                            
                    echo "<option value='".$row["duty_id"]."/".$row["inward_no"]."'>".$row["inward_no"]."</option>";                                                  
                  }
                }*/
              ?>
              </select>              
            </div>
          </div> -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyname">Part</label><br/>
            <select class="form-control" name="epart" >
              <option value="">Select</option>
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
            <label for="companyaddress">Serial No.</label>            
            <input class="form-control" name="eserialno" />
          </div>
        </div>
        <!-- <div class="col-md-3">
          <div class="form-group">
            <label for="lastname">Rate</label>
            <input type="text" class="form-control" name="erate"/>
          </div>
        </div> -->
        <!-- <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Landed Cost</label>
              <input type="text" class="form-control" name="eLandedCost" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Selling Cost</label>
              <input type="text" class="form-control" name="eSellingCost" />
            </div>
          </div>
        <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Discount %</label>
              <select class="form-control" name="epartdiscount"></select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Discounted Rate</label>
              <input class="form-control" name="epartdiscountrate"  readonly />
            </div>
          </div> -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="lastname">Quantity</label>
            <input type="text" class="form-control number" name="eqty" />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="lastname">Amount</label>
            <input type="text" class="form-control" name="eamount"   />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="updateDCPart">Update Part</button>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer" ></div>
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
    <script src="../js/select2.min.js"></script>
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
    <script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
    <script src="../js/custom.js"charset="utf-8"  type="text/javascript"></script>
    <script type="text/javascript">
    var partIndex = 0;
    var allStock = [];
    var stocks = [];
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem('parts');       
    var partPrice=0;
    var chNo = "";
    var dcSerial = [];
    var returnable=false;
    $("header,.container").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          
          $("select[name='to'],select[name='mode']").select2({"width":"100%"});
          checkNetworkStatus();
        });
        
        $(document).ready(function(){
          
          getPart();
          $("select[name='to']").prop('disabled', true);
          $("form.edit").submit(function(){
            $("select[name='to']").prop('disabled', false);
          });

          $("textarea[name='serial']").on("focusout",function(){            
            if($(this).val()=="na"||$(this).val()=="NA"||$(this).val()==" "||$(this).val()==""){             
              $("input[name='qty']").val("0");
            }else{ 
              if($(this).val().indexOf(",") !== -1){
                if($(this).val().indexOf(",")==$(this).val().length-1){                  
                  $("input[name='qty']").val($(this).val().split(',').length-1);
                }else{                 
                  $("input[name='qty']").val($(this).val().split(',').length);
                }
              }
            }
          });

           $("input[name='shipdate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });
          $("input[name='refdate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });
          $("input[name='issuedate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });

      


          $("textarea[name='eserialno']").on("focusout",function(){            
            if($(this).val()=="na"||$(this).val()=="NA"||$(this).val()==" "||$(this).val()==""){             
              $("input[name='eqty']").val("0");              
            }else{ 
              if($(this).val().indexOf(",") !== -1){
                if($(this).val().indexOf(",")==$(this).val().length-1){                  
                  $("input[name='eqty']").val($(this).val().split(',').length-1);                  
                }else{
                  $("input[name='eqty']").val($(this).val().split(',').length);                  
                }
              }
            }
          });

          $("select[name='serial[]']").on('select2:close', function (evt) {
            var uldiv = $(this).siblings('span.select2').find('ul')
            var count = $(this).select2('data').length
            if(count==0){
              uldiv.html("")
            }
            else{
              uldiv.html("<li>"+count+" items selected</li>")
            }
            $("input[name='qty']").val(count);
          });

          $("select[name='eserialno[]']").on('select2:close', function (evt) {
            var uldiv = $(this).siblings('span.select2').find('ul')
            var count = $(this).select2('data').length
            if(count==0){
              uldiv.html("")
            }
            else{
              uldiv.html("<li>"+count+" items selected</li>")
            }
            $("input[name='eqty']").val(count);
          });


          var type = "<?php echo $_GET['type']; ?>";
          if(type=="challan"){
            //getChallan();
          }
          $(".addpart").click(function(){
            partIndex++;
            addPartIds.push(partIndex);
            addPart();
          });         

          // part qty partdiscount rate amount

          $("select[name='inwardNo']").on("change",function (event) {
              console.log($(this).val());
              $.ajax({
                method: "POST",
                type: "json",
                data: { "inward_no":$(this).val().split("/")[1],
                "getDutyParticulars": "getDutyParticulars" },
                url: "../php/duty.php",
                success: function (data) {          
                    console.log(data);
                    $("select[name='part']").html("");
                    $("select[name='part']").append("<option value=''>Select</option>");
                    $.each(JSON.parse(data), function (i, part) {
                      $("select[name='part']").append("<option value='"+part.part_no+"'>"
                        +part.part_no.split("-")[1]+"</option>");
                    });
                    $("select[name='epart']").select2({"width":"100%"});
                }
              });  
          });
          
          $("select[name='eInwardNo']").on("change",function (event) {
              console.log($(this).val());
              $.ajax({
                method: "POST",
                type: "json",
                data: { "inward_no":$(this).val().split("/")[1],
                "getDutyParticulars": "getDutyParticulars" },
                url: "../php/duty.php",
                success: function (data) {          
                    console.log(data);
                    $("select[name='epart']").html("");
                    $("select[name='epart']").append("<option value=''>Select</option>");
                    $.each(JSON.parse(data), function (i, part) {
                      $("select[name='epart']").append("<option value='"+part.part_no+"'>"
                        +part.part_no.split("-")[1]+"</option>");
                    });
                    $("select[name='epart']").select2({"width":"100%"});
                }
              });  
          });

          $("select[name='part']").on("change",function (event) {
              var id = $(this).attr("id");
              var value = $(this).val();
              var val = $("select[name='part'] option:selected").text();                            
              $("select[name='partdiscount']").val("");
              $("input[name='partdiscountrate']").val("0");

              /*$.ajax({
                method: "POST",
                type: "json",
                data: { 
                  "inward_no":$("select[name='inwardNo']").val().split("/")[1],
                  "part":$(this).val(),
                  "getDutyParticularsPrice": "getDutyParticularsPrice" },
                  url: "../php/duty.php",
                  success: function (data) {          
                      var info = JSON.parse(data);
                      $("input[name='rate']").val(info.unit_rate_inr);
                      $("input[name='landedCost']").val(info.landed_cost_per_part);                      
                      $("input[name='amount']").val("0");                      
                  }
              });

              $.ajax({
                method: "POST",
                type: "json",
                data: { 
                  "inwardno":$("select[name='inwardNo']").val().split("/")[0],
                  "partno":val,
                  "getSerialByInward": "getSerialByInward" },
                url: "../php/dc.php",
                success: function (data) {  
                    console.log(data);
                  if(JSON.parse(data)[0].serial_number==""){
                      //alert();
                      $("select[name='serial[]']").html("");
                      $("select[name='serial[]']").select2({"width":"150px"}); 
                      $("select[name='serial[]']").prop('readonly', true);
                    }else{              
                      $("select[name='serial[]']").prop('readonly', false);
                      $("select[name='serial[]']").html("");
                      $("select[name='serial[]']").append("<option value=''>Select</option>");
                      $.each(JSON.parse(data), function (i, stock) {
                        $("select[name='serial[]']").append("<option value='"+stock.serial_number+"'>"
                          +stock.serial_number+"</option>");
                      });
                      $("select[name='serial[]']").select2({"width":"150px"});                  
                    }
               
                }
              });*/
          });

          $("select[name='epart']").on("change",function (event) {
              var id = $(this).attr("id");
              var value = $(this).val();
              var val = $("select[name='epart'] option:selected").text();
            

              $("select[name='epartdiscount']").val("");
              $("input[name='epartdiscountrate']").val("0");

              $.ajax({
                method: "POST",
                type: "json",
                data: { 
                  "inward_no":$("select[name='eInwardNo']").val().split("/")[1],
                  "part":$(this).val(),
                  "getDutyParticularsPrice": "getDutyParticularsPrice" },
                  url: "../php/duty.php",
                  success: function (data) {          
                      var info = JSON.parse(data);
                      $("input[name='erate']").val(info.unit_rate_inr);
                      $("input[name='eLandedCost']").val(info.landed_cost_per_part);                      
                      $("input[name='eamount']").val("0");                      
                  }
              });

              $.ajax({
                method: "POST",
                type: "json",
                data: { 
                  "inwardno":$("select[name='eInwardNo']").val().split("/")[0],
                  "partno":val,
                  "getSerialByInward": "getSerialByInward" },
                url: "../php/dc.php",
                success: function (data) {                            
                  $("select[name='eserialno[]']").html("");
                  $("select[name='eserialno[]']").append("<option value=''>Select</option>");
                  $.each(JSON.parse(data), function (i, stock) {
                    $("select[name='eserialno[]']").append("<option value='"+stock.serial_number+"'>"
                      +stock.serial_number+"</option>");
                  });
                  $("select[name='eserialno[]']").select2({"width":"100%"});                  
                }
              });
          });

         

          $("select[name='partdiscount']").on("change",function (event) {
            var dis = parseFloat($("select[name='partdiscount']").val()/100);
              var dr = $("input[name='sellingCost']").val() - (dis*$("input[name='sellingCost']").val());
              $("input[name='partdiscountrate']").val(dr);
              
          });

          $("select[name='epartdiscount']").on("change",function (event) {
              var dis = parseFloat($("select[name='epartdiscount']").val()/100);
              var dr = $("input[name='eSellingCost']").val() - (dis*$("input[name='eSellingCost']").val());
              $("input[name='epartdiscountrate']").val(dr);
             
          });

          $("input[name='qty']").on("keyup",function(){            
            var pr =parseInt($("input[name='partdiscountrate']").val());
            $("input[name='amount']").val(pr*$(this).val());            
          });

          $("input[name='eqty']").on("keyup",function(){
            var pr =parseInt($("input[name='epartdiscountrate']").val());
            $("input[name='eamount']").val(pr*$(this).val());            
          });

        });
      })();

      function addPart(){
        $("input[name='quantity']").val("")
        $("input[name='unitprice']").val("")
        $("input[name='amount']").val("");
        $("textarea[name='description']").val("");
        $("input[name='returnable']").val(returnable);
        $("input[name='challanId']").val(<?php echo $_GET['id'];?>+"-"+chNo);
        //chNo, returnable
        $("select[name='part'],select[name='inwardNo']").select2();
        $("select[name='part'],select[name='inwardNo']").select2({"width":"100%"});
        $("select[name='serial[]']").select2();
        $("select[name='serial[]']").select2({width: '100%'});
        $("#addPartModal").modal();
      }

      function getPart(){
        if(partsData==null){
          $.ajax({
          method:"POST",
          type:"json",
          data:{"getAllInventory":"getAllInventory"},
          url:"../php/inventory.php",
          success:function(data){
            partsData = data;
            localStorage.setItem('parts', partsData);            
            getCustomers();
          }
          });
        }else{
          getCustomers();
        }
      }

      function getCustomers(){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"viewAll":"getAllCustomers"},
  				url:"../php/customer.php",
  				success:function(data){
  					//console.log(data);
            customers = data;
            /*if(JSON.parse(data).length>0){
              $.each(JSON.parse(data),function(i,vendor){
                if(i==0){
                  $("select[name='to']").append("<option value='"+vendor.id+"'>"+vendor.company
                    +" - "+vendor.city+"</option>");
                }else{
                  $("select[name='to']").append("<option value='"+vendor.id+"'>"+vendor.company
                    +" - "+vendor.city+"</option>");
                }
              });
            }*/
            getChallan();
  			}});
      }

      function getChallan(){
        var id = <?php echo $_GET['id']; ?>;
        var data = {
          "getDC":"getDC",
          "dcId":id
        };
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"getDC":"getDC","dcId":id},
  				url:"../php/dc.php",
  				success:function(data){
  					console.log(data);
            var partdet = JSON.parse(data);
            $("input[name='id']").val(<?php echo  $_GET['id'];?>);
            $("select[name='to']").val([partdet[0].to]).trigger("change");
            $("input[name='challannumber']").val(partdet[0].chno);
            chNo = partdet[0].chno;            
            $("input[name='eprojectno']").val(partdet[0].projectno);
            $("input[name='ecourier']").val(partdet[0].courier);
            $("input[name='edispatchno']").val(partdet[0].dispatchno);
            $("input[name='issuedate']").val(partdet[0].date.split(" ")[0]);
            $("input[name='referencenumber']").val(partdet[0].refno);
            $("input[name='refdate']").val(partdet[0].refdate.split(" ")[0]);
            $("select[name='mode']").val([partdet[0].mode]).trigger("change");
            $("input[name='lr']").val(partdet[0].lrno);
            $("input[name='shipdate']").val(partdet[0].shipdate.split(" ")[0]);
            $("input[name='vehicle']").val(partdet[0].vehno);

            if(partdet[0].freight==1){
              $("input[name='freight'][value='yes']").attr('checked', 'checked');
            }else{
              $("input[name='freight'][value='no']").attr('checked', 'checked');
            }
			$("input[name='returnableStatusNewPart']").val(partdet[0].returnable);
            if(partdet[0].returnable==1){
              $("input[name='returnable'][value='yes']").attr('checked', 'checked');
              returnable = "yes";
            }else{
              returnable = "no";
              $("input[name='returnable'][value='no']").attr('checked', 'checked');
            }
            $("textarea[name='note']").val(partdet[0].terms);
            $("textarea[name='terms']").val(partdet[0].terms);
            $("select[name='partdiscount'],select[name='epartdiscount']").append("<option value=''>Select Discount</option>");
            $.each(JSON.parse(customers), function(i, cust){
              if(cust.id == partdet[0].to){
                $("select[name='partdiscount']").append("<option value='"+cust.discount1+"'>"+cust.discount1+"</option>");
                $("select[name='partdiscount']").append("<option value='"+cust.discount2+"'>"+cust.discount2+"</option>");
                $("select[name='partdiscount']").append("<option value='"+cust.discount3+"'>"+cust.discount3+"</option>");
                $("select[name='epartdiscount']").append("<option value='"+cust.discount1+"'>"+cust.discount1+"</option>");
                $("select[name='epartdiscount']").append("<option value='"+cust.discount2+"'>"+cust.discount2+"</option>");
                $("select[name='epartdiscount']").append("<option value='"+cust.discount3+"'>"+cust.discount3+"</option>");
              }
            });

            $.each(JSON.parse(data)[0].chParts, function(i, part){
              var partNo = partDesc = "";
              $.each(JSON.parse(partsData), function(d, p){
                if(p.id==part.partId){
                  partNo = p.partno;
                  partDesc = p.desc;
                }
              });
              var element = "";
              element = "<tr>"
              //+"<td>"
              //+"<input class='form-control' type='text' value='"+part.inward_no+"' readonly='readonly'/>"
              //+"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+partNo+"' readonly='readonly'/>"
              +"</td>"
              +"<td>"
              +"<textarea class='form-control' id='"+part.id+"' value='"+partDesc+"' readonly></textarea>"
              +"</td>"
              +"<td>"
              +"<textarea class='form-control' id='"+part.id+"' value='"+part.serials+"' readonly>"+part.serials+"</textarea>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.qty+"' readonly/>"
              +"</td>"
              /*+"<td>"
              +"<input class='form-control' type='text' value='"+part.part_dis+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.unitprice+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.landed_cost+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.selling_price+"' readonly/>"
              +"</td>"*/
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.partTotAmount+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<a onclick='updatePart("+part.id+")' id="+partIndex+">Edit</a>&emsp;"
              +"<a onclick='deleteDCPart("+part.id+")' id="+partIndex+">Remove</a>"
              +"</td>"
              +"</tr>";
              $("#parts").append(element);
              $("#"+part.id).val(partDesc);
              $.each(JSON.parse(partsData), function(i, part){
                $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"</option>");
              });
            });
            getStocks();
            //getAllStocks();

            $("header,.container").show();
            $(".loader").hide();
          },error:function(error){
            alert(error);
          }
        });
      }      

      function updatePart(id){
        $("input[name='quantity']").val("")
        $("input[name='unitprice']").val("")
        $("input[name='amount']").val("");
        $("textarea[name='description']").val("");
        $.ajax({
          method:"POST",
          type:"json",
          data:{"getDCPart":"getDCPart","dcPartId":id},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            //{"id":"2","dc":"1","part":"14","qty":"15","rate":"123","amount":"1850"}
            if(JSON.parse(data).length>0&&JSON.parse(data).length==1){
              var pa = JSON.parse(data)[0];
              //getAllStocks(pa,$("select[name='epart'] option:selected").text());
              $("input[name='eid']").val(pa.id);
              $("input[name='echallanId']").val(pa.dc);
              $("select[name='eInwardNo']").val(pa.inward_no);
              $("select[name='epart']").val(pa.part);
              $("input[name='eserialno']").val(pa.serials);
             // $("select[name='epartdiscount']").val(pa.part_dis);              
              $("input[name='eqty']").val(pa.qty);
             // $("input[name='erate']").val(pa.rate);
              //var discr = pa.rate - ((pa.rate*pa.part_dis)/100)
              //$("input[name='epartdiscountrate']").val(discr);
              $("input[name='eamount']").val(pa.amount);
              $("select[name='epart'],select[name='eInwardNo']").select2();
              $("select[name='epart'],select[name='eInwardNo']").select2({"width":"100%"});
              $("select[name='eserialno[]']").select2();
              $("select[name='eserialno[]']").select2({width: '100%'});
              $("#editPartModal").modal();
            }
          }
        });
      }

      function getStocks(){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"getWarehouseStocksUnused":"getWarehouseStocksUnused"},
          url:"../php/warehouseStock.php",
          success:function(data){
            console.log(data);
            stocks = data;
            //getSerialNo();
            
          },
          error:function(error){

          }
      });
    }

      function deleteDCPart(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"partId":id,"deleteDCPart":"deleteDCPart"},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            if(data=="Deleted"){
              location.reload();
            }else{
              alert("Unable to delete Contact Admin");
            }
          },error: function(error){
            alert("Unable to delete Contact Admin");
          }});
      }
    }

    function getAllStocks(part){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"stockByPart":"stockByPart", "part":part},
          url:"../php/warehouseStock.php",
          success:function(data){
            console.log("Akshay "+data);
            allStock = data;            
          },
          error:function(error){

          }
      });      
    }

    
    </script>
  </body>
</html>
