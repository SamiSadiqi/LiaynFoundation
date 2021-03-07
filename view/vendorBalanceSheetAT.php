<?php
	require_once("_header.php");
	$menu = "vendorsAT";
	$formHeader  = "بلانس فروشنده";
	$temp               = explode("-", $_SESSION['vendor']);
    $vendorId           = $temp[0];
	$vendorName         = $temp[1];
?>
<title><?php echo $pageTitle; ?></title>
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
			<span>موقعیت فعلی</span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>فروشنده گان</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php  goBackward('vendorHomeAT.php');   ?>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
													
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">از تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="از تاریخ" autocomplete="off" id="fromDate" name="fromDate"  data-select='datepicker' class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">الی تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="الی تاریخ" autocomplete="off" id="toDate" name="toDate" data-select='datepicker' class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							
							<?php
								SearchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						
						<?php
							if(isset($_POST['fromDate']) AND isset($_POST['toDate'])){
									$fromDate = $_POST['fromDate'];
									$toDate = $_POST['toDate'];
									listBalanceSheetVendors($fromDate,$toDate,$vendorId);
							}else{
									listBalanceSheetVendors(0,0,$vendorId);
							 
							}
 						?>
						
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
