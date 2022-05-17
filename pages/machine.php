<?php
  require_once("../php/db.php");
  $db=new DB();
  $connection=$db->getConnection();
?>
<html>
<head>
  <meta name="charset" content="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Control System</title>
  <link href="../css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../css/custom.css">
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

  label[for*='1']:before { content: '\f055'; }
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
  <div class="page">
  <?php include "menu.php";?>
    
    <div class="container-fluid">
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Add Machine</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View Machine List</label>
          <section id="content1">
            <form class="" action="../php/machine.php" method="post" enctype="multipart/form-data">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Machine No.</label>
                  <input type="text" class="form-control" name="machineNo" placeholder="Enter customer no" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Machine Name</label>
                  <input type="text" class="form-control" name="machineName" value="" placeholder="Enter name" />
                </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Customer</label>
                <select name="machineCustomer" class="form-control">
                  <option value="">Select</option>
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
                <label for="companyaddress">Location</label>
                <input class="form-control" type="text" name="machineLocation" />
              </div>
            </div>
            <div class="col-md-6" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="addMachine">Add Machine</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th rowspan="1" colspan="1">Machine No.</th>
                    <th rowspan="1" colspan="1">Machine Name</th>
                    <th rowspan="1" colspan="1">Customer</th>
                    <th>Location</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">Machine</th>
                    <th rowspan="1" colspan="1">Machine Name</th>
                    <th rowspan="1" colspan="1">Customer</th>
                    <th>Location</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <!-- <tbody id="machineList"> -->
                <tbody>
                <?php
                      $query="select m.*,c.company_name,c.city from machine m JOIN customers c on m.customer=c.id";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["machine_no"]."</td>";
                          echo "<td>".$row["machine_name"]."</td>";
                          echo "<td>".$row["company_name"]." - ".$row["city"]."</td>";
                          echo "<td>".$row["location"]."</td>";
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){                            
                            echo "<button class='btn btn-sm btn-warning' onclick='editMachine(".$row["machine_id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteMachine(".$row["machine_id"].")'>Delete</button></td>";
                          }else{                                                    
                            echo "<button class='btn btn-sm btn-warning' onclick='editMachine(".$row["machine_id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteMachine(".$row["machine_id"].")'disabled>Delete</button></td>";
                          }
                          echo "</tr>";
                        }
                      }                                
                    ?> 
                </tbody>
              </table>
            </div>
          </section>
        </main>
      </div>
    </div>
    <?php include("footer.php");?>
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
  <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit/View Machine</h4>
      </div>
      <div class="modal-body">
        <form class="" action="../php/machine.php" method="post" enctype="multipart/form-data">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="companyname">Id</label>
              <input type="text" class="form-control" name="eId" placeholder="Enter customer no" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Machine No.</label>
              <input type="text" class="form-control" name="eMachineNo" placeholder="Enter customer no" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Machine Name</label>
              <input type="text" class="form-control" name="eMachineName" value="" placeholder="Enter name" />
            </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Customer</label>
            <select name="eMachineCustomer" class="form-control">
              <option value="">Select</option>
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
            <label for="companyaddress">Location</label>
            <input class="form-control" type="text" name="eMachineLocation" />
          </div>
        </div>
        <!-- <div class="col-md-3">
          <div class="form-group">
            <img class="img-responsive" id="eMachineDrawing" src="" height="50px" width ="50px"/>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Machine Drawing</label>
            <input class="form-control" type="text" name="eMachineDrawingPath" readonly />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Machine Drawing</label>
            <input class="form-control" type="file" name="eMachineDrawing"/>
          </div>
        </div> -->
        <div class="col-md-6" style="padding:2%;">
            <button class="btn btn-success" type="submit" name="editMachine">Edit Machine</button>
            <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
          </div>
        </form>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
  </div>

  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/select2.min.js"></script>
  <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
  <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
  <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
  <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
  <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
    (function(){
      $(".loader").show();
      $(".page").hide();
      $(window).bind("load", function() {
        $("select[name='machineCustomer'],select[name='eMachineCustomer']").select2({"width":"100%"});
        if($.cookie("status")=="Offline"){
          $("button[name='addCustomer']").attr("disabled", "disabled");
        }else{
          //checkDataStatus();
        }
      });
      $(document).ready(function(){
        checkNetworkStatus();
        //getCustomers(); 
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
                      extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'excelHtml5',title:"machines List",exportOptions:{columns:[0,1,2,3]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"machines List",exportOptions:{columns:[0,1,2,3]}
                  } )
              ],"columnDefs": [
                {
                  "targets": [3],
                  "visible": false                
                }
              ]
          });
          $(".loader").hide();
          $(".page").show();       
      });
    })();
    function getMachine(){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"getAllMachine":"getAllMachine"},
				url:"../php/machine.php",
				success:function(data){					
          console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,machine){
              //alert(machine.company);
              var editBtn = "";
              var deleteBtn = "";

                  
              if($.cookie("status")=="Offline"){                      
                editBtn = "<button class='btn btn-warning'  onClick='editMachine("+machine.machineDetails.machine_id+")' id='"+machine.machineDetails.machine_id+"' disabled>Edit/View</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteMachine("+machine.id+")' id='"+machine.machineDetails.machine_id+"' disabled>Delete</button>";
              }else{
                editBtn = "<button class='btn btn-warning'  onClick='editMachine("+machine.machineDetails.machine_id+")'  id='"+machine.id+"' >Edit/View</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteMachine("+machine.machineDetails.machine_id+")' id='"+machine.machineDetails.machine_id+"' >Delete</button>";
              }
              if($.cookie("userrole")=="admin"){
                deleteBtn = "<button class='btn btn-danger' onClick='deletemachine("+machine.machineDetails.machine_id+")' id='"+machine.machineDetails.machine_id+"' disabled>Delete</button>";
              }
              if(i==0){
                $("#machineList").html("<tr>"
                  +"<td>"+machine.machineDetails.machine_no+"</td>"                  
                  +"<td>"+machine.machineDetails.machine_name+"</td>"
                  +"<td>"+machine.custDetails.company_name+"</td>"                  
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
              }else{
                $("#machineList").append("<tr>"
                  +"<td>"+machine.machineDetails.machine_no+"</td>"                  
                  +"<td>"+machine.machineDetails.machine_name+"</td>"
                  +"<td>"+machine.custDetails.company_name+"</td>"                 
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
              }
            });
          }
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
                      extend: 'excelHtml5',title:"machines List",exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"machines List",exportOptions:{columns:[0,1,2,3,4]}
                  } )
              ]
          });
          $(".loader").hide();
          $(".page").show();
			}});
    }

    

    function editMachine(id){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"machineId":id,"getMachine":"getMachine"},
				url:"../php/machine.php",
				success:function(data){
          console.log(data);
          var machine = JSON.parse(data);
          $("input[name='eId']").val(machine.machineDetails.machine_id);
          $("input[name='eMachineNo']").val(machine.machineDetails.machine_no);
          $("input[name='eMachineName']").val(machine.machineDetails.machine_name);              
          $("select[name='eMachineCustomer']").val([machine.custDetails.id]).trigger("change");
          $("input[name='eMachineLocation']").val(machine.machineDetails.location);
          //$("#eMachineDrawing").attr("src","http://www.igmrobotics.com/"+machine.machineDetails.machine_drawing);  
          $("#myModal").modal();        
			  },error:function(error){
          console.log(error);
        }});
    }

    function deleteMachine(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"machineId":id,"deleteMachine":"deleteMachine"},
  				url:"../php/machine.php",
  				success:function(data){
            console.log(data);
            if(data=="Deleted"){
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

    function getCustomers() {
      $.ajax({
        method: "POST",
        type: "json",
        data: { "viewAll": "getAllCustomers" },
        url: "../php/customer.php",
        success: function (data) {
          //console.log(data);
          customers = data;
          /*if (JSON.parse(data).length > 0) {
            $.each(JSON.parse(data), function (i, vendor) {
              if (i == 0) {
                $("select[name='machineCustomer'],select[name='eMachineCustomer']").append("<option value='" + vendor.id + "'>" + vendor.company + "</option>");
              } else {
                $("select[name='machineCustomer'],select[name='eMachineCustomer']").append("<option value='" + vendor.id + "'>" + vendor.company + "</option>");
              }
            });
          }
          getMachine();*/
        },error:function (err) {
          console.log("Error getting customers!!");
        }
      });

    }

  </script>
</body>
</html>
