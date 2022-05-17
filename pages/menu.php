<?php
$role = $_COOKIE["userrole"];
$userId= $_COOKIE["userId"];
//echo "<script>alert('".basename($_SERVER["PHP_SELF"])."');</script>";
$curr = basename($_SERVER["PHP_SELF"]);
?>


<header>
<nav class='navbar navbar-default'>
  <div class='container-fluid'>
    <div class='navbar-header'>
        <a class="navbar-brand" href="adminhome.php"><img src="../images/logo.png" style="max-width:8vw;"
                        class="img img-responsive" alt="logo"></a>
      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
    </div>
    <div class='collapse navbar-collapse' id='myNavbar'>
      <ul class='nav navbar-nav'>
<?php 
    switch($role){
        case 'superadmin':
?>
            <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                    <li class='<?php if($curr=="register.php"){echo "active";}else{ echo "";}?>'><a href='register.php'>Users</a></li>
                    <li class='<?php if($curr=="vendor.php"){echo "active";}else{ echo "";}?>'><a href='vendor.php'>Vendors</a></li>
                    <li class='<?php if($curr=="error.php"){echo "active";}else{ echo "";}?>'><a href='error.php'>Error Code</a></li>
                    <li class='<?php if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li>
                    <li class='<?php if($curr=="machine.php"){echo "active";}else{ echo "";}?>'><a href='machine.php'>Installed Machines</a>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="purchaseorder.php"||$curr=="editPo.php"){echo "active";}else{ echo "";}?>'><a href='purchaseorder.php'>Purchase Order</a></li>
                    <li class='<?php if($curr=="duty.php"){echo "active";}else{ echo "";}?>'><a href='duty.php'>Inward</a></li>
                    <li class='<?php if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="quotation.php"||$curr=="editQuot.php"){echo "active";}else{ echo "";}?>'><a href='quotation.php'>Quotation</a></li>
                    <li class='<?php if($curr=="invoice.php"||$curr=="editInv.php"||$curr=="invoicep.php"){echo "active";}else{ echo "";}?>'><a href='invoicep.php'>Invoice</a></li>            
                    <li class='<?php if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>  
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='profile.php'>Profile</a></li>
                     <li class='<?php if($curr=="creditnote.php"||$curr=="editCn.php"){echo "active";}else{ echo "";}?>'><a href='creditnote.php'>Credit Note</a></li>
                    <li class='<?php if($curr=="debitnote.php"||$curr=="editDn.php"){echo "active";}else{ echo "";}?>'><a href='debitnote.php'>Debit Note</a></li>
                    <li class='<?php if($curr=="storage.php"){echo "active";}else{ echo "";}?>'><a href='storage.php'>File Storage</a></li>
                    <li class='<?php if($curr=="sh.php"||$curr=="editSh.php"){echo "active";}else{ echo "";}?>'><a href='sh.php'>Service History</a></li>
                    <li class='<?php if($curr=="adminSettings.php"){echo "active";}else{ echo "";}?>'><a href='adminSettings.php'>Admin Settings</a></li>
                    <li class='<?php if($curr=="backup.php"){echo "active";}else{ echo "";}?>'><a href='backup.php'>General Settings</a></li>
                    <li class='<?php if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li>
                    </li>
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Super Admin</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
            </div>
            </div>
            </nav>
            </header>
<?php 
            break;
        case 'admin':
?>
            <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                    <li class='<?php if($curr=="register.php"){echo "active";}else{ echo "";}?>'><a href='register.php'>Users</a></li>
                    <li class='<?php if($curr=="vendor.php"){echo "active";}else{ echo "";}?>'><a href='vendor.php'>Vendors</a></li>
                    <!-- <li class='<?php //if($curr=="error.php"){echo "active";}else{ echo "";}?>'><a href='error.php'>Error Code</a></li> -->
                    <li class='<?php if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li>
                    <!-- <li class='<?php //if($curr=="machine.php"){echo "active";}else{ echo "";}?>'><a href='machine.php'>Installed Machines</a> -->
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="purchaseorder.php"||$curr=="editPo.php"){echo "active";}else{ echo "";}?>'><a href='purchaseorder.php'>Purchase Order</a></li>
                    <li class='<?php if($curr=="duty.php"){echo "active";}else{ echo "";}?>'><a href='duty.php'>Inward</a></li>
                    <li class='<?php if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="quotation.php"||$curr=="editQuot.php"){echo "active";}else{ echo "";}?>'><a href='quotation.php'>Quotation</a></li>
                    <li class='<?php if($curr=="invoice.php"||$curr=="editInv.php"||$curr=="invoicep.php"){echo "active";}else{ echo "";}?>'><a href='invoicep.php'>Invoice</a></li>            
                    <li class='<?php if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>  
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='profile.php'>Profile</a></li>
                     <li class='<?php if($curr=="creditnote.php"||$curr=="editCn.php"){echo "active";}else{ echo "";}?>'><a href='creditnote.php'>Credit Note</a></li>
                    <li class='<?php if($curr=="debitnote.php"||$curr=="editDn.php"){echo "active";}else{ echo "";}?>'><a href='debitnote.php'>Debit Note</a></li>
                    <li class='<?php if($curr=="storage.php"){echo "active";}else{ echo "";}?>'><a href='storage.php'>File Storage</a></li>
                    <li class='<?php if($curr=="adminSettings.php"){echo "active";}else{ echo "";}?>'><a href='adminSettings.php'>Admin Settings</a></li>
                    <li class='<?php if($curr=="passwordChange.php"){echo "active";}else{ echo "";}?>'><a href='passwordChange.php'>Update Password</a></li>
                    <li class='<?php if($curr=="backup.php"){echo "active";}else{ echo "";}?>'><a href='backup.php'>General Settings</a></li>
                    <li class='<?php if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li>
                    </li>
                    
                    </li>
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Admin</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>
<?php
            break;
        case 'spares':
?>
        <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <!-- <li class='<?php //if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li> -->
                    <li class='<?php if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <!-- <li class='<?php //if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li> -->
                    <li class='<?php if($curr=="purchaseorder.php"||$curr=="editPo.php"){echo "active";}else{ echo "";}?>'><a href='purchaseorder.php'>Purchase Order</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="quotation.php"||$curr=="editQuot.php"){echo "active";}else{ echo "";}?>'><a href='quotation.php'>Quotation</a></li>
                    <li class='<?php if($curr=="invoice.php"||$curr=="editInv.php"||$curr=="invoicep.php"){echo "active";}else{ echo "";}?>'><a href='invoicep.php'>Invoice</a></li>
                    <li class='<?php if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>  
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='profile.php'>Profile</a></li>
                    <li class='<?php if($curr=="sh.php"||$curr=="editSh.php"){echo "active";}else{ echo "";}?>'><a href='sh.php'>Service History</a></li>
                    <li class='<?php if($curr=="passwordChange.php"){echo "active";}else{ echo "";}?>'><a href='passwordChange.php'>Update Password</a></li>
                    <li class='<?php if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li>
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Spares</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>       
<?php
            break;        
        case "service":
?>
        <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                    <li class='<?php if($curr=="register.php"){echo "active";}else{ echo "";}?>'><a href='register.php'>Users</a></li>
                    <li class='<?php if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li>
                    <li class='<?php if($curr=="error.php"){echo "active";}else{ echo "";}?>'><a href='error.php'>Error Code</a></li>
                    <li class='<?php if($curr=="machine.php"){echo "active";}else{ echo "";}?>'><a href='machine.php'>Installed Machines</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="purchaseorder.php"||$curr=="editPo.php"){echo "active";}else{ echo "";}?>'><a href='purchaseorder.php'>Purchase Order</a></li>                                
                    <li class='<?php if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li> 
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">                    
                    <li class='<?php if($curr=="invoice.php"||$curr=="editInv.php"||$curr=="invoicep.php"){echo "active";}else{ echo "";}?>'><a href='invoicep.php'>Invoice</a></li>                       
                    <li class='<?php if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>
                </ul>
            </li>
            
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='profile.php'>Profile</a></li>
                    <li class='<?php if($curr=="passwordChange.php"){echo "active";}else{ echo "";}?>'><a href='passwordChange.php'>Update Password</a></li> 
                    <li class='<?php if($curr=="sh.php"||$curr=="editSh.php"){echo "active";}else{ echo "";}?>'><a href='sh.php'>Service History</a></li>
                    <li class='<?php if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li>
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Service</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>        
<?php
        break;
        case "engineer":
?>

        <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
             <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <!-- <li class='<?php //if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                    <li class='<?php //if($curr=="register.php"){echo "active";}else{ echo "";}?>'><a href='register.php'>Users</a></li>                    
                    <li class='<?php //if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li> -->
                    <li class='<?php if($curr=="error.php"){echo "active";}else{ echo "";}?>'><a href='error.php'>Error Code</a></li>
                    <!-- <li class='<?php //if($curr=="machine.php"){echo "active";}else{ echo "";}?>'><a href='machine.php'>Installed Machines</a></li> -->
                </ul>
            </li>
           <!--  <li> 
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php /*if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}*/?>'><a href='stock.php'>Stock</a></li>                                        
                </ul>
            </li> -->
            <!-- <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">                    
                    <li class='<?php //if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>                                       
                </ul>
            </li> -->
            
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="sh.php"||$curr=="editSh.php"){echo "active";}else{ echo "";}?>'><a href='sh.php'>Service History</a></li>
                    <!-- <li class='<?php /*if($curr=="passwordChange.php"){echo "active";}else{ echo "";}*/?>'><a href='passwordChange.php'>Update Password</a></li>  -->
                    <!-- <li><a href='profile.php'>Profile</a></li>
                    <li class='<?php //if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li> -->
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Engineer</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>
<?php
        break;
        case "viewer":
?>
        <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <!-- <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php //if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                    <li class='<?php //if($curr=="register.php"){echo "active";}else{ echo "";}?>'><a href='register.php'>Users</a></li>                    
                    <li class='<?php //if($curr=="customers.php"){echo "active";}else{ echo "";}?>'><a href='customers.php'>Customers</a></li>
                    <li class='<?php //if($curr=="error.php"){echo "active";}else{ echo "";}?>'><a href='error.php'>Error Code</a></li>
                    <li class='<?php //if($curr=="machine.php"){echo "active";}else{ echo "";}?>'><a href='machine.php'>Installed Machines</a></li>
                </ul>
            </li>-->
            <li> 
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li>                                        
                </ul>
            </li>
            <!-- <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">                    
                    <li class='<?php //if($curr=="challan.php"||$curr=="editChallan.php"){echo "active";}else{ echo "";}?>'><a href='challan.php'>Challan</a></li>                                       
                </ul>
            </li> -->
            
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="sh.php"||$curr=="editSh.php"){echo "active";}else{ echo "";}?>'><a href='sh.php'>Service History</a></li>
                    <li class='<?php if($curr=="passwordChange.php"){echo "active";}else{ echo "";}?>'><a href='passwordChange.php'>Update Password</a></li> 
                    <!-- <li><a href='profile.php'>Profile</a></li>
                    <li class='<?php //if($curr=="spr.php"||$curr=="editSpr.php"){echo "active";}else{ echo "";}?>'><a href='spr.php'>Spare Part Request</a></li> -->
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Engineer</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>
<?php
            break;
        case "finance":
?>
        
        <li class='<?php if($curr=="adminhome.php"){echo "active";}else{ echo "";}?>'><a href='adminhome.php'>Home</a></li>
            <!-- <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Master 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php //if($curr=="parts.php"){echo "active";}else{ echo "";}?>'><a href='parts.php'>Parts</a></li>
                </ul>
            </li> -->
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Inward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class='<?php if($curr=="purchaseorder.php"||$curr=="editPo.php"){echo "active";}else{ echo "";}?>'><a href='purchaseorder.php'>Purchase Order</a></li>
                    <li class='<?php if($curr=="stock.php"||$curr=="stock.php"){echo "active";}else{ echo "";}?>'><a href='stock.php'>Stock</a></li>   
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Outward 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">                    
                    <li class='<?php if($curr=="invoice.php"||$curr=="editInv.php"||$curr=="invoicep.php"){echo "active";}else{ echo "";}?>'><a href='invoicep.php'>Invoice</a></li>
                </ul>
            </li>
            
            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" href='#'>Other Features 
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='profile.php'>Profile</a></li>
                    <li class='<?php if($curr=="passwordChange.php"){echo "active";}else{ echo "";}?>'><a href='passwordChange.php'>Update Password</a></li>                     
                </ul>
            </li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
                <li><a>User Role: Finance</a></li>
                <li><a href='../php/login.php?logout=1' id='log'>Logout <span class="glyphicon glyphicon-off"></span></a></li>            
            </ul>
        
        </div>
        </div>
        </nav>
        </header>
<?php
            break;
    }
    
?>