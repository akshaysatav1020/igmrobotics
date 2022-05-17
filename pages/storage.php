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
          <label for="tab1">Upload File</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View Files</label>
          <section id="content1">
            <!-- <form class="" action="http://www.igmrobotics.com/php/storage.php" method="post" enctype="multipart/form-data"> -->
              <form class="" action="../php/storage.php" method="post" enctype="multipart/form-data">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Select File</label>
                  <input type="file" class="form-control" name="storageFile" accept="application/zip"/>
                </div>
              </div>
              <div class="col-md-6" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="addFile">Upload File</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody id="fileList">
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

  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
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
      console.log(location.href);
      $(".loader").show();
      $(".page").hide();
      $(window).bind("load", function() {
        //
        if($.cookie("status")=="Offline"){
          $("button[name='addCustomer']").attr("disabled", "disabled");
        }else{
          //checkDataStatus();
        }
      });
      $(document).ready(function(){
        checkNetworkStatus();
        getStorage();
        $("form").submit(function(event){
        //event.preventDefault();
        
        var formData = $(this).serializeArray();
        
        $(this).append("<input type='hidden' name='urlLink' value='"+location.href+"'/>");
      });
      });
    })();
    function getStorage(){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"fileList":"fileList"},
				url:"../php/storage.php",
				success:function(data){					
          console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,file){
              //alert(customer.company);
              var editBtn = "";
              var deleteBtn = "";

                  
              if($.cookie("status")=="Offline"){                      
                editBtn = "<button class='btn btn-sm btn-warning' id='"+file+"' disabled>Download</button>&emsp;";
                deleteBtn = "<button class='btn btn-sm btn-danger' onClick='deleteStorage(\""+file+"\")' id='"+file+"' disabled>Delete</button>";
              }else{
                editBtn = "<button class='btn btn-sm btn-warning' id='"+file+"' >Download</button>&emsp;";
                deleteBtn = "<button class='btn btn-sm btn-danger' onClick='deleteStorage(\""+file+"\")' id='"+file+"' >Delete</button>";
              }
              if($.cookie("userrole")=="admin"){
                deleteBtn = "<button class='btn btn-sm btn-danger' onClick='deleteStorage(\""+file+"\")' id='"+file+"' disabled>Delete</button>";
              }
              if(i!=0||i!=1){
                if(i==2){
                  $("#fileList").html("<tr>"
                    +"<td><a href='http://www.igmrobotics.com/storage/"+file+"' target='_blank' download>"+file+"</a></td>"
                    +"<td>"                    
                    +deleteBtn
                    +"</td>"
                  +"</tr>");
                }else{
                  $("#fileList").append("<tr>"
                    +"<td><a href='http://www.igmrobotics.com/storage/"+file+"' target='_blank' download>"+file+"</a></td>"
                    +"<td>"                    
                    +deleteBtn
                    +"</td>"
                  +"</tr>");
                }
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

    function deleteStorage(file){
      var c = confirm("Do you really want to delete "+file+"?");
      //alert(c);
      if(c){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"fileName":file,"deleteStorage":"deleteStorage"},
  				url:"../php/storage.php",
  				success:function(data){
            console.log(data);
            if(data=="deleted"){
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
  </script>
</body>
</html>
