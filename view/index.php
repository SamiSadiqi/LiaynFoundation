<?php
require_once("_header.php");
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
 
<!-- Page container -->
<div class="page-container">

  <!-- Page Sidebar -->
  <div class="page-sidebar">
  
  <?php
  	require_once("_navigation.php");
  ?>
  				
  </div>
  <!-- /page sidebar -->
  
  <!-- Main container -->
  <div class="main-container">
  
	<!-- Main header -->
    <div class="main-header row">
    
    <?php
    	require_once("_top.php");
    ?>
    
    </div>
	<!-- /main header -->
	
	<!-- Main content -->
	<div class="main-content">
			<h1 class="page-title">بنیاد لیان امیری</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="index.html"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="graph-flot.html">Graphs</a></li> 
				<li class="active"><strong>Flot Charts</strong></li> 
			</ol>
			<!--
			<div class="row">
				 <div class="col-lg-6">
					
					<div class="col-lg-12 animatedParent animateOnce z-index-49"> 
						<div class="panel panel-default animated fadeInUp">
							<div class="panel-heading clearfix"> 
								<div class="panel-title"></div> 
								<ul class="panel-tool-options"> 
									<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								</ul>
								 <?php
									//Total Customers
								/* 	$vendorAccount  = $conn->query("SELECT * FROM tbl_vendors WHERE deleted = 0 ORDER BY id DESC");
									$vendorAccountNumber = $vendorAccount->num_rows;
									
									 
									//Debit
									$totalDebitVendors  = $conn->query("SELECT sum(home_amount) as vendorDebit FROM tbl_vendor_statement WHERE deleted = 0 AND transaction_type = 2");
									$totalDebitVendorsFetch = $totalDebitVendors->fetch_array();
									$totalDebitVendorAccount = $totalDebitVendorsFetch['vendorDebit'];
									
									//Credit
									$totalCreditVendors  = $conn->query("SELECT sum(home_amount) as vendorCredit FROM tbl_vendor_statement WHERE deleted = 0 AND transaction_type = 1");
									$totalCreditVendorsFetch = $totalCreditVendors->fetch_array();
									$totalCreditVendorAccount = $totalCreditVendorsFetch['vendorCredit']; */
								 
								 ?>
								<a href="vendorListReportAT.php" title="Click For Details" target="_">  <span  style="font-size:20px;"> All Vendors </span> </style> </a>
								<span style="color:red;font-size:20px;text-decoration:underline"><?php  echo $vendorAccountNumber;  ?></span>

								
								 <div class="row">
									
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:25px;font-family:Time New Roman;text-align:center;"><?php echo number_format($totalCreditVendorAccount,2);  ?></span>
										<Br>
										<span class="col-md-12" style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="vendorLoanReportsAT.php" target="_" title="Click For Details">Credit <span style="font-size:7px;">USD</span></a></span>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:25px;font-family:Time New Roman;text-align:center;"><?php echo number_format($totalDebitVendorAccount,2);  ?></span>
										<Br>
										<span class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="vendorLoanReportsAT.php" target="_" title="Click For Details">Debit <span style="font-size:7px;">USD</span></a></span>
									</div>
									 
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:red;font-size:25px;font-family:Time New Roman;text-align:center;" title="Credit - Debit = Current Balance"><?php echo number_format($totalCreditVendorAccount - $totalDebitVendorAccount,2);  ?></span>
										<span  class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="vendorLoanReportsAT.php" target="_" title="Click For Details">Current Balance <span style="font-size:7px;">USD</span></a></span>
										<Br>
									</div>
 								 </div>
								 <span class="text-danger" style="font-size:10px;">Note: Credit - Debit = Current Balance</span>

							</div> 
							
							 
						</div> 
					</div>
					<div class="col-lg-12 animatedParent animateOnce z-index-49"> 
						<div class="panel panel-default animated fadeInUp">
							<div class="panel-heading clearfix"> 
								<div class="panel-title"></div> 
								<ul class="panel-tool-options"> 
									<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								</ul> 
								 <h3>Vendor Invoice Status</h3>
								  
								 
							</div> 
					
						</div> 
					</div>
					
				</div>
				<div class="col-lg-6">
					<div class="col-lg-12 animatedParent animateOnce z-index-49"> 
						<div class="panel panel-default animated fadeInUp">
							<div class="panel-heading clearfix"> 
								<div class="panel-title"></div> 
								<ul class="panel-tool-options"> 
									<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								</ul> 
								 <h3>Customer Invoice Status</h3>
								 <?php
									//On Hand Invoices
									/* $factorSqlHand  = $conn->query("SELECT * FROM tbl_customer_bill_title WHERE status_movement  = 1 AND deleted = 0 ORDER BY id DESC");
									$factorNumberHand =$factorSqlHand->num_rows;
									
									//Shipment Invoices
									$factorSqlShipment  = $conn->query("SELECT * FROM tbl_customer_bill_title WHERE status_movement  = 2 AND deleted = 0 ORDER BY id DESC");
									$factorNumberShipment =$factorSqlShipment->num_rows;
									
									//Deiliverd Invoices
									$factorSqlDeilivered  = $conn->query("SELECT * FROM tbl_customer_bill_title WHERE status_movement  = 3 AND deleted = 0 ORDER BY id DESC");
									$factorNumberDeilivered = $factorSqlDeilivered->num_rows; */
								 ?>
								 <div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:35px;font-family:Time New Roman;text-align:center;"><?php echo $factorNumberHand;  ?></span>
										<Br>
										<span class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customerBillDetailsStatisticAT.php?type=1" target="_" title="Click For Details">On Hand Invoices</a></span>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:35px;font-family:Time New Roman;text-align:center;"><?php  echo $factorNumberShipment;  ?></span>
										<Br>
										<span class="col-md-12" style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customerBillDetailsStatisticAT.php?type=2" target="_" title="Click For Details">shipment Invoice</a></span>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:35px;font-family:Time New Roman;text-align:center;"><?php echo $factorNumberDeilivered;   ?></span>
										<Br>
										<span  class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customerBillDetailsStatisticAT.php?type=3" target="_" title="Click For Details">Deiliverd Invoices</a></span>
									</div>
								 </div>
							</div> 
						</div> 
					</div>
					
					<div class="col-lg-12 animatedParent animateOnce z-index-49"> 
						<div class="panel panel-default animated fadeInUp">
							<div class="panel-heading clearfix"> 
								<div class="panel-title"></div> 
								<ul class="panel-tool-options"> 
									<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								</ul>
								 <?php
									//Total Customers
									/* $customerAccount  = $conn->query("SELECT * FROM tbl_customers WHERE deleted = 0 ORDER BY id DESC");
									$customerAccountNumber = $customerAccount->num_rows;
									
									 
									//Debit
									$totalDebitCustomers  = $conn->query("SELECT sum(home_amount) as customerDebit FROM tbl_customer_statement WHERE deleted = 0 AND transaction_type = 2");
									$totalDebitCustomersFetch = $totalDebitCustomers->fetch_array();
									$totalDebitCustomerAccount = $totalDebitCustomersFetch['customerDebit'];
									
									//Credit
									$totalCreditCustomers  = $conn->query("SELECT sum(home_amount) as customerCredit FROM tbl_customer_statement WHERE deleted = 0 AND transaction_type = 1");
									$totalCreditCustomersFetch = $totalCreditCustomers->fetch_array();
									$totalCreditCustomerAccount = $totalCreditCustomersFetch['customerCredit']; */
								 
								 ?>
								<a href="customerListReportAT.php" title="Click For Details" target="_">  <span  style="font-size:20px;"> All Customers </span> </style> </a>
								<span style="color:red;font-size:20px;text-decoration:underline"><?php  echo $customerAccountNumber;  ?></span>

								
								 <div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:25px;font-family:Time New Roman;text-align:center;"><?php echo number_format($totalDebitCustomerAccount,2);  ?></span>
										<Br>
										<span class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customersLoanReportsAT.php" target="_" title="Click For Details">Debit <span style="font-size:7px;">USD</span></a></span>
									</div>
									 
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:#33c6d8;font-size:25px;font-family:Time New Roman;text-align:center;"><?php echo number_format($totalCreditCustomerAccount,2);  ?></span>
										<Br>
										<span class="col-md-12" style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customersLoanReportsAT.php" target="_" title="Click For Details">Credit <span style="font-size:7px;">USD</span></a></span>
									</div>
									 
									<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
										<span class="col-md-12" style="color:red;font-size:25px;font-family:Time New Roman;text-align:center;" title="Debit - Credit = Current Balance"><?php echo number_format($totalDebitCustomerAccount - $totalCreditCustomerAccount,2);  ?></span>
										<span  class="col-md-12"  style="font-family:Time New Roman;text-align:center;" class="uppercase"><a href="customersLoanReportsAT.php" target="_" title="Click For Details">Current Balance <span style="font-size:7px;">USD</span></a></span>
										<Br>
									</div>
									<span class="text-danger" style="font-size:10px;">Note: Debit - Credit = Current Balance</span>

								 </div>
							</div> 
							 
						</div> 
					</div>
				</div>
			</div>
			--->
			<div class="row"> 
				<div class="col-lg-6 animatedParent animateOnce z-index-48"> 
					<div class="panel panel-default animated fadeInUp">
						<div class="panel-heading clearfix"> 
							<div class="panel-title">Pie Chart Example</div> 
							<ul class="panel-tool-options"> 
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>
										<li><a href="#"><i class="icon-list"></i> Detailed log</a></li>
										<li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>
										<li class="divider"></li>
										<li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>
									</ul>
								 </li>
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> 
						</div> 
						<!-- panel body --> 
						<div class="panel-body"> 
							 
						</div> 
					</div> 
				</div> 
				<div class="col-lg-6 animatedParent animateOnce z-index-47"> 
					<div class="panel panel-default animated fadeInUp">
						<div class="panel-heading clearfix"> 
							<div class="panel-title">Live Chart Example</div> 
							<ul class="panel-tool-options"> 
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>
										<li><a href="#"><i class="icon-list"></i> Detailed log</a></li>
										<li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>
										<li class="divider"></li>
										<li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>
									</ul>
								 </li>
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> 
						</div> 
						<!-- panel body --> 
						<div class="panel-body"> 
							 
						</div> 
					</div> 
				</div>
			</div>
			<div class="row"> 
				<div class="col-lg-12 animatedParent animateOnce z-index-46"> 
					<div class="panel panel-default animated fadeInUp">
						<div class="panel-heading clearfix"> 
							<div class="panel-title">Multiple Axes Line Chart Example</div> 
							<ul class="panel-tool-options"> 
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>
										<li><a href="#"><i class="icon-list"></i> Detailed log</a></li>
										<li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>
										<li class="divider"></li>
										<li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>
									</ul>
								 </li>
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> 
						</div> 
						<!-- panel body --> 
						 
					</div> 
				</div> 
			</div>
			 
			<!-- Footer -->
		<footer class="animatedParent animateOnce z-index-10"> 
			
			<?php
				require_once("_footer.php");
			?>
			
		</footer>	
		<!-- /footer -->
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<?php
	require_once("_extraScripts.php");	
?>
<script src="../assets/js/plugins/css3-animate-it-plugin/css3-animate-it.js"></script>
 <script src="../assets/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="../assets/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="../assets/js/plugins/blockui-master/jquery.blockUI.js"></script>
 <!-- /page container -->
<script src="../assets/js/plugins/flot/jquery.flot.min.js"></script>
<script src="../assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../assets/js/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="../assets/js/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="../assets/js/plugins/flot/jquery.flot.time.min.js"></script>
<script src="../assets/js/plugins/flot/flot-script.js"></script>
</body>
</html>