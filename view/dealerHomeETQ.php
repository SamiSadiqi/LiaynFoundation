<?php
	require_once("_header.php");
	$menu = "dealerETQ";
	$formHeader = "حسابات دیلرس";
	
	if(isset($_POST['name'])){
		$_SESSION['dealer'] = $_POST['name'];
		$temp              = explode("-", $_SESSION['dealer']);
		$dealerId           = $temp[0];
		$dealerName         = $temp[1];
	}else{
		$temp              = explode("-", $_SESSION['dealer']);
		$dealerId           = $temp[0];
		$dealerName         = $temp[1];
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
			<span>موقعیت فعلی: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>حسابات دیلر</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php  //echo $dealerName; ?>حسابات دیلر</div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					
					<?php
					$selectDealerQuery = $conn->query("SELECT * FROM tbl_dealers where id = $dealerId  AND deleted = 0");
					$rowFetchDealer = $selectDealerQuery->fetch_array();
					 
					//Money going to account of dealer.	
   					$selectSumDealerStatment = $conn->query("SELECT SUM(amount) as goingMoney FROM tbl_dealer_statement where dealers_id = $dealerId AND transaction_type = 2 AND deleted = 0");
					$fetchSumDealerRow = $selectSumDealerStatment->fetch_array();
					$goingMoney = $fetchSumDealerRow['goingMoney'];
					
 					
 					//Money comming to account of own business shop.
 					$selectSumDealerStatmentComing = $conn->query("SELECT SUM(amount) as comingMoney FROM tbl_dealer_statement where dealers_id = $dealerId AND transaction_type = 1 AND deleted = 0");
					$fetchSumDealerComing = $selectSumDealerStatmentComing->fetch_array();
					$comingMoney = $fetchSumDealerComing['comingMoney'];
					
					
					?>
				 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;">مجموعه حسابات </td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">نام دیلر</th>
										<td class="text-center"><?php  echo $rowFetchDealer['name'] ."-". $rowFetchDealer['family'];   ?></td>
									</tr>
									<tr>
										<th  class="text-center">شماره تماس</th>
										<td class="text-center"><?php  echo $rowFetchDealer['contact'];    ?></td>
									</tr>
									<tr>
										<th class="text-center">دیبت</td>
										<td class="number text-center" class="text-center"><?php  echo number_format($goingMoney);   ?></td>
									</tr>
									<tr>
										<th class="text-center">کریدیت</td>
										<td class="text-center number"><?php echo number_format($comingMoney); ?></td>
									</tr>
									<tr>
										<th class="text-center">حسابات فعلی</td>
										<td class="text-center number" dir='ltr'><?php echo number_format($comingMoney - $goingMoney); ?></td>
									</tr>
								</table>
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 col-sm-offset-4 col-xs-offset-4  col-lg-offset-2 ">
								<a href="dealerBalnaceSheetETQ.php">
									<img src="../assets/icons/transaction.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">بلانس دیلر</h4>
								</a>
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