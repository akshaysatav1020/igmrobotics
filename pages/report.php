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
        <div class="col-md-2">
          <a href="adminhome.php"><img src="../images/logo.png" alt="igm-logo" class="img-responsive"></a>
        </div>
        <div class="col-md-9">
          <h1>Inventory Control System</h1>
        </div>
      </div>
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Consumption Report</label>
          <input id="tab2" type="radio" name="tabs">
         <!--  <label for="tab2">View List</label> -->
          <section id="content1">
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
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="to">Part No</label>
                  <select class="form-control" name="vendor" required="required">
                    <option value="">Select Part</option>
                    <option value="all">All</option>
                    <?php                    
                      $query="SELECT * FROM inventory_parts";
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
              </div> -->              
              <div class="col-md-3">
                <button type="button" name="getReport" onClick="getConsumptionReport()" class="btn btn-info">Generate Report</button>
              </div>
            </form>
            <div class="col-md-12" id="report">
            	<table class="table table-bordered table-striped table-condensed" id="reportTable">
            		<thead>
            			<tr>
	            			<th>Part No</th>
	            			<th>Available</th>
	            			<th>Consumed</th>
	            			<th>Profit/Loss</th>

	            		</tr>
            		</thead>
            		<tfoot>
            			<tr>
	            			<th>Part No</th>
	            			<th>Available</th>
	            			<th>Consumed</th>
	            			<th>Profit/Loss</th>

	            		</tr>
            		</tfoot>
            		<tbody id="reportList"></tbody>
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
  <script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
  <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
  	$(".loader,div#report").hide();      
    
    $(document).ready(function(){ 

      if($.cookie("status")=="Offline"){                      
        $("button[name='getReport']").attr("disabled","disabled");
      }      
      
      $("input[name='startDate'],input[name='endDate']").datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
      });
    });

    function getConsumptionReport(){
      $.ajax({
		method:"POST",
		type:"json",
		data:{
			"startDate":$("input[name='startDate']").val(),
			"endDate":$("input[name='endDate']").val(),
			"getReport":"getReport"
		},
		url:"../php/report.php",
		success:function(data){
         	console.log(data);
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
         	$("div#report").show();
        }
      });
    }


    </script>
  </body>
</html>
