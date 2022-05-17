
(function () { 
  var vendorsData = localStorage.getItem('vendorsData');
  var customersData = localStorage.getItem('customersData');
  //setInterval(clearLocalStorage, 600000);
  
  function clearLocalStorage(){
    console.log("Clearing partsdata");
    localStorage.setItem('parts', "");
    $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllInventory":"getAllInventory"},
        url:"../php/inventory.php",
        success:function(data){
          //partsData = data;
          localStorage.setItem('parts', data);
        }
    });
  }

  $("a#log").on("click",function(e){
      //alert();e.preventDefault();
      if(confirm('Do you want to sync database?')){
        $("a#log").attr("href","../php/login.php?logout="+$.cookie("userid")+"&sync=yes");
      }else{
        $("a#log").attr("href","../php/login.php?logout="+$.cookie("userid")+"&sync=no");
      }
  });
   
  $(".number").keypress(function(e){
    $(".number").attr('maxlength',50);
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
        if(e.which==46){
          return true;
        }else{
      return false;
      }
    }
  });

  $("input").on("keyup",  function(event){
    console.log();
    if($(this).attr("input")=="number"){
      isNumber(event);
    }else{
      isCharacter(event);
    }
  });

  $("table.or").on("keypress", ".amount", function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
      if(e.which==46){
        return true;
      }else{
        return false;
      }
    }
  });

  $("table.or").on("keypress", ".number", function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
       if(e.which==46){
        return true;
      }else{
        return false;
      }
        //return false;
    }
  });  
}());

/*Status Function*/
  function checkNetworkStatus(){
    var data = {
      "checkstatus":"check"
    }
    var url = "";    
    // Development
    /*switch(window.location.href.match(/\/.+?/g).length){
      case 3:
        url="";
        break;
      case 4:
        url="../";
        break;
      case 5:
        url="../../";
        break;
      case 6:
        url="../../../";
        break;
    }*/

    // Deployment
    switch(window.location.href.match(/\/.+?/g).length){
      case 2:
        url="../";
        break;
      case 3:
        url="../../";
        break;
      case 4:
        url="../../";
        break;
      case 5:
        url="../../../";
        break;
    }

    /*var url = "http://www.igmrobotics.com";
    var img = new Image();
    img.src = url;

    img.onload = function(){
      //alert("Server is up!");
      //insertElement("Online");
    }

    img.onerror = function(){
      //alert("Server is down!");
      //insertElement("Offline");
    }*/

    insertElement();    
  }

  function insertElement(){    
    if($.cookie("status")=="Online"){
      //checkDataStatus();
    }else{
    }
    //$.cookie("status", status,{expires: 7, path: '/', domain: 'localhost'});
    //$.cookie("status", status,{expires: 7, path: '/', domain: location.host});
    var button = ($.cookie("status")=="Online")?"<button class='btn btn-success status'>Device/Server Online</button>":"<button class='btn btn-warning status'>Device/Server Offline</button>";
    $("body").append(button);    
  }
 

  /*Sync Server Data*/

  function checkDataStatus(){
    var url = "";
    //alert(window.location.href.match(/\/.+?/g).length);

    if($.cookie("status")=="Online"){
      var data = {
      "updateDB":"check"
      }
      var url = "";
      
      // Development
      /*switch(window.location.href.match(/\/.+?/g).length){
        case 3:
          url="";
          break;
        case 4:
          url="../";
          break;
        case 5:
          url="../../";
          break;
        case 6:
          url="../../../";
          break;
      }*/

      // Deployment
    switch(window.location.href.match(/\/.+?/g).length){
      case 2:
        url="../";
        break;
      case 3:
        url="../../";
        break;
      case 4:
        url="../../";
        break;
      case 5:
        url="../../../";
        break;
    }
      $.ajax({
        method:"POST",
        url:url+"php/syncServerData.php",
        //url:"http://localhost/igm/php/syncServerData.php",
        //cache:true,
        data:data,
        beforeSend:function(){
          console.log("Checking Data status");
        },
        success:function(data){
          //console.log(data);
          insertDataElement(data);
        },
        error:function(){
          alert("Error checking data status!! Contact Admin!!");
          console.log("Err!!Checking Data status");
        }
      });
    }else{
      insertDataElement("Offline");
    }
  }

  function userRole(){
    if($.cookie("userrole")=="admin"){
      //console.log("");
      //$("a[href='customers.html']").hide();
      $("a[href='register.html']").hide();
      //$("a[href='vendor.html']").hide();
      //$("a[href='backup.html']").hide();
    }
    switch($.cookie("userrole")){
      case "superadmin":
        $("a.role").html("Super Admin<span class='caret'></span>");
      break;
      case "admin":
        $("a.role").html("Admin<span class='caret'></span>");
      break;
      case "spares":
        $("a.role").html("Spares<span class='caret'></span>");
      break;
      case "viewer":
        $("a.role").html("Viewer<span class='caret'></span>");
      break;
      case "service":
        $("a.role").html("Service<span class='caret'></span>");
      break;
      case "finance":
        $("a.role").html("Finance<span class='caret'></span>");
      break;
    }
  }

  function insertDataElement(status){

    //$.cookie("status", status,{expires: 7, path: '/', domain: 'localhost'});
    var button = (status=="Data Synced")?"<button class='btn btn-success datastatus'>Data Syncing</button>":"<button class='btn btn-warning datastatus'>Data already Synced</button>";
    $("body").append(button);
  }
  /*End Sync Server Data*/
  /*Number Input*/
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function updateConfigXML(){
  var url = "";
  // Development
  /*switch(window.location.href.match(/\/.+?/g).length){
    case 3:
      url="";
      break;
    case 4:
      url="../";
      break;
    case 5:
      url="../../";
      break;
    case 6:
      url="../../../";
      break;
  }*/

  // Deployment
    switch(window.location.href.match(/\/.+?/g).length){
      case 2:
        url="../";
        break;
      case 3:
        url="../../";
        break;
      case 4:
        url="../../";
        break;
      case 5:
        url="../../../";
        break;
    }
  $.ajax({
      method:"POST",
      url:url+"php/updateConfig.php",
      //url:"http://localhost/igm/php/updateConfig.php",
      data:{"updateConfig":"updateConfig"},
      //url:"http://igmrobotics.com/config.xml",
      //dataType: "jsonp xml",
      beforeSend:function(){
        console.log("Updating Config XML");
      },
      success:function(data){
        console.log(data);
      },
      error:function(){
        //alert("Contact Admin");
        console.log("Err!!Updating Config XML");
      },
      complete:function(data){
        //console.log(data.responseText);
        if(data.status==200){
          console.log(data.responseText);
        }
      }
    });
}

function isCharacter(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode < 31 && (charCode > 48 || charCode < 57)) {
        return false;
    }
    return true;
}
