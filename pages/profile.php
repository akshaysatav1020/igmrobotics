<!DOCTYPE html>
<html>
  <head>
    <meta name="charset" content="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Control System</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/custom.css">
    <style media="screen">
    </style>
  </head>
  <body>
      <?php include "menu.php";?>
    <div class="container-fluid" >
      <div class="row">
        <form class="" action="../php/register.php" method="post">
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyname">Name</label>
              <input type="text" class="form-control" name="name" readonly="readonly"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="role">Role</label>
              <input class="form-control" name="role" readonly="readonly"/>               
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyaddress">Address</label>
              <textarea class="form-control" name="address" required="required" readonly="readonly"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="contactp">Contact Primary</label>
              <input type="text" name="con1" class="form-control number" readonly="readonly"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="contacts">Contact Secondary</label>
              <input type="text" name="con2" class="form-control number" readonly="readonly"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="emailp">Email</label>
              <input type="email" name="email" class="form-control" readonly="readonly"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="uname" class="form-control" readonly="readonly"/>
            </div>
          </div>
          <!-- <div class="col-md-4">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" readonly="readonly"/>
            </div>
          </div>           -->
          <!-- <div class="col-md-4" style="padding:2%;">
            <button class="btn btn-success" type="submit" name="register">Update</button>
            <button class="btn btn-default" type="reset" name="cancel">Cancel</button>
          </div> -->
        </form>
      </div>
    </div>
    <?php include("footer.php");?>
    <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
    <script type="text/javascript">
        (function(){
          $(window).bind("load", function() {
          checkNetworkStatus();
          userRole();
        });
          $(document).ready(function(){
            if($.cookie("userrole")=="superadmin"){
              $("input[name='name']").val("Prabu Mani");
              $("textarea[name='address']").val("NA");
              $("input[name='email']").val($.cookie("usermail"));
              $("input[name='con1']").val("NA");
              $("input[name='con2']").val("NA");
              $("input[name='role']").val("Super Admin");
              $("input[name='uname']").val($.cookie("userrole"));
            }else{
              getUser();
            }
          });
        })();
        function getUser(){
          $.ajax({
    				method:"POST",
    				type:"json",
    				data:{"userId":$.cookie("userId"),"viewUser":"getUser"},
    				url:"../php/register.php",
    				success:function(data){
              console.log(data);
              if(data!=""){
                var customer = JSON.parse(data);
                  $("input[name='name']").val(customer.name);
                  $("textarea[name='address']").val(customer.address);
                  $("input[name='email']").val(customer.email);
                  $("input[name='con1']").val(customer.contact1);
                  $("input[name='con2']").val(customer.contact2);
                  $("input[name='role']").val(customer.role);
                  $("input[name='uname']").val(customer.uname);
              }
    			  }});
        }
    </script>
  </body>
</html>
