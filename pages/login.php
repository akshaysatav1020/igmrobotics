<?php
  //require_once("../php/constants.php");
  require_once("../status.php");
  $connected = @fsockopen(PING, 80);
  /*if($connected){
    setcookie('status',"Online",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
  }else{
    setcookie('status',"Offline",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
  }*/  
?>
<html>
<head>
  <meta name="charset" content="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Control System</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
</head>
<body>
  <header>
    <style type="text/css">

    </style>
  </header>
  <div class="container-fluid" >
    <div class="row">
      <div class="col-md-2">
        <a href="../index.php"><img src="../images/logo.png" alt="igm-logo" class="img-responsive"></a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3" style="border:1px solid gray; border-radius:5px;padding:2%; background-color:#f00;float: none;margin: 0 auto;">
        <h1 style="text-align:center;">Login</h1>
        <form class="form-horizontal" action="../php/login.php" method="post">
          <div class="form-group">
            <label for="username" >Username/Email</label>
            <input type="text" input="text" class="form-control" name="uname" value="" placeholder="Enter email/username" required="required" autofocus/>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="" placeholder="Enter password" required="required"/>
          </div>
          <div class="form-group">
            <a href="forgetpassword.html">Forgot password..</a>
          </div>
          <button type="submit" class="btn btn-md btn-success" name="login">Login</button>
          <button type="reset" class="btn btn-md btn-default" name="cancel">Cancel</button>
        </form>
      </div>
    </div>
  </div>
  <div style="text-align:center;bottom:0;width:25%; margin: 5%auto;left: 0;right: 0;"><?php include("footer.php");?></div>  
  <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
    (function(){
      $(window).bind("load", function() {
        //checkNetworkStatus();        
      });
      $(document).ready(function(){
        
        localStorage.clear();
       $("form").submit(function(event){
          event.preventDefault();
          var l = <?php 
            $ch = curl_init(); 
            $serversion = 0;
            curl_setopt($ch, CURLOPT_URL, "http://www.igmrobotics.com/config.xml");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if(curl_exec($ch) === FALSE) {
               echo "Error: " . curl_error($ch);
            } else {              
              $xml = simplexml_load_string(curl_exec($ch));
              $serversion = $xml->clientappversion;           
            }

            $localxml = simplexml_load_file("../data.xml");
            if(($serversion - $localxml->appversion)==0){
              echo "true";
            }else{
              echo "false";
            }
          ?>;
          //if(l){
            var uname = $("input[name='uname']").val();
          var password = $("input[name='password']").val();
          if(uname=="superadmin"){
            $.ajax({
              method:"POST",
              type:"json",
              data:{"password":password,"checkRootPass":"checkRootPass"},
              url:"../php/dataSettings.php",
              success:function(data){
                 console.log(data);
                /*if(data=="true"){    */              
                  $.cookie("userId", "1",{expires: 7, path: '/', domain: location.hostname});
                  $.cookie("usermail", "mani.prabu@igm-india.com",{expires: 7, path: '/', domain: location.hostname});
                  $.cookie("userrole", "superadmin",{expires: 7, path: '/', domain:location.hostname});
                  $.cookie("rack", "8",{expires: 7, path: '/', domain:location.hostname});
                  $.cookie("floor", "5",{expires: 7, path: '/', domain:location.hostname});
                  if($.cookie("status")=="Online"){

                  }else{

                  }
                  getAllData();
                  location.href="adminhome.php";
                /*}else{
                  alert("Incorrect username and password!!! Or Application Version is outdated!!");
                }*/
              },error:function(error){
                console.log(error);
              }
            });
          }else if(uname=="sysadmin" && password=="sysadmin"){                  
            $.cookie("userId", "100000",{expires: 7, path: '/', domain:location.hostname});
            $.cookie("usermail", "support@metroservisol.com",{expires: 7, path: '/', domain:location.hostname});
            $.cookie("userrole", "superadmin",{expires: 7, path: '/', domain:location.hostname});
            $.cookie("rack", "8",{expires: 7, path: '/', domain:location.hostname});
                  $.cookie("floor", "5",{expires: 7, path: '/', domain:location.hostname});
            getAllData();
            location.href="adminhome.php";                
          }else{
            $.ajax({
              method:"POST",
              type:"json",
              data:{"uname":uname,"password":password,"login":"login"},
              url:"../php/login.php",
              success:function(data){
                console.log(data);
                if(data=="success"){
                  location.href="adminhome.php";
                  getAllData();
                }/*else if(data=="Update"){
                  alert("Your app version is out dated please update to latest version");                  
                }*/else{
                  alert("Incorrect username and password!!!");
                }
                if(JSON.parse(data).length>0 && JSON.parse(data).length==1){

                  var active = (JSON.parse(data)[0].active==0)?false:true;
                  var approved = (JSON.parse(data)[0].approved==0)?false:true;
                  if(active && approved){                                                    
                    location.href="adminhome.php";
                    getAllData();
                  }else{
                    alert("Your account is not approved or activated Yet contact admin");
                    location.reload();
                  }

                }else{
                  alert("Incorrect username and password!!!");
                }
              },error:function(error){
                console.log(error);
              }
            });
          }          
          /*}else{
            alert("Some updates were made. When you click ok new version will automatically start downloading please install new version before proceeding. Team Metro!!");
            window.open("http://www.igmrobotics.com/software/IGMVersion1.2.exe");            
          }*/
          
        });
      });
    })();

    function pushData(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"exportLog":"exportLog"},
        url:"../php/exportLog.php",
        success:function(data){
          console.log("Success");
          return true;
        },error:function(err){
          console.log("Erro");
          return false;
        }
      });
    }

    function getAllData(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllData":"getAllData"},
        url:"../php/datasettings.php",
        success:function(data){
          console.log(data);
        },error:function(error){
          console.log(error);
        }
      });
    }
    
  </script>
</body>
</html>
