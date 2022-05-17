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
    <link rel="stylesheet" href="../css/multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../css/datepicker.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link href="../css/select2.min.css" rel="stylesheet" />

    <style media="screen">
      textarea.form-control{
        height: 34px;
      }
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
      text-align: center;*/
      padding: 15px 25px;
      font-weight: 600;
      border: 1px solid transparent;
    }

    label:before {
      font-family: fontawesome;
      font-weight: normal;
      margin-right: 10px;
    }

    label[for*='1']:before { content: '\f1c1'; }
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
    
    <div class="container-fluid" >
      <div class="row">
        <main>
          <input id="tab1" type="radio" name="tabs" checked>
          <label for="tab1">Generate Challan</label>
          <input id="tab2" type="radio" name="tabs">
          <label for="tab2">View List</label>
          <!-- <input id="tab3" type="radio" name="tabs">
          <label for="tab3">Returnable StockParts</label> -->
          <section id="content1">
            <form class="" action="../php/dc.php" method="POST" id="addDC">
              <div class="col-md-2">
                <div class="form-group">
                  <label>Project No.</label>
                  <input type="text" class="form-control" name="projectno" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="to">Customer</label>
                  <select class="form-control" name="customer" required="required">
                    <option value="">Select Customer</option>                                        
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="challannumber">Challan No.</label>
                  <input type="text" name="challannumber" class="form-control" readonly/>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Issue Date</label>
                  <div id="datepicker" class="input-group date">
                      <input class="form-control" name="issuedate" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                    <label>Challan Type</label>
                    <select name="challanType" class="form-control">
                        <option value="returnable">Returnable</option>
                        <option value="nonreturnable">Non Returnable</option>
                        <option value="nontraceable">Non Traceable</option>
                    </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Refrence No.</label>
                  <input class="form-control" name="referencenumber" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Reference Date</label>
                  <div id="datepicker" class="input-group date" >
                      <input class="form-control" name="refdate" type="text" >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Shipment Date</label>
                  <div id="datepicker" class="input-group date" >
                      <input class="form-control" name="shipdate" type="text"  >
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Mode of transport</label>
                  <select class="form-control" name="mode" >
                    <option value="">Select</option>
                    <option value="air">Air</option>
                    <option value="road">Road</option>
                    <option value="rail">Rail</option>
                    <option value="byhand">By Hand</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Vehicle No.</label>
                  <input type="text" name="vehicle" class="form-control" >
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Courier Service</label>
                  <input type="text" class="form-control" name="courier" placeholder="Courier Service Name" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Dispatch No</label>
                  <input type="text" class="form-control" name="dispatchno" placeholder="Dispatch No." />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>L.R. / R.R. NO.</label>
                  <input type="text" name="lr" class="form-control" >
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                    <label>Freight</label>
                    <select class="form-control" name="freight">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
              </div>              
              <div class="col-md-2">
                <div class="form-group">
                  <label>Terms &amp; Condition</label>
                  <textarea class="form-control" name="terms" placeholder="Enter terms" ></textarea>
                </div>
              </div>
              <div class="col-md-2" style="padding:2%;">
                <button class="btn btn-default addpart" type="button" value="addpart">Add Particular</button><br><br>                
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed or">
                      <thead>
                        <tr>                          
                          <th>Part No.</th>
                          <th>Part Id</th>
						              <th>Description</th>
                          <th>Serial No.</th>
                          <th>Available</th>
                          <th>Unit Price</th>
                          <th>Quantity</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody id="parts">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" name="generateDC" class="btn btn-info">Generate</button>
              </div>
            </form>
          </section>
          <section id="content2">
            <div class="">
              <table class="table table-bordered table-striped table-condensed" id="myTable">
                <thead>
                  <tr>
                    <th>Challan No.</th>
                    <th>Customer</th>
                    <th>Ref. No</th>
                    <th>Returnable</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Challan No.</th>
                    <th>Customer</th>
                    <th>Ref. No</th>
                    <th>Returnable</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody id="challanList"></tbody>
              </table>
            </div>
          </section>
        </main>
      </div>
    </div>
    <!--Modal for returnable-->
  <div class="modal fade" id="returnableView" role="dialog">
    <div class="modal-dialog modal-lg">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Close Challan</h4>
        </div>
        <div class="modal-body">
          <div class="row">
          <form method="post" action="../php/dc.php" id="returnForm">
            <div class='col-md-3' style='display:none'>                     
              <input type='text' name='statusChId' class='form-control' value='' readonly/> 
              <input name='count'type='text' class='form-control' value='' readonly/>             
            </div>
            
            <div class='col-md-12'>
              <table class="table table-bordered table-striped">
                <thead>
                <th>Part Id</th>
                <th>Part No.</th>
                <th>Qty</th>
                <th>Old Serial</th>
                <th>New Serial</th>
                
              </thead>
              <tbody id="returnableParts"></tbody>
              </table>            
            </div>
            <div class='col-md-12' style='margin-top: 24px;'>
              <button class='btn btn-success' type='submit' name='updateDCClosing'>Submit</button>              
            </div>
          </form>
          </div>
        </div>
      </div>
      
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
  <script src="../js/multiselect/bootstrap-multiselect.min.js" charset="utf-8"></script>
  <script src="../js/bootstrap-datepicker.js"charset="utf-8"  type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8"  type="text/javascript"></script>
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
  <script type="text/javascript">
    //projectno,customer,challannumber,issuedate,challanType,referencenumber,refdate,shipdate,mode,
    //vehicle,courier,dispatchno,lr,freight,terms
      $("header,.container-fluid,footer").hide();
      $(".loader").show();
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];
    var partsData = localStorage.getItem("parts");
    var customers;
    var stocks=null;

    $(document).ready(function(){
      
      getChallanNo();
      getCustomers();
      getAllDC();
      checkNetworkStatus();      

      if($.cookie("status")=="Offline"){                      
        $("button[name='generateDC']").attr("disabled","disabled");
      }      

      $("input[name='shipdate'],input[name='refdate'],input[name='issuedate']").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
      });

      $(".addpart").attr("disabled","disabled");

      $("select[name='customer']").on("change", function() {
         $(".addpart").removeAttr("disabled");
      });

      $(".addpart").click(function(){
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });

      $("table.or").on("change", ".part", function (event) {          
        var id = $(this).attr("name").substr(6);
        var val = $(this).val().split("*");
        if($("select[name='challanType']").val() != "nontraceable"){
            $("input[name='partId"+id+"']").val(val[0]);
            $("textarea[name='description"+id+"']").val(val[2]);
            $("input[name='available"+id+"']").val(val[3]);   
        }else{
            $("input[name='partId"+id+"']").val("");
            $("textarea[name='description"+id+"']").val();
            $("input[name='available"+id+"']").val("0");
        }
      });

      $("table.or").on("click", ".removepart", function (event) {
          removePartIds.push(parseInt($(this).attr("id")));
          $(this).closest("tr").remove();
      });

      $("form#addDC").submit(function(event){
        //event.preventDefault();
        $("select[name='customer']").removeAttr("disabled");
        var formData = $(this).serializeArray();
        var diff = $(addPartIds).not(removePartIds).get();
        $(this).append("<input type='hidden' name='ids' value='"+diff+"'/>");
      });
    });

    function getChallanNo() {
      $.ajax({
        method: "POST",
        type: "json",
        data: {"getLastDC": "getLastDC"},
        url: "../php/dc.php",
        success: function(data) {
            console.log(data);
            if (data == "") {
                $("input[name='challannumber']").val("001");
            }else{
              if (parseInt(data) < 9) {
                $("input[name='challannumber']").val("00" + data);
              }else if (parseInt(data) < 99) {
                $("input[name='challannumber']").val("0" + data);
              } else{
                $("input[name='challannumber']").val(data);
              }
            }
        }
      });
    }

    function addPart(){
      var element = "";
      var partelement = "<select style='width:150px' class='form-control part'  name='partno" + partIndex +
            "' id=" + partIndex + "></select>";
      if ($("select[name='challanType']").val() == "nontraceable") {
          partelement = "<input style='width:150px' class='form-control part'  name='partno" + partIndex +
              "' id=" + partIndex + ">";
      }
      element = "<tr>"
      +"<td>"
      +partelement
      +"</td>"
      +"<td>"
      +"<input style='width:50px' type='text' class='form-control' name='partId"+partIndex+"'readonly/>"
      +"</td>"
      +"<td>"
      +"<textarea style='width:150px' class='form-control' name='description"+partIndex+"'></textarea>"
      +"</td>"
      +"<td>"
      +"<textarea class='form-control serial' name='serial"+partIndex+"' ></textarea>"
      +"<td>"
      +"<input style='width:50px' type='text' class='form-control number available' name='available"+partIndex+"' readonly/>"
      +"</td>"
      +"<td>"
      +"<input style='width:50px' type='text' class='form-control number unitprice' name='unitprice"+partIndex+"' />"
      +"</td>"      
      +"<td>"
      +"<input style='width:50px' type='text' class='form-control number qty' name='quantity"+partIndex+"' />"
      +"</td>"
      +"<td>"
      +"<input style='width:150px' type='text' class='form-control amount' name='amount"+partIndex+"' >"
      +"</td>"
      +"<td>"
      +"<button type='button' class='btn btn-sm btn-warning removepart' id='"+partIndex+"'>-</button>"
      +"</td>"
      +"</tr>";
      $("#parts").append(element);
      if ($("select[name='challanType']").val() != "nontraceable") {
        $("select[name='partno"+partIndex+"']").append("<option value=''>Select</option>");        
		    $("select[name='partno" + partIndex + "']").select2({
    			minimumInputLength: 1,tags: [],
    			ajax: {
    				url: "../php/dc.php",
    				dataType: 'json',
    				type: "POST",
    				quietMillis: 50,
    				data: function (term) {
    					return {
    						term: term,
    						challanType:$("select[name='challanType']").val(),
    						getParticularDC:'getParticularDC'				
    					};
    				},
    				processResults: function (data) {
    					console.log(data);
    					return {
    						results: $.map(data, function (item) {
    							return {
    								text: item.partnumber+"/"+item.country,
    								slug: item.partnumber,
    								id: item.id+"*"+item.partnumber+"*"+item.description+"*"+item.available
    							}
    						})
    					};
    				}
    			}
    		});
      }
    }
    
    function getCustomers() {
        $("select[name='customer']").select2({
            minimumInputLength: 2,
            tags: [],
            width: '100%',
            templateResult: function formatState(state) {
                if (!state.id) {
                    return state.text
                }
                if (!state.slug) {
                    return; // here I am excluding the user input
                }
                var $state = $(
                    '<span data-select2-id="' +
                    state.id + '">' + state.text + '</span>');
                return $state;
            },
            ajax: {
                url: "../php/dc.php",
                allowClear: true,
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function(term) {
                    return {
                        term: term,
                        getCustomerForDC: 'getCustomerForDC'
                    };
                },
                processResults: function(data) {
                    if (data != "") {
                        //console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.company,
                                    slug: item.company,
                                    id: item.id
                                }
                            })
                        };
                    } else {
                        return {
                            results: [{
                                'loading': false,
                                'description': 'No result',
                                'name': 'no_result',
                                'text': 'No result'
                            }]
                        }
                    }
                }
            }
        }); 
    }

    function getAllDC() {
      var buttonCommon = {
          exportOptions: {
              format: {
                  body: function(data, row, column, node) {
                      return column === 5 ?
                          data.replace(/[$,]/g, '') :
                          data;
                  }
              }
          }
      };
      $('#myTable').DataTable({
        'dom': 'Bfrtip',
        "iDisplayLength": 10,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../php/dc.php',
            "data": {
                "getAllDC": "getAllDC"
            }
        },
        columns: [
          {
                data: 'challan_no',//qno
                render: function(data, type, row) {
                    return ("<td style='width:30vw;'>" + data + "</td>");
                }
            },
            {
                data: 'company_name',//customer
                render: function(data, type, row) {
                    return ("<td style='width:10vw;'>" + data + "</td>");
                }
            },
            {
                data: 'ref_no',//qdate
                render: function(data, type, row) {
                    return ("<td style='width:10vw;'>" + data + "</td>");
                }
            },
            {
                data: 'challanType',//validdate
                render: function(data, type, row) {
                    return ("<td style='width:10vw;'>" + data + "</td>");
                }
            },
            {
                data: 'date',//amt
                render: function(data, type, row) {
                    return ("<td style='width:10vw;'>" + data + "</td>");
                }
            }, {
                data: 'totalAmt',//validdate
                render: function(data, type, row) {
                    return ("<td style='width:10vw;'>" + data + "</td>");
                }
            },
            {
                data: 'closing_status',//amt
                render: function(data, type, row) {
                      if(row.challanType=="returnable"){
                        if(data==0){
                          return("<button class='btn btn-xs btn-warning' onclick='changeClosingStatus(" +row.id + ")'>Change Status</button>");
                        }else{
                          return("<button class='btn btn-xs btn-info'>Closed</button>");
                        }
                      }else{
                        return ("<td style='width:30vw;'>NA</td>");
                      }
                        
                    }
            },               
            {
                data: 'id',
                render: function(data, type, row) {
                    return ("<td style='width:20vw;'>" +
                        "<button class='btn btn-sm btn-success' onclick='printChallan(" + data +
                        ")'>Print</button> " +
                        "<button class='btn btn-sm btn-warning' onclick='editChallan(" + data +
                        ")'>Edit</button> " +
                        "<button class='btn btn-sm btn-danger' onclick='deleteChallan(" + data +
                        ")'>Delete</button></td>");
                }
            }

          ],
          buttons: [
            $.extend(true, {}, buttonCommon, {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }),
            $.extend(true, {}, buttonCommon, {
                extend: 'excelHtml5',
                title: "Challan List",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }),
            $.extend(true, {}, buttonCommon, {
                extend: 'pdfHtml5',
                title: "Challan List",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            })
          ]
      }); 
      $("header,.container-fluid,footer").show();
      $(".loader").hide();
            
    }

    function changeClosingStatus(id){
      $.ajax({
          method:"POST",
          type:"json",
          data:{"id":id,"getDCForStatus":"getDCForStatus"},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            var count=0;
            $("tbody#returnableParts").html("");
            $.each(JSON.parse(data).info,function(i,info){
              count+=1;
              $("tbody#returnableParts").append("<tr>"
                +"<td><input type='text' name='statusChPartId"+i+"' class='form-control' "
              +"value='"+info.partId+"' readonly/></td>"
              +"<td><input type='text' name='statusChPartNo"+i+"' class='form-control' "
              +"value='"+info.partNo+"' readonly/></td>"
              +"<td><input type='text' name='statusChPartQty"+i+"' class='form-control' "
              +"value='"+info.qty+"' readonly/></td>"
              +"<td><input type='text' name='statusChSerialNoOld"+i+"' class='form-control' "
              +"value='"+info.serials+"' readonly/></td>"
              +"<td><input type='text' name='statusChSerialNoNew"+i+"' class='form-control' /></td>"
              +"</tr>");
            }); 
            $("#returnableView").modal();            
            $("input[name='count']").val(JSON.parse(data).particularCount);
            $("input[name='statusChId']").val(JSON.parse(data).info[0].challanId);
          },
          error:function(error){

          }
      });
    }    
    
    function printChallan(id){
      var copy = prompt("Please enter copy");
      if (copy != null) {
          window.open("../php/dc.php?id="+id+"&copy="+copy, "_blank");
      }
    }

    function editChallan(id){
      window.open("editChallan.php?id="+id+"", "_self");
    }   

    function deleteChallan(id){
      var c = confirm("Do you really want to delete "+id+"?");
      if(c){
        $.ajax({
          method:"POST",
          type:"json",
          data:{"dcId":id,"deleteDC":"deleteDC"},
          url:"../php/dc.php",
          success:function(data){
            console.log(data);
            location.reload();
          }});
      }
    }
    </script>
  </body>
</html>
