<?php
	require_once("_header.php");
	$menu = "staffETQ";
	$formHeader = "حسابات کارمند";
	
	$_SESSION['staff'] = $_POST['name'];
    $temp              = explode("-", $_SESSION['staff']);
    $staffId           = $temp[0];
	$staffName         = $temp[1];
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
			<li class="active"><i class="fa fa-list-ul"></i>حسابات کارمند</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">حسابات کارمند &nbsp;:  &nbsp; <?php echo $staffName;?> </div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-md-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;"> کلیات حسابات کارمند</td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">نام کارمند</th>
										<td class="text-center"><?php  echo  "علی احمد قره باغی";    ?></td>
									</tr>
									<tr>
										<th  class="text-center">شماره تماس</th>
										<td class="text-center"><?php  echo  "07004355274";    ?></td>
									</tr>
									<tr>
										<th class="text-center">مجموعه سرمایه داده شده به فروشنده</td>
										<td class="p-number text-center" class="text-center"><?php  echo "1200000$";    ?></td>
									</tr>
									<tr>
										<th class="text-center">مجموعه قیمت جنس خریداری شده از فروشنده</td>
										<td class="text-center p-number"><?php echo "1200000000000$";  // echo number_format($incomeCustomerTransactionOutcome,2);    ?></td>
									</tr>
									<tr>
										<th class="text-center">حساب فعلی فروشنده</td>
										<td class="text-center"><?php echo "3400000$"; ?></td>
									</tr>
								</table>
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