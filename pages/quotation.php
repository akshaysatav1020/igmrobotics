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
  <title>Inventory Control System| Quotation</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font.css">
  <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../css/datepicker.css">
   <link href="../css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/custom.css">
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

    input[type=radio] {
      display: none;
    }

    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #ddd;
    }

    label[for*='1'],
    label[for*='2'],
    label[for*='3'],
    label[for*='4'] {
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

    label[for*='1']:before {
      content: '\f1c1';
    }

    label[for*='2']:before {
      content: '\f06e';
    }

    label:hover {
      color: #888;
      cursor: pointer;
    }

    input:checked+label {
      color: #555;
      border: 1px solid #ddd;
      border-top: 2px solid orange;
      border-bottom: 1px solid #fff;
    }

    #tab1:checked~#content1,
    #tab2:checked~#content2,
    #tab3:checked~#content3,
    #tab4:checked~#content4 {
      display: block;
    }

    @media screen and (max-width: 650px) {
      label[for*='1'],
      label[for*='2'],
      label[for*='3'],
      label[for*='4'] {
        font-size: 0;
      }
      label[for*='1']:before,
      label[for*='2']:before,
      label[for*='3']:before,
      label[for*='4']:before {
        margin: 0;
        font-size: 18px;
      }
    }

    @media screen and (max-width: 400px) {
      label[for*='1'],
      label[for*='2'],
      label[for*='3'],
      label[for*='4'] {
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
        <label for="tab1">Generate Quotation</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">View List</label>
        <section id="content1">
          <form class="add" action="../php/quotation.php" method="POST">
            <div class="col-md-2">
              <div class="form-group">
                <label>Project No.</label>
                <input class="form-control" name="projectno"/>                  
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="to">Customer</label>
                <select class="form-control" name="customer" >
                  <option value="">Select Customer</option>
                               
                </select>
              </div>
            </div>
           
            <div class="col-md-2">
              <div class="form-group">
                <label>Quotation No.</label>
                <input type="text" name="quotationnumber" class="form-control" readonly/>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Quotation Date</label>
                <div id="datepicker" class="input-group date">
                  <input class="form-control" name="date" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Reference No.</label>
                <input type="text" name="refno" class="form-control" required="required" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Reference Date</label>
                <div id="datepicker" class="input-group date">
                  <input class="form-control" name="refdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>                
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Valid Until</label>
                <div id="datepicker" class="input-group date">
                  <input class="form-control" name="validdate" type="text" >
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>IGST(%)</label>
                <input class="form-control number" name="igst"  />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Packaging &amp; Forwarding</label>
                <input class="form-control number" name="packaging"  />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Terms &amp; Condition</label>
                <textarea class="form-control" name="terms" placeholder="Enter terms and condition here" ></textarea>
              </div>
            </div>
            <div class="col-md-3" style="padding:2%;">
              <button class="btn btn-default addpart" type="button">Add Part</button>
            </div>
            <div class="col-md-12">              
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-condensed or">
                    <thead>
                      <tr>
                        
                        <th>Part No.</th>
                        <th>Part Id</th>
                        <th>Description</th>
                        <th>Unit Price</th>                        
                        <!-- <th>Selling Cost</th> -->
                        <th>Qty</th>
                        <th>Discount %</th>
                        <!-- <th>Discounted Price</th> -->
                        <th>Tax %</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody id="parts"> 
                    </tbody>
                  </table>
                </div>              
            </div>
            <div class="col-md-3" style="padding:2%;">
              <button type="submit" name="generateQuot" class="btn btn-info">Generate</button>
            </div>
          </form>
        </section>
        <section id="content2">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed" id="myTable">
              <thead>
                <tr>
                  <th>Quotation No.</th>
                  <th>Customer</th>
                  <th>Quotation Date</th>
                  <th>Valid Date</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Quotation No.</th>
                  <th>Customer</th>
                  <th>Quotation Date</th>
                  <th>Valid Date</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody id="quoList">
              
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
  <script src="../js/bootstrap-datepicker.js" charset="utf-8" type="text/javascript"></script>
  <script src="../js/custom.js" charset="utf-8" type="text/javascript"></script>
  <script type="text/javascript">
    $("header,.container-fluid,footer").hide();
    $(".loader").show();
    var partIndex = 0;
    var addPartIds = [];
    var removePartIds = [];   
    var customers;
    var prefix = "";
    var inwardno=[];
    $(window).bind("load", function () {
      checkNetworkStatus();
      
      if ($.cookie("status") == "Offline") {
        $("button[name='generateQuot']").attr("disabled", "disabled");
      }
    });
    $(document).ready(function () {
       getQuoNo();
       getQuotations();
       $("select[name='customer']").select2({
        minimumInputLength: 2,tags: [],
        width: "100%",
        ajax: {
          url: "../php/quotation.php",
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
              term: term,
              customersForQuo:'customersForQuo'       
            };
          },
          processResults: function (data) {
            console.log(data);
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.company,
                  slug: item.company,
                  id: item.id
                }
              })
            };
          }
        }
      });


      $("input[name='date'],input[name='refdate'],input[name='validdate']").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
      });

      $(".addpart").attr("disabled", "disabled");

      $("select[name='customer']").on("change", function () {
        $(".addpart").removeAttr("disabled");
      });
      
      $(".addpart").click(function () {
        partIndex++;
        addPartIds.push(partIndex);
        addPart();
      });

      $("table.or").on("change", ".part", function (event) {
        var id = $(this).attr("name").substr(6);
        var val = $(this).val().split("~");
        var val = $(this).val().split('*');
        //console.log(val);        
        $("input[name='partId"+id+"']").val(val[0]);
        $("textarea[name='description" + id + "']").val(val[2]);
        if(val[4]!="0.00"){
            $("input[name='unitprice"+id+"']").val(val[4]);
        }else{
            $("input[name='unitprice"+id+"']").val(val[3]);
        }
        
      });

      $("table.or").on("keyup", ".qty", function (event) {
        var id = $(this).attr("name").substr(8);
        $("input[name='tax" + id + "'],input[name='discount" + id + "'],input[name='amount" + id + "']").val("0");
      });


      $("table.or").on("keyup", ".discount", function (event) {
        var id = $(this).attr("name").substr(8);
        var up = parseFloat($("input[name='unitprice"+id+"']").val());
        var qty = parseFloat($("input[name='quantity"+id+"']").val());
        var discount = parseFloat($(this).val())/100;
        var discountedAmt = up - (up*discount);
        $("input[name='amount" + id + "']").val(discountedAmt*qty);
      });
      

      $("table.or").on("keyup", ".tax", function (event) {
        var id = $(this).attr("name").substr(3);
        var up = parseFloat($("input[name='unitprice"+id+"']").val());
        var qty = parseFloat($("input[name='quantity"+id+"']").val());
        var discount = parseFloat($(this).val())/100;
        var discountedAmt = up - (up*discount);
        var tax = parseFloat($(this).val())/100;
        var taxAmount = discountedAmt + (discountedAmt*tax);
        $("input[name='amount" + id + "']").val(taxAmount*qty);
      });

      $("table.or").on("click", ".removepart", function (event) {
        removePartIds.push(parseInt($(this).attr("id")));
        $(this).closest("tr").remove();
      });

      $("form.add").submit(function (event) {
        //event.preventDefault();
        $("select[name='customer']").removeAttr("disabled");
        var formData = $(this).serializeArray();
        var diff = $(addPartIds).not(removePartIds).get();
        $(this).append("<input type='hidden' name='ids' value='" + diff + "'/>");
        //location.reload();
      });
    });

    function addPart() {
      var element = "";
      element = "<tr>"        
        + "<td >"
        + "<select style='width:150px;' class='form-control part' name='partno" + partIndex + "'><option value='default'>Select part</option></select>"
        + "</td>"
        + "<td >"
        + "<input style='width:150px;' class='form-control' name='partId" + partIndex + "' type='text' readonly/>"
        + "</td>"
        + "<td >"
        + "<textarea style='width:150px;' class='form-control' name='description" + partIndex + "'></textarea>"
        + "</td>"
        + "<td>"
        + "<input style='width:150px;' type='text' class='form-control' name='unitprice" + partIndex + "' readonly>"
        + "</td>"        
        + "<td >"
        + "<input style='width:50px;' type='text' class='form-control number qty' name='quantity" + partIndex + "'>"
        + "</td>"        
        + "<td >"
        +"<input style='width:50px;' class='form-control discount' name='discount"+partIndex+"' />"
        + "</td>"
        + "<td >"
        + "<input style='width:50px;' type='text' class='form-control number tax' name='tax" + partIndex + "'/>"
        + "</td>"
        + "<td >"
        + "<input style='width:200px;' type='text' class='form-control amount' name='amount" + partIndex + "' readonly>"
        + "</td>"
        + "<td >"
        + "<button  type='button' class='btn btn-sm btn-warning removepart' id=" + partIndex + ">-</button>"
        + "</td>"
        + "</tr>";
      $("#parts").append(element);
		  $("select[name='partno" + partIndex + "']").select2({
        minimumInputLength: 1,tags: [],
        ajax: {
          url: "../php/quotation.php",
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
              term: term,
              partsForQuoParticular:'partsForQuoParticular'       
            };
          },
          processResults: function (data) {
            console.log(data);
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.part_number,
                  slug: item.part_number,
                  id: item.id+"*"+item.part_number+"*"+item.description+"*"+item.upi+"*"+item.lc
                }
              })
            };
          }
        }
      });
    }

    function getQuoNo() {
      $.ajax({
        method: "POST",
        type: "json",
        url: "../php/quotation.php",
        data: { "getLastQuote": "getLastQuote"},
        success: function (data){
          var lastQuo = data.split('/');
          var currQuo = "IGM/";
          var currFisicalYear =
              parseInt((new Date()).getMonth() + 1) > 3 ?
              (new Date()).getFullYear() + "-" + ((((new Date()).getFullYear() + 1).toString())
                  .substr(-2)) :
              ((new Date()).getFullYear() - 1) + "-" + ((((new Date()).getFullYear()).toString())
                  .substr(-2));
          if (lastQuo[1] == currFisicalYear) {
              currQuo += currFisicalYear;
              if (parseInt(lastQuo[2]) <= 9) {
                  currQuo += "/00" + (parseInt(lastQuo[2]) + 1);
              } else if (parseInt(lastQuo[2]) <= 99) {
                  currQuo += "/0" + (parseInt(lastQuo[2]) + 1);
              } else {
                  currQuo += (parseInt(lastQuo[2]) + 1);
              }
          } else {
              currQuo += currFisicalYear + "/001";
          }
          $("input[name='quotationnumber']").val(currQuo); 
          $("header,.container-fluid,footer").show();
          $(".loader").hide();
        },error: function (error) {}
      });      
    }

    function getQuotations() {      
      var buttonCommon = {
            exportOptions: {
              format: {
                body: function (data, row, column, node) {
                  // Strip $ from salary column to make it numeric
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
                'url': '../php/quotation.php',
                "data": {
                    "getAllQuo": "getAllQuo"
                }
            },
            columns: [{
                    data: 'quo_no',//qno
                    render: function(data, type, row) {
                        return ("<td style='width:30vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'customer',//customer
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'quotDate',//qdate
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'validity',//validdate
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'totAmt',//amt
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },                
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" +
                            "<button class='btn btn-sm btn-success' onclick='printQuo(" + data +
                            ")'>Print</button> " +
                            "<button class='btn btn-sm btn-warning' onclick='editQuot(" + data +
                            ")'>Edit</button> " +
                            "<button class='btn btn-sm btn-danger' onclick='deleteQuo(" + data +
                            ")'>Delete</button></td>");
                    }
                }

            ],
            buttons: [
              $.extend(true, {}, buttonCommon, {
                extend: 'copyHtml5', exportOptions: { columns: [0, 1, 2, 3, 4] }
              }),
              $.extend(true, {}, buttonCommon, {
                extend: 'excelHtml5', title: "Quotation List", exportOptions: { columns: [0, 1, 2, 3, 4] }
              }),
              $.extend(true, {}, buttonCommon, {
                extend: 'pdfHtml5', title: "Quotation List", exportOptions: { columns: [0, 1, 2, 3, 4] }
              })
            ]
          });      
    }

    function printQuo(id) {            
      window.open("../php/quotation.php?id=" + id + "", "_blank");
    }

    function editQuot(id) {
      window.open("editQuot.php?type=quo&id=" + id + "", "_self");
    }

    function deleteQuo(id) {
      var c = confirm("Do you really want to delete " + id + "?");
      if (c) {
        $.ajax({
          method: "POST",
          type: "json",
          data: { "deleteQuo": "deleteQuo", "qId": id },
          url: "../php/quotation.php",
          success: function (data) {
            alert("Deleted");
            location.reload();
          }, error: function (error) {
            alert("Error Deleting");
          }
        });
      }
    }
  </script>
</body>

</html>