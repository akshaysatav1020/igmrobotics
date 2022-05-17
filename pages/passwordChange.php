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
        <div class="col-md-2">
          <a href="adminhome.php"><img src="../images/logo.png" alt="igm-logo" class="img-responsive"></a>
        </div>
        <div class="col-md-9">
            <!-- <h1>Inventory Control System</h1> -->
        </div>
      </div>
      <div class="row">
        <main>
          <form class="form" method="POST" action="passwordChange.php">
            <div class="col-md-6">
              <div class="from-group">
                <label>User Id</label>
                <input class="form-control" name="user_id" value="<?php echo $_COOKIE["userId"];?>" readonly></input>
              </div>
            </div>
            <div class="col-md-6">
              <div class="from-group">
                <label>Old Password</label>
                <input class="form-control" name="old_password" type="password"></input>
              </div>
            </div> 
            <div class="col-md-6">
              <div class="from-group">
                <label>New  Password</label>
                <input class="form-control" name="new_password" type="password"></input>
              </div>
            </div>
            <div class="col-md-6">
              <div class="from-group">
                <label>Confirm Password</label>
                <input class="form-control" name="confirm_password" type="password"></input>
              </div>
            </div>
            <div class="col-md-6">
              <div class="from-group">
                <button class="btn btn-sm btn-warning" name="updatepassword">Update</button>
                <button class="btn btn-sm btn-default">Cancel</button>
              </div>
            </div> 
          </form>
        </main>
      </div>
    </div>
    <?php include("footer.php");?>
    <?php
      if($_POST!=null){
        if(isset($_POST["updatepassword"])){          
          if($_POST["new_password"]==$_POST["confirm_password"]){
            $dbPassword="";
            $query="SELECT * FROM user WHERE id=".$_COOKIE["userId"]."";
            $result = $connection->query($query);
            $data = array();
            if($result->num_rows>0){
              while($row=$result->fetch_assoc()){
                $dbPassword=$row['password'];
              }
            }
            if($dbPassword==$_POST["old_password"]){
              $query = "UPDATE user SET password=? WHERE id=?";
              $stmt = $connection->prepare($query);
              $stmt->bind_param("si", $password,$id);
              $password = $_POST["confirm_password"];
              $id = $_COOKIE["userId"];              
              if($stmt->execute()){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Password Updated');
                  window.location.href='passwordChange.php';
                  </SCRIPT>");
              }else{
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error updating password');
                  window.location.href='passwordChange.php';
                  </SCRIPT>");
              }
            }else{
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('You have entered Incorrect old password');
              window.location.href='passwordChange.php';
              </SCRIPT>");
            }
          }else{
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Password Confirm  password should not match');
              window.location.href='passwordChange.php';
              </SCRIPT>");
          }
        }
      }
    ?>
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
        $(".loader").hide();
        $(".page").show();
      });
    })();
    
  </script>
</body>
</html>
