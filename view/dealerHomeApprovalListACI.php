<?php
	require_once("_header.php");
	$menu = "dealerETQ";
	$formHeader = "Approvals List ( Bid guranty , Loan ) ";
	  
	 
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
			<li class="active"><i class="fa fa-list-ul"></i>Approval Details</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12   animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">Approvals Details</div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							 
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 col-lg-offset-3  col-sm-offset-3 ">
									
								<a href="alarmBidGurantyLoanACI.php">
									<img src="../assets/icons/credit.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Oudated Loans And Bid Guranties List</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 col-md-offset-0">
								
								<a href="loadAndDebitApprovalsGurantyACI.php">
									<img src="../assets/icons/debit.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Loans And Bid Guranties Requests (Debit)</h4>
								</a>
								
							</div>
							 
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
								
								<a href="loanAndDebitInfomrsGurantyACI.php">
									<img src="../assets/icons/transfer2.jpg" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Loans And Bid Guranties (Credit)</h4>
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
</html>-
