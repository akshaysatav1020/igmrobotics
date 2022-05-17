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
    <style media="screen">
    textarea.form-control{
        height: 34px;
      }</style>
  </head>
  <body>
    <?php include "menu.php";?>
    <div class="container-fluid">
      <form class="edit" action="../php/invoice.php"  method="post">
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label>Id</label>
                  <input class="form-control" type="text" name="id" readonly/>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="projectno" />                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Customer</label>
                  <input class="form-control" name="customer" readonly/>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Invoice No.</label>
                  <input type="text" name="invoicenumber" class="form-control" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Date</label>
                  <div id="datepicker" class="input-group date">
                      <input class="form-control" name="date" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
                <label>Reference No.</label>
                <input type="text" name="refno" class="form-control" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Reference Date</label>
                <div id="datepicker" class="input-group date">
                  <input class="form-control" name="refdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Shipment Date</label>
                  <div id="datepicker" class="input-group date">
                      <input class="form-control" name="shipmentdate" type="text">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Mode of transport</label>
                  <select class="form-control" name="transport">
                    <option value="default">Select</option>
                    <option value="air">Air</option>
                    <option value="road">Road</option>
                    <option value="rail">Rail</option>
                    <option value="byhand">By Hand</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Courier Service</label>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Vehicle No.</label>
                  <input type="text" name="vehiclenumber" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Dispatch No</label><br/>
                  <input type="text" class="form-control" name="dispatchno" placeholder="Dispatch No." />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Freight</label>
                  <select class="form-control" name="freight">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>IGST</label>
                      <input class="form-control number" name="igst" type="text" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Packaging</label>
                      <input class="form-control number" name="packaging" type="text" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="note">Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms and condition here"></textarea>
                </div>
              </div>
              <div class="col-md-2" style="padding:2%;">
                <button type="submit" name="editInv" class="btn btn-info">Update Details</button>
              </div>
              <div class="col-md-2" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button>
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>
                          <th>Part No.</th>
                          <th>Part Id</th>
                          <th>Description</th>
                          <th>Unit Price</th>
                          <th>Quantity</th>
                          <th>Discount %</th>
                          <th>Tax %</th>
                          <th>Amount</th>
                          <th>Action</th>
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
        <form action="../php/invoice.php" method="post">
          <div class="col-md-2" style="display: none;">
            <div class="form-group">
              <label>Invoice Id</label>
              <input type="text" class="form-control" name="apInvId" readonly/>
            </div>
          </div>
          
          <div class="col-md-2">
            <div class="form-group">
              <label>Part</label><br/>
              <select class="form-control" name="apPart" ></select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Unit Rate</label>
              <input type="text" class="form-control" name="apRate" readonly/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="lastname">Quantity</label>
              <input type="text" class="form-control number" name="apQty"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Discount %</label>
              <input class="form-control" name="apDiscount"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Tax %</label>
              <input type="text" class="form-control number" name="apTax"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <input type="text" class="form-control" name="apAmt" />
            </div>
          </div>
          <div class="col-md-2" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addInvPart">Add Part</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer"></div>
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
      <form class="editForm" action="../php/invoice.php" method="post">
        <div class="col-md-2" style="display: none;">
          <div class="form-group">
            <label>Id</label>
            <input type="text" class="form-control" name="upPartId"  readonly />
          </div>
        </div>        
        <div class="col-md-2">
          <div class="form-group">
            <label>Part</label><br/>
            <select class="form-control" name="upPart" ></select>
          </div>
        </div>        
        <div class="col-md-2">
          <div class="form-group">
            <label>Unit Rate</label>
            <input type="text" class="form-control" name="upRate" readonly />
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control" name="upQty"/>
          </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
              <label>Discount %</label>
              <input class="form-control" name="upDiscount"/>
            </div>
          </div>
        <div class="col-md-2">
            <div class="form-group">
              <label>Tax %</label>
              <input type="text" class="form-control" name="upTax" />
            </div>
          </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control" name="upAmount" />
          </div>
        </div>
        <div class="col-md-2" style="padding:2%;">
          <div class="form-group">
            <button class="btn btn-warning" type="submit" name="updateInvPart">Update Part</button>
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
    <script src="../js/select2.min.js"></script>
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
    <script src="../js/custom.js"charset="utf-8"  type="text/javascript"></script>
    <script type="text/javascript">
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var invParticulars=[];
    var partPrice = 0;
    $("header,.container, footer").hide();
    $(".loader").show();
      (function(){
        $(window).bind("load", function() {
          checkNetworkStatus();
        });
        $(document).ready(function(){
          getInv();
          $("input[name='date'],input[name='refdate'],input[name='shipmentdate']").datepicker({
            format:'dd-mm-yyyy',
            autoclose:true
          });

          $(".addpart").click(function(){
            partIndex++;
            addPartIds.push(partIndex);
            addPart();
          });

          $("select[name='apPart']").on("change",  function (event) {
            var val = $(this).val().split('*');
            $("input[name='apRate']").val(val[3]);
          });

          $("input[name='apQty']").on("keyup",  function (event) {              
              $("input[name='amount'],input[name='tax']").val(0);
          });

          $("input[name='upQty']").on("keyup",  function (event) {
              $("input[name='etax'],input[name='eamount']").val("0");
          });

          $("select[name='apDiscount']").on("keyup", function (event) {
              var qty = parseInt($(this).val());
              var unitPrice = partPrice;
              var dis = parseFloat($("select[name='partdiscount']").val()/100);
              $("input[name='rate']").val(unitPrice-(unitPrice*dis));
              $("input[name='amount']").val(qty*(unitPrice-(unitPrice*dis)));
          });

          $("select[name='upDiscount']").on("keyup", function (event) {
              var qty = parseInt($(this).val());
              var unitPrice = $("input[name='erate']").val();
              var dis = parseFloat($("select[name='epartdiscount']").val()/100);
              $("input[name='erate']").val(unitPrice-(unitPrice*dis));
              $("input[name='eamount']").val(qty*(unitPrice-(unitPrice*dis)));
          });

          $("input[name='apTax']").on("keyup",  function (event) {
              var qty = parseInt($("input[name='qty']").val());
              var unitPrice = parseFloat($("input[name='rate']").val());
              var actualprice = qty*(unitPrice+(unitPrice*($(this).val()/100)));
              $("input[name='amount']").val(actualprice);
          });

          $("input[name='upTax']").on("keyup",  function (event) {
              var qty = parseInt($("input[name='eqty']").val());
              var unitPrice = parseFloat($("input[name='erate']").val());
              var actualprice = qty*(unitPrice+(unitPrice*($(this).val()/100)));
              $("input[name='eamount']").val(actualprice);
          });


        });
      })();

      function getInv(){        
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"getInvoice":"getInvoice","id":<?php echo  $_GET['id'];?>},
  				url:"../php/invoice.php",
  				success:function(data){
  					var invDetails = JSON.parse(data).invoiceDetails;
            invParticulars = JSON.parse(data).particularDetails;
            $("input[name='id']").val(invDetails.id);
            $("input[name='projectno']").val(invDetails.projectno);
            $("input[name='customer']").val(invDetails.customer);
            $("input[name='invoicenumber']").val(invDetails.inv_no);
            $("input[name='date']").val(invDetails.invDate);
            $("input[name='refno']").val(invDetails.refno);
            $("input[name='refdate']").val(invDetails.refdate);
            $("input[name='shipmentdate']").val(invDetails.shipment_date);
            $("select[name='transport']").val(invDetails.transport);            
            $("input[name='courier']").val(invDetails.courier);
            $("input[name='vehiclenumber']").val(invDetails.vehicle);
            $("input[name='dispatchno']").val(invDetails.dispatchno);
            $("select[name='frieght']").val(invDetails.frieght);
            $("input[name='igst']").val(invDetails.igst);
            $("input[name='packaging']").val(invDetails.packaging);
            $("textarea[name='terms']").val(invDetails.terms);           
            $.map(invParticulars, function(particular){              
              $("#parts").append( "<tr>"              
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.part_number+"' readonly='readonly'/>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.partId+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<textarea class='form-control' readonly>"+particular.description+"</textarea>"
                +"</td>"              
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.unitprice+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.qty+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.discount+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.tax+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' value='"+particular.partTotAmount+"' readonly/>"
                +"</td>"
                +"<td>"
                +"<a onclick='updatePart("+particular.particularId+")'>Edit</a>&emsp;"
                +"<a onclick='deleteInvPart("+particular.particularId+")'>Delete</a>"
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

      function addPart(){
        //apInvId,apPart,apRate,apQty,apDiscount,apTax,apAmt        
        $("input[name='apQty'],input[name='apRate'],input[name='apAmt']").val("");
        $("input[name='apInvId']").val(<?php echo $_GET['id'];?>);        
        $("#addPartModal").modal();
        $("select[name='apPart']").select2({
          minimumInputLength: 4,tags: [],
          ajax: {
            url: "../php/invoice.php",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
              return {
                term: term,
                partsForInvParticular:'partsForInvParticular'       
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

      }

      function updatePart(id){
        //upPartId,upPart,upRate,upQty,upDiscount,upTax,upAmount
        $("input[name='upQty'],input[name='upRate'],input[name='upAmount']").val("");
        $.map(invParticulars, function(particular){
          if(particular.particularId==id){
            $("input[name='upPartId']").val(particular.particularId);
            $("select[name='upPart']").val(particular.partId);
            $("input[name='upQty']").val(particular.qty);
            $("input[name='upRate']").val(particular.unitprice);
            $("input[name='epartdiscount']").val(particular.discount);
            $("input[name='etax']").val(particular.tax);
            $("input[name='eamount']").val(particular.amount);
            $("#editPartModal").modal();
          }
        });        
      }

    function deleteInvPart(id){
      var c = confirm("Do you really want to delete "+id+"?");      
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"partId":id,"deleteInvPart":"deleteInvPart"},
          url:"../php/invoice.php",
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
