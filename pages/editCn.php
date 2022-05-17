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
      	
        <form class="" action="../php/cn.php" method="post">
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <label for="partnumber">ID</label>
                  <input type="text" class="form-control" name="eid" required="required" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Project No.</label>
                  <input class="form-control" name="eprojectno" />                  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="partnumber">To</label>
                  <select class="form-control" name="eto" class="form-control" ></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="partnumber">Credit No.</label>
                  <input type="text" class="form-control" name="ecnno"  />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="description">Invoice No.</label>
                  <input type="text" class="form-control" name="erefno"  placeholder="Enter Purchase Order No." />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Courier Service</label><br/>
                  <input type="text" class="form-control" name="ecourier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="note">Dispatch No</label><br/>
                  <input type="text" class="form-control" name="edispatchno" placeholder="Dispatch No." />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>CGST(%)</label>
                  <input type="text" class="form-control number" name="ecgst"  placeholder="CGST %" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>SGST(%)</label><br/>
                  <input type="text" class="form-control number" name="esgst" placeholder="SGST %" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>IGST(%)</label><br/>
                  <input type="text" class="form-control number" name="eigst" placeholder="IGST %" />
                </div>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-success" type="submit" name="edit">Update Details</button>
              </div>
              <div class="col-md-3" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" >Add Particular</button>
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>
                          <th>Part No.</th>
                          <th>Reason</th>
                          <th>Quantity</th>
                          <th>Unit Rate</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="parts"></tbody>
                    </table>
                  </div>
                </div>
              </div>              
            </form>
      </div>
    </div>
    <?php include("footer.php");?>

<div class="modal fade" id="addPartModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Part To Credit Note</h4>
      </div>
      <div class="modal-body">
        <form class="editForm" action="../php/cn.php" method="post">
          <div class="col-md-4" style="display: none;">
            <div class="form-group">
              <label for="custid">Credit Note Id</label>
              <input type="text" class="form-control" name="cnId" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyname">Part</label><br/>
              <select class="form-control" name="partId" ></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="companyaddress">Reason</label>
              <textarea class="form-control" name="reason"></textarea>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Quantity</label>
              <input type="text" class="form-control number" name="qty"  />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Unit Rate</label>
              <input type="text" class="form-control number" name="unitprice"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Amount</label>
              <input type="text" class="form-control" name="partTotAmount"  />
            </div>
          </div>
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-success" type="submit" name="addCNPart">Add Part</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" ></div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="editPartModal" role="dialog">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Update Part</h4>
    </div>
    <div class="modal-body">
      <form class="editForm" action="../php/cn.php" method="post">
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="custid">Id</label>
              <input type="text" class="form-control" name="eid" readonly="readonly" required="required"/>
            </div>
          </div>
          <div class="col-md-3" style="display: none;">
            <div class="form-group">
              <label for="custid">Credit Note Id</label>
              <input type="text" class="form-control" name="ecnId" readonly="readonly" required="required"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyname">Part</label><br/>
              <select class="form-control" name="epartId" required="required"></select>
            </div></div>
          
          <div class="col-md-3">
            <div class="form-group">
              <label for="companyaddress">Reason</label>
              <textarea class="form-control" name="ereason"  required="required"></textarea>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Quantity</label>
              <input type="text" class="form-control number" name="eqty"  required="required"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Unit Rate</label>
              <input type="text" class="form-control number" name="eunitprice"  required="required"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="lastname">Amount</label>
              <input type="text" class="form-control" name="epartTotAmount"  required="required" readonly="readonly"/>
            </div>
          </div>
          <div class="col-md-3" style="padding:2%;">
            <div class="form-group">
              <button class="btn btn-warning" type="submit" name="editCNPart">Edit Part</button>
            </div>
          </div>
        </form>
    </div>
    <div class="modal-footer" ></div>
  </div>
</div>
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
    	//edit addCNPart editCNPart deleteCNPart getCNPart cnPartId getAllCNPart
    var partsData = localStorage.getItem('parts');    
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    $("header,.container, footer").hide();
    $(".loader").show();
    $(window).bind("load", function() {
          checkNetworkStatus();
           $("select[name='eto']").select2({"width":"100%"});
        });
    $(document).ready(function(){
      getCustomers();
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

      $("input[name='qty']").on("input", function (event) {
          $("input[name='unitprice']").val("0");
          $("input[name='partTotAmount']").val("0");
      });

      $("input[name='eqty']").on("input", function (event) {
          var qty = $("input[name='eqty']").val();
          var unitPrice = $("input[name='eunitprice']").val();
          $("input[name='epartTotAmount']").val(parseInt(qty)*parseFloat(unitPrice));
      });

      $("input[name='eunitprice']").on("input", function (event) {
          var qty = $("input[name='eqty']").val();
          var unitPrice = $("input[name='eunitprice']").val();
          $("input[name='epartTotAmount']").val(parseInt(qty)*parseFloat(unitPrice));
      });

      $("input[name='unitprice']").on("input", function (event) {
          var qty = $("input[name='qty']").val();
          var unitPrice = $("input[name='unitprice']").val();
          $("input[name='partTotAmount']").val(parseInt(qty)*parseFloat(unitPrice));
      });
      

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
                  extend: 'copyHtml5'
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'excelHtml5'
              } ),
              $.extend( true, {}, buttonCommon, {
                  extend: 'pdfHtml5'
              } )
          ]
      });
    });

	function addPart(){
		$("input[name='cnId']").val(<?php echo $_GET["id"]; ?>);
    $("select[name='partId']").select2();
    $("select[name='partId']").select2({"width":"100%"});
    $("#addPartModal").modal();  
    }

    function getCustomers(){
      $.ajax({
        method:"POST",
        type:"json",
        data:{"viewAll":"getAllCustomers"},
        url:"../php/customer.php",
        success:function(data){
          //console.log(data);
          customers = data;
          if(JSON.parse(data).length>0){
            $("select[name='eto']").append("<option value='default'>Select Customer</option>");
            $.each(JSON.parse(data),function(i,vendor){
              if(i==0){
                $("select[name='eto']").append("<option value='"+vendor.id+"'>"+vendor.company+
                  " - "+vendor.city+"</option>");
              }else{
                $("select[name='eto']").append("<option value='"+vendor.id+"'>"+vendor.company+
                  " - "+vendor.city+"</option>");
              }
            });
          }
      getPart();
      }
    });
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
              $("select[name='partId']").append("<option value=''>Select</option>");
            $("select[name='epartId']").append("<option value=''>Select</option>");
	          	$.each(JSON.parse(partsData), function(i, part){
                if(part.landedcost!="0.00"){                
    	        		$("select[name='partId']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
    	        		$("select[name='epartId']").append("<option value='"+part.id+"'>"+part.partno+"</option>");
                }
				});                            
	        }
    	});
    }else{
      getCN();
    }
      
    }

    function getCN(){
    	$.ajax({
	        method:"POST",
	        type:"json",
	        data:{"get":"get","cnId":<?php echo $_GET["id"];?>},
	        url:"../php/cn.php",
	        success:function(data){
	          if(JSON.parse(data).length>0&&JSON.parse(data).length==1){
	          	//console.log(data);
              var partNo = partDesc = "";
              $.each(JSON.parse(data)[0].cnparts, function(i, part){
              $.each(JSON.parse(partsData), function(d, p){
                //console.log(p);
                if(p.id==part.partId){
                  partNo = p.partno;
                  partDesc = p.desc;
                }
              });
            });

	          	$.each(JSON.parse(data), function(i, cn){
	          		$("input[name='eid']").val(cn.id);
                $("select[name='eto']").val([cn.cust]).trigger("change");;
                $("input[name='ecnno']").val(cn.cnno);
                $("input[name='erefno']").val(cn.refno);
                $("input[name='eprojectno']").val(cn.projectno);
                $("input[name='ecourier']").val(cn.courier);
                $("input[name='edispatchno']").val(cn.dispatchno);
                $("input[name='ecgst']").val(cn.cgst);
                $("input[name='esgst']").val(cn.sgst);
                $("input[name='eigst']").val(cn.igst);
					$.each(cn.cnparts, function(i, cnpart){
						var element= "<tr>"
						+"<td><input class='form-control' value='"+partNo+"' readonly/></td>"
						+"<td><textarea class='form-control' id='"+cnpart.id+"'  readonly></textarea></td>"
						+"<td><input class='form-control' value='"+cnpart.qty+"' readonly/></td>"
						+"<td><input class='form-control' value='"+cnpart.unitprice+"' readonly/></td>"
						+"<td><input class='form-control' value='"+cnpart.partTotAmount+"' readonly/></td>"
						+"<td>"
						+"<a onClick='editCNPart("+cnpart.id+")'>Update</a>&emsp;"
						+"<a onClick='deleteCNPart("+cnpart.id+")'>Delete</a>"
						+"</td>"
						+"</tr>";            
						if(i==0){
							$("#parts").html(element);
						}else{
							$("#parts").append(element);
						}
            $("#"+cnpart.id).val(cnpart.reason);
					});
	          	});
            }
            $("header,.container, footer").show();
            $(".loader").hide();
	        }
        });
    }
    

    function getCNPart(){
    	$.ajax({
	        method:"POST",
	        type:"json",
	        data:{"getCNPart":"getCNPart"},
	        url:"../php/cn.php",
	        success:function(data){
	          console.log(data);
	          $("#editPartModal").modal();
	        }
        });
    }

    function editCNPart(id){
    	$.ajax({
	        method:"POST",
	        type:"json",
	        data:{"getCNPart":"getCNPart","cnPartId":id},
	        url:"../php/cn.php",
	        success:function(data){
	          console.log(data);
	          //[{"id":"3","cnId":"15","partId":"1","unitprice":"12.00","reason":"dfsdfdsds","qty":"12","partTotAmount":"144.00"}]
	          $.each(JSON.parse(data), function(i, part){
              if(id==part.id){
  	          	$("input[name='eid']").val(part.id);
  	          	$("input[name='ecnId']").val(part.cnId);
  	          	$("input[name='epartId']").val(part.partId);
  	          	$("textarea[name='ereason']").html(part.reason);
  	          	$("input[name='eunitprice']").val(part.unitprice);
  	          	$("input[name='eqty']").val(part.qty);
  	          	$("input[name='epartTotAmount']").val(part.partTotAmount);
  	          	$("select[name='epartId']").val(part.partId);
              }
	          });
            $("select[name='epartId']").select2();
            $("select[name='epartId']").select2({"width":"100%"});
	          $("#editPartModal").modal();

	        }
        });
    }

    function deleteCNPart(id){
    	var c = confirm("Are you sure you want to delete!!");
    	if(c){
    		$.ajax({
	        method:"POST",
	        type:"json",
	        data:{"deleteCNPart":"deleteCNPart","cnPartId":id},
	        url:"../php/cn.php",
	        success:function(data){
	          console.log(data);
	          if(data){
	          	alert("Deleted");
	          	location.reload();
	          }
	        }
        });
    	}
    }
    </script>
  </body>
</html>
