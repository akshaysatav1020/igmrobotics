<html>
<head>
  <meta name="charset" content="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Control System|Settings</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <style media="screen">
  .row{
    margin-bottom: 2%;
  }
  .row>.box{
    padding:2%;
    border: 1px solid #efefef;
    border-radius: 4px;
    text-align: center;
    margin-bottom: 0.5%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  }
  .box>h1{
    color: #000;
  }
  .box>a{
    color: #fff;
    position: relative;
    bottom: -20px;
  }
  .box>a:hover{
    text-decoration: none;
  }
  
  main {
      min-width: 320px;
      max-width: 100%;
      padding: 50px;
      margin: 0 auto;
      background: #fff;
    }


    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #ddd;
    }

    label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
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

    label[for*='1']:before { content: '\f153'; }
    label[for*='2']:before { content: '\f06e'; }
    label[for*='3']:before { content: '\f016'; }
    label[for*='4']:before { content: '\f15b'; }
    label[for*='5']:before { content: '\f067'; }
    label[for*='6']:before { content: '\f1cb'; }

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
    #tab4:checked ~ #content4,
    #tab5:checked ~ #content5,
    #tab6:checked ~ #content6 {
      display: block;
    }

    @media screen and (max-width: 650px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
        font-size: 0;
      }
      label[for*='1']:before, label[for*='2']:before, label[for*='3']:before, label[for*='4']:before, label[for*='5']:before, label[for*='6']:before {
        margin: 0;
        font-size: 18px;
      }
    }

    @media screen and (max-width: 400px) {
      label[for*='1'], label[for*='2'], label[for*='3'], label[for*='4'], label[for*='5'], label[for*='6'] {
        padding: 15px;
      }
    }

  </style>
</head>
<body>
  <?php include "menu.php";?>
  <div class="container-fluid" >
    <div class="row">
      <main>            
          <input id="tab3" type="radio" name="tabs" checked="">
          <label for="tab3">Import</label>
          <input id="tab4" type="radio" name="tabs">
          <label for="tab4">Export</label>
          <input id="tab6" type="radio" name="tabs">
          <label for="tab6">Reset SysAdmin Password</label>                  
          <section id="content3">
            <form action="../php/backup.php" method="POST" enctype="multipart/form-data">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="description">Choose File</label>
                  <input type="file" class="form-control" name="importfile" required="required"/>
                </div>
              </div>
              <div class="col-md-4" style="padding:2%;">
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-warning" name="import">Import Database</button>
                </div>
              </div>
           </form>            
          </section>
          <section id="content4">
            <form action="../php/backup.php" method="POST">              
              <button type="submit" class="btn btn-md btn-success" name="export">Export Database</button>
            </form>
          </section>
          
          <section id="content6">            
              <form  method="GET" name="password">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="description">Password</label>
                    <input type="password" class="form-control" maxlength="12" name="password" required="required"/>
                  </div>
                </div>
                <div class="col-md-4" style="padding:2%;">
                  <div class="form-group">
                      <button type="button" class="btn btn-md btn-warning" onclick="updatePassword()" name="resetsysadmin">Reset SysAdmin</button>
                  </div>
                </div>
             </form>            
          </section>
      </main>
    </div>
  </div>
  <?php include("footer.php");?>
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
    //var url = "";
  $("header,.container-fluid,footer").hide();
  $(".loader").show();
  $(document).ready(function(){
    checkNetworkStatus();    
    if($.cookie("status")!="Online"){      
      //resetsysadmin export import updatewarehouse updaterate
      $("button[name='resetsysadmin']").attr("disabled","disabled");
      $("button[name='import']").attr("disabled","disabled");
      $("button[name='updatewarehouse']").attr("disabled","disabled");
      $("button[name='updaterate']").attr("disabled","disabled");
    }
    $("header,.container-fluid,footer").show();
    $(".loader").hide();
    //getEuroRate();
    
  });

  function updatePassword(){
    
    $.ajax({
      method:"POST",
      type:"json",
      data:{"password":$("input[name='password']").val(),"resetsysadmin":"resetsysadmin"},
      url:"../php/dataSettings.php",
      success:function(data){
        console.log(data); 
        if(data=="Updated"){
          alert("Updated");          
          location.reload();
        }               
      },error: function(error){
        console.log("Error updating! Info Contact Admin");
      }
    });
  }

  
  
  </script>
</body>
</html>