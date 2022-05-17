<html>

<head>
    <meta name="charset" content="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Control System|Admin</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
    <link rel="stylesheet" href="../css/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/datatable/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <style media="screen">
    .row {
        margin-bottom: 2%;
    }

    .row>.box {
        padding: 2%;
        border: 1px solid lightgray;
        border-radius: 14px;
        text-align: center;
        margin-bottom: 0.5%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    .box>h1 {
        color: #000;
    }

    .box>a {
        color: #fff;
        position: relative;
        bottom: 0px;
    }

    .box>a:hover {
        text-decoration: none;
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


    .bg-red {
        background-color: #ff0700;
    }

    .bg-pink {
        background-color: #FF4081
    }

    .bg-orange {
        background-color: #f39c12;
    }

    .bg-purple {
        background-color: #605ca8;
    }

    .bg-green {
        background-color: #1AB394;
    }

    .bg-darkblue {
        background-color: #3F51B5;
    }

    .bg-gray {
        background-color: #8b8b8c;
    }

    .ribbon {
        width: 48%;
        height: 188px;
        position: relative;
        float: left;
        margin-bottom: 30px;
        text-transform: uppercase;
        color: white;
    }

    .ribbon1 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #E53935;
    }

    .ribbon1:before,
    .ribbon1:after {
        content: "";
        position: absolute;
    }

    .ribbon1:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon1:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #E53935;
    }

    .ribbon2 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #FF1744;
    }

    .ribbon2:before,
    .ribbon2:after {
        content: "";
        position: absolute;
    }

    .ribbon2:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon2:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #FF1744;
    }

    .ribbon3 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #F06292;
    }

    .ribbon3:before,
    .ribbon3:after {
        content: "";
        position: absolute;
    }

    .ribbon3:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon3:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #F06292;
    }

    .ribbon4 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #BA68C8;
    }

    .ribbon4:before,
    .ribbon4:after {
        content: "";
        position: absolute;
    }

    .ribbon4:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon4:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #BA68C8;
    }

    .ribbon5 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #512DA8;
    }

    .ribbon5:before,
    .ribbon5:after {
        content: "";
        position: absolute;
    }

    .ribbon5:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon5:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #512DA8;
    }

    .ribbon6 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #43A047;
    }

    .ribbon6:before,
    .ribbon6:after {
        content: "";
        position: absolute;
    }

    .ribbon6:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon6:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #43A047;
    }

    .ribbon7 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #F57F17;
    }

    .ribbon7:before,
    .ribbon7:after {
        content: "";
        position: absolute;
    }

    .ribbon7:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon7:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #F57F17;
    }

    .ribbon8 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #F4511E;
    }

    .ribbon8:before,
    .ribbon8:after {
        content: "";
        position: absolute;
    }

    .ribbon8:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon8:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #F4511E;
    }

    .ribbon9 {
        width: 85%;
        height: 50px;
        line-height: 50px;
        padding-left: 15px;
        position: absolute;
        left: -8px;
        top: 20px;
        color: #fff;
        background: #59324C;
    }

    .ribbon9:before,
    .ribbon9:after {
        content: "";
        position: absolute;
    }

    .ribbon9:before {
        height: 0;
        width: 0;
        /*top: -8.5px;*/
        left: 0.1px;
        /*border-bottom: 9px solid black;*/
        border-left: 9px solid transparent;
    }

    .ribbon9:after {
        height: 0;
        width: 0;
        right: -14.5px;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 15px solid #59324C;
    }
    </style>
</head>

<body>
    <?php include "menu.php"; ?>

    <div class="container-fluid content">

        <?php if($_COOKIE["userrole"]=="admin" || $_COOKIE["userrole"]=="superadmin"){ ?>
        <!-- <div class="row">
            <div class="col-md-1">
                <a href="parts.php"><span class="ribbon1">Parts</span></a>
            </div>
            <div class="col-md-1">
                <a href="register.php"><span class="ribbon2">User</span></a>
            </div>
            <div class="col-md-1">
                <a href="vendor.php"><span class="ribbon3">Vendor</span></a>
            </div>
            <div class="col-md-1">
                <a href="error.php"><span class="ribbon4">Error code</span></a>
            </div>
            <div class="col-md-1">
                <a href="customers.php"><span class="ribbon5">Customer</span></a>
            </div>
            <div class="col-md-1">
                <a href="machine.php"><span class="ribbon6">Machines</span></a>
            </div>
            <div class="col-md-1">
                <a href="purchaseorder.php"><span class="ribbon7">PO</span></a>
            </div>
            <div class="col-md-1">
                <a href="stock.php"><span class="ribbon8">Stock</span></a>
            </div>
            <div class="col-md-1">
                <a href="quotation.php"><span class="ribbon9">Quotation</span></a>
            </div>
            <div class="col-md-1">
                <a href="invoice.php"><span class="ribbon8">Invoice</span></a>
            </div>
            <div class="col-md-1">
                <a href="challan.php"><span class="ribbon7">Challan</span></a>
            </div>
            <div class="col-md-1">
                <a href="creditnote.php"><span class="ribbon6">Credit Note</span></a>
            </div>
        </div>
        <div class="row" style="margin-top: 5%;">
            <div class="col-md-3"></div>
            <div class="col-md-2">
                <a href="debitnote.php"><span class="ribbon5">Debit Note</span></a>
            </div>
            <div class="col-md-2">
                <a href="spr.php"><span class="ribbon4">SPR</span></a>
            </div>
            <div class="col-md-2">
                <a href="sh.php"><span class="ribbon1">Service</span></a>
            </div>

        </div> -->
        <?php }?>
        <div class="row">
            <div class="col-md-12" style="float:none; margin:0 auto;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed" id="myTable">
                        <thead>
                            <tr>
                                <th>Part No.</th>
                                <th>Description</th>
                                <th>Available</th>
                                <th>Min Quantity</th>
                                <th>Location</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Part No.</th>
                                <th>Description</th>
                                <th>Available</th>
                                <th>Min Quantity</th>
                                <th>Location</th>
                                <th>Country</th>
                            </tr>
                        </tfoot>
                        <tbody id="stockList">

                        </tbody>
                    </table>
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
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/datatable/jquery.dataTables.min.js" charset="utf-8"></script>
    <script src="../js/datatable/dataTables.buttons.min.js" charset="utf-8"></script>
    <script src="../js/datatable/jszip.min.js" charset="utf-8"></script>
    <script src="../js/datatable/pdfmake.min.js" charset="utf-8"></script>
    <script src="../js/datatable/vfs_fonts.js" charset="utf-8"></script>
    <script src="../js/datatable/buttons.html5.min.js" charset="utf-8"></script>
    <script src="../js/custom.js" charset="utf-8" type="text/javascript"></script>
    <script type="text/javascript">
    var all = [];
    var available = [];
    var avail = "";

    $(document).ready(function() {
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


        jQuery.fn.DataTable.Api.register('buttons.exportData()', function(options) {
            console.log(options);
            //console.log(this.context[0].sTableId)
            var rs = '';
            if (this.context.length) {
                var jsonResult = $.ajax({
                    url: '../php/getHomePageData.php?page=all',
                    data: {
                        search: {
                            value: $("#myTable_filter input").val()
                        }
                    },
                    method: 'post',
                    success: function(result) {
                        console.log(result);
                        rs = JSON.parse(result);
                    },
                    error: function(error) {
                        console.log(error);
                    },
                    async: false
                });
                return {
                    body: rs.aaData,
                    header: $("#myTable thead tr th").map(function() {
                        return this.innerHTML;
                    }).get(),
                    options: options
                };
                //return {body: rs.aaData, header: ["Part No.", "Description" ,"Available", "Min", "Location (Rack - Column)",  "Country"],options:options};
                // console.log(jsonResult); return;
            }

        });

        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5',
                    title: "Home List",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5'
                })
            ],
            'ordering': false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '../php/getHomePageData.php'
            },
            "deferRender": true,
            'columns': [{
                    data: 'part_number'
                },
                {
                    data: 'description'
                },
                {
                    data: 'count'
                },
                {
                    data: 'min'
                },
                {
                    data: 'location'
                },
                {
                    data: 'country'
                }
            ],
            "columnDefs": [{
                "targets": [0, 2],
                "createdCell": function(td, cellData, rowData, row, col) {
                    console.log(rowData.count + "   " + rowData.min);
                    if (rowData.count < rowData.min && rowData.count != 27) {
                        $(td).addClass('blink_me')
                    }
                }
            }]
        });
        if ($.cookie("userrole") == "engineer") {
            $('#myTable').DataTable().buttons(['.buttons-copy', '.buttons-excel', '.buttons-pdf']).disable();
        } else {
            $('#myTable').DataTable().buttons(['.buttons-copy', '.buttons-excel', '.buttons-pdf']).enable();
        }

        $(".loader").hide();
        $("body").show();
    });

    function getLastBackup() {
        $.ajax({
            method: "POST",
            type: "json",
            data: {
                "lastBackup": "lastBackup"
            },
            url: "../php/backup.php",
            success: function(data) {
                //console.log(data);
                var last = data.split("_");
                //console.log(last[0]);
                var date1 = new Date(last[0]);
                var date2 = new Date();
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                if (diffDays > 30) {
                    var c = confirm(
                        "Last backup took 30 days back!\n Try Backing up your data for safety!!");
                    if (c) {
                        location.href = "backup.php";
                    }
                }
                $(".loader").hide();
                $("body").show();
            },
            error: function(error) {}
        });
    }
    </script>
</body>

</html>