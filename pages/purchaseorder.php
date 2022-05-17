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
    <link rel="stylesheet" href="../css/datepicker.css">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/custom.css">

    <style media="screen">
    textarea.form-control {
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

    .blink_me {
        color: red;
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
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
                <label for="tab1">Generate PO</label>
                <input id="tab2" type="radio" name="tabs">
                <label for="tab2">PO List</label>
                <input id="tab3" type="radio" name="tabs">
                <label for="tab3">PO Tracking</label>
                <section id="content1">
                    <form class="po" action="../php/po.php" method="POST">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Project No.</label>
                                <input class="form-control" name="projectno" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Vendor</label>
                                <select class="form-control" name="vendor" required="required"></select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Purchase Order No.</label>
                                <input type="text" name="ponumber" class="form-control" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>PO Date</label>
                                <div id="datepicker" class="input-group date">
                                    <input class="form-control" name="podate" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>PO Validity Date</label>
                                <div id="datepicker" class="input-group date">
                                    <input class="form-control" name="poValidityDate" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quotation No.</label>
                                <input class="form-control" name="quotenumber" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quotation Date</label>
                                <div id="datepicker" class="input-group date">
                                    <input class="form-control" name="quotationdate" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Packaging Amount</label>
                                <input class="form-control number" name="pack" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label >Currency</label>
                                <select class="form-control" name="currency">
                                    <option value="">Select Currency</option>
                                    <option value="eur">EURO</option>
                                    <option value="inr">INR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Conversion Rate</label>
                                <input class="form-control" name="eurorate" type="text">
                            </div>
                        </div>                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Discount %</label>
                                <input class="form-control" name="discount" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>IGST %</label>
                                <input class="form-control" name="igst" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Delivery Terms</label>
                                <select class="form-control" name="deliveryTerms">
                                    <option value="">Select</option>
                                    <option value="CIF">CIF</option>
                                    <option value="DAP">DAP</option>
                                    <option value="DDP">DDP</option>
                                    <option value="EXW Place">EXW Place</option>
                                    <option value="Courier Charges">Courier Charges</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Payment Terms</label>
                                <select class="form-control" name="paymentTerms">
                                    <option value="">Select</option>
                                    <option value="100%">100%</option>
                                    <option value="30 Days Credit">30 Days Credit</option>
                                    <option value="60 Days Credit">60 Days Credit</option>
                                    <option value="50% in advance and 50% after receival of invoice">50% in advance and
                                        50% after receival of invoice</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="terms">Terms &amp; Condition</label>
                                <textarea class="form-control" name="terms"
                                    placeholder="Enter terms and condition here"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding:2%;">
                            <button class="btn btn-default addpartnew" type="button">Order New Part</button>
                            <button class="btn btn-default addpart" type="button">Order Existing Part</button>
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
                                                <th>Unit Price</th>
                                                <!-- <th>Unit Price(INR)</th>-->
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <!-- <th>Amount(INR)</th>-->
                                            </tr>
                                        </thead>
                                        <tbody id="parts">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="generatePO" class="btn btn-info">Generate</button>
                        </div>
                    </form>
                </section>
                <section id="content2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed" id="myTable">
                            <thead>
                                <tr>
                                    <th>Purchase Order No.</th>
                                    <th>Vendor</th>
                                    <th>Quotation Number</th>
                                    <th>Currency</th>
                                    <th>Total Amount</th>
                                    <!-- <th>Total Amount(EURO)</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Purchase Order No.</th>
                                    <th>Vendor</th>
                                    <th>Quotation Number</th>
                                    <th>Currency</th>
                                    <th>Total Amount</th>
                                    <!-- <th>Total Amount(EURO)</th>-->
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody id="poList"></tbody>
                        </table>
                    </div>
                </section>
                <section id="content3">
                    <div class="tableresponsive">
                        <table class="table table-bordered table-condensed" id="myTable1">
                            <thead>
                                <tr>
                                    <th>PO No.</th>
                                    <th>Part No</th>
                                    <th>Ordered</th>
                                    <th>Received</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>PO No.</th>
                                    <th>Part No</th>
                                    <th>Ordered</th>
                                    <th>Received</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
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

    <div class="modal fade" id="addToMaster" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Inventory Part</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Part Number</label>
                                <input type="text" class="form-control" name="partnumber" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Description</label>
                                <input type='text' class="form-control" name="description" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country">
                                    <option value="">Select</option>                                    
                                    <option value="India">India</option>
                                    <option value="Austria">Austria</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Location</label>
                                <input class="form-control" name="location" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Euro Price</label>
                                <input class="form-control" name="europrice" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>INR Price</label>
                                <input class="form-control" name="inrprice" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Minimum Stock Quantity</label>
                                <input class="form-control" name="min" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-success" type="button" name="addpart">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updatePOTrackModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update</h4>
                </div>
                <div class="modal-body">
                    <form action="../php/po.php" method="post">
                        <div class="col-md-4 hide">
                            <div class="form-group">
                                <label>Id</label>
                                <input type="text" class="form-control" name="poTrackId" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>PO No.</label>
                                <input type="text" class="form-control" name="poNo" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Part No</label>
                                <input type='text' class="form-control" name="partNo" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ordered</label>
                                <input class="form-control" name="ordered" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Received</label>
                                <input class="form-control" name="received" />
                            </div>
                        </div>
                        <div class="col-md-2" >
                            <div class="form-group">
                                <button class="btn btn-success" type="submit" name="updatePOTrack">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
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
    var partsData = localStorage.getItem('parts');
    var vendors;
    var prefix = "";
    var eurorate = 0;
    $(window).bind("load", function() {
        checkNetworkStatus();
        if ($.cookie("status") == "Offline") {
            $("button[name='generatePO']").attr("disabled", "disabled");
        }
    });
    $(document).ready(function() {
        getPoNo();
        
        $("select[name='vendor']").select2({
            minimumInputLength: 2,
            tags: [],
            width: '100%',
            templateResult: function formatState(state) {
                //console.log(state);
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
                url: "../php/po.php",
                allowClear: true,
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function(term) {
                    return {
                        term: term,
                        vendorsForPO: 'vendorsForPO'
                    };
                },
                processResults: function(data) {
                    if (data != "") {
                        console.log(data);
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


        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function(data, row, column, node) {
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
                'url': '../php/po.php',
                "data": {
                    "getAllPO": "getAllPO"
                }
            },
            columns: [{
                    data: 'po_no',
                    render: function(data, type, row) {
                        return ("<td style='width:30vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'vendor',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'q_no',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'currency',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'totAmt',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },
                /*{
                    data: 'totAmtEURO',
                    render: function(data, type, row) {
                        return ("<td style='width:10vw;'>" + data + "</td>");
                    }
                },*/
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" +
                            "<button class='btn btn-sm btn-success' onclick='printPO(" + data +
                            ")'>Print</button> " +
                            "<button class='btn btn-sm btn-warning' onclick='editPo(" + data +
                            ")'>Edit</button> " +
                            "<button class='btn btn-sm btn-danger' onclick='deletePo(" + data +
                            ")'>Delete</button></td>");
                    }
                }

            ],
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5',
                    title: "Purchase Order List",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5',
                    title: "Purchase Order List",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                })
            ]
        });



        var buttonCommon1 = {
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
        $('#myTable1').DataTable({
            'dom': 'Bfrtip',
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '../php/po.php',
                "data": {
                    "getAllPoTrack": "getAllPoTrack"
                }
            },
            "deferRender": true,
            columns: [{
                    data: 'po_no',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'part_number',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'ordered',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'received',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" + data + "</td>");
                    }
                },
                {
                    data: 'po_track_id',
                    render: function(data, type, row) {
                        return ("<td style='width:20vw;'>" +
                            "<button class='btn btn-sm btn-warning' onclick='editPOTrack(" +
                            data +
                            ")'>Edit</button></td>");
                    }
                }

            ],
            buttons: [
                $.extend(true, {}, buttonCommon1, {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }),
                $.extend(true, {}, buttonCommon1, {
                    extend: 'excelHtml5',
                    title: "Purchase Order List",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }),
                $.extend(true, {}, buttonCommon1, {
                    extend: 'pdfHtml5',
                    title: "Purchase Order List",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                })
            ]
        });


        if ($.cookie("userrole") == "finance" || $.cookie("userrole") == "service") {
            $("input[id='tab1'],label[for='tab1']").hide();
            $("input[id='tab3'],label[for='tab3']").hide();
            $("input[id='tab2']").attr("checked", "checked");
        }
      

        $("input[name='podate'],input[name='poValidityDate'],input[name='quotationdate']").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $(".addpart").click(function() {
            partIndex++;
            addPartIds.push(partIndex);
            addPart();
        });

        $("button.addpartnew").click(function() {
            $("#addToMaster").modal();
        });

        $("button[name='addpart']").click(function() {
            $.ajax({
                method: "POST",
                type: "json",
                data: {
                    "partnumber": $("input[name='partnumber']").val(),
                    "description": $("input[name='description']").val(),
                    "country": $("select[name='country']").val(),
                    "location": $("input[name='location']").val(),
                    "europrice": $("input[name='europrice']").val(),
                    "inrprice": $("input[name='inrprice']").val(),
                    "min": $("input[name='min']").val(),
                    "addPartToMaster": "addPartToMaster"
                },
                url: "../php/po.php",
                success: function(data) {
                    alert(data);
                    $("input[name='partnumber'], input[name='description'], select[name='country']," +
                        "input[name='location'], input[name='inrprice'], input[name='europrice']," +
                        "input[name='min']").val("");
                    $("#addToMaster").modal('hide');
                }
            });
        });
        $("table.or").on("change", ".part", function(event) {
            var id = $(this).attr("name").substr(6);
            var val = $(this).val().split("*");
            console.log(id);
            $("input[name='partId" + id + "']").val(val[0]);
            $("textarea[name='description" + id + "']").html(val[2]);
            if($("select[name='currency']").val()=="eur"){
                $("input[name='up" + id + "']").val(val[3]);

            }else{
                $("input[name='up" + id + "']").val(val[4]);
            }
        });
        $("table.or").on("input", ".qty", function(event) {
            var qty = parseInt($(this).val());
            var id = $(this).attr("name").substr(8);
            var up = parseFloat($("input[name='up" + id + "']").val());
            //var upi = parseFloat($("input[name='upi" + id + "']").val());
            console.log(id);
            $("input[name='st" + id + "']").val(qty * up);
            //$("input[name='sti" + id + "']").val(qty * upi);
        });
        $("table.or").on("click", ".removepart", function(event) {
            removePartIds.push(parseInt($(this).attr("id")));
            $(this).closest("tr").remove();
        });
        $("form").submit(function(event) {
            //event.preventDefault();
            var formData = $(this).serializeArray();
            var diff = $(addPartIds).not(removePartIds).get();
            $(this).append("<input type='hidden' name='ids' value='" + diff + "'/>");
            localhost.reload();
        });
    });

    function editPOTrack(id) {
        console.log(id);
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "id": id,
                "getPOTrack": "getPOTrack"
            },
            url: "../php/po.php",
            success: function(data) {
                console.log(data);
                if (data != "") {
                    var info = JSON.parse(data);
                    $("input[name='poTrackId']").val(info.po_track_id);
                    $("input[name='poNo']").val(info.po_no);
                    $("input[name='partNo']").val(info.part_no);
                    $("input[name='ordered']").val(info.ordered);
                    $("input[name='received']").val(info.received);
                    $("#updatePOTrackModal").modal();
                }
            },
            error: function() {

            }
        });
    }

    function addPart() {
        var element = "";
        element = "<tr>" +
            "<td>" +
            "<select class='form-control part' id='" + partIndex + "' name='partno" + partIndex +
            "'><option value=''>Select part</option></select>" +
            "</td>" +
            "<td><input type='text' class='form-control' name='partId" + partIndex + "' value='' readonly/></td>" +
            "<td>" +
            "<textarea class='form-control' name='description" + partIndex + "' readonly required></textarea>" +
            "</td>" +
            "<td>" +
            "<input type='text' class='form-control number up' name='up" + partIndex + "' readonly required>" +
            "</td>" +
            //"<td>" +
            //"<input type='text' class='form-control upi' name='upi" + partIndex + "' readonly required/>" +
            //"</td>" +
            "<td>" +
            "<input type='text' class='form-control qty' name='quantity" + partIndex + "'  required>" +
            "</td>" +
            //"<td>" +
            //"<input type='text' class='form-control ste' name='ste" + partIndex + "'" + " readonly required/>" +
            //"</td>" +
            "<td>" +
            "<input type='text' class='form-control st' name='st" + partIndex + "' readonly required/>" +
            "</td>" +
            "<td>" +
            "<button type='button' class='btn btn-sm btn-warning removepart' id='" + partIndex + "'>-</button>" +
            "</td>" +
            "</tr>";
        $("#parts").append(element);
        $("select[name='partno" + partIndex + "']").select2({
            minimumInputLength: 1,
            width:'100%',
            tags: [],
            ajax: {
                url: "../php/po.php",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function(term) {
                    return {
                        term: term,
                        partsForPOParticular: 'partsForPOParticular'
                    };
                },
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.part_number,
                                slug: item.part_number,
                                id: item.id + "*" + item.part_number+ "*" + item.description+ "*" + item.upe
                                + "*" + item.upi
                            }
                        })
                    };
                }
            }
        });
    }

    function printPO(id) {
        window.open("../php/po.php?id=" + id + "", "_blank");
    }

    function editPo(id) {
        window.open("editPo.php?id=" + id + "", "_self");
    }

    function deletePo(id) {
        var c = confirm("Do you really want to delete " + id + "?");
        if (c) {
            $.ajax({
                method: "POST",
                type: "json",
                data: {
                    "deletePO": "deletePO",
                    "poId": id
                },
                url: "../php/po.php",
                success: function(data) {
                    alert("Deleted");
                    location.reload();
                },
                error: function(error) {
                    alert("Error Deleting");
                }
            });
        }

    }

    function getPoNo() {
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "getLastPO": "getLastPO"
            },
            url: "../php/po.php",
            success: function(data) {
                var lastPO = data.split('/');
                var currPO = "IGM/";
                var currFisicalYear =
                    parseInt((new Date()).getMonth() + 1) > 3 ?
                    (new Date()).getFullYear() + "-" + ((((new Date()).getFullYear() + 1).toString())
                        .substr(-2)) :
                    ((new Date()).getFullYear() - 1) + "-" + ((((new Date()).getFullYear()).toString())
                        .substr(-2));
                if (lastPO[1] == currFisicalYear) {
                    currPO += currFisicalYear;
                    if (parseInt(lastPO[2]) <= 9) {
                        currPO += "/00" + (parseInt(lastPO[2]) + 1);
                    } else if (parseInt(lastPO[2]) <= 99) {
                        currPO += "/0" + (parseInt(lastPO[2]) + 1);
                    } else {
                        currPO += (parseInt(lastPO[2]) + 1);
                    }
                } else {
                    currPO += currFisicalYear + "/001";
                }
                $("input[name='ponumber']").val(currPO);
            }
        });
        $("header,.container-fluid,footer").show();
        $(".loader").hide();
    }
    </script>
</body>

</html>