<!DOCTYPE html>
<?php
  require_once("php/constants.php");
  require_once("status.php");
?>

<head>
  <meta name="charset" content="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory Control System</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <link rel="stylesheet" type="text/css" href="css/font.css">
  <style media="screen" type="text/css">
    .row{
      margin-bottom: 2%;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <img src="images/logo.png" alt="igm-logo" class="img-responsive"/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4" style="border:1px solid gray; border-radius:5px; background-color:#f00;text-align:center;float: none;margin: 0 auto;">
          <h1 style="color:white; padding:5%;">Inventory Control System</h1><br/>
          <button class="btn btn-lg btn-default" style="margin:5%;" type="button" name="button">Sign in</button>          
      </div>
    </div>
  </div>
  <?php include("pages/footer.php");?>
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
  
  <script src="js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
  <script src="js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  <script src="js/custom.js" charset="utf-8"  type="text/javascript"></script>
  <script type="text/javascript">
    (function(){    
      $(window).bind("load", function() {
        $(".loader").hide();         
      });
      $(document).on("keyup",function(event){
        if (event.keyCode === 13) {
          $(location).attr('href', 'pages/login.php');
        }
      });      
    }());
    
  </script>
</body>
</html>