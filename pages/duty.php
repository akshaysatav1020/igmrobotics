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
		
	.table>thead:first-child>tr:first-child>th:nth-child(1){width:8%;}
	.table>thead:first-child>tr:first-child>th:nth-child(2){width:5%;}
	.table>thead:first-child>tr:first-child>th:nth-child(3){width:8%;}
	.table>thead:first-child>tr:first-child>th:nth-child(4){width:4%;}
	.table>thead:first-child>tr:first-child>th:nth-child(5){width:10%;}
	.table>thead:first-child>tr:first-child>th:nth-child(6){width:5%;}
	.table>thead:first-child>tr:first-child>th:nth-child(7){width:10%;}
	.table>thead:first-child>tr:first-child>th:nth-child(8){width:10%;}
	.table>thead:first-child>tr:first-child>th:nth-child(9){width:10%;}	
	.table>thead:first-child>tr:first-child>th:nth-child(10){width:10%;}
	.table>thead:first-child>tr:first-child>th:nth-child(11){width:10%;}
	.table>thead:first-child>tr:first-child>th:nth-child(12){width:10%;}

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
          <label for="tab1">Duty Calculation</label>
          <input id="tab3" type="radio" name="tabs">
         <label for="tab3">Inward List</label>
          <!-- <input id="tab2" type="radio" name="tabs">         
         <label for="tab2">Consumption Report</label>           -->
          <section id="content1">
            <form class="" action="../php/duty.php" method="POST">
              <input type="text" name="againstPo" style="display: none;" value="false">   
              <div class="col-md-3">
                <div class="form-group">
                  <label>Inward Number</label>
                  <input class="form-control" name="inwardNo" id="inwardno" value="" readonly="readonly" />                  
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
                  <label>Invoice Number.</label>
                  <input class="form-control" name="invoiceNo" />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="to">Vendor</label>
                  <select class="form-control" name="vendor" required="required">
                    <option value="">Select Vendor</option>                    
                    <?php                    
                      $query="SELECT * FROM vendors";
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
                  <label for="conversion">Conversion Rate</label>
                  <input class="form-control" name="euroRate" />                  
                </div>
              </div>                
              <div class="col-md-3">
                <div class="form-group">
                  <label>Discount %</label>
                  <input class="form-control" name="discount" value="0.00"  />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Duty</label>
                  <input class="form-control" name="duty" value="0.00"  />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Clearing</label>
                  <input class="form-control" name="claring" value="0.00"  />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Packaging</label>
                  <input class="form-control" name="packaging" value="0.00"  />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Forwarding</label>
                  <input class="form-control" name="forwarding" value="0.00"  />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Total Amount</label>
                  <input class="form-control" name="total" value="0.00"  />                  
                </div>
              </div>
              <!-- <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button><br><br>                
              </div> -->
              <div class="col-md-3">
                <div class="form-group">
				  <input type="file" class="form-control" id="fileUpload" />
				  <input type="button" class="btn btn-default" id="upload" value="Upload" />
				</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
					  <a href="../importtemplates/dutyAutoCalc.xlsx" download>Download Template File</a>
					</div>
				</div>
              <!-- <form class="excelForm"  method="POST" action='../php/duty.php' enctype="multipart/form-data">              
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select Excel</label>
                    <input type="file" class="form-control" name="excelFile" id="excelFile" value="" />                  
                  </div>
                </div>
                  <div class="col-md-3">
                  <div class="form-group">
                    <input class="form-control" type="submit" name="dutyPartsList" value="import"/>                  
                  </div>
                </div>
            </form> -->

              <div class="col-md-12">
                <div class="form-group">
                  <div class="table-responsive">
                    <!-- <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>                                                    
                        <th style="width: 100px;">Part No.</th>                          
                        <th style="width: 137px;">Unit Rate (Euro)</th>
                        <th style="width: 137px;">Unit Rate (INR)</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>% Share</th>
                        <th>Duty </th>
                        <th style="width: 129px;">Clearing Amt.</th>
                        <th>Packaging</th>
                        <th style="width: 149px;">Forwarding Amt.</th>
                        <th style="width: 154px;">Landed Cost/Unit</th>
                        <th style="width: 96px;">Landed Cost</th>                        
                        </tr>
                      </thead>
                      <tbody id="inwardparts">
                      </tbody>
                    </table> -->
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" name="addDuty" class="btn btn-info">Generate</button>
              </div>
            </form>
            
          </section>
          <section id="content3">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>Inward No.</th>
                    <th>Purchase Order</th>
                    <th>Vendor</th>
                    <th>Bill Entry No.</th>
                    <th>Bill Entry Date</th> 
                    <th>Inward Type</th>                                   
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Inward No.</th>
                    <th>Purchase Order</th>
                    <th>Vendor</th>
                    <th>Bill Entry No.</th>
                    <th>Bill Entry Date</th>
                    <th>Inward Type</th>                                        
                    <th>Action</th>
                  </tr>
                </tfoot>                
                <tbody>
                  <?php
                      $query="SELECT dt.*, po.po_no as pono, vend.company_name as vname FROM duty dt LEFT JOIN purchaseorder po on dt.po=po.id LEFT JOIN vendors vend on dt.vendor=vend.id";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["inward_no"]."</td>";
                          echo "<td>".$row["pono"]."</td>";                          
                          echo "<td>".$row["vname"]."</td>";
                          echo "<td>".$row["bill_of_entry_no"]."</td>";                          
                          echo "<td>".parseDateString($row["bill_of_entry_date"])."</td>";
                          echo "<td>".$row["inward_type"]."</td>";                          
                          
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){  
                            echo "<button class='btn btn-xs btn-warning' onclick='editInward(".$row["duty_id"].",\"".$row["inward_type"]."\")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger' onclick='deleteInward(".$row["duty_id"].")'>Delete</button></td>";
                          }else{                                                    
                            echo "<button class='btn btn-xs btn-warning' onclick='editInward(".$row["duty_id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-xs btn-danger' onclick='deleteInward(".$row["duty_id"].")'disabled>Delete</button></td>";
                          }
                          echo "</tr>";
                        }
                      } 

                      function getVendor($connection, $id){
                        $query="SELECT * FROM vendors WHERE id=".$id;
                        $result = $connection->query($query);
                        $data = "";
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){          
                            $data = $row['company_name']." - ".$row['city'];
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
          <section id="content2">
            <form  action="#" method="POST">                
              <div class="col-md-3">
                <div class="form-group">
                  <label>Start Date</label>
                   <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                      <input class="form-control" name="startDate" />  
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>                 
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>End Date</label>
                   <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                         <input class="form-control" name="endDate" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Type</label>
                   <select name="type" class="form-control">
                     <option value='Tabular'>Tabular</option>
                     <option value='Graphical'>Graphical</option>
                   </select>                  
                </div>
              </div>
              <div class="col-md-3" style="margin-top:24px;">
                <button type="button" name="getReport" onClick="getConsumptionReport()" class="btn btn-info">Generate Report</button>
              </div>
            </form>
            <div class="col-md-12" id="report">
              
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
  <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
  <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
  <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
  <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
  <script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
  <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
      $("header,.container-fluid,footer").hide();
      $(".loader").show();
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem("parts");
    var customers;
    var stocks=null;
    var cur = "";
    
    $("body").on("click", "#upload", function () {
            //Reference the FileUpload element.
            var fileUpload = $("#fileUpload")[0];

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function (e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function (e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        });
        function ProcessExcel(data) {
            //Read the Excel File data.
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            //Fetch the name of First Sheet.
            var firstSheet = workbook.SheetNames[0];

            //Read all rows from First Sheet into an JSON array.
            var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

            

            //Create a HTML Table element.
            $("div.table-responsive").html('<table class="table table-striped table-bordered table-condensed or"><thead><tr><th>Part No.</th><th>Euro Amt.</th><th>INR Amt.</th><th>Qty</th><th>Total</th><th>Share%</th><th>Duty Amt.</th><th>Clearing Amt.</th><th>Packaging</th><th>Forwarding Amt.</th><th>Landed Cost/Unit</th><th>Landed Cost</th></tr></thead><tbody id="inwardparts">');
			var euroRate = parseFloat($("input[name='euroRate']").val());
            var totalValue = parseFloat($("input[name='total']").val());
            var dutyValue = parseFloat($("input[name='duty']").val());
            var clearingValue = parseFloat($("input[name='claring']").val());
            var packagingValue = parseFloat($("input[name='packaging']").val());
            var forwardingValue = parseFloat($("input[name='forwarding']").val());
            //Add the data rows from Excel file.
            for (var i = 0; i < excelRows.length; i++) {
				addPartIds.push(i);
                $("tbody#inwardparts").append("<tr>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='partno"+i+"' value='"+excelRows[i].Parts+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='unitRateEuro"+i+"' value='"+excelRows[i].Euro+"' readonly/></td>");

                /*Auto Calculations precision upto 2 decimals*/
                var inrValue = parseFloat(excelRows[i].Euro*euroRate).toFixed(2);
                var totalPartValue = parseFloat(excelRows[i].Qty*inrValue).toFixed(2);               
                var pershare = ((totalPartValue/totalValue)*100).toFixed(2);
                var dutyPerParticular = ((pershare*dutyValue)/100).toFixed(2);
                var clearingPerParticular = ((pershare*clearingValue)/100).toFixed(2);
                var packagingPerParticular = ((pershare*packagingValue)/100).toFixed(2);
                var forwardingPerParticular = ((pershare*forwardingValue)/100).toFixed(2);
                var total = (parseFloat(dutyPerParticular)+parseFloat(clearingPerParticular)+parseFloat(packagingPerParticular)+parseFloat(forwardingPerParticular)+parseFloat(totalPartValue)).toFixed(2);

                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='unitRateInr"+i+"' value='"+inrValue+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='quantity"+i+"' value='"+excelRows[i].Qty+"' readonly/></td>"); 
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' value='"+totalPartValue+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' value='"+pershare+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='duty"+i+"' value='"+dutyPerParticular+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='clearing"+i+"' value='"+clearingPerParticular+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='packging"+i+"' value='"+packagingPerParticular+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='forwarding"+i+"' value='"+forwardingPerParticular+"' readonly/></td>");
                var v = (total/excelRows[i].Qty).toFixed(2);
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='Landedcostper"+i+"' value='"+v+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='landedcost"+i+"' value='"+total+"' readonly/></td>");
				$("tbody#inwardparts").append("</tr>");
                /*addPartIds.push(i);
                $("tbody#inwardparts").append("<tr>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='partno"+i+"' value='"+excelRows[i].Parts+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='unitRateEuro"+i+"' value='"+excelRows[i].Euro+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='unitRateInr"+i+"' value='"+excelRows[i].INR+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='quantity"+i+"' value='"+excelRows[i].Qty+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' value='"+excelRows[i].Total_VALUE+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' value='"+excelRows[i].Percent_Share+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='duty"+i+"' value='"+excelRows[i].Duty_Paid+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='clearing"+i+"' value='"+excelRows[i].Clearing_Paid+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='packging"+i+"' value='"+excelRows[i].Packaging_Paid+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='forwarding"+i+"' value='"+excelRows[i].Forwarding_Paid+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='Landedcostper"+i+"' value='"+(excelRows[i].Total_Amount)/(excelRows[i].Qty)+"' readonly/></td>");
                $("tbody#inwardparts").append("<td><input type='text' class='form-control' name='landedcost"+i+"' value='"+excelRows[i].Total_Amount+"' readonly/></td>");
                $("tbody#inwardparts").append("</tr>");*/
                
            }
            $("table.or").append("</tbody></table>");
            /*var dvExcel = $("#inwardparts");
            dvExcel.html("");*/
            //dvExcel.append(table);
        };

        $("form").submit(function(event){        
          $("select[name='to']").removeAttr("disabled");
          var formData = $(this).serializeArray();
          //var diff = $(addPartIds).not(removePartIds).get();
          $(this).append("<input type='hidden' name='ids' value='"+addPartIds+"'/>");
        });
    $(document).ready(function(){
      checkNetworkStatus();
      $("select[name='vendor']").select2({"width":"100%"});
      if(confirm("Are you Inwarding against PO?")){
        window.open("dutyPo.php", "_self");
      }
      getPart();
      getInwardno();
      if($.cookie("status")=="Offline"){                      
        $("button[name='generateDC']").attr("disabled","disabled");
      }

      $("input[name='startDate'],input[name='endDate']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
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
      $('#myTable').DataTable({
        dom: 'Bfrtip',
          buttons: [
              $.extend( true, {}, buttonCommon, {
                  extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3,4]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'excelHtml5',title:"Inward List",exportOptions:{columns:[0,1,2,3,4]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'pdfHtml5',title:"Inward List",exportOptions:{columns:[0,1,2,3,4]}
              } )
          ]
      });
      
      $("input[name='inwardDate'],input[name='billOfEntryDate']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
      });

      
      
      $(".addpart").attr("disabled","disabled");
        var $select = $("select[name='vendor']");
        $select.on("change", function() {        
        $(".addpart").removeAttr("disabled");
      });

      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });

      $("table.or").on("click", ".removepart", function (event) {          
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
      });

      $("table.or").on("change", ".part", function (event) {          
          var id = $(this).attr("id");
          var val = $(this).val().split("-");
          $("select[name='serial"+id+"[]'").empty();
          $.each(JSON.parse(partsData), function(i, part){
            if(part.id==val[0]){
              $("textarea[name='description"+id+"']").val(part.desc);
              $("input[name='unitRateInr"+id+"']").val(part.unitpriceinr);
              $("input[name='unitRateEuro"+id+"']").val(part.unitpriceeuro);             
            }
          });
          $("select[name='serial"+id+"[]']").multiselect();
      });     

      $("table.or").on("keyup", ".qty", function (event) {
        var id = $(this).attr("id");
        var eurorate = parseFloat($("input[name='euroRate']").val());
        var unitRateEuro = parseFloat($("input[name='unitRateEuro"+id+"']").val());
        var unitRateInr = parseFloat($("input[name='unitRateInr"+id+"']").val());
        var qty = $(this).val();        
        var landedcost = unitRateInr*qty;
        $("input[name='Landedcostper"+id+"']").val(landedcost/qty);
        $("input[name='landedcost"+id+"']").val(landedcost);          
      });

      $("table.or").on("keyup", ".forwarding", function (event) {
        var id = $(this).attr("id");
        var eurorate = parseFloat($("input[name='euroRate']").val());
        var unitRateInr = parseFloat($("input[name='unitRateInr"+id+"']").val());
        var duty = parseFloat($("input[name='duty"+id+"']").val());
        var clearing = parseFloat($("input[name='clearing"+id+"']").val());
        var packging = parseFloat($("input[name='packging"+id+"']").val());
        var forwarding = parseFloat($("input[name='forwarding"+id+"']").val());
        var qty = parseFloat($("input[name='quantity"+id+"']").val());
        var landedcost = (unitRateInr*qty)+(duty+clearing+packging+forwarding);
        console.log((unitRateInr*qty)+" "+(duty+clearing+packging+forwarding));
        $("input[name='Landedcostper"+id+"']").val((landedcost/qty).toFixed(2));
        $("input[name='landedcost"+id+"']").val((landedcost).toFixed(2));
          
      });

      

    });

  

  function editInward(id,type){
      if(type=="Under Warranty and other reason"){
        window.open("editDuty.php?type=duty&id="+id+"", "_self");
      }else{
        window.open("editDutyPo.php?type=duty&id="+id+"", "_self");
      }     
  }

   

  function deleteInward(id){
    var c = confirm("Do you really want to delete "+id+"?");
    //alert(c);
    if(c){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"id":id,"deleteDuty":"deleteDuty"},
        url:"../php/duty.php",
        success:function(data){
          console.log(data);
          if(data.trim()=="Deleted"){
            alert("Deleted");
            location.reload();
          }else{
            alert("Unable to delete Contact Admin");
          }
        },error: function(error){
          alert("Unable to delete Contact Admin");
      }});
    }
  }

  function getInwardno(){
    $.ajax({
      method:"POST",
      type:"json",
      data:{"getLastInwardNo":"getLastInwardNo"},
      url:"../php/duty.php",
      success:function(data){
        console.log(data);
        var today = new Date();    
        //get current month
        var curMonth = today.getMonth();    
        var fiscalYr = "";
        if (curMonth > 3) { //
            var nextYr1 = (today.getFullYear() + 1).toString();
            fiscalYr = today.getFullYear().toString().substr(2.4) + "-" + nextYr1.charAt(2) + nextYr1.charAt(3);
        } else {
            var nextYr2 = today.getFullYear().toString();
            fiscalYr = (today.getFullYear() - 1).toString().substr(2.4) + "-" + nextYr2.charAt(2) + nextYr2.charAt(3);
        }
        var count = "";  
        if(data!=""){
          count = parseInt(data.split("-")[1])+1;
          $("input[name='inwardNo']").val('IGM-'+count+'-'+ fiscalYr);
        }else{
          count=1;
          $("input[name='inwardNo']").val('IGM-'+count+'-'+ fiscalYr);
        }
        
      },
      error:function(error){}
    });
    
  }



  function addPart(){
      var element = "";
      element = "<tr>"      
      +"<td>"
      +"<select class='form-control part js-example-basic-single' data-show-subtext='true' data-live-search='true' name='partno"+partIndex+"' id="+partIndex+"><option value='default'>Select part</option></select>"
      +"</td>"      
      +"<td>"
      +"<input type='text' class='form-control unitRateEuro' name='unitRateEuro"+partIndex+"' id='"+partIndex+"' >"
      +"</td>"
       +"<td>"
      +"<input type='text' class='form-control unitRateInr' name='unitRateInr"+partIndex+"' id='"+partIndex+"' >"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control number qty' name='quantity"+partIndex+"' id='"+partIndex+"'/>"
      +"</td>"
      +"<td>"
     +"<input type='text' class='form-control duty' name='duty"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control clearing' name='clearing"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control  packging' name='packging"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control forwarding' name='forwarding"+partIndex+"' id='"+partIndex+"'>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control Landedcostper' name='Landedcostper"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control landedcost' name='landedcost"+partIndex+"' id='"+partIndex+"' readonly>"
      +"</td>"
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
      +"</td>"
      +"</tr>";
      $("#inwardparts").append(element);                  
      $("input[name='duty"+partIndex+"']").val("0");
      $("input[name='clearing"+partIndex+"']").val("0");
      $("input[name='packging"+partIndex+"']").val("0");
      $("input[name='forwarding"+partIndex+"']").val("0");
      $.each(JSON.parse(partsData), function(i, part){
        $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"</option>");
      });
      $("select[name='partno"+partIndex+"']").select2();
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
          localStorage.setItem("parts",partsData) ;
        }
      });
    }      
    $("header,.container-fluid,footer").show();
    $(".loader").hide();
  }

  function getConsumptionReport(){
    $.ajax({
      method:"POST",
      type:"json",
      data:{
        "startDate":$("input[name='startDate']").val(),
        "endDate":$("input[name='endDate']").val(),
        "type":$("select[name='type']").val(),
        "getReport":"getReport"
      },
      url:"../php/report.php",
      success:function(data){
            console.log(data);
            $("div#report").html("");
            if($("select[name='type']").val()=="Tabular"){
              tabularReport(data);
            }else{
              graphicalReport(data);
            }
            
          }
    });
  }

  function tabularReport(data){
    $("div#report").append("<table class='table table-bordered table-striped table-condensed' id='reportTable'>"
    +"<thead>"
    +"<tr>"
    +"<th>Part No</th>"
    +"<th>Available</th>"
    +"<th>Consumed</th>"
    +"<th>Profit/Loss</th>"
    +"</tr>"
    +"</thead>"
    +"<tfoot>"
    +"<tr>"
    +"<th>Part No</th>"
    +"<th>Available</th>"
    +"<th>Consumed</th>"
    +"<th>Profit/Loss</th>"
    +"</tr>"
    +"</tfoot>"
    +"<tbody id='reportList'></tbody>"
    +"</table>");
    $.each(JSON.parse(data), function(i,report){
      var className=(report.profit>0)?"success":"danger";
      $("tbody#reportList").append("<tr>"
        +"<td>"+report.partNo+"</td>"
        +"<td>"+report.available+"</td>"
        +"<td>"+report.consumed+"</td>"
        +"<td class='"+className+"'>"+report.profit+"</td>"
        +"</tr>");
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
    $('#reportTable').DataTable({
      dom: 'Bfrtip',
        buttons: [                  
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',title:"Consumption Report",exportOptions:{columns:[0,1,2,3]}
            } )
        ]
    });
    
  }

  function graphicalReport(data){
    $("div#report").append("<div class='col-md-6'><div id='pieGraph'></div></div>"
    +"<div class='col-md-6'><div id='barGraph'></div></div>")
    plotPie(JSON.parse(data).pieGraph);
    plotGraph(JSON.parse(data).barGraph, JSON.parse(data).barCategories);
    $("div#report").show();
  }

  function plotPie(data){
    var month = ['Jan', 'Feb', 'Mar', 'April', 'May','Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    //console.log(info);
    Highcharts.chart('pieGraph', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
            
        },        
        title: {
            text: 'Pie Representation'
        },
        tooltip: {
            pointFormat: 'Amount: <b>{point.y}Rs.</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                turboThreshold:0,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },            
       series: data    
    });
}

function plotGraph(data,categories){
    console.log(categories);
    var month = ['Jan', 'Feb', 'Mar', 'April', 'May','Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    //$("p.graphTitle").html("Report for month of "+month[new Date().getMonth()]);
    //var info = JSON.parse(data);        
    Highcharts.chart('barGraph', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Bar Representation'
        },
        subtitle: {
            text: 'Source:'
        },
        plotOptions: {
            column: {
                colorByPoint: true
            }
        },
        colors: [
            '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680', 
            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
        ],
        xAxis: {
            categories: categories,
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Consumption'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Count: <b>{point.y}</b>'
        },
        series: [{ 
            name: 'Consumption',
            data: data,

            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y}',
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
}
    </script>
  </body>
</html>
