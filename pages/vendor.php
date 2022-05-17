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
          <label for="tab1">Add Vendor</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View List</label>
          <section id="content1">            
            <form class="" action="../php/vendor.php" method="post">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Vendor No.</label>
                  <input type="text" class="form-control" name="vno" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyname">Company Name</label>
                  <input type="text" class="form-control" maxlength="200" name="companyname" value="" placeholder="Enter name"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyaddress">Address Line 1</label>
                  <input class="form-control" name="addressline1" placeholder="Address Line1"/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyaddress">Address Line2</label>
                  <input class="form-control" name="addressline2" placeholder="Address Line2" />
                </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="companyaddress">City-Postcode</label>
                    <input class="form-control" name="city" placeholder="City-Postcode" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="companyaddress">Country</label>
                    <input class="form-control" name="country" placeholder="Country"/>
                  </div>
                </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="lastname">Contact Person1</label>
                  <input type="text" class="form-control" maxlength="200" name="contactper1" value="" placeholder="Enter name for person" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="lastname">Contact Person2</label>
                  <input type="text" class="form-control" maxlength="200" name="contactper2" value="" placeholder="Enter name for person" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contactp">Contact Primary</label>
                  <input type="text" class="form-control number" name="contactpri" value="" placeholder="Enter Contact Primary" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contacts">Contact Secondary</label>
                  <input type="text" class="form-control number" name="contactsec" value="" placeholder="Enter Contact Secondary" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="emailp">Email Primary</label>
                  <input type="email" class="form-control" maxlength="200" name="emailpri" value="" placeholder="Email Primary" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="emails">Email Secondary</label>
                  <input type="email" class="form-control" maxlength="200" name="emailsec" value="" placeholder="Email Secondary" />
                </div>
              </div>
              <div class="col-md-6" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="addVendor">Add Vendor</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th rowspan="1" colspan="1">Company</th>
                    <th rowspan="1" colspan="1">ContactPerson(Pri.)</th>
                    <th rowspan="1" colspan="1">Contact(Pri.)</th>
                    <th rowspan="1" colspan="1">ContactPerson(Sec.)</th>
                    <th rowspan="1" colspan="1">Contact(Sec.)</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">Company</th>
                    <th rowspan="1" colspan="1">ContactPerson(Pri.)</th>
                    <th rowspan="1" colspan="1">Contact(Pri.)</th>
                    <th rowspan="1" colspan="1">ContactPerson(Sec.)</th>
                    <th rowspan="1" colspan="1">Contact(Sec.)</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <!-- <tbody id="customerList"> -->
                <tbody>
                <?php
                      $query="SELECT * FROM vendors";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["company_name"]."</td>";
                          echo "<td>".$row["contact_person1_name"]."</td>";
                          echo "<td>".$row["contact_person1_number"]."</td>";
                          echo "<td>".$row["contact_person2_name"]."</td>";
                          echo "<td>".$row["contact_person2_number"]."</td>";
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){                            
                            echo "<button class='btn btn-sm btn-warning' onclick='editVendor(".$row["id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteVendor(".$row["id"].")'>Delete</button></td>";
                          }else{                                                    
                            echo "<button class='btn btn-sm btn-warning' onclick='editVendor(".$row["id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteVendor(".$row["id"].")'disabled>Delete</button></td>";
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
<!-- https://finance.google.com/finance/converter?a=100&from=USD&to=INR -->
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
        <h4 class="modal-title">Edit/View Vendor</h4>
      </div>
      <div class="modal-body">
        <form class="editForm" action="../php/vendor.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="custid">Vendor Id</label>
              <input type="text" class="form-control" name="vendorId" readonly="readonly" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Vendor No.</label>
              <input type="text" class="form-control" name="evno" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Company Name</label>
              <input type="text" class="form-control" name="ecompanyname" />
            </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Address Line 1</label>
                <input class="form-control" name="eaddressline1" placeholder="Address Line1" />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="companyaddress">Address Line2</label>
                <input class="form-control" name="eaddressline2" placeholder="Address Line2" />
              </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="companyaddress">City-Postcode</label>
                  <input class="form-control" name="ecity" placeholder="City-Postcode" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="companyaddress">Country</label>
                  <input class="form-control" name="ecountry" placeholder="Country" />
                </div>
              </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Contact Person1</label>
              <input type="text" class="form-control" name="econtactper1"  />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Contact Person2</label>
              <input type="text" class="form-control" name="econtactper2"  />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="contactp">Contact Primary</label>
              <input type="text" class="form-control number" name="econtactpri" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="contacts">Contact Secondary</label>
              <input type="text" class="form-control number" name="econtactsec" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="emailp">Email Primary</label>
              <input type="email" class="form-control" name="eemailpri" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="emails">Email Secondary</label>
              <input type="email" class="form-control" name="eemailsec" />
            </div>
          </div>
          <div class="col-md-6" style="padding:2%;">
            <button class="btn btn-warning" type="submit" name="editVendor">Update Customer</button>
            <button class="btn btn-default" data-dismiss="modal" type="button" name="close">Cancel</button>
          </div>
        </form>
      </div>
      <div class="modal-footer" >
        <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button> -->
      </div>
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
          checkNetworkStatus();
          getVendorNo();
          if($.cookie("status")=="Offline"){                      
            $("button[name='addVendor']").attr("disabled","disabled");
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
                      extend: 'copyHtml5',exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'excelHtml5',title:"Vendors List",exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"Vendors List",exportOptions:{columns:[0,1,2,3,4]}
                  } )
              ]
          });
          $(".loader").hide();
         $(".page").show();

      });
    })();
    

    function editVendor(id){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"vendorId":id,"viewVendor":"getVendors"},
				url:"../php/vendor.php",
				success:function(data){
            console.log(data);
          if(JSON.parse(data).length>0 && JSON.parse(data).length==1){
            $.each(JSON.parse(data), function(i, customer){
              //companyname companyaddress contactper1 contactper2 contactpri contactsec emailpri emailsec editCustomer
              $("input[name='vendorId']").val(customer.id);
              $("input[name='evno']").val(customer.vno);
              $("input[name='ecompanyname']").val(customer.company);
              $("input[name='eaddressline2']").val(customer.addressline2);
              $("input[name='eaddressline1']").val(customer.addressline1);
              $("input[name='ecity']").val(customer.city);
              $("input[name='ecountry']").val(customer.country);
              $("input[name='econtactper1']").val(customer.person1);
              $("input[name='econtactper2']").val(customer.person2);
              $("input[name='econtactpri']").val(customer.no1);
              $("input[name='econtactsec']").val(customer.no2);
              $("input[name='eemailpri']").val(customer.email1);
              $("input[name='eemailsec']").val(customer.email2);
            });
          }
          $("#myModal").modal();
			  }});
    }

    function deleteVendor(id){
      var c = confirm("Do you really want to delete "+id+"?");
      //alert(c);
      if(c){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"vendorId":id,"deleteVendor":"deleteCustomers"},
  				url:"../php/vendor.php",
  				success:function(data){
            console.log(data);
            if(data=="Deleted"){
              location.reload();
            }else{
              alert("Unable to delete Contact Admin");
            }
          },error: function(error){
            alert("Unable to delete Contact Admin");
          }});
      }
    }

    function getVendorNo(){      
        $.ajax({
          method:"POST",
          type:"json",
          data:{"getVendorNo":"getVendorNo"},
          url:"../php/vendor.php",
          success:function(data){
            //console.log(data);
            if(data<10){
              $("input[name='vno']").val("00"+data);
            }else if(data<100){
              $("input[name='vno']").val("0"+data);
            }else if(data>=100){
              $("input[name='vno']").val(data);
            }
            
          },error: function(error){
            
          }});      
    }
  </script>
</body>
</html>
