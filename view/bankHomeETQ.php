<?php
	require_once("_header.php");
	$menu = "banksAT";
	$formHeader = "حسابات بانکی";
	if(isset($_POST['name'])){
		$_SESSION['bank'] = $_POST['name'];
		$temp                 = explode("-", $_SESSION['bank']);
		$bankId           = $temp[0];
		$bankName         = $temp[1];
    }else{
		$temp             = explode("-", $_SESSION['bank']);
		$bankId           = $temp[0];
		$bankName         = $temp[1];
	}
	
	$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $bankId);
    
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
			<span>موقعیت فعلی شما: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>بانکداری</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		 
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $formHeader.": <span style='font-weight:bold'>". $bankName." </span>"; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<?php
						$selectBankQuery = $conn->query("SELECT * FROM tbl_banks where id = $bankId AND deleted = 0");
						$rowFetchBanks = $selectBankQuery->fetch_array();
						
						//Money going to account of dealer.	
 						
						$selectSumStatment = $conn->query("SELECT SUM(amount) as goingMoney FROM tbl_bank_statement where banks_id = $bankId AND transaction_type = 2 AND deleted = 0");
						$fetchSumCustomer = $selectSumStatment->fetch_array();
						$goingMoney = $fetchSumCustomer['goingMoney'];
						
						//Money comming to account of own business shop.	
						$selectSumStatmentComing = $conn->query("SELECT SUM(amount) as comingMoney FROM tbl_bank_statement where banks_id = $bankId AND transaction_type = 1 AND deleted = 0");
						$fetchSumCustomerComing = $selectSumStatmentComing->fetch_array();
						$comingMoney = $fetchSumCustomerComing['comingMoney'];
						 
					?>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;">بانک بلانس </td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">نام بانک</th>
										<td class="text-center"><?php  echo  $rowFetchBanks['name'];    ?></td>
									</tr>
								 
									<tr>
										<th class="text-center">کل مقدار خارج شده</td>
										<td class="p-number text-center" class="text-center"><?php  echo number_format($goingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">کل مقدار وارد شده</td>
										<td class="text-center p-number"><?php  echo number_format($comingMoney,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">بلانس فعلی</td>
										<td class="text-center"><?php echo  number_format($comingMoney - $goingMoney,2); ?></td>
									</tr>
								</table>
							</div>
							 
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-3">
								<a href="bankBalanceSheetETQ.php">
									<img src="../assets/icons/balance.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">بانک بلانس</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
								
								<a href="bankTransactionReportsETQ.php">
									<img src="../assets/icons/report.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">گزارش ترانزکشن ها </h4>
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