<?php
	require_once("_header.php");
	$menu = "vendorsAT";
	$formHeader = "حسابات فروشنده";
	if(isset($_POST['name'])){
		$_SESSION['vendor'] = $_POST['name'];
		$temp                 = explode("-", $_SESSION['vendor']);
		$vendorId           = $temp[0];
		$vendorName         = $temp[1];
	}else{
		$temp                 = explode("-", $_SESSION['vendor']);
		$vendorId           = $temp[0];
		$vendorName         = $temp[1];
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
			<span>موقعیت فعلی شما</span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>حسابات فروشنده</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">نام فروشنده &nbsp;:  &nbsp; <?php echo $vendorName;?> </div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div>
					<?php
					$selectVendorQuery = $conn->query("SELECT * FROM tbl_vendors where id = $vendorId and users_id = $userId AND deleted = 0");
					$rowFetchVendor = $selectVendorQuery->fetch_array();
 					
					//Money going to account of dealer.	
 					
				 	$selectSumVendorStatment = $conn->query("SELECT SUM(amount) as goingMoney FROM 	tbl_vendor_statement where vendors_id = $vendorId AND transaction_type = 2 AND users_id = $userId AND deleted = 0");
					$fetchSumVendor = $selectSumVendorStatment->fetch_array();
					$goingMoney = $fetchSumVendor['goingMoney'];
					
					//Money comming to account of own business shop.	
					$selectSumVendorStatmentComing = $conn->query("SELECT SUM(amount) as comingMoney FROM tbl_vendor_statement where vendors_id = $vendorId AND transaction_type = 1 AND users_id = $userId AND deleted = 0");
					$fetchSumVendorComing = $selectSumVendorStatmentComing->fetch_array();
					$comingMoney = $fetchSumVendorComing['comingMoney'];
					 
					?>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;"> خلاقه حسابات فروشنده</td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">فروشنده</th>
										<td class="text-center"><?php  echo  $vendorName;;    ?></td>
									</tr>
									<tr>
										<th  class="text-center">شماره موبایل</th>
										<td class="text-center"><?php echo  $rowFetchVendor['contact']; ?></td>
									</tr>
									<tr>
										<th class="text-center">کل قیمت فروشات</td>
										<td class="p-number text-center" class="text-center"><?php  echo number_format($goingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">کل قیمت خریداری اجناس</td>
										<td class="text-center p-number"><?php  echo number_format($comingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">بلانس فعلی</td>
										<td class="text-center"><?php echo $comingMoney - $goingMoney; ?></td>
									</tr>
								</table>
						</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="vendorBalanceSheetAT.php" target="_blank">
									<img src="../assets/icons/balance.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">بلانس فروشنده</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="vendorPaymentReport.php" target="_blank">
									<img src="../assets/icons/document.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">گزارش پرداختی ها فروشندهک</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="searchVendorFactorAT.php" target="_blank">
									<img src="../assets/icons/report.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">فاکتور فروشنده</h4>
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