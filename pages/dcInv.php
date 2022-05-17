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
    <link rel="stylesheet" href="../css/multiselect/bootstrap-multiselect.css">
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
          <label for="tab1">Generate Challan</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View List</label>
          <!-- <input id="tab3" type="radio" name="tabs">
          <label for="tab3">Returnable StockParts</label> -->
          <section id="content1">
            <form class="" action="../php/dc.php" method="POST" id="addDC">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Invoice</label>
                  
                  <select class="form-control" name="invoice" >
                    <option value="">Select</option>
                    <?php
                        $query="SELECT * FROM invoice";
                        $result = $connection->query($query);
                        $data = array();
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){
                            echo "<option value='".$row["id"]."'>".$row["inv_no"]."</option>";
                          }
                        }                                     
                      ?>  
                </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Machine No.</label>
                  <input type="text" class="form-control" name="projectno" />
                  <!-- <select class="form-control" name="projectno" >
                    <option value="">Select</option>
                    <?php
                        /*$query="SELECT * FROM machine";
                        $result = $connection->query($query);
                        $data = array();
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){
                            echo "<option value='".$row["machine_no"]."'>".$row["machine_no"]."</option>";
                          }
                        }*/                                     
                      ?>  
                </select> -->
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
                  <label for="note">Shipment Date</label>
                  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="shipdate" type="text"  >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Mode of transport</label>
                  <select class="form-control" name="mode" >
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
                  <label for="note">L.R. / R, R, NO.</label>
                  <input type="text" name="lr" maxlength="200" class="form-control" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Vehicle No.</label>
                  <input type="text" name="vehicle" class="form-control" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Courier Service</label>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Dispatch No</label>
                  <input type="text" class="form-control" name="dispatchno" placeholder="Dispatch No." />
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Freight</label><br/>
                  <input type="radio" name="freight" value="yes" checked>Yes&emsp;
                  <input type="radio" name="freight" value="no" >No
                </div>
              </div>
              <input type="text" name="returnable" value="no" style="display: none"/>
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Returnable</label><br/>
                  <input type="radio" name="returnable" value="yes" checked>Yes&emsp;
                  <input type="radio" name="returnable" value="no" >No
                </div>
              </div> -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms" ></textarea>
                </div>
              </div>
              <!-- <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button><br><br>                
              </div> -->

              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>                          
                          
                          <th>Part No.</th>  
                          <th>Description</th>
                          <th>Serial No.</th>
                          <th>Quantity</th>
                          <th>Amount</th>
                         <!--  <th>Unit Rate (Rupees)</th>
                          <th>Landed Cost</th>
                          <th>Selling Cost</th>
                          <th>Part Discount (%)</th>
                          <th>Discounted Rate (Rupees)</th>
                          <th>Amount (Rupees)</th> -->
                        </tr>
                      </thead>
                      <tbody id="parts">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" name="generateDC" class="btn btn-info">Generate</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>Challan No.</th>
                    <th>Customer</th>
                    <th>Ref. No</th>
                    <th>Returnable</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Challan No.</th>
                    <th>Customer</th>
                    <th>Ref. No</th>
                    <th>Returnable</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <!-- <tbody id="challanList"> -->
                <tbody>
                  <?php
                      $query="SELECT dc.*, cust.company_name as cname, SUM(dcp.partTotAmount) as totalAmt FROM `deliverychallan` dc LEFT JOIN customers cust on dc.cust_id=cust.id LEFT JOIN dc_products dcp on dc.id=dcp.dcId GROUP BY dc.id";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["challan_no"]."</td>";
                          echo "<td>".$row["cname"]."</td>";
                          echo "<td>".$row["ref_no"]."</td>";
                          if($row["returnable"]=="1"){
                            echo "<td>Returnable</td>";
                          }else{
                            echo "<td>Non Returnable</td>";
                          }
                          echo "<td>".parseDateString($row["date"])."</td>";
                          echo "<td>".$row["totalAmt"]."</td>";
                          if($row["returnable"]=="1"){                            
                            if($row["closing_status"]==1){
                              echo "<td><button class='btn btn-xs btn-info'>Closed</button></td>";
                            }else{
                              echo "<td><button class='btn btn-xs btn-danger' 
                              onClick='changeClosingStatus(".$row["id"].")'>Change Status</button></td>";
                            }
                          }else{
                            echo "<td>NA</td>";
                          }
                          
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){
                            echo "<button class='btn btn-xs btn-success' onclick='printChallan(".$row["id"].")'>Print</button>&emsp;";
                            echo "<button class='btn btn-xs btn-warning' onclick='editChallan(".$row["id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger' onclick='deleteChallan(".$row["id"].")'>Delete</button></td>";
                          }else{                        
                            echo "<button class='btn btn-xs btn-success' onclick='printChallan(".$row["id"].")'>Print</button>&emsp;";
                            echo "<button class='btn btn-xs btn-warning' onclick='editChallan(".$row["id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger' onclick='deleteChallan(".$row["id"].")'disabled>Delete</button></td>";
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

                      function getTotalAmount($connection, $id){
                        $query="SELECT SUM(partTotAmount) as total FROM dc_products WHERE dcId=".$id;
                        $result = $connection->query($query);
                        $data = "";
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){          
                            $data = $row['total'];
                          }
                        }      
                        return $data;
                      }  

                      function parseDateString($date){
                        $date=explode("-", explode(" ", $date)[0]);
                        return $date[2]."-".$date[1]."-".$date[0];
                      }                 
                    ?>                  
                </tbody>
              </table>
            </div>
          </section>
                  <section id="content3">
            <div class="col-md-12">
              <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable2">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Part No.</th>
                    <th>Challan No.</th>
                    <th>Out Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Part No.</th>
                    <th>Challan No.</th>
                    <th>Out Date</th>
                    <th>Action</th>
                  </tr>
                </tfoot>                
                <tbody>
                <?php                      
                    $query = "SELECT * FROM inventory WHERE returnable=1 AND used=1";
                    $result = $connection->query($query);
                    $data = array();                
                    if($result->num_rows>0){
                      while($row=$result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["serial_number"]."</td>";
                        echo "<td>".$row["part_number"]."</td>";                        
                        echo "<td>".$row["ch_no"]."</td>";
                        echo "<td>".$row["modified_on"]."</td>";
                        echo "<td><button class='btn btn-sm btn-warning' onClick='changeReturnStatus(".$row["id"].",0)'>Change Status</button></td>";                        
                        echo "</tr>";
                      }
                    }

                  ?>
                </tbody>
              </table>
              </div>
            </div>
          </section>
          <section id="content4">
            <button type="submit" class="btn btn-lg btn-success" name="button">IMPORT</button>
          </section>
          <section id="content5">
            <button type="submit" class="btn btn-lg btn-success" name="button">EXPORT</button>
          </section>

        </main>
      </div>
    </div>
    <!--Modal for returnable-->
  <div class="modal fade" id="returnableView" role="dialog">
    <div class="modal-dialog modal-lg">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Close Challan</h4>
        </div>
        <div class="modal-body">
          <div class="row">
          <form method="post" action="../php/dc.php" id="returnForm">
            
          </form>
          </div>
        </div>
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
  <script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
  <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
      $("header,.container-fluid,footer").hide();
      $(".loader").show();
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem("parts");
    var customers;
    var stocks=null;
    var inwardno=[];
    $(document).ready(function(){
      checkNetworkStatus();
      getPart();
      $("select[name='to'],select[name='mode'],select[name='invoice']").select2({"width":"100%"});
      if($.cookie("status")=="Offline"){                      
        $("button[name='generateDC']").attr("disabled","disabled");
      }  

      $("select[name='invoice']").on("change", function(){
        $(".addpart").removeAttr("disabled");
        getInvDetails($(this).val());
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

      $(".addpart").attr("disabled","disabled");
      var $select = $("select[name='to']");
      $select.on("change", function() {
         //$(this).attr("disabled","disabled");
         $(".addpart").removeAttr("disabled");
      });

      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });
      $("table.or").on("click", ".removepart", function (event) {
          //alert($(this).attr("id"));
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
      });
      $("table.or").on("focusout", ".unitprice", function (event) {
          var qty = parseInt($("input[name='quantity"+$(this).attr("id")+"']").val());
          var unitPrice = parseFloat($("input[name='unitprice"+$(this).attr("id")+"']").val());
          var actualprice = parseFloat(qty*unitPrice);
          $("input[name='amount"+$(this).attr("id")+"']").val(actualprice);
      });

      

      $("table.or").on("change", ".inwardno", function (event) {
        var id = $(this).attr("id");
        //console.log($(this).val());
        $.ajax({
          method: "POST",
          type: "json",
          data: { "inward_no":$(this).val().split("/")[1],"getDutyParticulars": "getDutyParticulars" },
          url: "../php/duty.php",
          success: function (data) {          
              //console.log(data);
              $("select[name='partno"+id+"']").html("");
              $("select[name='partno"+id+"']").append("<option value=''>Select</option>");
              $.each(JSON.parse(data), function (i, part) {
                $("select[name='partno"+id+"']").append("<option value='"+part.part_no+"'>"
                  +part.part_no.split("-")[1]+"</option>");
              });              
              $('.js-example-basic-single').select2();
          }
        });            
      });

      $("table.or").on('select2:close',".serial", function (evt) {
        var id = $(this).attr("id");
        console.log(id);
        var uldiv = $(this).siblings('span.select2').find('ul')
        var count = $(this).select2('data').length
        if(count==0){
          uldiv.html("")
        }
        else{
          uldiv.html("<li>"+count+" items selected</li>")
        }
        $("input[name='quantity"+id+"']").val(count);
        var diff = $(addPartIds).not(removePartIds).get();
        for(var i=0;i<diff.length;i++){                 
      var ind = diff[i];
      var uldiv = $("select[name='serial"+ind+"[]']").siblings('span.select2').find('ul');
          var count = $("select[name='serial"+ind+"[]']").select2('data').length;
          if(count==0){
            uldiv.html("");
          }
          else{
            uldiv.html("<li>"+count+" items selected</li>");
          }
    }
      });

      $("table.or").on("change", ".part", function (event) {          
          var id = $(this).attr("id");         
          var val = $(this).val().split("-");          
          
            $.each(JSON.parse(partsData), function(i, part){                    
              if(part.id==val[0]){ 
                console.log(part);              
                $("input[name='unitprice"+id+"']").val(part.unitpriceinr);
                $("input[name='landedcost"+id+"']").val("0");
                $("textarea[name='description"+id+"']").val(part.desc);                    
              }
            });
            $.ajax({
              method: "POST",
              type: "json",
              data: {                 
                "partno":val[1],
                "getAllSerial": "getAllSerial" },
              url: "../php/dc.php",
              success: function (data) {   
                //console.log(data)                         ;
                $("select[name='serial"+id+"[]']").html("");
                $("select[name='serial"+id+"[]']").append("<option value=''>Select</option>");
                $.each(JSON.parse(data), function (i, stock) {
                  $("select[name='serial"+id+"[]']").append("<option value='"+stock.id+"-"+stock.serial_number+"'>"
                    +stock.id+"-"+stock.serial_number+"</option>");
                });
                //$("select[name='serial"+id+"[]']").select2({"width":"150px"}); 
                $("select.serial").select2({"width":"150px"});
              }
            });
          
                    
      });


      

      $("table.or").on("change", ".discountslab", function (event) {
        var up = 0;
        var id = $(this).attr("id");
        var val = $("select[name='partno"+id+"']").val().split("-");
        $.each(JSON.parse(partsData), function(i, part){
          if(part.partno==val[1]){
            up = parseFloat(part.landedcost);
          }
        });
        up = parseFloat($("input[name='sellingcost"+id+"']").val());
        var dis = parseFloat($(this).val()/100);
        console.log(up);
        $("input[name='discprice"+id+"']").val(parseFloat(up-(up*dis)));
        var d = up-(up*dis);
        var q = $("input[name='quantity"+id+"']").val();
        $("input[name='amount"+id+"']").val(q*d);
      });



      $("form#addDC").submit(function(event){
        //event.preventDefault();
        $("select[name='to']").removeAttr("disabled");
        var formData = $(this).serializeArray();
        var diff = $(addPartIds).not(removePartIds).get();
        $(this).append("<input type='hidden' name='ids' value='"+diff+"'/>");
      });
    });
    function addPart(){
      var element = "";
      element = "<tr>"
      // +"<td>"+partIndex+".</td>"
      //  +"<td>"
      // +"<select style='width:150px' class='form-control inwardno' name='inwardno"+partIndex+"' id="+partIndex+"></select>"
      // +"</td>"
      +"<td>"
      +"<select style='width:150px' class='form-control part js-example-basic-single'  name='partno"+partIndex+"' id="+partIndex+"></select>"
      +"</td>"
      +"<td>"
      +"<textarea style='width:150px' class='form-control' name='description"+partIndex+"' id="+partIndex+"></textarea>"
      +"</td>"
      +"<td>"
      //+"<select style='width:150px' class='form-control serial js-example-basic-multiple' data-show-subtext='true' data-live-search='true' name='serial"+partIndex+"[]' id="+partIndex+"  multiple><option value=''>Select Serial</option></select>"
      +"<textarea class='form-control serial' name='serial"+partIndex+"' id="+partIndex+"></textarea>"
      //+"<select class='form-control serial' name='serial"+partIndex+"[]' id="+partIndex+" multiple></select>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px' type='text' class='form-control number qty' name='quantity"+partIndex+"' id='"+partIndex+"'/>"
      +"</td>"
      /*+"<td>"
      +"<input style='width:150px' type='text' class='form-control unitprice' name='unitprice"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input style='width:150px' type='text' class='form-control landedcost' name='landedcost"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<input style='width:150px' type='text' class='form-control sellingcost' name='sellingcost"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<select style='width:100px' class='form-control discountslab' name='discountslab"+partIndex+"' id='"+partIndex+"' required></select>"
      +"</td>"
      +"<td>"
      +"<input style='width:150px' type='text' class='form-control discprice' name='discprice"+partIndex+"' id='"+partIndex+"' >"
      +"</td>"
      +"<td>"
      +"<input style='width:150px' type='text' class='form-control amount' name='amount"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"*/
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
      +"</td>"
      +"</tr>";
      $("#parts").append(element);
      // $("select[name='inwardno"+partIndex+"']").append("<option value=''>Select</option>");
      // $.each(JSON.parse(inwardno), function (i, inward) {
      //     $("select[name='inwardno"+partIndex+"']").append("<option value='"+inward.duty_id+"/"+inward.inward_no+"'>"+inward.inward_no+"</option>");
      // });
      $("select[name='discountslab"+partIndex+"']").append("<option value=''>Select</option>");
      $.each(JSON.parse(customers), function(i, cust){
        if(cust.id == $("select[name=to]").val()){
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount1+"'>"+cust.discount1+"</option>");
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount2+"'>"+cust.discount2+"</option>");
          $("select[name='discountslab"+partIndex+"']").append("<option value='"+cust.discount3+"'>"+cust.discount3+"</option>");
        }
      });
      $("select[name='partno"+partIndex+"']").append("<option value=''>Select</option>");        
      $.each(JSON.parse(partsData), function(i, part){        
          $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"-"+part.location+"</option>");
      });
      
      $("select[name='partno"+partIndex+"']").select2({"Width":"100%"});
      //$(".js-example-basic-multiple").select2();
    }

    function changeClosingStatus(id){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"id":id,"getDCForStatus":"getDCForStatus"},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            $("form#returnForm").html("");
            $("form#returnForm").append(""
              +"<div class='col-md-4' style='display:none'>"
              +"<div class='form-group' style='text-align:right;'>"
              +"<label for=''>Challan Id</label>"                            
              +"<input type='text' name='statusChId' class='form-control' value='"+id+"' readonly/>"
              +"</div>"
              +"</div>");
            var count=0;
            $.each(JSON.parse(data),function(i,info){
              count+=1;
              $("form#returnForm").append(""              
              +"<div class='col-md-4'>"
              +"<div class='form-group'>"
              +"<label for=''>Part No.</label>"
              +"<input type='text' name='statusChPartNo"+i+"' class='form-control' "
              +"value='"+info.partNo+"' readonly/>"
              +"</div>"
              +"</div>"
              +"<div class='col-md-4'>"
              +"<div class='form-group'>"
              +"<label for='serialNo'>Old Serial No.</label>"
              +"<input type='text' name='statusChSerialNoOld"+i+"' class='form-control' "
              +"value='"+info.serials+"' readonly/>"
              +"</div>"
              +"</div>"
              +"<div class='col-md-4'>"
              +"<div class='form-group'>"
              +"<label for='serialNo'>New Serial No.</label>"
              +"<input type='text' name='statusChSerialNoNew"+i+"' class='form-control' />"
              +"</div>"
              +"</div>");
            });
            $("form#returnForm").append("<div class='col-md-12'>"              
              +"<input name='count' value='"+count+"' style='display:none'/>"
              +"</div>");
            $("form#returnForm").append("<div class='col-md-12' style='margin-top: 24px;'>"
              +"<button class='btn btn-success' type='submit' name='updateDCClosing'>Submit</button>"
              +"<button class='btn btn-danger'>Clear</button>"
              +"</div>");            
            $("#returnableView").modal();            
          },
          error:function(error){

          }
      });
    }

    function getInwardNo(){
      $.ajax({
        method: "POST",
        type: "json",
        data: { "getAllDuty": "getAllDuty" },
        url: "../php/duty.php",
        success: function (data) {          
            inwardno=data;
        }
      });
    }

    function getInvDetails(id){
      $("tbody#parts").html("");
      $.ajax({
          method:"POST",
          type:"json",
          data:{"invId":id,"getInv":"getInv"},
          url:"../php/invoice.php",
          success:function(data){
            var info = JSON.parse(data)[0];
            $("input[name='projectno']").val(info.projectno);
            $("select[name='to']").val(info.to);
            $("input[name='dispatchno']").val(info.dispatchno);
            $("input[name='shipdate']").val(info.shipdate.split(" ")[0]);
            $("select[name='mode']").val(info.mode);
            $("input[name='vehicle']").val(info.projectno);
            if(info.freight=="1"){
              $("input[value='yes']").prop("checked",true);
            }else{
              $("input[value='no']").prop("checked",true);
            }
            $("input[name='courier']").val(info.courier);
            $("textarea[name='terms']").val(info.terms);
            $.each(info.parts, function(i, invparts){ 
            var description,country,partNo,partId;  
            //console.log("ss");       
              $.each(JSON.parse(partsData), function(j, p){
                if(p.id==invparts.partId){            
                  country=p.country;
                  console.log(country);
                  description=p.desc;
                  partNo=p.partno;
                  partId=p.id;
                }
              });
            element = "<tr>"                
            +"<td style='display:none;'>"
            +"<input class='form-control'  name='partid"+partIndex+"' value='"+partId+"' />"
            +"</td>"
            +"<td>"
            +"<input class='form-control'  name='partno"+partIndex+"' value='"+partNo+"/"+country+"' readonly/>"
            //+"<select style='width:150px' class='form-control part js-example-basic-single'  name='partno"+partIndex+"' id="+partIndex+"></select>"
            +"</td>"
            +"<td>"
            +"<textarea style='width:150px' class='form-control' name='description"+partIndex+"' id="+partIndex+">"+description+"</textarea>"
            +"</td>"
            +"<td>"          
            +"<textarea class='form-control serial' name='serial"+partIndex+"' id="+partIndex+"></textarea>"
            +"</td>"
            +"<td>"
            +"<input style='width:50px' type='text' class='form-control number qty' name='quantity"+partIndex+"' id='"+partIndex+"'/>"
            +"</td>"
            +"<td>"
            +"<input style='width:150px' type='text' class='form-control amount' name='amount"+partIndex+"' id='"+partIndex+"' >"
            +"</td>"
            +"</tr>";
            $("tbody#parts").append(element);
            
            addPartIds.push(partIndex);
            partIndex++;
          });
          },
          error:function(error){

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
            $("header,.container-fluid,footer").show();
            $(".loader").hide();
          },
          error:function(error){

          }
      });
    }

    function getCustomers(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"viewAll":"getAllCustomers"},
        url:"../php/customer.php",
        success:function(data){         
          customers = data;
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
                      extend: 'excelHtml5',title:"Challan List",exportOptions:{columns:[0,1,2,3,4,5]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"Challan List",exportOptions:{columns:[0,1,2,3,4,5]}
                  } )
              ]
          });          
          getPreChallanNo(); 
          $("header,.container-fluid,footer").show();
          $(".loader").hide();                          
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
            partsData = data;
            localStorage.setItem("parts",partsData);
          }
        });
      }
      getCustomers();
      getInwardNo();
    }

    function getChallan(){
      var lastChNo = "";
      var to="";
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllDC":"getAllDC"},
        url:"../php/dc.php",
        success:function(data){
          console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,challan){
              var returnable="Non returnable";
              if(challan.returnable==1){
                returnable="Returnable";
              }
              $.each(JSON.parse(customers),function(i,customer){
                if(customer.id==challan.to){
                  to = customer.company;
                }
              });
              var tot = 0;
              $.each(challan.chParts,function(i,qop){
                tot=tot+parseInt(qop.partTotAmount);
              });
              var editBtn = "";
              var deleteBtn = "";
              var printBtn = "";
              if($.cookie("status")=="Offline"){                      
                printBtn = "<button class='btn btn-success' onClick='printChallan("+challan.id+")' >Print</button>&emsp;";
                editBtn = "<button class='btn btn-warning' onClick='editChallan("+challan.id+")' id='"+challan.id+"' disabled>Edit</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteChallan("+challan.id+")' id='"+challan.id+"' disabled>Delete</button>";
              }else{
                printBtn = "<button class='btn btn-success' onClick='printChallan("+challan.id+")'>Print</button>&emsp;";
                editBtn = "<button class='btn btn-warning' onClick='editChallan("+challan.id+")' id='"+challan.id+"'>Edit</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteChallan("+challan.id+")' id='"+challan.id+"'>Delete</button>";
              }
              if(i==0){
                $("#challanList").html("<tr>"
                +"<td>"+challan.chno+"</td>"
                +"<td>"+to+"</td>"
                +"<td>"+challan.refno+"</td>"
                +"<td>"+returnable+"</td>"
                +"<td>"+challan.date.split(" ")[0]+"</td>"
                +"<td>"+tot+"</td>"
                +"<td>"
                +printBtn
                +editBtn
                +deleteBtn
                +"</td>"
                +"</tr>");
              }else{
                $("#challanList").append("<tr>"
                +"<td>"+challan.chno+"</td>"
                +"<td>"+to+"</td>"
                +"<td>"+challan.refno+"</td>"
                +"<td>"+returnable+"</td>"
                +"<td>"+challan.date.split(" ")[0]+"</td>"
                +"<td>"+tot+"</td>"
                +"<td>"
                +printBtn
                +editBtn
                +deleteBtn
                +"</td>"
                +"</tr>");
              }
              lastChNo = challan.chno;
            });            
          }else{            
          }          
        }
      });
    }

    function printChallan(id){
      var copy = prompt("Please enter copy");
      if (copy != null) {
          window.open("../php/dc.php?id="+id+"&copy="+copy, "_blank");
      }
    }

    function editChallan(id){
     window.open("editChallan.php?type=challan&id="+id+"", "_self");
    }

   

    function deleteChallan(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"dcId":id,"deleteDC":"deleteDC"},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            //if(data=="Deleted"){
              alert("Deleted");
              location.reload();
            /*}else{
              alert("Unable to delete Contact Admin");
            }*/
          },error: function(error){
            alert("Unable to delete Contact Admin");
        }});
      }
    }

    function getPreChallanNo(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getLastDC":"getLastDC"},
        url:"../php/dc.php",
        success:function(data){
          console.log(data);
          if(data==""){
            $("input[name='challannumber']").val("001");
          }else{

            if(parseInt(data)+1<9){
              $("input[name='challannumber']").val("00"+(parseInt(data)+1));
            }else if(parseInt(data)+1<99){
              $("input[name='challannumber']").val("0"+(parseInt(data)+1));
            }else{
              $("input[name='challannumber']").val(parseInt(data)+1);
            }
          }          
        },error: function(error){
          alert("Unable to delete Contact Admin");
      }});
    }


    function getReturnableStock(){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"getAllReturnableStock":"getAllReturnableStock"},
          url:"../php/warehouseStock.php",
          success:function(data){
            //console.log("Returnable Stocks   "+data);
            var element = "";
            var returnableStocks = JSON.parse(data);
            $.each(returnableStocks, function(i, stock){
              var last = stock.mo.split(" ");
              var date1 = new Date(last[0]);
              var date2 = new Date();
              var timeDiff = Math.abs(date2.getTime() - date1.getTime());
              var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
              var statBtn = "";
              if($.cookie("status")=="Offline"){
                statBtn = "<button class='btn btn-sm btn-warning' onClick='changeReturnStatus("+stock.id+",0)' disabled='disabled'>Change Status</button>";
              }else{
                statBtn = "<button class='btn btn-sm btn-warning' onClick='changeReturnStatus("+stock.id+",0)'>Change Status</button>";
              }
              if(diffDays>=30){
                element = "<tr>"
                +"<td class='blink_me' style='color:red;'>"+stock.srno+"</td>"          
                +"<td>"+stock.part+"</td>"          
                +"<td>"+stock.ch_no+"</td>"
                +"<td class='blink_me' style='color:red;'>"+stock.mo.split(" ")[0]+"</td>"        
                +"<td>"+statBtn+"</td>"
                +"</tr>";
              }else{
                element = "<tr>"
                +"<td>"+stock.srno+"</td>"          
                +"<td>"+stock.part+"</td>"          
                +"<td>"+stock.ch_no+"</td>"
                +"<td>"+stock.mo.split(" ")[0]+"</td>"        
                +"<td>"+statBtn+"</td>"
                +"</tr>";
              }
              
              $("#returnableList").append(element);
            });
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
            $('#myTable2').DataTable({
              dom: 'Bfrtip',
                buttons: [
                  $.extend( true, {}, buttonCommon, {
                    extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3]}
                  }),
                  $.extend( true, {}, buttonCommon, {
                    extend: 'excelHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
                  }),
                  $.extend( true, {}, buttonCommon, {
                    extend: 'pdfHtml5',title:"Returnable List",exportOptions:{columns:[0,1,2,3]}
                  })
                ]
            });
            //$("header,.container-fluid,footer").show();
            //$(".loader").hide();
          },error: function(error){
            console.log("Unable to get returnable stocks");
          }
      });
    }
    function changeReturnStatus(id,status){
      var c = confirm("Do you really want to change status "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"stockId":id,"changeReturnStatus":"changeReturnStatus"},
          url:"../php/warehouseStock.php",
          success:function(data){
            console.log(data);
            if(data=="Changed"){
              alert("Changed");
              location.reload();
            }else{
              alert("Unable to change status Contact Admin");
            }
          },error: function(error){
            console.log("Unable to change status Contact Admin");
          }});
      }
    }

    </script>
  </body>
</html>
