<?php
	require_once("_header.php");
	$menu = "sevicesAT";
	$formHeader  = "Services Transaction";
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
			<li class="active"><i class="fa fa-list-ul"></i>Service Account</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
				
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('dealerHomeETQ.php');  ?>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsServiceTransactionAT.php" method="POST">
						
							<input name="formParameter" value="<?php echo encryptIt("insertServiceTransaction"); ?>" type="hidden"  />
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="date">Date</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Date" autocomplete="off" id="date" data-select='datepicker' required  name="date" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="serviceType">Service Provider</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='provider' onchange="selectProviderCurrency(this.value)"  autocomplete="off">
									    <option value="">Select Service Provider</option>
										<?php
										 
										$vendorCategoryRow= $conn->query("SELECT * FROM `tbl_service_provider` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $vendorCategoryRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
											if($id == $service_provider_id){
												echo "<option value='$id' selected >$name</option>";
											}else{
												echo "<option value='$id' >$name</option>";
											}
										}   
									
										?>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currenciesId">Currency</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='currenciesId'  onchange="readCurrencyRate(this.value),selectBanks(this.value)" autocomplete="off" id='currenciesId'>
									    <option value="">Select Currency</option>
									 
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">Bank</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId' required autocomplete="off" id='bankId'>
										<option Value="">Select Bank</option>
										<?php
									   
										$bankRow= $conn->query( "SELECT * FROM `tbl_banks` WHERE  deleted = 0");
										While($row = $bankRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
												echo "<option   value='$id'>$name</option>";
								 
										}   
									 
										?>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">Rate</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)"  value="<?php echo $existanceAmount;  ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
													
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">Tasks Amount</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Amount" autocomplete="off"  id="amount" name="amount" onKeyPress="return isNumericKey(event)"  onKeyPress="return isNumericKey(event)"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">Payment Amount</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Payment Amount" autocomplete="off"  id="paymentAmount" onKeyPress="return isNumericKey(event)"  name="paymentAmount" onKeyPress="return isNumericKey(event)"  onchange="calculateFactorRemain()"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">Remain Amount</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Remain Amount" autocomplete="off"  id="remainAmount" onKeyPress="return isNumericKey(event)"  name="remainAmount" onKeyPress="return isNumericKey(event)"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="expenserId">Supervisor</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='supervisorId' autocomplete="off" id='supervisorId'>
										<option Value="">Select Supervisor</option>
										<?php
										 
										$staffRow= $conn->query("SELECT * FROM `tbl_staff` WHERE deleted = 0 ORDER BY id DESC");
										While($row = $staffRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
												echo "<option   value='$id'>$name</option>";
								 
										}   
									
										?>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">Description</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'Description' autocomplete="off" name='description' name='description' class='form-control'></textarea>
 									<p class="help-block"></p>
								 </div> 
							</div>
							 
								<?php
								fetchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						
						<?php
							}
							serviceTransactionList('addServiceTransactionAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
function selectProviderCurrency(providerId){
	$.post("AjaxSelectProviderCurrencyAT.php",{"providerId":providerId},function(data){
	$("#currenciesId").append(data);
	});
}
	
</script>
<?php
	require_once("_extraScripts.php");	
?>
<script>
 
function calculateFactorRemain(){
	var totalAmount     = $("#amount").val();
 	var paymentAmount = $("#paymentAmount").val();
	var factorRemain  = parseFloat(totalAmount - paymentAmount);
	$("#remainAmount").val(factorRemain);
}
</script>
</body>
</html>
