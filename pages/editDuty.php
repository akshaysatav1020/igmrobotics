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
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid">
      <form class="edit" action="../php/duty.php" method="POST">
        <div class="col-md-3" style="display: none">
          <div class="form-group">
            <input class="form-control" name="id" readonly/>
            <input type="text" name="againstPo" value='false' style="display: none" />
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Inward Number</label>
                <input class="form-control" name="inwardNo" value="" readonly="readonly" />                  
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Inward Date</label>
                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                    <input class="form-control" name="inwardDate" />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>                  
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Vendor</label>
                <input class="form-control" name="vendor" type="text" readonly/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Invoice Number.</label>
                <input class="form-control" name="invoiceNo" />                  
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Bill Of Entry Number.</label>
                <input class="form-control" name="billOfEntryNo" />                  
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label>Bill of Entry Date</label>
               <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="billOfEntryDate" />  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>                 
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Conversion Rate</label>
                <input class="form-control" name="euroRate" />                  
            </div>
        </div>
        <div class="col-md-3" style="display: none">
            <div class="form-group">
                <label>Discount %</label>
                <input class="form-control" name="discount" value="0.00"/>                  
            </div>
        </div>              
        <div class="col-md-3" style="padding-top: 2%;">
            <button type="submit" name="updateDuty" class="btn btn-info">Update Details</button>
            <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-condensed or">
                <thead>
                  <tr>
                  <th style="width: 100px;">Part No.</th>                          
                  <th style="width: 137px;">Unit Rate (Euro)</th>
                  <th style="width: 137px;">Unit Rate (INR)</th>
                  <th>Quantity</th>
                  <th>Duty Amt.</th>
                  <th style="width: 129px;">Clearing Amt.</th>
                  <th>Packaging</th>
                  <th style="width: 149px;">Forwarding Amt.</th>
                  <th style="width: 154px;">Landed Cost/Unit</th>
                  <th style="width: 96px;">Landed Cost</th>
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
        <form class="editForm" action="../php/duty.php" method="post">
          <input type="text" name="againstPo" value='false'  style="display: none"/>
          <input type="text" style="display: none" name="dutyId" value="<?php echo $_GET['id']; ?>"/>
          <div class="col-md-3">
          <div class="form-group">
            <label>Inward No</label>
            <input type="text" class="form-control" name="inwardnoParticular" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Part No.</label>
            <select class="form-control" name="part">
              <option value="">Select Part</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Unit Rate (INR)</label>
            <input class="form-control" name="unitRateEuro">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Unit Rate (INR)</label>
            <input class="form-control" name="unitRateInr" />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control" name="qty"/>
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label>Duty Amt.</label>
              <input class="form-control" name="duty" value="0" readonly />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Clearing Amt.</label>
              <input class="form-control" name="clearing"  value="0" readonly/>
            </div>
          </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="lastname">Packaging Amt.</label>
            <input type="text" class="form-control number" name="packaging" value="0" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Forwarding Amt.</label>
            <input type="text" class="form-control" name="forwarding" value="0" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="lastname">Landed Cost Per Part</label>
            <input type="text" class="form-control" name="landedPerPart" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Landed Cost</label>
            <input type="text" class="form-control" name="totalLanded" readonly/>
          </div>
        </div>
          <div class="col-md-3" style="margin-top:2.5%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addDutyParticular">Add Part</button>
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
      <form class="editForm" action="../php/duty.php" method="post">
        <input type="text" name="eAgainstPo" value='false' style="display: none" />
        <div class="col-md-3" style="display: none">
          <div class="form-group">
            <label>Duty Id</label>
            <input type="text" class="form-control" name="eDutyId" value="<?php echo $_GET['id']; ?>" readonly />
          </div>
        </div>
        <div class="col-md-3" style="display: none">
          <div class="form-group">
            <label>PO Id</label>
            <input type="text" class="form-control" name="eDutyPO"  readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Id</label>
            <input type="text" class="form-control" name="eId" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Part No.</label>
            <input type="text" class="form-control" name="ePart" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Unit Rate (INR)</label>
            <input class="form-control" name="eUnitRateEuro" readonly>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Unit Rate (INR)</label>
            <input class="form-control" name="eUnitRateInr" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control" name="eQty"/>
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label>Duty Amt.</label>
              <input class="form-control" name="eDuty"value="0" readonly/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Clearing Amt.</label>
              <input class="form-control" name="eClearing"  value="0" readonly/>
            </div>
          </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Packaging Amt.</label>
            <input type="text" class="form-control number" name="ePackaging" value="0" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Forwarding Amt.</label>
            <input type="text" class="form-control" name="eForwarding"   value="0" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Landed Cost Per Part</label>
            <input type="text" class="form-control" name="eLandedPerPart" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Landed Cost</label>
            <input type="text" class="form-control" name="eTotalLanded" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="updateDutyParticular">Update Part</button>
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
    var partsData = localStorage.getItem("parts");
    var inwardnoParticular="";
    $("header,.container").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          checkNetworkStatus();
        });
        
        $(document).ready(function(){
          getDuty();
          $("form.edit").submit(function(){
            $("select[name='to']").prop('disabled', false);
          });

          $("input[name='billOfEntryDate'],input[name='inwardDate']").datepicker({
            format:'dd-mm-yyyy',
            autoclose:true
          });

          $("select[name='part']").on("change",function(){            
            var val = $(this).val().split("-");
          });


          $("input[name='qty']").on("keyup",function(){            
            var euroRate = parseFloat($("input[name='unitRateEuro']").val());
            var inrRate = parseFloat($("input[name='unitRateInr']").val());
            var qty = parseInt($("input[name='qty']").val());
            var duty = parseFloat($("input[name='duty']").val());
            var clearing = parseFloat($("input[name='clearing']").val());
            var packaging = parseFloat($("input[name='packaging']").val());
            var forwarding = parseFloat($("input[name='forwarding']").val());

            var lcPerPart = duty+clearing+packaging+forwarding+inrRate;
            var lc = (duty+clearing+packaging+forwarding)+(inrRate*qty);

            $("input[name='landedPerPart']").val(lcPerPart);
            $("input[name='totalLanded']").val(lc);
          });

          $("input[name='eQty']").on("keyup",function(){                        
            var euroRate = parseFloat($("input[name='eUnitRateEuro']").val());
            var inrRate = parseFloat($("input[name='eUnitRateInr']").val());
            var qty = parseInt($("input[name='eQty']").val());
            var duty = parseFloat($("input[name='eDuty']").val());
            var clearing = parseFloat($("input[name='eClearing']").val());
            var packaging = parseFloat($("input[name='ePackaging']").val());
            var forwarding = parseFloat($("input[name='eForwarding']").val());

            var lcPerPart = duty+clearing+packaging+forwarding+inrRate;
            var lc = (duty+clearing+packaging+forwarding)+(inrRate*qty);
            $("input[name='eLandedPerPart']").val(lcPerPart);
            $("input[name='eTotalLanded']").val(lc);
          });

          $(".addpart").click(function(){            
            addPart();
          });         

        });
    })();

    function addPart(){        
        $("input[name='inwardnoParticular']").val(inwardnoParticular)        
        $("input[name='unitRateEuro']").val();
        $("input[name='unitRateInr']").val();
        $("input[name='qty']").val();
        $("input[name='duty']").val();
        $("input[name='clearing']").val();
        $("input[name='packaging']").val();
        $("input[name='forwarding']").val();
        $("input[name='landedPerPart']").val();
        $("input[name='totalLanded']").val();
        $("select[name='part']").select2();
        $("select[name='part']").select2({"width":"100%"});
        $("#addPartModal").modal();
    }

    function getDuty(){
        var id = <?php echo $_GET['id']; ?>;
        var data = {
          "getDC":"getDC",
          "dcId":id
        };
        $.ajax({
  		method:"POST",
  		type:"json",
  		data:{"getDuty":"getDuty","id":id},
  		url:"../php/duty.php",
  		success:function(data){
            var dutyDetails=JSON.parse(data).dutyDetails;
            var partDetails=JSON.parse(data).partDetails;
            $("input[name='id']").val(dutyDetails.duty_id);
            $("select[name='po']").val(dutyDetails.po);
            $("input[name='eDutyPO']").val(dutyDetails.po);
            $("input[name='billOfEntryNo']").val(dutyDetails.bill_of_entry_no);
            $("input[name='billOfEntryDate']").val(dutyDetails.bill_of_entry_date.split(" ")[0]);
            $("input[name='invoiceNo']").val(dutyDetails.invoice_no);
            $("input[name='vendor']").val([dutyDetails.vendor]);
            $("input[name='euroRate']").val(dutyDetails.euro_rate);
            $("input[name='inwardDate']").val(dutyDetails.inward_date.split(" ")[0]);
            $("input[name='inwardNo']").val(dutyDetails.inward_no);
            $("input[name='discount']").val(dutyDetails.discount);
            var element = "";
            $.map(partDetails, function(part){
                element += "<tr>"
                    +"<td>"
                    +"<input class='form-control' style='width:150px' type='text' value='"+part.part_no+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.unit_rate_euro+"' readonly>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.unit_rate_inr+"' readonly>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.qty+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control'  type='text' value='"+part.duty+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.clearing_charges+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.packaging+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.forwarding_charges+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.landed_cost_per_part+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<input class='form-control' type='text' value='"+part.total_landed_cost+"' readonly/>"
                    +"</td>"
                    +"<td>"
                    +"<a class='btn btn-sm btn-warning' onclick='updatePart("+part.duty_particluar_id+")'>Edit</a>&nbsp;"
                    +"<a class='btn btn-sm btn-danger' onclick='deletePart("+part.duty_particluar_id+")'>Remove</a>"
                    +"</td>"
                    +"</tr>";
            });
            $("#parts").append(element);
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
          data:{"getDutyParticular":"getDutyParticular","id":id},
          url:"../php/duty.php",
          success:function(data){
            //console.log(data); 
            var info=JSON.parse(data);
            $("input[name='eId']").val(info.duty_particluar_id);
            $("input[name='ePart']").val(info.part_no);
            $("input[name='eUnitRateEuro']").val(info.unit_rate_euro);
            $("input[name='eUnitRateInr']").val(info.unit_rate_inr);
            $("input[name='eQty']").val(info.qty);
            $("input[name='eDuty']").val(info.duty);
            $("input[name='eClearing']").val(info.clearing_charges);
            $("input[name='ePackaging']").val(info.packaging);
            $("input[name='eForwarding']").val(info.forwarding_charges);
            $("input[name='eLandedPerPart']").val(info.landed_cost_per_part);
            $("input[name='eTotalLanded']").val(info.total_landed_cost); 
            $("#editPartModal").modal();
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
          data:{"id":id,"deleteDutyParticular":"deleteDutyParticular"},
          url:"../php/duty.php",
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
