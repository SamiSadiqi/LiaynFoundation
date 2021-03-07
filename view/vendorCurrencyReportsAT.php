<?php
	require_once("_header.php");
	$menu = "reportsAT";
	$formHeader  = "Vendor Loan Reports";
	 
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
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>Your Current Location:</span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Vendor Currency Loan</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('vendorReportETQ.php');  ?>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<form class="form-horizontal" action="vendorLoanReportsAT.php" method="POST">
											
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="unit">Currency</label> 
								<div class="col-lg-6 col-md-8 col-sm-10">  
									<select class="select2 form-control" name='currencyId' autocomplete="off" id='currencyId'>
										<option Value="all">Select Currency</option>
										<option value="all"> All </option>
										<?php
										 
											$currencyQuery = $conn->query("SELECT * FROM `tbl_currencies` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $currencyQuery->fetch_array()){
													$id = $row['id'];
 													$name = $row['code'];
													echo "<option   value='$id'>$name</option>";
											}   
									
										?>
									</select>
									<p class="help-block"></p>
								</div>
								 									 
							</div>
								
							<?php
								searchFormSubmissionButtons();
							?> 
						</form>
					
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
