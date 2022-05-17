<?php
  require_once("../php/db.php");
  $db=new DB();
  $connection=$db->getConnection();
?>
<!DOCTYPE html>
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
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">
    <style media="screen">
      textarea.form-control{
        height: 34px;
      }
    label[for*='1']:before { content: '\f1c1'; }
    label[for*='2']:before { content: '\f06e'; }

    </style>
  </head>
  <body>
  <?php include "menu.php";?>
    <div class="container-fluid" >
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Generate Debit Note</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View List</label>
          <section id="content1">
            <form class="" action="../php/dn.php" method="post">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="projectno" />                  
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="partnumber">Vendor</label>
                  <select name="to" class="form-control" required>
                    <option value="">Select Vendor</option>                    
                    <?php                    
                      $query="SELECT * FROM vendors";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                 
                          echo "<option value='".$row["id"]."'>".$row["company_name"]
                          ." - ".$row["city"]."</option>";
                        }
                      }                     
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="partnumber">Debit No.</label>
                  <input type="text" class="form-control" name="dnno"   />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="description">Purchase Order no.</label>
                  <input type="text" class="form-control" name="refno"  placeholder="Enter PO No." />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="note">Courier Service</label><br/>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="note">Dispatch No</label><br/>
                  <input type="text" class="form-control" name="dispatchno" placeholder="Dispatch No." />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>CGST(%)</label>
                  <input type="text" class="form-control number" name="cgst"  placeholder="CGST %" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>SGST(%)</label><br/>
                  <input type="text" class="form-control number" name="sgst" placeholder="SGST %" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>IGST(%)</label><br/>
                  <input type="text" class="form-control number" name="igst" placeholder="IGST %" />
                </div>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button>
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>
                          <th>Part No.</th>
                          <th>Reason</th>
                          <th>Unit Rate (Rupees)</th>
                          <th>Quantity</th>
                          <th>Total (Rupees)</th>
                        </tr>
                      </thead>
                      <tbody id="parts"></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button class="btn btn-success" type="submit" name="add">Generate</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>Debit No</th>
                    <th>Vendor</th>
                    <th>Total (Rupees)</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Debit No</th>
                    <th>Vendor</th>
                    <th>Total (Rupees)</th>
                    <th>Action</th>
                </tfoot>
                <!-- <tbody id="dnlist"> -->
                <tbody>
                  <?php
                  $query="SELECT dn.*, vend.company_name as vname, (SUM(dnp.partTotAmount)+((cgst/100)*SUM(dnp.partTotAmount))+((sgst/100)*SUM(dnp.partTotAmount))+((igst/100)*SUM(dnp.partTotAmount))) as totalAmt FROM `debitnote` dn LEFT JOIN vendors vend on dn.vend=vend.id LEFT JOIN dn_parts dnp on dn.id=dnp.dnId GROUP BY dn.id";
                      $result = $connection->query($query);
                      $data = array();
                      if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){                    
                          echo "<tr>";
                          echo "<td>".$row["dnno"]."</td>";
                          echo "<td>".$row["vname"]."</td>";
                          echo "<td>".$row["totalAmt"]."</td>";
                          echo "<td>";
                          if($_COOKIE["status"]=="Online"){
                            echo "<button class='btn btn-sm btn-success' onclick='printDN(".$row["id"].")'>Print</button>&emsp;";
                            echo "<button class='btn btn-sm btn-warning' onclick='editDN(".$row["id"].")'>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteDN(".$row["id"].")'>Delete</button></td>";
                          }else{                        
                            echo "<button class='btn btn-sm btn-success' onclick='printDN(".$row["id"].")'>Print</button>&emsp;";
                            echo "<button class='btn btn-sm btn-warning' onclick='editDN(".$row["id"].")' disabled>Edit</button>&emsp;";
                            echo "<button class='btn btn-sm btn-danger' onclick='deleteDN(".$row["id"].")'disabled>Delete</button></td>";
                          }
                          echo "</tr>";
                        }
                      } 

                      function getVendor($connection, $id){
                        $query="SELECT * FROM vendors WHERE id=".$id;
                        $result = $connection->query($query);
                        $data = "";
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){          
                            $data = $row['company_name']." - ".$row['city'];
                          }
                        }      
                        return $data;
                      } 

                      function getTotalAmount($connection, $id){
                        $query="SELECT SUM(partTotAmount) as total FROM dn_parts WHERE dnId=".$id;
                        $result = $connection->query($query);
                        $data = "";
                        if($result->num_rows>0){
                          while($row=$result->fetch_assoc()){          
                            $data = $row['total'];
                          }
                        }      
                        return $data;
                      }                   
                    ?>
                </tbody>
              </table>
            </div>
          </section>
          <section id="content3">
            <button type="submit" class="btn btn-lg btn-success" name="button">IMPORT</button>
          </section>
          <section id="content4">
            <button type="submit" class="btn btn-lg btn-success" name="button">EXPORT</button>
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
   <script src="../js/select2.min.js"></script>
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
      //add edit delete dnId get getAll
      $("header,.container-fluid,footer").hide();
            $(".loader").show();
    var partsData = localStorage.getItem('parts');       
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    $(document).ready(function(){
      checkNetworkStatus();
      $("select[name='to']").select2({"width":"100%"});
      if($.cookie("status")=="Offline"){                      
        $("button[name='add']").attr("disabled","disabled");
      }
      getVendors();      
      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });
      $("table.or").on("click", ".removepart", function (event) {
          //alert($(this).attr("id"));
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
      });
      $("form").submit(function(event){
        //event.preventDefault();
        var formData = $(this).serializeArray();
        var diff = $(addPartIds).not(removePartIds).get();
        $(this).append("<input type='hidden' name='ids' value='"+diff+"'/>");
      });

      $("table.or").on("input", ".rate", function (event) {
          $("input[name='qty"+$(this).attr("id")+"']").val("0");          
          $("input[name='total"+$(this).attr("id")+"']").val("0");
      });

      $("table.or").on("input", ".qty", function (event) {
          var qty = $("input[name='qty"+$(this).attr("id")+"']").val();
          var unitPrice = $("input[name='rate"+$(this).attr("id")+"']").val();
          //console.log(qty+"    "+unitPrice);
          $("input[name='total"+$(this).attr("id")+"']").val(parseInt(qty)*parseFloat(unitPrice));
      });      
    });

    function addPart(){
      var element = "";
      element = "<tr>"
      // +"<td>"+partIndex+".</td>"
      +"<td>"
      +"<select class='form-control part js-example-basic-single' name='partno"+partIndex+"' id="+partIndex+"><option value='default'>Select part</option></select>"
      +"</td>"
      +"<td>"
      +"<textarea class='form-control' name='reason"+partIndex+"' required></textarea>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control number rate' id='"+partIndex+"' name='rate"+partIndex+"' required/>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control number amount qty' name='qty"+partIndex+"' id='"+partIndex+"' required/>"
      +"</td>"
      +"<td>"
      +"<input type='text' class='form-control' name='total"+partIndex+"' required readonly='readonly'/>"
      +"</td>"
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id="+partIndex+">-</button>"
      +"</td>"
      +"</tr>";
      $("#parts").append(element);
      $.each(JSON.parse(partsData), function(i, part){
        if(part.landedcost!="0.00"){          
          $("select[name='partno"+partIndex+"']").append("<option value='"+part.id+"-"+part.partno+"'>"+part.partno+"</option>");
        }
      });
      $("select[name='partno"+partIndex+"']").select2();
    }

    function getVendors(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"viewAll":"getAllVendor"},
        url:"../php/vendor.php",
        success:function(data){
          //console.log(data);
          vendors = data;          
          getPart();
            
      }});
    }

    function getPart(){
      if(partsData==null){
        $.ajax({
        method:"POST",
        type:"json",
        data:{"getAllInventory":"getAllInventory"},
        url:"../php/inventory.php",
        success:function(data){
          //console.log(data);
          partsData = data;
          localStorage.setItem("parts",partsData);          
        }
        });
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
                        extend: 'copyHtml5',exportOptions:{columns:[0,1,2]}
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5',title:"Debit Note List",exportOptions:{columns:[0,1,2]}
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5',title:"Debit Note List",exportOptions:{columns:[0,1,2]}
                    } )
                ]
            });
      getPreDNNo();
      $("header,.container-fluid,footer").show();
      $(".loader").hide();
    }    

    function printDN(id){
      window.open("../php/dn.php?id="+id+"","_blank");
    }

    function editDN(id){
      window.open("editDn.php?id="+id+"","_self");
    }

    function getPreDNNo(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"getLastDN":"getLastDN"},
        url:"../php/dn.php",
        success:function(data){
          console.log(data);          
          if(data!=""){
            var id = parseInt(data.substr(3,5))+1;
            if(parseInt(id)<9){
              a = "00"+id;
            }else if(parseInt(id)<99){
              a = "0"+id;
            }else{
              a = id;
            }
            $("input[name='dnno']").val("DN"+a);
          }else{
            a="001";
            $("input[name='dnno']").val("DN"+a);
          }         
        },error:function(error){

        }
      });     
    }

    function deleteDN(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){   
        $.ajax({
            method:"POST",
            type:"json",
            data:{"dnId":id,"delete":"delete"},
            url:"../php/dn.php",
            success:function(data){
              console.log(data);
              if(data=="Deleted"){
                alert("deleted");
                location.reload();
              }
            },error:function(error){

            }
          });
      }
    }

    </script>
  </body>
</html>
