<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader  = "Backup Sheet";
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
			<span>Your Current Locations: </span>
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
							
							<div class="col-lg-3 col-md-2 col-sm-6 col-sm-offset-1 col-xs-12">
								 
							</div>
							<?php
								$backupSql  =$conn->query("SELECT * FROM tbl_backup WHERE  deleted = 0 ORDER BY id desc");
 								$backup_row  = $backupSql->fetch_array();
								$nameLast = $backup_row['name'];
						 ?>
							 
							<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
								
								<a href="../config/backup.php">
									<img src="../assets/icons/backup.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Backup</h4>
								</a>
								
							</div>
							
							<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
								
								<a href="../backup/<?php  echo $nameLast;  ?>">
									<img src="../assets/icons/download.png" class="img-circle img-rotate" />
									<div class="margin-top-10"></div>
									<h4 class="text-center">Download</h4>
								</a>
								
							</div>
							
							 
							<div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 col-lg-offset-1">
								
							</div>
						</div>
						<div class='blank'>
						</div>
						<?Php  
							listBackup($validationEditCondition,$validationRemoveCondition);
 						?> 
 					</div> 
				</div> 
			</div>
			<div class='row'>
			
			
			
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
