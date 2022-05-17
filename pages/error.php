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
          <label for="tab1">Add Error Code</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View Error Code List</label>
          <input id="tab3" type="radio" name="tabs">
          <label for="tab3">Bulk Import Error Code List</label>
          <section id="content1">           
            <form class="" action="../php/errorCode.php" method="post">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Error Code</label>
                  <input type="text" class="form-control" name="errorCode" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Error Code Description</label>
                  <textarea class="form-control" name="errorCodeDescription"/></textarea>
                </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Error Code Action</label>
                <textarea class="form-control" name="errorCodeAction"/></textarea>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Root Cause</label>
                <textarea class="form-control" name="rootCause"/></textarea>
              </div>
            </div>
            
              <div class="col-md-6" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="addErrorCode">Add Error Code</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th rowspan="1" colspan="1">Error Code</th>                  
                    <th rowspan="1" colspan="1">Error Description</th>                          
                    <th rowspan="1" colspan="1">Action</th>
                    <th rowspan="1" colspan="1">Root Cause</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">Error Code</th>                  
                    <th rowspan="1" colspan="1">Error Description</th>
                    <th rowspan="1" colspan="1">Action</th>
                    <th rowspan="1" colspan="1">Root Cause</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <!-- <tbody id="errorCodeList"> -->
                <tbody>
                <?php
                      $query="SELECT * FROM error";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["error_code"]."</td>";
                          echo "<td>".$row["error_description"]."</td>";
                          echo "<td>".$row["action"]."</td>";
                          echo "<td>".$row["root_cause"]."</td>";
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"&&$_COOKIE["userrole"]!="engineer"){                            
                            echo "<button class='btn btn-sm btn-warning' onclick='editErrorCode(".$row["error_id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteErrorCode(".$row["error_id"].")'>Delete</button></td>";
                          }else{
                          echo "<button class='btn btn-sm btn-warning' onclick='editErrorCode(".$row["error_id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteErrorCode(".$row["error_id"].")'disabled>Delete</button></td>";
                          }
                          echo "</tr>";
                        }
                      }                                     
                    ?>              
                </tbody>                                                    
                        
              </table>
            </div>
          </section>
          <section id="content3">
            <form class="" action="../php/errorCode.php" method="post" enctype="multipart/form-data">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Select File</label>
                  <input type="file" class="form-control" name="codeList" accept="application/xls" />
                </div>
              </div>
              <div class="col-md-6" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="importErrorCode">Upload</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
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
        <h4 class="modal-title">Edit/View Error Code</h4>
      </div>
      <div class="modal-body">
        <form class="" action="../php/errorCode.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label>Id</label>
              <input type="text" class="form-control" name="eErrorCodeId" readonly/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Error Code</label>
              <input type="text" class="form-control" name="eErrorCode"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Error Code Description</label>
              <textarea class="form-control" name="eErrorCodeDescription"/></textarea>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Error Code Action</label>
              <textarea class="form-control" name="eErrorCodeAction"/></textarea>
            </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Root Cause</label>
                <textarea class="form-control" name="eRootCause"/></textarea>
              </div>
            </div>
        
          <div class="col-md-6" style="padding:2%;">
            <button class="btn btn-success" type="submit" name="editErrorCode">Update Error Code</button>
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
        //
        if($.cookie("status")=="Offline"){
          $("button[name='addCustomer']").attr("disabled", "disabled");
        }else{
          //checkDataStatus();
        }
      });
      $(document).ready(function(){
        checkNetworkStatus();
        //getErrorCode();
        if($.cookie("userrole")=="viewer"||$.cookie("userrole")=="finance"||$.cookie("userrole")=="engineer"){
          $("input[id='tab1'],label[for='tab1']").hide();
          $("input[id='tab3'],label[for='tab3']").hide();             
          $("input[id='tab2']").attr("checked","checked"); 
        }

        var buttonCommon = {
          exportOptions: {
            format: {
              body: function ( data, row, column, node ) {                              
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
                  extend: 'excelHtml5',title:"Errors List",exportOptions:{columns:[0,1,2,3]}
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'pdfHtml5',title:"Errors List",exportOptions:{columns:[0,1,2,3]}
              } )
          ],"columnDefs": [
            {
              "targets": [3],
              "visible": false                
            }
          ]
        });
        if($.cookie("userrole")=="engineer"){
          $('#myTable').DataTable().buttons(['.buttons-copy','.buttons-excel','.buttons-pdf']).disable();  
        }
        $(".loader").hide();
        $(".page").show();
      });
    })();
    

    function editErrorCode(id){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"errorCodeId":id,"getErrorCode":"getErrorCode"},
				url:"../php/errorCode.php",
				success:function(data){
          console.log(data);
          var error = JSON.parse(data);           
          $("input[name='eErrorCodeId']").val(error.error_id);
          $("input[name='eErrorCode']").val(error.error_code);
          $("textarea[name='eErrorCodeDescription']").val(error.error_description);              
          $("textarea[name='eErrorCodeAction']").val(error.action);
          $("textarea[name='eRootCause']").val(error.root_cause); 
          $("#myModal").modal();             
			  }});
    }

    function deleteErrorCode(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"errorCodeId":id,"deleteErrorCode":"deleteErrorCode"},
  				url:"../php/errorCode.php",
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
  </script>
</body>
</html>
