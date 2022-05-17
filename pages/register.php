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
  <link href="../css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <style media="screen">
    textarea.form-control{
      height:34px;
    }
  main {
    min-width: 320px;
    max-width: 100%;
    padding: 50px;
    margin: 0 auto;
    background: #fff;
  }

  input[type=radio]{
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
<?php include "menu.php";?>  
<div class="container-fluid">
    <div class="row">
      <main>
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">Add User</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">View Users</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3">User Status</label>
        <section id="content1">
            <form id="addUser" action="../php/register.php" method="POST">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="companyname">Name</label>
                  <input type="text" class="form-control" maxlength="200" name="name" placeholder="Enter name" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" name="role" required="required">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="spares">Spares</option>
                    <option value="viewer">Viewer</option>
                    <option value="service">Service</option>
                    <option value="finance">Finance</option>
                    <option value="engineer">Engineer</option>                    
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="companyaddress">Address</label>
                  <textarea class="form-control" name="address" required="required"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contactp">Contact Primary</label>
                  <input type="text" class="form-control number" name="contactpri" placeholder="Enter Contact Primary" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contacts">Contact Secondary</label>
                  <input type="text" class="form-control number" name="contactsec" placeholder="Enter Contact Secondary" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="emailp">Email</label>
                  <input type="email" class="form-control" maxlength="200" name="email" placeholder="Email Primary" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" maxlength="200" name="username" placeholder="Enter username" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" maxlength="200" name="password" placeholder="Enter password" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="confpassword">Re-enter Password</label>
                  <input type="password" class="form-control" maxlength="200" name="confpassword" placeholder="Re-type password" required="required"/>
                </div>
              </div>
              <div class="col-md-4" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="register">Add User</button>
                <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
              </div>
            </form>
        </section>
        <section id="content2">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed" id="myTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Role</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Role</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <!-- <tbody id="userList"> -->
              <tbody>
                <?php
                      $query="SELECT * FROM user";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["name"]."</td>";
                          echo "<td>".$row["email"]."</td>";
                          echo "<td>".$row["contact1"]."</td>";
                          echo "<td>".$row["role"]."</td>";
                          echo "<td>".$row["address"]."</td>";
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"&&$_COOKIE["userrole"]=="superadmin"){                            
                            echo "<button class='btn btn-sm btn-warning' onclick='editUser(".$row["id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteUser(".$row["id"].")'>Delete</button></td>";
                          }else{                                                    
                            echo "<button class='btn btn-sm btn-warning' onclick='editUser(".$row["id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteUser(".$row["id"].")'disabled>Delete</button></td>";
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
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed" id="myTable1">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Active Status</th>
                  <th>Approve Status</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Active Status</th>
                  <th>Approve Status</th>
                </tr>
              </tfoot>
              <!-- <tbody id="statusList"> -->
                <tbody>
                <?php
                      $query="SELECT * FROM user";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["name"]."</td>";                          
                          if($row["active"]=="1"){                            
                            echo "<td><button class='btn btn-sm btn-success' onclick='activate(".$row["id"].",0)'>Active</button></td>";
                          }else{
                            echo "<td><button class='btn btn-sm btn-danger' onclick='activate(".$row["id"].",1)'>Inactive</button></td>";
                          }
                          if($row["approved"]=="1"){                            
                            echo "<td><button class='btn btn-sm btn-success' onclick='approve(".$row["id"].",0)'>Approved</button></td>";
                          }else{                            
                            echo "<td><button class='btn btn-sm btn-danger' onclick='approve(".$row["id"].",1)'>Not Approved</button></td>";
                          }                          
                          echo "</tr>";
                        }
                      }                                     
                    ?>
              </tbody>
              </tbody>
            </table>
          </div>
        </section>
      </main>
    </div>
  </div>
  <?php include("footer.php");?>
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
        <h4 class="modal-title">Edit/View User</h4>
      </div>
      <div class="modal-body">
        <form class="" action="../php/register.php" method="post">
              <div class="col-md-4" style="display: none;">
                <div class="form-group" >
                  <label for="companyname">Id</label>
                  <input type="text" class="form-control" name="eid" placeholder="Enter name" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="companyname">Name</label>
                  <input type="text" class="form-control" name="ename" placeholder="Enter name" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" name="erole" required="required">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="spares">Spares</option>
                    <option value="viewer">Viewer</option>
                    <option value="service">Service</option>
                    <option value="finance">Finance</option>
                    <option value="engineer">Engineer</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contactp">Contact Primary</label>
                  <input type="text" class="form-control number" name="econtactpri" placeholder="Enter Contact Primary" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contacts">Contact Secondary</label>
                  <input type="text" class="form-control number" name="econtactsec" placeholder="Enter Contact Secondary" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="companyaddress">Address</label>
                  <textarea class="form-control" name="eaddress" required="required"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="emailp">Email</label>
                  <input type="email" class="form-control" name="eemail" placeholder="Email Primary" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="eusername" placeholder="Enter username" readonly="readonly" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="epassword" placeholder="Enter password" required="required"/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="confpassword">Confirm</label>
                  <input type="password" class="form-control" name="econfpassword" placeholder="Enter confirm password" required="required"/>
                </div>
              </div>
              <div class="col-md-4" style="padding:2%;">
                <button class="btn btn-warning" type="submit" name="editUser">Update User</button>
                <button class="btn btn-default" type="button" data-dismiss="modal" name="cancel">Cancel</button>
              </div>
            </form>
      </div>
      <div class="modal-footer" >
      </div>
    </div>
  </div>
  </div>
  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/select2.min.js"></script>
  <script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
  <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
  <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
  <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
  <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
    $("header,.container-fluid,footer").hide();
    $(".loader").show();
    var dU = dE = false;
    $(window).bind("load", function() {
      checkNetworkStatus();
      $("select[name='role'],select[name='erole']").select2({"width":"100%"});
      if($.cookie("status")=="Offline"){                      
        $("button[name='register']").attr("disabled","disabled");
      }
    });
    $(document).ready(function(){
      //getUsers();
      if($.cookie("userrole")=="service"||$.cookie("userrole")=="engineer"){
        $("select[name='role']").html("");
        $("select[name='role']").append("<option value=''>Select Role</option>");
        $("select[name='role']").append("<option value='service'>Service</option>");        
        $("select[name='role']").append("<option value='engineer'>Engineer</option>");        
        $("input[id='tab3'],label[for='tab3']").hide();
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
                      extend: 'copyHtml5',title:"User List",exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'excelHtml5',title:"User List",exportOptions:{columns:[0,1,2,3,4]}
                  } ),
                  $.extend( true, {}, buttonCommon, {
                      extend: 'pdfHtml5',title:"User List",exportOptions:{columns:[0,1,2,3,4]}
                  } )
              ]
          });
          var buttonCommon1 = {
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
          $('#myTable1').DataTable({
            dom: 'Bfrtip',
              buttons: [
                  $.extend( true, {}, buttonCommon1, {
                      extend: 'copyHtml5',exportOptions:{columns:[0,1]}
                  } ),
                  $.extend( true, {}, buttonCommon1, {
                      extend: 'excelHtml5',title:"User Status List",exportOptions:{columns:[0,1]}
                  } ),
                  $.extend( true, {}, buttonCommon1, {
                      extend: 'pdfHtml5',title:"User Status List",exportOptions:{columns:[0,1]}
                  } )
              ]
          });
          $("header,.container-fluid,footer").show();
          $(".loader").hide();
    });
    $("form#addUser").submit(function(event){
      
    });
    function emailCheck(email){
      $.ajax({
        method:"POST",
        type:"json",
				data:{"email":email,"checkEmail":"checkEmail"},
				url:"../php/register.php",
        success:function(data){
          if(data=="NotExist"){
            dE = true;
          }else{
            dE = false;
          }
        },error:function(error){
          dE = false;
        }
      });
      return dE;
    }
    function checkUsername(username){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"username":username, "checkUsername":"checkUsername"},
        url:"../php/register.php",
        success:function(data){
          if(data=="NotExist"){
            dU = true;
          }else{
            dU = false;
          }
        },error:function(error){
          dU = false;
        }
      });
      return dU;
    }
    function passwordCheck(){
      var password = $("input[name='password']").val();
      var confirm = $("input[name='confpassword']").val();
      if(password!=confirm){
        return false;
      }else{
        return true;
      }
    }
    function checkProperEmail(){
      var ex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      var email = $("input[type='email']").val();
      if(! ex.test(email)) {
        //alert("Enter proper mail!!");
        return false;
      }else{
        return true;
      }
    }
    function getUsers(){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"viewAll":"getAllUsers"},
				url:"../php/register.php",
				success:function(data){
					//console.log(data);
          if(JSON.parse(data).length>0){
            $.each(JSON.parse(data),function(i,customer){
              //alert(customer.company);
              var editBtn = "";
              var deleteBtn = "";
              if($.cookie("status")=="Offline"){
                editBtn = "<button class='btn btn-warning' onclick='editUser("+customer.id+")'id='"+customer.id+"' disabled>Edit/View User</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteUser("+customer.id+")' id='"+customer.id+"' disabled>Delete User</button>";
              }else{                
                 editBtn = "<button class='btn btn-warning' onclick='editUser("+customer.id+")'id='"+customer.id+"'>Edit/View User</button>&emsp;";
                deleteBtn = "<button class='btn btn-danger' onClick='deleteUser("+customer.id+")' id='"+customer.id+"'>Delete User</button>";
              }
              if(i==0){
                $("#userList").html("<tr>"
                  +"<td>"+customer.name+"</td>"
                  +"<td>"+customer.email+"</td>"
                  +"<td>"+customer.contact1+"</td>"
                  +"<td>"+customer.role+"</td>"
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
                var actBtn = "";
                var appBtn = "";
                if(customer.active!=0){
                  if($.cookie("status")=="Offline"){
                    actBtn = "<button class='btn btn-sm btn-success' onClick='activate("+customer.id+",0)' disabled>Active</button>";
                  }else{
                    actBtn = "<button class='btn btn-sm btn-success' onClick='activate("+customer.id+",0)'>Active</button>";
                  }
                  
                }else{
                  if($.cookie("status")=="Offline"){
                    actBtn = "<button class='btn btn-sm btn-danger' onClick='activate("+customer.id+",1)' disabled>In Active</button>";
                  }else{
                    actBtn = "<button class='btn btn-sm btn-danger' onClick='activate("+customer.id+",1)'>In Active</button>";
                  }
                  
                }

                if(customer.approved!=0){
                  if($.cookie("status")=="Offline"){
                    appBtn = "<button class='btn btn-sm btn-success' onClick='approve("+customer.id+",0)' disabled>Approved</button>";
                  }else{
                    appBtn = "<button class='btn btn-sm btn-success' onClick='approve("+customer.id+",0)'>Approved</button>";
                  }
                  
                }else{
                  if($.cookie("status")=="Offline"){
                    appBtn = "<button class='btn btn-sm btn-danger' onClick='approve("+customer.id+",1)' disabled>Not Approved</button>";  
                  }else{
                    appBtn = "<button class='btn btn-sm btn-danger' onClick='approve("+customer.id+",1)'>Not Approved</button>";
                  }
                  
                }
                $("#statusList").html("<tr>"
                +"<td>"+customer.name+"</td>"
                +"<td>"+actBtn+"</td>"
                +"<td>"+appBtn+"</td>"
                +"</tr>");
              }else{
                $("#userList").append("<tr>"
                  +"<td>"+customer.name+"</td>"
                  +"<td>"+customer.email+"</td>"
                  +"<td>"+customer.contact1+"</td>"
                  +"<td>"+customer.role+"</td>"
                  +"<td>"
                  +editBtn
                  +deleteBtn
                  +"</td>"
                +"</tr>");
                var actBtn = "";
                var appBtn = "";
                if(customer.active!=0){
                  if($.cookie("status")=="Offline"){
                    actBtn = "<button class='btn btn-sm btn-success' onClick='activate("+customer.id+",0)' disabled>Active</button>";
                  }else{
                    actBtn = "<button class='btn btn-sm btn-success' onClick='activate("+customer.id+",0)'>Active</button>";
                  }
                  
                }else{
                  if($.cookie("status")=="Offline"){
                    actBtn = "<button class='btn btn-sm btn-danger' onClick='activate("+customer.id+",1)' disabled>In Active</button>";
                  }else{
                    actBtn = "<button class='btn btn-sm btn-danger' onClick='activate("+customer.id+",1)'>In Active</button>";
                  }
                  
                }

                if(customer.approved!=0){
                  if($.cookie("status")=="Offline"){
                    appBtn = "<button class='btn btn-sm btn-success' onClick='approve("+customer.id+",0)' disabled>Approved</button>";
                  }else{
                    appBtn = "<button class='btn btn-sm btn-success' onClick='approve("+customer.id+",0)'>Approved</button>";
                  }
                  
                }else{
                  if($.cookie("status")=="Offline"){
                    appBtn = "<button class='btn btn-sm btn-danger' onClick='approve("+customer.id+",1)' disabled>Not Approved</button>";  
                  }else{
                    appBtn = "<button class='btn btn-sm btn-danger' onClick='approve("+customer.id+",1)'>Not Approved</button>";
                  }
                  
                }
                $("#statusList").append("<tr>"
                +"<td>"+customer.name+"</td>"
                +"<td>"+actBtn+"</td>"
                +"<td>"+appBtn+"</td>"
                +"</tr>");
              }
            });
          }
          
			}});
    }

    function editUser(id){
      $.ajax({
				method:"POST",
				type:"json",
				data:{"userId":id,"viewUser":"getUser"},
				url:"../php/register.php",
				success:function(data){
            console.log(data);
          if(data!=""){
              var user=JSON.parse(data);                          
              $("input[name='eid']").val(user.id);
              $("input[name='ename']").val(user.name);
              $("textarea[name='eaddress']").val(user.address);
              $("select[name='erole']").val([user.role]).trigger("change");
              $("input[name='econtactpri']").val(user.contact1);
              $("input[name='econtactsec']").val(user.contact2);
              $("input[name='eemail']").val(user.email);
              $("input[name='eusername']").val(user.uname);
              $("input[name='epassword']").val(user.password);
              $("input[name='econfpassword']").val(user.password);            
          }
              $("#myModal").modal();
			  }});
    }

    function deleteUser(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){
        $.ajax({
  				method:"POST",
  				type:"json",
  				data:{"userId":id,"deleteUser":"deleteUser"},
  				url:"../php/register.php",
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

    function approve(id, status){
      // alert(id+"-----"+status);
      var c = confirm("Do you really want to change status "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"id":id,"approve":"approve","status":status},
          url:"../php/register.php",
          success:function(data){
            console.log(data);
            if(data){
              alert("Status Changed");
              location.reload();
            }else{
              alert("Unable to update");
            }
          },error: function(error){
            alert("Unable to Update");
          }});
      }
    }

    function activate(id, status){
      // alert(id+"-----"+status);
      var c = confirm("Do you really want to change status "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"id":id,"activate":"activate","status":status},
          url:"../php/register.php",
          success:function(data){
            console.log(data);
            if(data){
              alert("Status Changed");
              location.reload();
            }else{
              alert("Unable to Update");
            }
          },error: function(error){
            alert("Unable to Update");
          }});
      }
    }
  </script>
</body>
</html>
