<?php
	require_once("_header.php");
	$menu = "reportsAT";
	$formHeader  = "گزارش ";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<style>
@media screen and (min-width: 320px) and (max-width: 768px){
    .text-center{
		font-size:10px;
	}
}
@media screen and (min-width: 768px) and (max-width: 1024px){
   .text-center{
		font-size:10px;
	}
}
</style>
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
 			<li class="active"><strong ><i class="fa fa-user"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						 <div class="row">
						 
							<div class="col-lg-2 col-md-2 col-sm-3 col-lg-offset-5 col-md-offset-5 col-sm-offset-5  col-xs-offset-5  col-xs-3">
								
								<a href="genralBalanceSheetAT.php">
									<img src="../assets/icons/genral_balance.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">بلانس عمومی</h4>
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
