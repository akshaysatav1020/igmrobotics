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
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../css/datepicker.css">
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
        
            <form class="addForm" action="../php/sh.php" method="post" enctype="multipart/form-data">
          <div class="col-md-3">
            <div class="form-group">
              <label>Service Id</label>              
              <input type="text" name="serviceId" class="form-control" value="<?php echo $_GET['id'];?>" readonly/>
            </div>
          </div>                 
        <div class="col-md-3">
          <div class="form-group">
            <label for="companyaddress">Defect Photo/Photos(If Any)</label>
            <input class="form-control" type="file" name="photos[]" accept=".png, .jpg, .jpeg" multiple required="" />
          </div>
        </div>               
        <div class="col-md-6" style="padding:2%;">
            <button class="btn btn-success" type="submit" name="addServicePhotos">Add Service</button>
            <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
        </div>
        </form>
          
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
  <div class="modal fade  " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body" id="listPhotos"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>            
        </div>
    </div>
</div>

  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
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
      var partIndex = 0;
      var addPartIds = [];
      var removePartIds = [];
      var customerData="";
    (function(){
      $(".loader").show();
      $(".page").hide();
      $(window).bind("load", function() {
        $("input[name='closedDate'],input[name='reportDate'],input[name='eClosedDate'],input[name='eReportDate'],input[name='serviceDate']").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
          });
        if($.cookie("status")=="Offline"){
          $("button[name='addCustomer']").attr("disabled", "disabled");
        }else{
          //checkDataStatus();
        }
      });
      $(document).ready(function(){
        checkNetworkStatus();
        if($.cookie("userrole")=="viewer"){
          $("input[id='tab1'],label[for='tab1'],input[id='tab3'],label[for='tab3']").hide();
          $("input[id='tab2']").attr("checked","checked");        
        }
        $("select[name='searchCust']").on("change",function(){
          
          getbyCustomerAndError();
        });

          var buttonCommon = {
            exportOptions: {
              format: {
                body: function ( data, row, column, node ) {
                  return column === 5 ?data.replace( /[$,]/g, '' ):data;
                }
              }
            }
          };
          if($.cookie("userId")!="15"){
          $('#myTable').DataTable({
            dom: 'Bfrtip',
              buttons: [
                  $.extend( true, {}, buttonCommon, {
                      extend: 'excelHtml5',title:"Service List",
                      exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]}
                  })
              ],"columnDefs": [
                {
                  "targets": [1,3,5,6,7,8,9,10,13,14,16,17],
                  "visible": false                
                }
              ]
          });
        }else{
          $('#myTable').DataTable({
            "columnDefs": [
                {
                  "targets": [1,3,5,6,7,8,9,10,13,14,16,17],
                  "visible": false                
                }
              ]
          });
          }
          $(".loader").hide();
          $(".page").show();
          
        $(".addpart").click(function () {
          partIndex++;
          addPartIds.push(partIndex);
          addPart();
        });
        $("table.or").on("click", ".removepart", function (event) {          
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
        });
      });
    })();
    
    function getbyCustomerAndError(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"customer":$("select[name='searchCust']").val(),
        "errorCode":$("input[name='searchError']").val(),
        "getServicesByParam":"getServicesByParam"},
        url:"../php/sh.php",
        success:function(data){
          console.log(data);
          $("tbody#serviceList").html("");
          $('#myTable').DataTable().clear();
          $('#myTable').DataTable().destroy();
          if(JSON.parse(data).length>0){
            
          $.each(JSON.parse(data),function(i,service){
            var editBtn = "";
              var deleteBtn = "";                  
              if($.cookie("status")=="Offline"){                      
                editBtn = "<button class='btn btn-warning'  onClick='editService("+service.service_id+")' disabled>Edit/View</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
              }else{
                editBtn = "<button class='btn btn-warning'  onClick='editService("+service.service_id+")' >Edit/View</button>&emsp;";
                if($.cookie("userrole")=="viewer"){
                  deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
                }else{
                  deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' >Delete</button>";
                }
              }
              if($.cookie("userrole")=="admin"){
                deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
              }
              if(i==0){                                
                $("#serviceList").html("<tr>"
                  +"<td>"+service.machineNo+"</td>"
                  +"<td>"+service.machineName+"</td>"
                  +"<td>"+service.customer+"</td>"
                  +"<td>"+service.service_date+"</td>"
                  +"<td>"+service.reported_date+"</td>"
                  +"<td>"+service.closed_date+"</td>"
                  +"<td>"+service.working_hrs+"</td>"
                  +"<td>"+service.engineer+"</td>"
                  +"<td>"+service.repetitive+"</td>"
                  +"<td>"+service.down_hrs+"</td>"
                  +"<td>"+service.cost+"</td>"
                  +"<td>"+service.error_code+"</td>"
                  +"<td>"+service.error_description+"</td>"
                  +"<td>"+service.action+"</td>"
                  +"<td>"+service.root_cause+"</td>"
                  +"<td>"+service.status+"</td>"
                  +"<td>"+service.remarks+"</td>"
                  +"<td>"+service.spare_part_replace+"</td>"
                  +"<td><a href='#' class='btn-info btn' onClick='getPhotos(" + service.service_id + ")' id='" + service.service_id + "' operation='vphoto'>View Photo</a></td>"
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
              }else{
                $("#serviceList").append("<tr>"
                  +"<td>"+service.machineNo+"</td>"
                  +"<td>"+service.machineName+"</td>"
                  +"<td>"+service.customer+"</td>"
                  +"<td>"+service.service_date+"</td>"
                  +"<td>"+service.reported_date+"</td>"
                  +"<td>"+service.closed_date+"</td>"
                  +"<td>"+service.working_hrs+"</td>"
                  +"<td>"+service.engineer+"</td>"
                  +"<td>"+service.repetitive+"</td>"
                  +"<td>"+service.down_hrs+"</td>"
                  +"<td>"+service.cost+"</td>"
                  +"<td>"+service.error_code+"</td>"
                  +"<td>"+service.error_description+"</td>"
                  +"<td>"+service.action+"</td>"
                  +"<td>"+service.root_cause+"</td>"
                  +"<td>"+service.status+"</td>"
                  +"<td>"+service.remarks+"</td>"
                  +"<td>"+service.spare_part_replace+"</td>" 
                  +"<td><a href='#' class='btn-info btn' onClick='getPhotos(" + service.service_id + ")' id='" + service.service_id + "' operation='vphoto'>View Photo</a></td>"
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
                  return column === 5 ? data.replace( /[$,]/g, '' ):data;
                }
              }
            }
          };
          $('#myTable').DataTable({
            dom: 'Bfrtip',
              buttons: [
                  $.extend( true, {}, buttonCommon, {
                      extend: 'excelHtml5',title:"Service List",
                      exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]}
                  })
              ],"columnDefs": [
                {
                  "targets": [1,3,5,6,7,8,9,10,13,14,16,17],
                  "visible": false                
                }
              ]
          });
        },error:function(){

        }});
    }


    function getServiceHistory(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllServices":"getAllServices"},
        url:"../php/sh.php",
        success:function(data){         
          console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,service){
             
              var editBtn = "";
              var deleteBtn = "";

                  
              if($.cookie("status")=="Offline"){                      
                editBtn = "<button class='btn btn-warning'  onClick='editService("+service.service_id+")' disabled>Edit/View</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
              }else{
                editBtn = "<button class='btn btn-warning'  onClick='editService("+service.service_id+")' >Edit/View</button>&emsp;";
                if($.cookie("userrole")=="viewer"){
                  deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
                }else{
                  deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' >Delete</button>";
                }
              }
              if($.cookie("userrole")=="admin"){
                deleteBtn = "<button class='btn btn-danger' onClick='deleteService("+service.service_id+")' id='"+service.service_id+"' disabled>Delete</button>";
              }
              if(i==0){
                $("#serviceList").html("<tr>"
                  +"<td>"+service.machine_id+"</td>"                  
                  +"<td>"+service.error_description+"</td>"
                  +"<td>"+service.action+"</td>" 
                  +"<td>"+service.reported_date+"</td>"
                  +"<td><a href='#' class='btn-info btn' onClick='getPhotos(" + service.service_id + ")' id='" + service.machine_id + "' operation='vphoto'>View Photo</a></td>"
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
              }else{
                $("#serviceList").append("<tr>"
                  +"<td>"+service.machine_id+"</td>"                  
                  +"<td>"+service.error_description+"</td>"
                  +"<td>"+service.action+"</td>" 
                  +"<td>"+service.reported_date+"</td>" 
                  +"<td><a href='#' class='btn-info btn' onClick='getPhotos(" + service.service_id + ")' id='" + service.machine_id + "' operation='vphoto'>View Photo</a></td>"                 
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
                      extend: 'excelHtml5',title:"Customers List",exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"Customers List",exportOptions:{columns:[0,1,2,3,4]}
                  } )
              ]
          });
          $(".loader").hide();
          $(".page").show();
      }});
    }

    function editService(id){
      location.href="editSh.php?id="+id;
    }    

    function deleteService(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"serviceId":id,"deleteService":"deleteService"},
          url:"../php/sh.php",
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

    function getPhotos(id){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"serviceId":id,"getServicePhotos":"getServicePhotos"},
        url:"../php/sh.php",
        success:function(data){         
          console.log(data);
          //service_photo_id, service, url
          if(JSON.parse(data).length>0){
            var li = "";
            var image ="";
            $.each(JSON.parse(data),function(i,servicePhoto){
              if(i==0){
                li += "<li data-target='#lightbox' data-slide-to='"+i+"' class='active'></li>";
              image+="<div class='item active'>"
              +"<img name='' src='http://www.igmrobotics.com/"+servicePhoto.url+"'>"
              +"<div class='carousel-caption'>"
              //+"<button onClick='download(\"http://www.igmrobotics.com/"+servicePhoto.url+"\",\"Service"+servicePhoto.service_photo_id+"\")'>download</button>"
              +"<a href='http://www.igmrobotics.com/"+servicePhoto.url+"' download='Service"+servicePhoto.service_photo_id+"'>Download</a>"
              "</div>"
              +"</div>";
              }else{
                  li += "<li data-target='#lightbox' data-slide-to='"+i+"'></li>";
              image+="<div class='item'>"
              +"<img src='http://www.igmrobotics.com/"+servicePhoto.url+"'>"
              +"<div class='carousel-caption'>"
              //+"<button onClick='download(\"http://www.igmrobotics.com/"+servicePhoto.url+"\",\"Service"+servicePhoto.service_photo_id+"\")'>download</button>"
              +"<a href='http://www.igmrobotics.com/"+servicePhoto.url+"' download='Service"+servicePhoto.service_photo_id+"'>Download</a>"
              "</div>"
              +"</div>";
              }

              //$("#").append("");              
            });
           $("#listPhotos").html("<div class='carousel slide' id='MyCarousel'>"
            +"<ol class='carousel-indicators'>"
            +li
            +"</ol>"
            +"<div class='carousel-inner'>"
            +image
            +"</div>"
            +"</div>"
            +"<a class='left carousel-control' href='#lightbox' role='button' data-slide='prev'>"
            +"<span class='glyphicon glyphicon-chevron-left'></span>"
            +"</a>"
            +"<a class='right carousel-control' href='#lightbox' role='button' data-slide='next'>"
            +"<span class='glyphicon glyphicon-chevron-right'></span>"
            +"</a>");
            $("#MyCarousel").carousel();
            $('#MyCarousel').bind('slide.bs.carousel', function (e) {});
            $('#MyCarousel').bind('slid', function (e) {});
            $("#myModal").modal(); 
          }else{
            alert("No related photos");
          }
      }});
    }

    function download(url,name) {
      var a = document.createElement("a");
      a.href = url;
      a.download = name;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }

    function getMachines(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllMachine":"getAllMachine"},
        url:"../php/machine.php",
        success:function(data){         
          machineData=data;
          
      }});
    }

    function getUsers(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"viewAll":"viewAll"},
        url:"../php/customer.php",
        success:function(data){          
          if(JSON.parse(data).length>0){
            customerData=data;
          }                           
        }
      });
    }

    function getParts() {
      $.ajax({
        method: "POST",
        type: "json",
        data: { "getAllInventory": "getAllInventory" },
        url: "../php/inventory.php",
        success: function (data) {        
          partsData = data;
        }
      });
    }

    function addPart() {
      var element = "";
      element = "<tr>"               
        + "<td>"
        + "<select class='form-control part' name='partNo" + partIndex + "' id=" + partIndex + "><option value='default'>Select part</option></select>"
        + "</td>"        
        +"<td>"
        + "<textarea class='form-control' name='serialNo" + partIndex + "'></textarea>"
        + "</td>"
        + "<td>"
        + "<button type='button' class='btn btn-sm btn-warning removepart' id=" + partIndex + ">-</button>"
        + "</td>"
        + "</tr>";
      $("#replaceParts").append(element);
      $.each(JSON.parse(partsData), function (i, part) {
        $("select[name='partNo" + partIndex + "']").append("<option value='" + part.id + "-" + part.partno + "'>" + part.partno + "</option>");
      });      
    }


  </script>
</body>
</html>
