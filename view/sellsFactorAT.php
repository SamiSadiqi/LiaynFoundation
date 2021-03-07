<?php
	require_once("_header.php");
	$menu = "customersAT";
	$formHeader  = "Add Invoice";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>

<!-- Page container -->
<div class="page-container">


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
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsCusotmerFactorETQ.php" method="POST">
							
							<input name="formParameter" value="<?php echo encryptIt("insertCustomerFactorETQ"); ?>" type="hidden"  />
							<div class="alert alert-info"  style="padding-bottom: 0px;background-color:#00b8ce">
								<div class="form-group">
									
									<div class="col-lg-2 col-md-4 col-sm-4"> 
										<input type="text" placeholder="Date" autocomplete="off" id="date" data-select="datepicker" name="date" class="form-control">
										<p class="help-block"></p>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-4"> 
										<select class="select2 form-control" name='customerId' required onchange="selectCustomerCurrency(this.value)" autocomplete="off" id='customerId'>
											<option Value="">Select Customer</option>
											<?php
											 
											$customerRow= $conn->query("SELECT * FROM `tbl_customers` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $customerRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}   
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									
									 <div class="col-lg-2 col-md-3 col-sm-4"> 
										<select class="select2 form-control" name='currenciesId' required autocomplete="off" onchange="readCurrencyRate(this.value),selectBanks(this.value)"  id='currenciesId'>
											<option Value="">Select Currency</option>
											
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-4"> 
										<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" required class="form-control">
										<p class="help-block"></p>
									</div>  
									<div class="col-lg-2 col-md-4 col-sm-4"> 
										<select class="select2 form-control" name='bankId' autocomplete="off" required id='bankId'>
											<option Value="">Select Bank</option>
										 
										</select>
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-2 col-md-4 col-sm-4"> 
										<input type="text" placeholder="Invoice Number" autocomplete="off" id="factorNumber" required name="factorNumber" class="form-control">
										<p class="help-block"></p>
									</div> 
								</div>
							</div>
							
							<div class="alert" style="background-color: #efeaea;">
								
								<div class="form-group">
									<div class="col-lg-1 col-md-2 col-sm-2"> 
										<h4 class="text-center">No</h4>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Select Inventory</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-5">
										<h4 class="text-center">Item</h4>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<h4 class="text-center">Unit</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<h4 class="text-center">Quantity</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<h4 class="text-center">Unit Price</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-6"> 
										<h4 class="text-center">Total Amount</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">Description</h4>
									</div>										
								</div>
								
								<!-- ------------------------------------------------------------------------------------------------- -->
								<input type="hidden" id="form-field" value="9" />
								<?php
								
									for($i = 0; $i < 10; $i++){
									
								?>
								<div class="form-group">
									<div class="col-lg-1 col-md-2 col-sm-2"> 
										<input type="text"   autocomplete="off" style="text-align:center" value="<?php  echo $i+1;  ?>"  readonly class="form-control">
										<p class="help-block"></p>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<select class="select2 form-control" name='stockId[]' autocomplete="off" id='stockId-<?php  echo $i;  ?>'>
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
											 
											$itemsRow= $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $itemsRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}   
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<select class="select2 form-control" name='itemUnit[]' autocomplete="off" id='itemUnit-<?php echo $i; ?>'>
											<option Value="">Select Unit</option> 
											<?php
											 
									 
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<input type="text" placeholder="Quantity" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)"  ondblclick = "getExistanceStock(<?php   echo $i; ?>)" id="amount-<?php echo $i; ?>" name="amount[]" class="form-control p-number">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<input type="text" placeholder="Unit Price" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" id="fee-<?php echo $i; ?>" name="fee[]" class="form-control p-number">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-6"> 
										<input type="text" placeholder="Total Amount" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" id="totalFee-<?php echo $i; ?>" name="totalFee[]" class="form-control totalFee p-number">
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
								
								<div class="form-group" id="buttons">
									<div class="col-sm-12 col-md-1 col-md-offset-11 col-lg-1 col-lg-offset-11">
										<button id="addRow" class="btn btn-success btn-outline" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</div>
								</div>
								
							</div>
							 
							<div class="alert alert-success col-md-4 col-lg-4 col-xs-12 col-sm-12" style="padding-bottom: 0px;background-color:#00b8ce;">
							
								 
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="name">Total Price</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
										<input type="text" placeholder="Total Amount" onkeyup="calculateFactorRemain()" autocomplete="off" id="totalFactorPrice" name="totalFactorPrice" class="form-control p-number">
											<p class="help-block"></p>
										</div> 
									</div> 
									
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="factorPayment">Payment Amount</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
										<input type="text" placeholder="Payment Amount" onkeyup="calculateFactorRemain()" autocomplete="off" id="factorPayment" name="factorPayment" class="form-control">
											<p class="help-block"></p>
										</div> 
									</div> 
									  
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="factorRemain">Remain Amount</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
										<input type="text" placeholder="Remain Amount" onkeyup="calculateFactorRemain()" autocomplete="off" id="factorRemain" name="factorRemain" class="form-control">
											<p class="help-block"></p>
										</div> 
									</div> 
									   
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="factorDescription">Factor Description</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
										<textarea    placeholder = "Factor Description" autocomplete="off" name="factorDescription" name="factorDescription" class="form-control"></textarea>

 											<p class="help-block"></p>
										</div> 
									</div>  
									
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="dueDate">Due Date</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
											<input type="text" placeholder="Due Date" autocomplete="off" id="dueDate" data-select="datepicker" name="dueDate" required class="form-control">
 											<p class="help-block"></p>
										</div> 
									</div> 
									 
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="factorDescription"> Status </label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
											<select class="select2 form-control" name='movementStatus'  autocomplete="off">
												<option Value="">Select type of Status</option>
												<option Value="1">On Hand</option>
												<option Value="2">Shipment</option>
												<option Value="3">Delivered</option>
											</select>
										<p class="help-block"></p>
										</div> 
									</div> 
									 
							</div>
							
							<?php
								fetchFormSubmissionButtons();
							?> 
						</form>
						<div class="blank"></div>
						
						<?php
							}
							listsellsFactor('sellsFactorAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
function selectCustomerCurrency(customerId){
	$.post("AjaxSelectCustomerCurrencyETQ.php",{"customerId":customerId},function(data){
 	$("#currenciesId").append(data);
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
</script>
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>
