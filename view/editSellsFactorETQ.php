<?php
	require_once("_header.php");
	$menu = "customersAT";
	$formHeader  = "Edit Customer Factor 's Details";
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
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Customers</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
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
					
					<?php
					
						if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
							
							$id = decryptIt($_GET['id']);
							 
							editCustomerDetails($id,$validationEditCondition,$validationRemoveCondition);
						}else{
 							header("location: sellsFactorAT.php");
							exit();
						}
						
					?>
					 
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
<script>
function calculateTotal(){
   	var amount = $("#amount").val();
 	var fee    = $("#fee").val();
	var temp   = 0;
	
	if (typeof amount != 'undefined' && amount && typeof fee != 'undefined' && fee) {
		var temp = parseFloat(amount) * parseFloat(fee);
	}
	$("#totalFee").val(temp);
 	 
 }
 
function selectItemUnit(itemId){
  	$.post("AjaxSelectUnitFactor.php",{"itemId":itemId},function(data){
		$("#itemUnit").append(data);
	});
}

</script>
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>
