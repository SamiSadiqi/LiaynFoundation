<?php
	require_once("_header.php");
	$menu = "factoryAT";
	$formHeader  = "Add Recycling Materials to Stocks";
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
 		<div id="myModal" class="modal fade">
			<div class="modal-dialog lg-model">
				<div class="modal-content">
					<div class="modal-header" style='height:40px;'>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h5 class="modal-title">Current Item Amount</h5>
					</div>
					<div class="modal-body" id='myModalData'>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					 </div>
				</div>
			</div>
		</div>
 	<!-- Main content -->
	<div class="main-content">
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Record Salvages to Stocks</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
							<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content">
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>	
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsSalvageEquipmentsAT.php" method="POST">
							
								<input name="formParameter" value="<?php echo encryptIt("expenseEquipmentsAT"); ?>" type="hidden"  />
						 
							<div class="alert" style="background-color: #efeaea;">
								
								<div class="form-group">
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Date</h4>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Select Inventory</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<h4 class="text-center">Item</h4>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Unit</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<h4 class="text-center">Quantity</h4>
									</div> 
										
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Description</h4>
									</div>										
								</div>
							
								<!-- ------------------------------------------------------------------------------------------------- -->
								<input type="hidden" id="form-field" value="5" />
								<?php
								
								for($i = 0; $i < 5; $i++){
									
								?>
								<div class="form-group">
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<input type="text" placeholder="Date" autocomplete="off" id="date" data-select="datepicker" name="date[]" class="form-control">
 									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<select class="select2 form-control" name='stockId[]'  onchange='selectInventoryData(this.value,<?php  echo $i;   ?>)' autocomplete="off" id='stockId-<?php  echo $i;  ?>'>
											<option Value="">Select Inventory</option>
											<?php
											 
											$stockRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $stockRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}   
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<select class="select2 form-control" name='itemId[]' onchange='selectItemUnit(this.value,<?php  echo $i;   ?>)' autocomplete="off" id='itemId-<?php echo $i; ?>'>
											<option Value="">Select Item</option>
											<?php
											/*  
											$itemsRow= $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $itemsRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}  */  
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<select class="select2 form-control" name='itemUnit[]'   autocomplete="off" id='itemUnit-<?php echo $i; ?>'>
											<option Value="">Select Unit</option> 
											<?php
											 
									 
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<input type="text" placeholder="Quantity" autocomplete="off" onKeyPress="return isNumericKey(event)"  ondblclick = "getExistanceStock(<?php   echo $i; ?>)" id="amount-<?php echo $i; ?>" name="amount[]" class="form-control p-number">
										<p class="help-block"></p>
									</div> 
									
									 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<input type="text" placeholder="Description" autocomplete="off" id="description-<?php echo $i; ?>" name="subDescription[]" class="form-control">
										<p class="help-block"></p>
									</div> 
								</div>
								
								<?php
								
									}
								
								?>
								
								<!-- ------------------------------------------------------------------------------------------------- -->
								 	
								
								
							</div>
						 
							
							<?php
								fetchFormSubmissionButtons();
							?> 
						</form>
						<div class="blank"></div>
						
						<?php
							}
							ListSalvageValue('expenseEquipmentAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
<script>
function selectItemUnit(itemId,rowId){
 	$.post("AjaxSelectUnitFactor.php",{"itemId":itemId},function(data){
		$("#itemUnit-"+rowId).html("");
 		$("#itemUnit-"+rowId).append(data);
	});
}
  
 
function getExistanceStock(rowId){
	var itemId  = $("#itemId-"+rowId).val();
	var stockId  = $("#stockId-"+rowId).val();
	$.post("AjaxExistedStockAmount.php",{"itemId":itemId,"stockId":stockId},function(data){
		$("#myModalData").html(data)
		$("#myModal").modal('show')
	});
}

function selectInventoryData(stockId,rowId){
	$.post("AjaxSelectInventoryItemsRecyclingAT.php",{"stockId":stockId},function(data){
 		$("#itemId-"+rowId).html("");
 		$("#itemId-"+rowId).append(data);
	});
}

</script>
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>
