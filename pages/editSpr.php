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

    <link rel="stylesheet" href="../css/multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/datepicker.css">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
    <title></title>
    <style type="text/css">
      textarea.form-control{
        height: 34px;
      }
      .btn-group{
          position: relative;
          display: block;
          vertical-align: middle;
      }
    </style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid">
      <form class="edit" action="../php/spr.php" method="POST">
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label for="to">Id</label>
                  <input class="form-control" name="sprId" />
                </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>SPR Date</label>
                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="sprdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Spr No.</label>
                <input class="form-control" name="sprno" value="SPR-<?php echo Date("Ymd");?>" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Customer</label>
                <select class="form-control" name="customer" >
                  <option value="">Select Customer</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" name="machiname"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Igm Order No</label>
                <input class="form-control number" name="ordreno" />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Machine No</label>
                <!-- <input type="text" class="form-control" name="machino"/> -->
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
            <div class="col-md-3">
              <div class="form-group">
                <label>Request Date</label>
                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="reqdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Reference Email</label>
                <input class="form-control number" name="refEmail" maxlength="32" />
              </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
              <div class="form-group">
                <label>Shipment By</label>
                <select class="form-control" name="shpimentBy">
                  <option value="">Select</option>
                  <option value="TNT/DHL">TNT/DHL</option>
                  <option value="Air freight">Air freight</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remark" maxlength="70"></textarea>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Error</label>
                <textarea class="form-control" name="error" maxlength="70"></textarea>
              </div>
            </div>
              <div class="col-md-3" style="padding:2%;">
                <button type="submit" name="editSpr" class="btn btn-info">Update Spr Details</button>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" >Add SPR Part</button>
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>                         
                        <th>Quantity</th>
                        <th>Part No.</th>
                        <th>Serial number</th>
                        <th>Description</th>
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
        <form  action="../php/spr.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="Quantity">SPR</label>
              <input type="text" class="form-control" name="sprId" value="<?php echo $_GET["id"]?>"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="newpartused">Part Used From</label>
              <select class="form-control" name="newPartUsed">
                <option value="">Select</option>
                <option value='Customers stock'>Customers stock</option>
                <option value='Consignment Stock'>Consignment Stock</option>
                <option value='igm India stock'>igm India stock</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="Quantity">Quantity</label>
              <input type="text" class="form-control" name="quantity" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="partno">Part No</label><br/>
              <select class="form-control" name="part" ></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="discription">Description</label>
              <textarea class="form-control" name="description"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="remark">Remarks</label>
              <textarea class="form-control" name="remark"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="newserial">Serial No.</label>
              <textarea class="form-control" name="newSer"></textarea>
            </div>
          </div>
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addSPRPart">Add Part</button>
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
      <form class="editForm" action="../php/spr.php" method="post">
        <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="Quantity">Id</label>
              <input type="text" class="form-control" name="eId" />
            </div>
          </div>
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="Quantity">SPR</label>
              <input type="text" class="form-control" name="eSprId" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="Quantity">Quantity</label>
              <input type="text" class="form-control" name="eQuantity" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="newpartused">Part Used From</label>
              <select class="form-control" name="eUsedFrom">
                <option value="">Select</option>
                <option value='Customers stock'>Customers stock</option>
                <option value='Consignment Stock'>Consignment Stock</option>
                <option value='igm India stock'>igm India stock</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="partno">Part No</label><br/>
              <select class="form-control" name="ePart" >
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="discription">Description</label>
              <textarea class="form-control" name="eDescription"></textarea>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="newserial">Serial No.</label>
              <textarea class="form-control" name="eSerialNo"></textarea>
            </div>
          </div>          
          <div class="col-md-3">
            <div class="form-group">
              <label for="remark">Remarks</label>
              <textarea class="form-control" name="eRemark"></textarea>
            </div>
          </div>
        <div class="col-md-3" style="padding:2%;">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="updateSPRPart">Update Part</button>
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
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem('parts');
    var unp=0;
    $("header,.container, footer").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          checkNetworkStatus();
          $("select[name='machino'],select[name='nonAccountableReason'],select[name='shpimentBy']").select2({"width":"100%"});
        });
        $(document).ready(function(){
          /*$("select[name='nonAccountableReason']").multiselect({
            numberDisplayed: 1
          });*/
          getCustomers();
          getPart();
          getMachines();

          $("select[name='machino']").on("change",function(){
            getMachineName($(this).val());            
          });

          $("select[name='customer']").prop('disabled', true);
          $("form.edit").submit(function(){
            $("select[name='customer']").prop('disabled', false);
          });

          $("select[name='discount']").change(function(){
            var price = ($(this).val()/100)*$("input[name='rate']").val();
            $("input[name='discountprice']").val($("input[name='rate']").val()-price);
          });

          $("input[name='date'],input[name='reqdate'],input[name='sprdate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });
          

          
          $(".addpart").click(function(){
            // partIndex++;
            // addPartIds.push(partIndex);
            addPart();
          });

          $("select[name='part']").on("change",function (event) {
              var id = $(this).attr("id");
              var val = $(this).val();
              $("input[name='amount']").val("0");
              $("select[name='discount']").val("");
              $("input[name='discountprice']").val("0");
              $.each(JSON.parse(partsData), function(i, part){
                if(part.id==val){
                  $("textarea[name='description']").val(part.desc);
                  $("input[name='rate']").val(part.unitprice);
                  $("input[name='qty']").val("0");
                  $("input[name='amount']").val("0");
                  $("input[name='tax']").val("0");
                  unp = part.unitprice;
                }
              });
          });

          $("select[name='ePart']").on("change",function (event) {              
              $("textarea[name='eDescription']").val("");
              $.each(JSON.parse(partsData), function(i, part){
                if(part.id==$("select[name='ePart']").val()){
                  $("textarea[name='eDescription']").val(part.desc);                                    
                }
              });
          });

          $("input[name='qty']").on("input",function (event) {
            $("input[name='tax']").val("0");
            $("input[name='amount']").val("0");
          });

          $("input[name='eqty']").on("input",function (event) {
            $("input[name='etax']").val("0");
            $("input[name='eamount']").val("0");
          });

          $("select[name='discount']").on("change",function (event) {
            var dis = parseFloat($(this).val()/100);
            $("input[name='amount']").val("0");
            $("input[name='tax']").val("0");
            $("input[name='rate']").val(unp-(unp*dis));
          });

          $("select[name='ediscount']").on("change",function (event) {
            var dis = parseFloat($(this).val()/100);
            $("input[name='eamount']").val("0");
            $("input[name='etax']").val("0");
            //$("input[name='erate']").val(unp-(unp*dis));
            $("input[name='ediscountprice']").val($("input[name='erate']").val()-($("input[name='erate']").val()*dis));
          });

          $("input[name='tax']").on("input",  function (event) {
              var qty = parseInt($("input[name='qty']").val());
              var unitPrice = parseFloat($("input[name='rate']").val());
              var dis = parseFloat(parseFloat($("select[name='discount']").val())/100);
              var tax = parseFloat($(this).val())/100;
              var fup = (unitPrice-(unitPrice*dis)) + (tax*unitPrice-(unitPrice*dis));
              var amt = parseFloat(fup*qty);
              //var amt = parseFloat(((unitPrice-(unitPrice*dis))*qty) + (tax*unitPrice-(unitPrice*dis)));
              $("input[name='amount']").val(parseInt(amt));
          });

          $("input[name='etax']").on("input",  function (event) {
            var qty = parseInt($("input[name='eqty']").val());
            var unitPrice = parseFloat($("input[name='erate']").val());
            var dis = parseFloat(parseFloat($("select[name='ediscount']").val())/100);
            var tax = parseFloat($(this).val());
            var fup = (unitPrice-(unitPrice*dis)) + (tax*unitPrice-(unitPrice*dis));
            var amt = parseFloat(fup*qty);
            //var amt = parseFloat(((unitPrice-(unitPrice*dis))*qty) + tax);
            $("input[name='eamount']").val(parseInt(amt));
          });

        });
      })();

       function getMachines(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllMachine":"getAllMachine"},
        url:"../php/machine.php",
        success:function(data){         
          console.log(data);
          /*if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,machine){
              $("select[name='machino']").append("<option value='"+machine.machineDetails.machine_id+"'>"+machine.machineDetails.machine_no+"</option>");              
            });
          }*/
      }});
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

      function addPart(){        
        $.each(JSON.parse(partsData),function(i,part){
          $("select[name='part']").append("<option value='part.id'>"+part.partno+"</option>");
        });
        $("select[name='part']").select2(); 
        $("select[name='part']").select2({width: '100%'});
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
            console.log(data);
            $("select[name='part']").append("<option value='default'>Select Part</option>");
            $("select[name='epart']").append("<option value='default'>Select Part</option>");
            $.each(JSON.parse(data), function(i,part){
              //if(part.landedcost!="0.00"){ 
                $("select[name='part']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
                $("select[name='epart']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
              //}
            })
            partsData = data;                       
            localStorage.setItem("parts", partsData);
            getSpr();
          }
          });
        }else{
          getSpr();
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
            if(JSON.parse(data).length>0){
              $.each(JSON.parse(data),function(i,vendor){
                if(i==0){
                  $("select[name='customer']").append("<option value='"+vendor.id+"'>"+vendor.company+" - "+vendor.city+"</option>");
                }else{
                  $("select[name='customer']").append("<option value='"+vendor.id+"'>"+vendor.company+" - "+vendor.city+"</option>");
                }
              });
            }
            
        }});
      }

      function getSpr(){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"getSPR":"getSPR","sprId":<?php echo $_GET['id']; ?>},
          url:"../php/spr.php",
          success:function(data){
            console.log(data);
            $spr = JSON.parse(data);
            $("input[name='sprId']").val($spr.sprDetails.spr_id);
            $("input[name='sprdate']").val($spr.sprDetails.spr_date.split(" ")[0]);
            $("input[name='sprno']").val($spr.sprDetails.spr_no);
            $("select[name='customer']").val([$spr.sprDetails.customer]).trigger("change");
            $("select[name='deliveryTo']").val([$spr.sprDetails.delivery_to]).trigger("change");
            $("select[name='machino']").val([$spr.sprDetails.machine]).trigger("change");
            $("input[name='machiname']").val($spr.sprDetails.machine_name);
            $("input[name='reqby']").val($spr.sprDetails.request_by);            
            $("input[name='reqdate']").val($spr.sprDetails.request_date);
            $("input[name='ordreno']").val($spr.sprDetails.igm_order_no);
            $("input[name='refEmail']").val($spr.sprDetails.ref_email);
            $("select[name='shpimentBy']").val([$spr.sprDetails.shipment_by]).trigger("change");
            $("select[name='nonAccountableReason']").val([$spr.sprDetails.non_accountable_reason]).trigger("change");            
            //console.log($spr.sprDetails.non_accountable_reason.split(", "));
            $("textarea[name='remark']").val($spr.sprDetails.remarks);
            $("textarea[name='error']").val($spr.sprDetails.error);
            $.each($spr.sprParts,function(i,$sprPart){
              var partNo = "";
              $.each(JSON.parse(partsData),function(i,part){
                //console.log(part);
                if(part.id==$sprPart.part_no){
                  partNo = part.partno;
                }
                //$("select[name='ePartNo']").append("<option value='part.id'>"+part.partno+"</option>");
              });
              $("#parts").append("<tr>"
                +"<td>"+$sprPart.quantity+"</td>"
                +"<td>"+partNo+"</td>"
                +"<td>"+$sprPart.serial_no+"</td>"
                +"<td>"+$sprPart.description+"</td>"
                +"<td>"+$sprPart.remarks+"</td>"
                +"<td>"+$sprPart.used_from+"</td>"
                +"<td><a onClick='getSprPart("+$sprPart.spr_part_id+")' class='btn btn-warning'>Edit</a></td>"
                +"</tr>");                              
            });
            $("header,.container, footer").show();
            $(".loader").hide();
          },error:function(error){
            alert(error);
          }
        });
      }

      function getSprPart(id){
        $("input[name='eId']").val("");
            $("input[name='eSprId']").val("");
            $("input[name='eQuantity']").val("");
            $("select[name='ePart']").val("");
            $("textarea[name='eDescription']").val("");
            $("textarea[name='eRemark']").val("");
            $("textarea[name='eSerialNo']").val("");
            $("select[name='eUsedFrom']").val("");
        $.ajax({
          method:"POST",
          type:"json",
          data:{"getSPRPart":"getSPRPart","sprPartId":id},
          url:"../php/spr.php",
          success:function(data){
            $.each(JSON.parse(partsData),function(i,part){
              //if(part.landedcost!="0.00"){
                $("select[name='ePart']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
              //}              
            });
            var sprPart = JSON.parse(data);
            $("input[name='eId']").val(sprPart.spr_part_id);
            $("input[name='eSprId']").val(sprPart.spr);
            $("input[name='eQuantity']").val(sprPart.quantity);
            $("select[name='ePart']").val(sprPart.part_no);
            $("textarea[name='eDescription']").val(sprPart.description);
            $("textarea[name='eRemark']").val(sprPart.remarks);
            $("textarea[name='eSerialNo']").val(sprPart.serial_no);
            $("select[name='eUsedFrom']").val(sprPart.used_from);
            $("select[name='ePart']").select2(); 
            $("select[name='ePart']").select2({width: '100%'});
            $("#editPartModal").modal();
          }
        });
      }


      function deleteQuoPart(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"partId":id,"deleteQuoPart":"deleteQuoPart"},
          url:"../php/quotation.php",
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
    </script>
  </body>
</html>
