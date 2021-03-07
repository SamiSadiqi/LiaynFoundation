<?php
	require_once("_header.php");
	$menu = "banksAT";
	$formHeader  = "بانک بلانس";
	$temp             = explode("-", $_SESSION['bank']);
	$bankId           = $temp[0];
	$bankName           = $temp[1];

	$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $bankId);
	$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $rowBank['currencies_id']);

?>
<title><?php echo $pageTitle; ?></title>
<style>
	@media print {
		  body * {
			visibility: hidden;
		  }
		  #section-to-print, #section-to-print * {
			visibility: visible;
		  }
		  #section-to-print {
			position: absolute;
			left: 0;
			top: -300px;
		  }
		} 
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
 			<li class="active"><i class="fa fa-list-ul"></i>حسابات بانکی</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $formHeader.": <span style='font-weight:bold'>". $bankName." - ".$rowCurrency['code']."</span>"; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('bankHomeETQ.php');  ?>

						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
													
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">از تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="از تاریخ" autocomplete="off" id="fromDate" data-select='datepicker' name="fromDate" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">الی تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="الی تاریخ" autocomplete="off" id="toDate" data-select='datepicker' name="toDate" class="form-control">
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
									listBalanceSheetBanks($fromDate,$toDate,$bankId);
							}else{
									listBalanceSheetBanks(0,0,$bankId);
							 
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