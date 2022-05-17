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
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
    <title></title>
    <style type="text/css">
      textarea.form-control{
        height: 34px;
      }
    </style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fuid">
      <form class="edit" action="../php/quotation.php" method="POST">
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label for="to">Id</label>
                  <input class="form-control" name="id" />
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
                  <input type="text" class="form-control" name="customer" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="quotationnumber">Quotation No.</label>
                  <input type="text" name="quotationnumber" class="form-control"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Date</label>
                  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="date" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                  
                </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label for="quotationnumber">Reference No.</label>
                <input type="text" name="refno" class="form-control"  />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="date">Reference Date</label>
                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                  <input class="form-control" name="refdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">Valid Until</label>
                  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="validdate" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label for="valid">CGST</label>
                      <input class="form-control number" name="cgst" type="text" >
                </div>
              </div>
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label for="valid">SGST</label>
                      <input class="form-control number" name="sgst" type="text" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">IGST</label>
                      <input class="form-control number" name="igst" type="text" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">Packaging</label>
                      <input class="form-control number" name="packaging" type="text" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="terms">Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms and condition here" ></textarea>
                </div>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button type="submit" name="editQuo" class="btn btn-info">Update Quote Details</button>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" >Add Particular</button>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>
                          <th>Part No.</th>
                          <th>Description</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Discount(%)</th>
                          <th>Tax(%)</th>
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
        <form class="editForm" action="../php/quotation.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label>Quotation Id</label>
              <input type="text" class="form-control" name="quoId" readonly />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Part</label>
              <select class="form-control" name="part">
                <option value="">Select</option>
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Rate</label>
              <input type="text" class="form-control" name="rate" readonly />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control number" name="qty" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Discount %</label>
              <input class="form-control" name="discount"  />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tax %</label>
              <input type="text" class="form-control number" name="tax"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Amount</label>
              <input type="text" class="form-control" name="amount" readonly/>
            </div>
          </div>
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addQuoPart">Add Part</button>
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
      <form class="editForm" action="../php/quotation.php" method="post">
        <div class="col-md-3" style="display: none;">
          <div class="form-group">
            <label>Id</label>
            <input type="text" class="form-control" name="eid" readonly/>
            <input type="text" class="form-control" name="eQuotId" readonly/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Part</label>
            <input type="text" class="form-control" name="epart" readonly />
          </div>
        </div>        
        <div class="col-md-3">
          <div class="form-group">
            <label>Unit Rate</label>
            <input type="text" class="form-control " name="erate" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control " name="eqty"  />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Discount %</label>
            <input class="form-control " name="ediscount"/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Tax %</label>
            <input type="text" class="form-control " name="etax"  />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control" name="eamount" readonly/>
          </div>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="updateQuoPart">Update Part</button>
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
<script src="../js/custom.js"charset="utf-8"  type="text/javascript"></script>
<script type="text/javascript">
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem("parts");
    var unp=0;
    var particularDetails ="";
    $("header,.container, footer").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          checkNetworkStatus();
        });
        $(document).ready(function(){
          getQuo();
          
        $("input[name='eqty']").on("keyup",function(){
            var up = parseFloat($("input[name='erate']").val());
            var qty = parseFloat($("input[name='eqty']").val());  
            $("input[name='etax'], input[name='ediscount']").val("0");
            $("input[name='eamount']").val(up*qty);
        });
        
        $("input[name='ediscount']").on("keyup",function(){
            var up = parseFloat($("input[name='erate']").val());
            var qty = parseInt($("input[name='eqty']").val()); 
            var d = parseFloat($("input[name='ediscount']").val()/100);
            $("input[name='etax']").val("0");
            $("input[name='eamount']").val((up-(up*d))*qty);
        });
        
        $("input[name='etax']").on("keyup",function(){
            var up = parseFloat($("input[name='erate']").val());
            var qty = parseInt($("input[name='eqty']").val());  
            var d = parseFloat($("input[name='ediscount']").val()/100);
            var t = parseFloat($("input[name='etax']").val()/100);
            $("input[name='eamount']").val((up-(up*d)+(up*t))*qty);
        });
        
         $("input[name='qty']").on("keyup",function(){
            var up = parseFloat($("input[name='rate']").val());
            var qty = parseFloat($("input[name='qty']").val());  
            $("input[name='tax'], input[name='discount']").val("0");
            $("input[name='amount']").val(up*qty);
        });
        
        $("input[name='discount']").on("keyup",function(){
            var up = parseFloat($("input[name='rate']").val());
            var qty = parseInt($("input[name='qty']").val()); 
            var d = parseFloat($("input[name='discount']").val()/100);
            $("input[name='tax']").val("0");
            $("input[name='amount']").val((up-(up*d))*qty);
        });
        
        $("input[name='tax']").on("keyup",function(){
            var up = parseFloat($("input[name='rate']").val());
            var qty = parseInt($("input[name='qty']").val());  
            var d = parseFloat($("input[name='discount']").val()/100);
            var t = parseFloat($("input[name='tax']").val()/100);
            $("input[name='amount']").val((up-(up*d)+(up*t))*qty);
        });
        
        
        
        $("form.edit").submit(function(){
            $("select[name='customer']").prop('disabled', false);
        });

         

        $("input[name='date'],input[name='refdate'],input[name='validdate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
        });
          
        $(".addpart").click(function(){
            addPart();
            $("input[name='rate'],input[name='qty'],input[name='discount'],input[name='tax'],input[name='amount']").val("0");
        });
          

        $("select[name='part']").on("change",function (event) {
            var val = $(this).val().split('*');
            $("input[name='rate']").val(val[3]);
        });


          

        });
      })();

      function addPart(){
        $("input[name='quoId']").val(<?php echo $_GET['id'];?>);
        $("select[name='part']").select2({
        minimumInputLength: 1,tags: [],width:"100%",
        ajax: {
          url: "../php/quotation.php",
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
              term: term,
              partsForQuoParticular:'partsForQuoParticular'       
            };
          },
          processResults: function (data) {
            //console.log(data);
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.part_number,
                  slug: item.part_number,
                  id: item.id+"*"+item.part_number+"*"+item.description+"*"+item.upi
                }
              })
            };
          }
        }
        });
        $("#addPartModal").modal();
      }

      

      function getQuo(){
        var id = <?php echo $_GET['id']; ?>;
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"getQuo":"getQuo","qoId":id},
  				url:"../php/quotation.php",
  				success:function(data){
  					console.log(data);
            var quotDetails = JSON.parse(data).quotation;
            particularDetails = JSON.parse(data).particularDetails;
            $("input[name='id']").val(<?php echo  $_GET['id'];?>);
            $("input[name='customer']").val([quotDetails.to]);
            $("input[name='quotationnumber']").val(quotDetails.qno);
            $("input[name='eprojectno']").val(quotDetails.projectno);
            $("input[name='date']").val(quotDetails.date);
            $("input[name='refno']").val(quotDetails.refno);
            $("input[name='packaging']").val(quotDetails.packaging);
            $("input[name='refdate']").val(quotDetails.refdate);
            $("input[name='validdate']").val(quotDetails.validdate);
            $("textarea[name='terms']").val(quotDetails.terms);
            $("input[name='igst']").val(quotDetails.igst);
            $.map(particularDetails, function(part){
              var element = "";
              element = "<tr>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.part_number+"' readonly='readonly'/>"
              +"</td>"
              +"<td>"
              +"<textarea class='form-control' readonly>"+part.description+"</textarea>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.qty+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.unitprice+"' readonly/>"
              +"</td>"              
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.discount+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.tax+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+part.partTotAmt+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<a onclick='updatePart("+part.particularId+")'>Edit</a>&emsp;"
              +"<a onclick='deleteQuoPart("+part.particularId+")' >Remove</a>"
              +"</td>"
              +"</tr>";
              $("#parts").append(element);
                
            });
                $("header,.container, footer").show();
                $(".loader").hide();
  			  },error:function(error){
                alert(error);
          }
        });
      }

      function updatePart(id){
        $("input[name='eid']").val("");
        $("input[name='epart']").val("");
        $("input[name='erate']").val("");
        $("input[name='ediscount']").val("");
        $("input[name='eqty']").val("");
        $("input[name='etax']").val("");
        $("input[name='eamount']").val("");
        $.map(particularDetails, function(part){
            if(id==part.particularId){
                $("input[name='eid']").val(part.particularId);
                $("input[name='eQuotId']").val(part.particularQuotId);
                $("input[name='epart']").val(part.part_number);
                $("input[name='erate']").val(part.unitprice);
                $("input[name='ediscount']").val(part.discount);
                $("input[name='eqty']").val(part.qty);
                $("input[name='etax']").val(part.tax);
                $("input[name='eamount']").val(part.partTotAmt);
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
          }});
      }
    }
    </script>
  </body>
</html>
