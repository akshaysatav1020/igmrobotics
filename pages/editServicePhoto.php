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
      	<div class="col-md-12">
            <div class="table-responsive">
             	<table class="table table-bordered table-striped table-condensed" id="myTable">
                	<thead>
                		<th>Photo</th>
                		<th>Action</th>
                	</thead>
                	<tfoot>
                		<th>Photo</th>
                		<th>Action</th>
                	</tfoot>
                	<tbody>
                		<?php
                      		$query="SELECT * FROM service_photo WHERE service=$_GET[id]";
                      		$result = $connection->query($query);                      
                      		if($result->num_rows>0){
		                        while($row=$result->fetch_assoc()){                        			                
                          			echo "<tr>";
                          			echo "<td><img src='http://www.igmrobotics.com/".$row["url"]."' class='img-responsive' style='height:50px;width:50px;'/></td>";                          
                          			echo "<td><button class='btn btn-sm btn-warning' onclick='editPhoto(".$row["service_photo_id"].")' >Edit</button>&emsp;";
                            		echo "<form action='../php/sh.php' method='post'>"
                            		."<input style='display:none;' name='servicePhotoId' value='".$row["service_photo_id"]."'/>"
                            		."<button class='btn btn-sm btn-danger' type='submit' name='removeServicePhotos'>Delete</button></form></td>";
                          			echo "</tr>";
                      			}
                  			}
                  		?>
                	</tbody>
           		</table>
           	</div>
       </div>
                    
          
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
        <div class="modal-body">
        	<form class="addForm" action="../php/sh.php" method="post" enctype="multipart/form-data">
	          <div class="col-md-3">
	            <div class="form-group">
	              <label>Id</label>              
	              <input type="text" name="servicePhotoId" class="form-control"  readonly/>
	            </div>
	          </div>                 
		        <div class="col-md-6">
		          <div class="form-group">
		            <label for="companyaddress">Select File</label>
		            <input class="form-control" type="file" name="photos[]" accept=".png, .jpg, .jpeg" multiple required />
		          </div>
		        </div>               
		        <div class="col-md-6" style="padding:2%;">
		            <button class="btn btn-success" type="submit" name="updateServicePhotos">Update</button>
		            <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
		        </div>
	        </form>
        </div>        
        <div class="modal-footer">
            
        </div>
    </div>
</div></div>

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
      
    (function(){
      $(".loader").show();
      $(".page").hide();
      
      $(document).ready(function(){
        checkNetworkStatus();
        $('#myTable').DataTable();
        $(".loader").hide();
      	$(".page").show();
      });
    })();

    function editPhoto(id){

    	$("input[name='servicePhotoId']").val(id);
    	$("#myModal").modal();
    }
    
    


  </script>
</body>
</html>
