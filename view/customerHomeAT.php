<?php
	require_once("_header.php");
	$menu = "customersAT";
	$formHeader = "Customers Account";
	if(isset($_POST['name'])){
		$_SESSION['customer'] = $_POST['name'];
		$temp                 = explode("-", $_SESSION['customer']);
		$customerId           = $temp[0];
		$customerName         = $temp[1];
    }else{
		$temp                 = explode("-", $_SESSION['customer']);
		$customerId           = $temp[0];
		$customerName         = $temp[1];
	}
 ?>
<title><?php echo $pageTitle; ?></title>
<style>
 
</style>
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
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Customers</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">Customer Name &nbsp;:  &nbsp; <?php echo $customerName;?> </div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<?php
						$selectCustomerQuery = $conn->query("SELECT * FROM tbl_customers where id = $customerId AND deleted = 0");
						$rowFetchCustomer = $selectCustomerQuery->fetch_array();
						$currencyId = $rowFetchCustomer['currencies_id'];
						 
						$currencyCodeQuery = $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencyId ORDER BY id DESC");
						$currencyCode = $currencyCodeQuery->fetch_array();
						//Money going to account of dealer.	
						 
						$selectSumStatment = $conn->query("SELECT SUM(amount) as goingMoney FROM tbl_customer_statement where customers_id = $customerId AND transaction_type = 2 AND deleted = 0");
						$fetchSumCustomer = $selectSumStatment->fetch_array();
						$goingMoney = $fetchSumCustomer['goingMoney'];
						
						//Money comming to account of own business shop.	
						$selectSumStatmentComing = $conn->query("SELECT SUM(amount) as comingMoney FROM tbl_customer_statement where customers_id = $customerId AND transaction_type = 1 AND deleted = 0");
						$fetchSumCustomerComing = $selectSumStatmentComing->fetch_array();
						$comingMoney = $fetchSumCustomerComing['comingMoney'];
						 
					?>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;">Summary of Customer Account <span class="text-danger"><?php echo $currencyCode['code'];  ?></span></td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">Customer</th>
										<td class="text-center"><?php  echo  $customerName;    ?></td>
									</tr>
									<tr>
										<th  class="text-center">Contact</th>
										<td class="text-center"><?php echo  $rowFetchCustomer['contact']; ?></td>
									</tr>
									<tr>
										<th class="text-center">Total Debit Amount</td>
										<td class="p-number text-center" class="text-center"><?php  echo number_format($goingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">Total Credit Amount</td>
										<td class="text-center p-number"><?php  echo number_format($comingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">Current Balance</td>
										<td class="text-center"><?php echo $comingMoney - $goingMoney; ?></td>
									</tr>
								</table>
							</div>
							
							 
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="customerBalanceSheetETQ.php" target="_blank">
									<img src="../assets/icons/balance.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Customer Balance</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="customerPaymentReportETQ.php"  target="_blank">
									<img src="../assets/icons/document.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Customer Payment Report</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="searchCustomerFactorETQ.php"  target="_blank">
									<img src="../assets/icons/report.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Search Factor</h4>
								</a>
								
							</div>
						</div>
					</div>  
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
<!-- /page container -->

<?php
	require_once("_extraScripts.php");	
?>
 
</body>
</html>