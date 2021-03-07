<?php
	require_once("_header.php");
	$menu = "customersAT";
	$formHeader  = "Customer Payment";
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
			<li class="active"><i class="fa fa-list-ul"></i>Customer Accounts</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('customerHomeAT.php');  ?>

						</ul> 
					</div> 
					<?php
					//select Factor Id.
					$factorSql  = $conn->query("SELECT * FROM tbl_customer_payment WHERE deleted = 0 AND payment_type = 2 ORDER BY id DESC");
					$factorNumber = $factorSql->num_rows+1;
					?>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsCustomerPaymentETQ.php" method="POST">
						
							<input name="formParameter" value="<?php echo encryptIt("insertCustomerPaymentETQ"); ?>" type="hidden"  />
  							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="date">Date</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Date" autocomplete="off" id="date" name="date" data-select="datepicker" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="factorNumber">Payment Number</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text"  value="<?php  echo $factorNumber;  ?>"   name='factorNumber'  class="form-control" readOnly>
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currencyId">Customer Name</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='customerId' onchange="selectCustomerCurrency(this.value)" autocomplete="off" id='customerId'>
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
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currenciesId">Currency</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<select class="select2 form-control" name='currenciesId' autocomplete="off" onchange="readCurrencyRate(this.value),selectBanks(this.value)"  id='currenciesId'>
											<option Value="">Select Currency</option>
											
										</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">Amount</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Amount" autocomplete="off" id="amount" onKeyPress="return isNumericKey(event)"  name="amount" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">Rate</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Rate" autocomplete="off" id="rate" onKeyPress="return isNumericKey(event)"  name="rate" value="<?php echo $rate;     ?>" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">Bank</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
									    	<option Value="">Select Bank</option>
											<?php
										   
 											$bankRow= $conn->query( "SELECT * FROM `tbl_banks` WHERE currencies_id = '$currencyId' AND deleted = 0");
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
							listCustomersPayments($validationEditCondition,$validationRemoveCondition);
						
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
function selectCustomerCurrency(customerId){
	$.post("AjaxSelectCustomerCurrencyETQ.php",{"customerId":customerId},function(data){
 	$("#currenciesId").append(data);
	});
}
</script>
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>
