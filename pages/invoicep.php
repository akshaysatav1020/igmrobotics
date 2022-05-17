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
    <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/datepicker.css">
    <link rel="stylesheet" href="../css/custom.css">
      <link href="../css/select2.min.css" rel="stylesheet" />
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

    input[name=tabs]{
      display:none;
    }

    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #ddd;
    }

    label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'] {
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

    label[for*='1']:before { content: '\f1c1'; }
    label[for*='2']:before { content: '\f06e'; }

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
    #tab4:checked ~ #content4 {
      display: block;
    }

    @media screen and (max-width: 650px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'] {
        font-size: 0;
      }
      label[for*='1']:before, label[for*='2']:before, label[for*='3']:before, label[for*='4']:before {
        margin: 0;
        font-size: 18px;
      }
    }

    @media screen and (max-width: 400px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'] {
        padding: 15px;
      }
    }
    </style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid" >
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Generate Invoice</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View List</label>
          <section id="content1">
            <form class="" action="../php/invoice.php" method="post">
              <div class="col-md-2">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="projectno"/>                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Customer</label>
                  <select class="form-control" name="to" required="required">
                    <option value="">Select Customer</option>                    
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Invoice Number</label>
                  <input type="text" name="invoicenumber" class="form-control" readonly/>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Invoice Date</label>
                  <div id="datepicker" class="input-group date">
                      <input class="form-control" name="date" type="text">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Reference No.</label>
                  <select name="refquono" class="form-control">
                    <option value="">Select Quotation</option>                    
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="date">Reference Date</label>
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
                      <input class="form-control" name="shipmentdate" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>                          
              <div class="col-md-2">
                <div class="form-group">
                  <label>Mode of transport</label>
                  <select class="form-control" name="transport">
                    <option value="">Select</option>
                    <option value="air">Air</option>
                    <option value="road">Road</option>
                    <option value="rail">Rail</option>
                    <option value="byhand">By Hand</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Courier Service</label><br/>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Vehicle No.</label>
                  <input type="text" name="vehiclenumber" maxlength="10" class="form-control">
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
                    <option value="1" >Yes</option>
                    <option value="0" >No</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                  <div class="form-group">
                    <label>IGST %</label>
                    <input class="form-control number" name="igst"/>
                  </div>
                </div>
              <div class="col-md-2">
                  <div class="form-group">
                    <label>Packaging &amp; Forwarding</label>
                    <input class="form-control number" name="packaging"/>
                  </div>
                </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="note">Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms and condition here" ></textarea>
                </div>
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
                          <th>Part No.</th>
                          <th>Part Id</th>
                          <th>Description</th>
                          <th>Unit Price</th>
                          <th>Qty</th>
                          <th>Discount %</th>                          
                          <th>Tax %</th>
                          <th>Amount</th>                          
                        </tr>
                      </thead>
                      <tbody id="parts">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" name="generateInvoice" class="btn btn-info">Generate</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                  <th>Customer</th>
                  <th>Invoice</th>
                  <th>Invoice Date</th>
                  <th>Shipment Date</th>
                  <th>Freight</th>
                  <th>Total Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Customer</th>
                    <th>Invoice</th>
                    <th>Invoice Date</th>
                    <th>Shipment Date</th>
                    <th>Freight</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody id="invList"></tbody>
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
<script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
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
  $("header,.container-fluid,footer").hide();
  $(".loader").show();
  var partIndex = 0;
  var addPartIds = [];
  var removePartIds = [];
  var refQuots = [];
  var partsData = localStorage.getItem("parts");
  var customers;
  var up = 0;
  var inwardno=[];
  $(window).bind("load", function() {
    checkNetworkStatus();             
    if($.cookie("status")=="Offline"){                      
      $("button[name='generateInvoice']").attr("disabled","disabled");            
    }
  });
    $(document).ready(function(){
      if($.cookie("userrole")=="finance"||$.cookie("userrole")=="service"){
        $("input[id='tab1'],label[for='tab1']").hide();  
        $("input[id='tab2']").attr("checked","checked");      
      }

      getPreInvNo();
      getCustomers();
      getQuoNo();
      getInvoice();
            
      $("input[name='date'],input[name='shipmentdate'],input[name='refdate']").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
      });      

      $(".addpart").attr("disabled","disabled");

      $("select[name='to']").on("change", function() {
         $(".addpart").removeAttr("disabled");
      });      
      
      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });

      $("table.or").on("change", ".part", function (event) {
        var id = $(this).attr("name").substr(6);
        var val = $(this).val().split('*');
        //console.log(val);        
        $("input[name='partId"+id+"']").val(val[0]);
        $("textarea[name='description" + id + "']").val(val[2]);
        $("input[name='rate"+id+"']").val(val[3]); 
      });

      $("table.or").on("keyup", ".qty", function (event) {
          var id = $(this).attr("name").substr(8);
          $("input[name='tax"+id+"'],input[name='discount"+id+"']").val(0);
          var up = parseFloat($("input[name='rate"+id+"']").val());
          var qty = $(this).val();
          $("input[name='amount"+id+"']").val((up*qty).toFixed(2));
      });

      $("table.or").on("keyup", ".discount", function (event) { 
        var id = $(this).attr("name").substr(8);
        $("input[name='tax"+id+"']").val(0);
        var discount = parseFloat($(this).val()/100)*parseFloat($("input[name='amount"+id+"']").val());
        var amt = parseFloat($("input[name='amount"+id+"']").val());
        $("input[name='amount"+id+"']").val((amt-discount).toFixed(2));
      });

      $("table.or").on("keyup", ".tax", function (event) { 
        var id = $(this).attr("name").substr(3);
        var tax = parseFloat($(this).val()/100)*parseFloat($("input[name='amount"+id+"']").val());
        var amt = parseFloat($("input[name='amount"+id+"']").val());
        $("input[name='amount"+id+"']").val((amt-tax).toFixed(2));
      });      
    
      $("table.or").on("click", ".removepart", function (event) {
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
      });

      $("form").submit(function(event){
        $("select[name='to']").removeAttr("disabled");
        var formData = $(this).serializeArray();
        var diff = $(addPartIds).not(removePartIds).get();
        $(this).append("<input type='hidden' name='ids' value='"+diff+"'/>");
      });

    });

    function getPreInvNo(){
      $.ajax({
        method: "POST",
        type: "json",
        data: { "getLastInv": "getLastInv" },
        url: "../php/invoice.php",
        success: function (data) {
          if(data==""){
            $("input[name='invoicenumber']").val("INV001");
          }else{        
            var id = parseInt(data.substr(3,5))+1;
            if(parseInt(id)<9){
              a = "00"+id;
            }else if(parseInt(id)<99){
              a = "0"+id;
            }else{
              a = id;
            }
            $("input[name='invoicenumber']").val("INV"+a);
          }
          $("header,.container-fluid,footer").show();
          $(".loader").hide();         
        }
      });              
    }  

    function getCustomers(){
      $("select[name='to']").select2({
        minimumInputLength: 2,tags: [],
        width: "100%",
        ajax: {
          url: "../php/invoice.php",
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
              term: term,
              customersForInv:'customersForInv'       
            };
          },
          processResults: function (data) {
            //console.log(data);
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.company,
                  slug: item.company,
                  id: item.id
                }
              })
            };
          }
        }
      });
    }

    function getQuoNo(){
      $("select[name='refquono']").select2({
        minimumInputLength: 2,tags: [],
        width: "100%",
        ajax: {
          url: "../php/invoice.php",
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
              term: term,
              quoForInv:'quoForInv'       
            };
          },
          processResults: function (data) {
            //console.log(data);
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.quo_no,
                  slug: item.quo_no,
                  id: item.id+"_"+item.quo_no
                }
              })
            };
          }
        }
      });
    }

    function getInvoice(){
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
        $('#myTable').DataTable({
          'dom': 'Bfrtip',
          "iDisplayLength": 10,
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          'ajax': {
              'url': '../php/invoice.php',
              "data": {
                  "getAllInvoice": "getAllInvoice"
              }
          },
          columns: [{
                    data: 'customer',
                    render: function(data, type, row) {
                        return ("<td style='width:30vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'inv_no',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'invDate',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'shipment_date',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'freight',
                    render: function(data, type, row) {
                      if(data==0){
                        return ("<td style='width:10vw;'>Not Paid</td>");
                      }else{
                        return ("<td style='width:10vw;'>Paid</td>");
                      }   
                    }
                },
                {
                    data: 'totAmt',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'cancelled',
                    render: function(data, type, row) {
                      if(data==0){
                        return ("<td><button class='btn btn-sm btn-danger' onclick='cancelInv("+ data + ",0)'>Cancelled</button></td>");
                      }else{
                        return ("<td><button class='btn btn-sm btn-warning' onclick='cancelInv("+ data + ",1)'>Cancel</button></td>");
                      }   
                    }
                },                
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" +
                            "<button class='btn btn-sm btn-success' onclick='printInvoice(" + data +
                            ")'>Print</button> " +
                            "<button class='btn btn-sm btn-warning' onclick='editInv(" + data +
                            ")'>Edit</button> " +
                            "<button class='btn btn-sm btn-danger' onclick='deleteInv(" + data +
                            ")'>Delete</button></td>");
                    }
                }

            ],
          buttons: [
              $.extend( true, {}, buttonCommon, {
                  extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3,4,5]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'excelHtml5',title:"Invoice List",exportOptions:{columns:[0,1,2,3,4,5]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'pdfHtml5',title:"Invoice List",exportOptions:{columns:[0,1,2,3,4,5]}
              } )
          ]
        });
      }

    function addPart(){
      var element = "";
      element = "<tr>"
      +"<td>"
      +"<select style='width:150px;' class='form-control part' name='partno"+partIndex+"'>"
      +"<option>Select part</option></select>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px;' type='text' class='form-control partId' name='partId"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<textarea style='width:150px;' type='text' class='form-control' name='description"+partIndex+"'></textarea>"
      +"</td>"      
      +"<td>"
      +"<input style='width:50px;' type='text' class='form-control rate' name='rate"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px;' type='text' class='form-control qty' name='quantity"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px;' class='form-control discount' name='discount"+partIndex+"' required/>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px;' type='text' class='form-control tax' name='tax"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input style='width:150px;' type='text' class='form-control amount' name='amount"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
      +"</td>"
      +"</tr>";
      $("#parts").append(element);
      $("select[name='partno" + partIndex + "']").select2({
        minimumInputLength: 1,tags: [],
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
    
    function cancelInv(id,status){      
      $.ajax({
        method:"POST",
        type:"json",
        data:{"cancelInv":"cancelInv", "invId":id, "status":status},
        url:"../php/invoice.php",
        success:function(data){
          console.log(data);
          if(data == "Cancelled"){
            alert("Status Changed");
            location.reload()
          }else{
            alert("Unable to change  status");
          }
        },error:function(error){
          alert("Unable to change  status"+error);
        }
      });
    }

    function editInv(id) {
      window.open("editInv.php?id="+id+"", "_self");
    }

    function printInvoice(id){
      var copy = prompt("Please enter copy");
      if (copy != null) {
          window.open("../php/invoice.php?id="+id+"&copy="+copy, "_blank");
      }      
    }

    function deleteInv(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"deleteInv":"deleteInv", "invId":id},
          url:"../php/invoice.php",
          success:function(data){
            console.log(data);
            //if(data=="Deleted"){
              alert("Deleted");
              location.reload();
            //}
          },error:function(error){
            alert("Error Deleting");
          }
        });
      }
      
    }
    </script>
  </body>
</html>
