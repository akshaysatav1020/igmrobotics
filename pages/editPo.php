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
    <style media="screen">
      textarea.form-control{
        height: 34px;
      }</style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid">
      <form class="" action="../php/po.php" method="POST">
        <div class="col-md-2">
          <div class="form-group">
            <label>Project No.</label>
            <input class="form-control" name="projectno"/>                  
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Vendor</label>
            <input class="form-control" name="vendor" type="text" readonly>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Purchase Order No.</label>
            <input type="text" name="ponumber" class="form-control" readonly/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>PO Date</label>
            <div id="datepicker" class="input-group date">
                <input class="form-control" name="podate" type="text" >
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>PO Validity Date</label>
            <div id="datepicker" class="input-group date">
                <input class="form-control" name="poValidityDate" type="text">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Quotation No.</label>
            <input class="form-control" name="quotenumber"/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Quotation Date</label>
            <div id="datepicker" class="input-group date">
                <input class="form-control" name="quotationdate" type="text">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>                  
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Packaging Amount</label>
            <input class="form-control number" name="pack" type="text" >
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Currency</label>
            <select class="form-control" name="currency">
              <option value="">Select Currency</option>
              <option value="eur">EURO</option>
              <option value="inr">INR</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Conversion Rate</label>
            <input class="form-control" name="eurorate" type="text" />
          </div>
        </div>        
        <div class="col-md-2">
          <div class="form-group">
            <label>Discount %</label>
            <input class="form-control" name="discount" type="text" >
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>IGST %</label>
            <input class="form-control" name="igst" type="text" >
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Delivery Terms</label>
            <select class="form-control" name="deliveryTerms">
              <option value="">Select</option>
              <option value="CIF">CIF</option>
              <option value="DAP">DAP</option>
              <option value="DDP">DDP</option>
              <option value="EXW Place">EXW Place</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Payment Terms</label>
            <select class="form-control" name="paymentTerms">
              <option value="">Select</option>
              <option value="100%">100%</option>
              <option value="30 Days Credit">30 Days Credit</option>
              <option value="60 Days Credit">60 Days Credit</option>
		          <option value="50% in advance and 50% after receival of invoice">50% in advance and 50% after receival of invoice
               </option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Terms &amp; Condition</label>
            <textarea class="form-control" name="terms" placeholder="Enter terms and condition here" ></textarea>
          </div>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <button type="submit" name="editPO" class="btn btn-info">Update PO Details</button>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <button class="btn btn-default addpart" type="button">Add Particular</button>
        </div>
        <div class="col-md-11">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-condensed or">
                <thead>
                  <tr>                          
                    <th>Part No.</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
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
        <form class="editForm" action="../php/po.php" method="post">
          <div class="col-md-2 hide">            
              <input type="text" class="form-control" name="apPoId"/>            
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Part</label><br/>
              <select class="form-control" name="apPart"></select>
            </div>
          </div>          
          <div class="col-md-2">
            <div class="form-group">
              <label>Unit Rate</label>
              <input type="text" class="form-control number" name="apRate" readonly/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control number" name="apQty"  />
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <input type="text" class="form-control" name="apAmount"  readonly/>
            </div>
          </div>
          <div class="col-md-2" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="ap">Add Part</button>
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
      <form class="editForm" action="../php/po.php" method="post">        
        <div class="col-md-2 hide">
            <input type="text" class="form-control" name="upId"/>          
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Part</label><br/>
            <input class="form-control" type="text" name="upPart" readonly/>
          </div>
        </div>        
        <div class="col-md-2">
          <div class="form-group">
            <label>Unit Rate</label>
            <input type="text" class="form-control number" name="upRate"  readonly/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control number" name="upQty"  />
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control" name="upAmount" readonly/>
          </div>
        </div>
        <div class="col-md-3" style="padding:2%;">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="up">Update Part</button>
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
    var vendors;
    var eurorate = 0;
    var poParticulars = currencyType = '';
    $("header,.container, footer").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          checkNetworkStatus();
          
        });
        $(document).ready(function(){
          getPO();

          $("input[name='podate'],input[name='poValidityDate'],input[name='quotationdate']").datepicker({
            format:'dd-mm-yyyy',
            autoclose:true
          });

          $(".addpart").click(function(){
           addPart();
          });
          
          $("input[name='upQty']").on("keyup",function(){
            var up = parseFloat($("input[name='upRate']").val());
            var qty = parseInt($("input[name='upQty']").val());
            $("input[name='upAmount']").val(up*qty);    
          });
          
          $("input[name='apQty']").on("keyup",function(){
            var up = parseFloat($("input[name='apRate']").val());
            var qty = parseInt($("input[name='apQty']").val());
            $("input[name='apAmount']").val(up*qty);    
          });

          $("select[name='apPart']").on("change",function (event) {
              var val = $(this).val().split('*');
              if(currencyType=="eur"){
                $("input[name='apRate']").val(val[3]);
              }else{
                  $("input[name='apRate']").val(val[4]);
              }
              $("input[name='apQty'],input[name='apAmount']").val("0");
          });
        });
      })();

      function addPart(){
        $("input[name='apQty'],input[name='apRate'],input[name='apAmount']").val("0");
        $("textarea[name='description']").val("");
        $("input[name='poId']").val(<?php echo $_GET['id'];?>);
        
        $("#addPartModal").modal();
        $("select[name='apPart']").select2({
            minimumInputLength: 4,tags: [],
            ajax: {
                url: "../php/po.php",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                      term: term,
                      partsForPOParticular:'partsForPOParticular'       
                    };
                },
                processResults: function (data) {
                    return {
                      results: $.map(data, function (item) {
                        return {
                          text: item.part_number,
                          slug: item.part_number,
                          id: item.id+"*"+item.part_number+"*"+item.description+"*"+item.upe+"*"+item.upi
                        }
                      })
                    };
                }
            }
        });
      }


      function getPO(){ 
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"id":<?php echo $_GET['id'];?>,"getPO":"getPO"},
  				url:"../php/po.php",
  				success:function(data){
            var poDetails = JSON.parse(data).poDetails;
            poParticulars = JSON.parse(data).poParticulars;  					
            currencyType = poDetails.currency;
            $("input[name='projectno']").val(poDetails.projectno);            
            $("input[name='vendor']").val(poDetails.company_name);            
            $("input[name='ponumber']").val(poDetails.po_no);
            $("input[name='podate']").val(poDetails.po_date);
            $("input[name='poValidityDate']").val(poDetails.po_validity);
            $("input[name='quotenumber']").val(poDetails.q_no);
            $("input[name='quotationdate']").val(poDetails.q_date);
            $("input[name='pack']").val(poDetails.package);
            $("select[name='currency']").val(poDetails.currency);
            $("input[name='eurorate']").val(poDetails.eurorate);
            $("input[name='discount']").val(poDetails.discount);
            $("input[name='igst']").val(poDetails.igst);
            $("select[name='paymentTerms']").val(poDetails.payment_terms);
            $("select[name='deliveryTerms']").val(poDetails.delivery_terms);
            $("textarea[name='terms']").val(poDetails.terms);
            $.map(poParticulars, function(particular){
              $("#parts").append("<tr>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+particular.part_number+"' readonly='readonly'/>"
              +"</td>"
              +"<td>"
              +"<textarea class='form-control' readonly>"+particular.description+"</textarea>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+particular.qty+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+particular.unitprice+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<input class='form-control' type='text' value='"+particular.partTotAmt+"' readonly/>"
              +"</td>"
              +"<td>"
              +"<a onclick='editPart("+particular.particularId+")' >Edit</a>&emsp;"
              +"<a onclick='deletePoPart("+particular.particularId+")'>Remove</a>"
              +"</td>"
              +"</tr>");
            });
            $("header,.container, footer").show();
            $(".loader").hide();
  			  },error:function(error){
            alert(error);
          }
        });
      }

      function editPart(id){
        $("input[name='quantity'],input[name='unitprice'],input[name='amount']").val("");
        $.map(poParticulars, function(particular){
            if(particular.particularId==id){
                $("input[name='upId']").val(particular.particularId);              
                $("input[name='upPart']").val(particular.part_number);
                $("input[name='upRate']").val(particular.unitprice);
                $("input[name='upQty']").val(particular.qty);
                $("input[name='upAmount']").val(particular.partTotAmt);              
                $("#editPartModal").modal();
            }
        });
      }

    function deletePoPart(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"partId":id,"deletePoPart":"deletePoPart"},
          url:"../php/po.php",
          success:function(data){
            console.log(data);
            if(data=="Deleted"){
              location.reload();
            }else{
              alert("Unable to delete Contact Admin");
            }
          }
        });
      }
    }

    </script>
  </body>
</html>