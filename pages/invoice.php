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
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
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
              <div class="col-md-3">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="projectno" />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="quotationnumber">Reference No.</label>
                  <select name="refquono" class="form-control" >
                    <option value="">Select Quotation</option>
                    <?php                    
                      $query="SELECT * FROM quotation";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                 
                          echo "<option value='".$row["id"]."_".$row["quo_no"]."'>".$row["quo_no"]."</option>";
                        }
                      }                     
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="to">Customer</label>
                  <select class="form-control" name="to" required="required">
                    <option value="">Select Customer</option>
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
                  <label for="challannumber">Invoice Number</label>
                  <input type="text" name="invoicenumber" class="form-control"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Invoice Date</label>
                  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="date" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>                  
                </div>
              </div>
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">CGST(%)</label>
                  <input class="form-control number" maxlength="2" name="cgst" value="0.00" style="display: none;"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">SGST(%)</label>
                  <input class="form-control number" maxlength="2" name="sgst" value="0.00" style="display: none;"/>
                </div>
              </div> -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">IGST(%)</label>
                  <input class="form-control number" maxlength="2" name="igst"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valid">Packaging &amp; Forwarding (INR)</label>
                  <input class="form-control number" name="packaging"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="shipment">Shipment Date</label>
                  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="shipmentdate" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Mode of transport</label>
                  <select class="form-control" name="transport">
                    <option value="">Select</option>
                    <option value="byhand">By Hand</option>
                    <option value="road">Road</option>
                    <option value="rail">Rail</option>
                    <option value="air">Air</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Vehicle No.</label>
                  <input type="text" name="vehiclenumber" maxlength="10" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Courier Service</label><br/>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Freight</label><br/>
                  <input type="radio" name="freight" value="yes" checked>Yes&emsp;
                  <input type="radio" name="freight" value="no" >No
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Dispatch No</label><br/>
                  <input type="text" class="form-control" name="dispatchno" placeholder="Dispatch No." />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Total</label>
                  <input class="form-control number" name="total"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms and condition here" ></textarea>
                </div>
              </div>
              <!-- <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Part</button>
              </div> -->
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>
                          <!-- <th>No.</th> -->
                          <th>Part No.</th>
                          <th>Description</th>
                          <th>Unit Rate (Rupees)</th>
                          <th>Discount (%)</th>
                          <th>Discounted Rate (Rupees)</th>
                          <th>Quantity</th>
                          <th>Tax(%)</th>
                          <th>Amount (Rupees)</th>
                          <!-- <th>Action</th> -->
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
                  <th>Total Amount (INR)</th>
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
                    <th>Total Amount (INR)</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <!-- <tbody id="invList"> -->
                <tbody>
                  <?php
                      $query="SELECT inv.*, cust.company_name as cname, (SUM(ip.partTotAmount)+((inv.igst/100)+SUM(ip.partTotAmount))+inv.packaging) as totAmt FROM invoice inv LEFT JOIN customers cust on inv.cust_id=cust.id LEFT JOIN invoice_products ip on inv.cust_id=ip.invId GROUP BY inv.id";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["inv_no"]."</td>";
                          echo "<td>".$row["cname"]."</td>";
                          echo "<td>".explode("-", explode(" ", $row["date"])[0])[2]."-".explode("-", explode(" ", $row["date"])[0])[1]."-".explode("-", explode(" ", $row["date"])[0])[0]."</td>";
                          echo "<td>".explode("-", explode(" ", $row["shipment_date"])[0])[2]."-".explode("-", explode(" ", $row["shipment_date"])[0])[1]."-".explode("-", explode(" ", $row["shipment_date"])[0])[0]."</td>";
                          if($row["freight"]=="1"){
                            echo "<td>Paid</td>";
                          }else{
                            echo "<td>Not Paid</td>";
                          }
                          echo "<td>".$row["totAmt"]."</td>";
                          if($_COOKIE["userrole"]=="finance"||$_COOKIE["userrole"]=="service"){
                            echo "<td>NA</td>";
                          }else{
                            if($row["cancelled"]=="0"){
                              echo "<td><button class='btn btn-sm btn-success' onclick='cancelInv(".$row["id"].",1)'>Not Cancelled</button></td>";
                            }else{
                              echo "<td><button class='btn btn-sm btn-danger' onclick='cancelInv(".$row["id"].",0)'>Cancelled</button></td>";
                            }
                          }
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){
                            if($_COOKIE["userrole"]=="finance"||$_COOKIE["userrole"]=="service"){ 
                              echo "<button class='btn btn-sm btn-success' onclick='printInvoice(".$row["id"].")'>Print</button>&emsp;";
                            }else{
                              echo "<button class='btn btn-sm btn-success' onclick='printInvoice(".$row["id"].")'>Print</button>&emsp;";
                              echo "<button class='btn btn-sm btn-warning' onclick='editInv(".$row["id"].")'>Edit</button>&emsp;";
                              echo "<button class='btn btn-sm btn-danger' onclick='deleteInv(".$row["id"].")'>Delete</button></td>";
                            }
                          }else{                        
                            echo "<button class='btn btn-sm btn-success' onclick='printInvoice(".$row["id"].")'>Print</button>&emsp;";
                            echo "<button class='btn btn-sm btn-warning' onclick='editInv(".$row["id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteInv(".$row["id"].")'disabled>Delete</button></td>";
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
                            $data = $row['company_name'];
                          }
                        }      
                        return $data;
                      }                    
                    ?>
                </tbody>
              </table>
            </div>
          </section>
          <section id="content3">
            <button type="submit" class="btn btn-lg btn-success" name="button">IMPORT</button>
          </section>
          <section id="content4">
            <button type="submit" class="btn btn-lg btn-success" name="button">EXPORT</button>
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
    $(window).bind("load", function() {
          
          checkNetworkStatus();          
          $("select[name='refquono'],select[name='to'],select[name='transport']").select2({"width":"100%"}); 
          if($.cookie("status")=="Offline"){                      
            $("button[name='generateInvoice']").attr("disabled","disabled");            
          }
          if($.cookie("userrole")=="finance"||$.cookie("userrole")=="service"){
            $("input[id='tab2']").attr("checked","checked");
            $("input[id='tab1'],label[for='tab1']").hide();     
          }else{
            var scratch = confirm("Generate Invoice from Quotation? ");
            if(!scratch){
              location.href = "invoicep.php" ;
            }
          }
    });
    $(document).ready(function(){
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
            dom: 'Bfrtip',
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
      if($.cookie("userrole")=="finance"){
        $("input[id='tab1'],label[for='tab1']").hide();
        $("input[id='tab2']").attr("checked","checked");        
      }

      $("input[name='date']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
      });

      $("select[name='refquono']").change(function(){        
        $.each(JSON.parse(refQuots), function(i, quot){
            //$("select[name='refquono']").append("<option value='"+quot.id+"'>"+quot.qno+"</option>"); 
            if(quot.id==$("select[name='refquono']").val().split("_")[0]){              
              $("input[name='refdate']").val(quot.date.split(" ")[0]);
              $("input[name='igst']").val(quot.igst);
              $("input[name='cgst']").val(quot.cgst);
              $("input[name='sgst']").val(quot.sgst);
              $("input[name='packaging']").val(quot.packaging);
              $("select[name='to']").val(quot.to);
                $("#parts").html("");
                var tot = 0; 
                var total = 0;
                var partIndex = 0;             
              $.each(quot.qoparts, function(i, qparts){

                tot = 0;
                var element = "";
                var discRate = qparts.selling_price-(qparts.selling_price*(qparts.discount/100));                
                var partNo = "";
                var desc = "";
                
                tot+=(discRate+(discRate*parseFloat(qparts.tax/100)))*qparts.qty;
                $.each(JSON.parse(partsData),function(i, part){
                  if(qparts.partId == part.id){
                    partNo = part.partno;
                    desc = part.desc;
                  }
                });
                element = "<tr>"                
                +"<td>"
                +"<input class='form-control' type='text' name='partno"+partIndex+"' value='"+qparts.partId+"-"+partNo+"' readonly>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' name='description"+partIndex+"' value='"+desc+"' readonly>"
                +"</td>"      
                +"<td>"
                +"<input class='form-control' type='text' name='rate"+partIndex+"' value='"+qparts.selling_price+"' readonly>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' name='discountslab"+partIndex+"' value='"+qparts.discount+"' readonly>"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' id='"+partIndex+"' name='discrate"+partIndex+"' value='"+discRate+"' readonly>"
                +"</td>"
                +"<td>"
                +"<input class='form-control qty' type='text' id='"+partIndex+"' name='quantity"+partIndex+"' value='"+qparts.qty+"' >"
                +"</td>"
                +"<td>"
                +"<input class='form-control tax' type='text' id='"+partIndex+"' name='tax"+partIndex+"' value='"+qparts.tax+"' >"
                +"</td>"
                +"<td>"
                +"<input class='form-control' type='text' id='"+partIndex+"' name='amount"+partIndex+"' value='"+tot+"' readonly>"
                +"</td>"
                // +"<td>"
                // +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
                // +"</td>"
                +"</tr>";
                $("#parts").append(element);
                total+=tot;
                addPartIds.push(partIndex);
                partIndex++;
              });
              //total=tot+tot*((parseFloat(quot.igst)+parseFloat(quot.sgst)+parseFloat(quot.cgst))/100)+parseFloat(quot.packaging);              
              $("input[name='total']").val(total+(total*((parseFloat(quot.igst)+parseFloat(quot.sgst)+parseFloat(quot.cgst))/100))+parseFloat(quot.packaging));
              //$("input[name='total']").val(quot.amount);              
              
            }
            //getQuotDetails($("select[name='refquono']").val());
          });
      });

      $(".addpart").attr("disabled","disabled");

      var $select = $("select[name='to']");
      $select.on("change", function() {
         //$(this).attr("disabled","disabled");
         $(".addpart").removeAttr("disabled");
      });

      $("input[name='shipmentdate']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
      });
      getPart();
      
      
      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });

      $("table.or").on("keyup", ".tax", function (event) {
        var id = $(this).attr("id");
        var qty = parseInt($("input[name='quantity"+id+"']").val());
        var unitPrice = parseFloat($("input[name='discrate"+id+"']").val());
        var tax = (unitPrice*qty)*(parseFloat($(this).val())/100);
        console.log(tax);
        $("input[name='amount"+id+"']").val(tax+(unitPrice*qty));
    });

      $("table.or").on("click", ".removepart", function (event) {
        //alert($(this).attr("id"));
        removePartIds.push(parseInt($(this).attr("id")));
        $(this).closest("tr").remove();
    });
    $("table.or").on("focusout", ".rate", function (event) {
        var qty = parseInt($("input[name='quantity"+$(this).attr("id")+"']").val());
        var unitPrice = parseFloat($("input[name='rate"+$(this).attr("id")+"']").val());
        var actualprice = parseFloat(qty*unitPrice);
        $("input[name='amount"+$(this).attr("id")+"']").val(actualprice);
    });

    $("table.or").on("input", ".qty", function (event) {
        var qty = parseInt($("input[name='quantity"+$(this).attr("id")+"']").val());
        var unitPrice = parseFloat($("input[name='discrate"+$(this).attr("id")+"']").val());
        var actualprice = parseFloat(qty*unitPrice);
        $("input[name='amount"+$(this).attr("id")+"']").val(actualprice);
    });

    $("table.or").on("focus", ".amount", function (event) {
        var qty = parseInt($("input[name='quantity"+$(this).attr("id")+"']").val());
        var unitPrice = parseFloat($("input[name='rate"+$(this).attr("id")+"']").val());
        var actualprice = parseFloat(qty*unitPrice);
        $("input[name='amount"+$(this).attr("id")+"']").val(actualprice);
    });


    $("table.or").on("change", ".part", function (event) {
        var id = $(this).attr("id");
        var val = $(this).val().split("-");
        $.each(JSON.parse(partsData), function(i, part){
          if(part.id==val[0]){
            $("textarea[name='description"+id+"']").val(part.desc);
            $("input[name='rate"+id+"']").val(part.unitprice);
            $("input[name='quantity"+id+"']").val(0);
            $("input[name='amount"+id+"']").val("0");
            up = part.unitprice;
          }
        });
    });

    $("table.or").on("change", ".discountslab", function (event) {
        var id = $(this).attr("id");
        $("input[name='quantity"+id+"']").val(0);
        $("input[name='amount"+id+"']").val("0");
        $("input[name='discrate"+id+"']").val(up-(up*parseFloat($(this).val()/100)));
    });

    $("table.or").on("focus", ".rate", function (event) {
        var up = 0;
        var id = $(this).attr("id");
        var val = $("select[name='partno"+id+"']").val().split("-");
        $.each(JSON.parse(partsData), function(i, part){
          if(part.partno==val[1]){
            up = parseFloat(part.unitprice);
          }
        });
        var dis = parseFloat($("select[name='discountslab"+id+"']").val()/100);
        $(this).val(up-(up*dis));
    });

    $("form").submit(function(event){
      //event.preventDefault();
      $("select[name='to']").removeAttr("disabled");
      var formData = $(this).serializeArray();
      var diff = $(addPartIds).not(removePartIds).get();
      //$(this).append("<input type='hidden' name='ids' value='"+diff+"'/>");
      $(this).append("<input type='hidden' name='ids' value='"+addPartIds+"'/>");
    });
    });
    function addPart(){
      var element = "";
      element = "<tr>"
      // +"<td>"+partIndex+".</td>"
      +"<td>"
      +"<select class='form-control part' name='partno"+partIndex+"' id='"+partIndex+"'><option value='default'>Select part</option></select>"
      +"</td>"
      +"<td>"
      +"<textarea type='text' class='form-control' name='description"+partIndex+"'></textarea>"
      +"</td>"      
      +"<td>"
      +"<input type='text' class='form-control rate' name='rate"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      // +"<select class='form-control discountslab' name='discountslab"+partIndex+"' id='"+partIndex+"' required></select>"
      +"<input style='width:100px;' class='form-control discountslab' name='discountslab"+partIndex+"' id='"+partIndex+"' required/>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control rate' name='discrate"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control number qty' name='quantity"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control amount' name='amount"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
      +"</td>"
      +"</tr>";
      $("#parts").append(element);
      $("select[name='discountslab"+partIndex+"']").append("<option value=''>Select Discount</option>");
      $.each(JSON.parse(customers), function(i, cust){
        if(cust.id == $("select[name=to]").val()){
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount1+"'>"+cust.discount1+"</option>");
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount2+"'>"+cust.discount2+"</option>");
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount3+"'>"+cust.discount3+"</option>");
        }
      });
      $.each(JSON.parse(partsData), function(i, part){
        $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"/"+part.country+"</option>");
      });
      $("select[name='partno" + partIndex + "']").select2();
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
                $("select[name='to']").append("<option value='"+vendor.id+"'>"+vendor.company+"</option>");
              }else{
                $("select[name='to']").append("<option value='"+vendor.id+"'>"+vendor.company+"</option>");
              }
            });
          }*/
          //getInvoice();
          getPreInvNo();          
			}});
    }

    function getPart(){
      if(partsData==null){
        $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllInventory":"getAllInventory"},
        url:"../php/inventory.php",
        success:function(data){
          //console.log(data);
          partsData = data;
          localStorage.setItem("parts",partsData);
        }
      });
      }
      getCustomers();
      getRefQuo();
    }

    function getInvoice(){
      var lastInvNo = "";
      $.ajax({
				method:"POST",
				type:"json",
				data:{"getAllInv":"getAllInv"},
				url:"../php/invoice.php",
				success:function(data){
					console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,inv){
              //alert(customers);
              $.each(JSON.parse(customers),function(i,customer){
                if(customer.id==inv.to){
                  to = customer.company;
                }
              });
                var tot = 0;
                $.each(inv.parts,function(i,pop){
                  tot=tot+parseInt(pop.amount);
                });
                tot+=tot*((parseFloat(inv.igst)+parseFloat(inv.sgst)+parseFloat(inv.cgst))/100)+parseFloat(inv.packaging);
              var cancelled = "";
              var freight = "";
              if(inv.freight == 1){
                freight = "Paid";
              }else{
                freight = "To be Paid";
              }
              if(inv.cancelled == 1){
                if($.cookie("status")=="Offline"){
                  cancelled = "<button class='btn btn-md btn-danger' onClick='cancelInv("+inv.id+",0)' disabled>Cancelled</button>";
                }else{
                  cancelled = "<button class='btn btn-md btn-danger' onClick='cancelInv("+inv.id+",0)'>Cancelled</button>";
                }                
                
              }else{
                if($.cookie("status")=="Offline"){
                  cancelled = "<button class='btn btn-md btn-success' onClick='cancelInv("+inv.id+",1)' disabled>Not Cancelled</button>";
                }else{
                  if($.cookie("userrole")=="finance"){
                    cancelled = "<button class='btn btn-md btn-success' onClick='cancelInv("+inv.id+",1)' disabled>Not Cancelled</button>";
                  }else{
                    cancelled = "<button class='btn btn-md btn-success' onClick='cancelInv("+inv.id+",1)'>Not Cancelled</button>";
                  }
                }
                
              }
              var editBtn = "";
              var deleteBtn = "";
              var printBtn = "";              
              if($.cookie("status")=="Offline"){
                printBtn = "<button class='btn btn-success' onClick='printInvoice("+inv.id+")' >Print</button>&emsp;";
                editBtn = "<button class='btn btn-warning' onClick='editInv("+inv.id+")' id='"+inv.id+"' disabled>Edit</button>&emsp;";
                deleteBtn ="<button class='btn btn-danger' onClick='deleteInv("+inv.id+")' id='"+inv.id+"' disabled>Delete</button>";
              }else{
                printBtn = "<button class='btn btn-success' onClick='printInvoice("+inv.id+")' >Print</button>&emsp;";
                if($.cookie("userrole")=="finance"){
                  editBtn = "<button class='btn btn-warning' onClick='editInv("+inv.id+")' id='"+inv.id+"' disabled>Edit</button>&emsp;";
                  deleteBtn ="<button class='btn btn-danger' onClick='deleteInv("+inv.id+")' id='"+inv.id+"' disabled>Delete</button>";
                }else{                  
                  editBtn = "<button class='btn btn-warning' onClick='editInv("+inv.id+")' id='"+inv.id+"' >Edit</button>&emsp;";
                  deleteBtn ="<button class='btn btn-danger' onClick='deleteInv("+inv.id+")' id='"+inv.id+"' >Delete</button>";
                }
              }

              // if($.cookie("userrole")=="finance"){
              //   printBtn = "<button class='btn btn-success' onClick='printInvoice("+inv.id+")' >Print</button>&emsp;";
              //   editBtn = "<button class='btn btn-warning' onClick='editInv("+inv.id+")' id='"+inv.id+"' disabled>Edit</button>&emsp;";
              //   deleteBtn ="<button class='btn btn-danger' onClick='deleteInv("+inv.id+")' id='"+inv.id+"' disabled>Delete</button>";
              // }
              
              if(i==0){
                $("#invList").html("<tr>"
                    +"<td>"+to+"</td>"
                    +"<td>"+inv.invno+"</td>"
                    +"<td>"+inv.date.split(" ")[0]+"</td>"
                    +"<td>"+inv.shipdate.split(" ")[0]+"</td>"
                    +"<td>"+freight+"</td>"
                    +"<td>"+tot+"</td>"
                    +"<td>"+cancelled+"</td>"
                    +"<td>"
                    +printBtn
                    +editBtn
                    +deleteBtn
                    +"</td>"
                    +"</tr>");
              }else{
                $("#invList").append("<tr>"
                    +"<td>"+to+"</td>"
                    +"<td>"+inv.invno+"</td>"
                    +"<td>"+inv.date.split(" ")[0]+"</td>"
                    +"<td>"+inv.shipdate.split(" ")[0]+"</td>"
                    +"<td>"+freight+"</td>"
                    +"<td>"+tot+"</td>"
                    +"<td>"+cancelled+"</td>"
                    +"<td>"
                    +printBtn
                    +editBtn
                    +deleteBtn
                    +"</td>"
                    +"</tr>");
              }
              lastInvNo = inv.invno;

            });
          }else{
            /*alert("No quotation exist!! Try Generating one.");
            location.href="quotation.html";*/
          }
          getPreInvNo();
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
            dom: 'Bfrtip',
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
      });
    }

    function editInv(id) {
      window.open("editInv.php?type=inv&id="+id+"", "_self");
    }

    function printInvoice(id){
      var copy = prompt("Please enter copy");
      if (copy != null) {
          // document.getElementById("demo").innerHTML =
          // "Hello " + person + "! How are you today?";
          window.open("../php/invoice.php?id="+id+"&copy="+copy, "_blank");
      }
      // location.href = "../php/dc.php?id="+id+"";
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
            //console.log(data);
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

    function cancelInv(id,status){
      //console.log(id+"---"+status);
      $.ajax({
        method:"POST",
        type:"json",
        data:{"cancelInv":"cancelInv", "invId":id, "status":status},
        url:"../php/invoice.php",
        success:function(data){
          //console.log(data);
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

    function getRefQuo(){
      //refquono
      $.ajax({
        method: "POST",
        type: "json",
        data: { "getAllQuo": "getAllQuo" },
        url: "../php/quotation.php",
        success: function (data) {
          refQuots = data;
          /*$("select[name='refquono']").append("<option value=''>Select Quotation</option>");
          $.each(JSON.parse(data), function(i, quot){
            $("select[name='refquono']").append("<option value='"+quot.id+"_"+quot.qno+"'>"+quot.qno+"</option>");  
          });*/
        }});
    }

    function getQuotDetails(quoId){

    }

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
        }});
    }
    </script>
  </body>
</html>
