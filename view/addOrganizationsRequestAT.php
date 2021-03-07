<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader = "ثبت درخواست های مکاتب / سازمان";
	 
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
			<li class="active"><i class="fa fa-list-ul"></i><strong >درخواست ها</strong></li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
 						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							 
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 col-lg-offset-3">
								
								<a href="addOrganizationMaterialsRequestAT.php" target="_blank">
									<img src="../assets/icons/materialsF.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">درخواست اقلام</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="addOrgConstructionsRequestAT.php" target="_blank">
									<img src="../assets/icons/reconstructionF.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">درخواست تعمیراتی</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
								
								<a href="addSupportCeremoniesRequestAT.php" target="_blank">
									<img src="../assets/icons/cermonyF.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">درخواست تمویل محافل</h4>
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
