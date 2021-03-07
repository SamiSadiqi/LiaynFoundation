<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader   = "این صفحه به صفحه اندیکس انتقال داده خواهد شد";
	$formHeader1  = "جزئیات درخواست های اجراء شده";
?>
<title><?php echo $pageTitle; ?></title>
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
			<span>موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
 			<li class="active"><strong ><i class="fa fa-user"></i>جزئیات درخواست ها</strong></li>
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
						 <?php
							$countUndoingRequest  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_org_req_materials_title  WHERE status = 0");
							$fetchCountUndoingRequest = $countUndoingRequest->fetch_array();
							$totalMessages = $fetchCountUndoingRequest['totalRows'];
						 
						 ?>
						 
							<div class="col-lg-2 col-md-2 col-sm-2  col-xs-3 col-lg-offset-3 col-md-offset-3 col-sm-offset-3" >
								<a href="preDonationListAT.php"  target="_blank">
 									<div class="margin-top-10"></div>
									<span class="badge badge-danger"><?php  echo $totalMessages; ?></span>
									<h4 class="text-center">د.اقلام جدید</h4>
								</a>
							</div>
						<?php
							$countUndoingConstructionRequest  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_org_construction_requests  WHERE status = 0");
							$fetchCountUndoingConstructionRequest = $countUndoingConstructionRequest->fetch_array();
							$totalConstruMessages = $fetchCountUndoingConstructionRequest['totalRows'];
						 
						 ?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
									<a href="preConstructionDonationRequestAT.php"  target="_blank">
								 
									<div class="margin-top-10"></div>
									<span class="badge badge-success"><?php  echo $totalConstruMessages;  ?></span>
									<h4 class="text-center">د.تعمیراتی </h4>
								</a>
							</div>
							
							<?php
							$countUndoingCermonyCircleRequest  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_support_ceremonies_requests  WHERE status = 0");
							$fetchCountUndoingCermonyCircleRequest = $countUndoingCermonyCircleRequest->fetch_array();
							$totalConstruCircleRequest = $fetchCountUndoingCermonyCircleRequest['totalRows'];
						 
						 ?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
								<a  href="preRequestCircleCermonyAT.php" target="_blank">
 									<div class="margin-top-10"></div>
									<span class="badge badge-primary"><?php   echo $totalConstruCircleRequest;    ?></span>
									<h4 class="text-center" >د.تمویل محافل</h4>
								</a> 
							</div>
						 
							
						</div>
					</div> 
				</div> 
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-success animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader1; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						 <div class="row">
						 <?php
							$countUndoingRequestEx  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_org_req_materials_title  WHERE status = 1");
							$fetchCountUndoingRequestEx = $countUndoingRequestEx->fetch_array();
							$totalMessagesEx = $fetchCountUndoingRequestEx['totalRows'];
						 
						 ?>
						 
							<div class="col-lg-2 col-md-2 col-sm-2  col-xs-3 col-lg-offset-3 col-md-offset-3 col-sm-offset-3" >
								<a href="preDonationListAT.php"  target="_blank">
 									<div class="margin-top-10"></div>
									<span class="badge badge-danger"><?php  echo $totalMessagesEx; ?></span>
									<h4 class="text-center">د.اقلام جدید</h4>
								</a>
							</div>
						<?php
							$countUndoingConstructionRequestEx  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_org_construction_requests  WHERE status = 1");
							$fetchCountUndoingConstructionRequestEx = $countUndoingConstructionRequestEx->fetch_array();
							$totalConstruMessagesEx = $fetchCountUndoingConstructionRequestEx['totalRows'];
						 
						 ?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
									<a href="preConstructionDonationRequestAT.php"  target="_blank">
 									<div class="margin-top-10"></div>
									<span class="badge badge-success"><?php  echo $totalConstruMessagesEx;  ?></span>
									<h4 class="text-center">د.تعمیراتی </h4>
								</a>
							</div>
							
							<?php
							$countUndoingCermonyCircleRequestEx  = $conn->query("SELECT COUNT(*) AS totalRows FROM tbl_support_ceremonies_requests  WHERE status = 1");
							$fetchCountUndoingCermonyCircleRequestEx = $countUndoingCermonyCircleRequestEx->fetch_array();
							$totalConstruCircleRequestEx = $fetchCountUndoingCermonyCircleRequestEx['totalRows'];
						 
						 ?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
								<a  href="preRequestCircleCermonyAT.php" target="_blank">
 									<div class="margin-top-10"></div>
									<span class="badge badge-primary"><?php   echo $totalConstruCircleRequestEx;    ?></span>
									<h4 class="text-center" >د.تمویل محافل</h4>
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
