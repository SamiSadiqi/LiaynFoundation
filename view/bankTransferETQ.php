<?php
	require_once("_header.php");
	$menu = "banksAT";
	$formHeader  = "انتقالات بانکی";

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
			<span>موقعیت فعلی شما: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>بانکداری</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">انتقالات بانکی</div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
 
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsTransferBankETQ.php" method="POST">
						
							<input name="formParameter" value="<?php echo encryptIt("insertTransferBankETQ"); ?>" type="hidden"  />
							<input name="currenciesId"  id = "currenciesId" type="hidden" />
							<input name="desCurrenciesId"  id = "desCurrenciesId" type="hidden" />
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">تاریخ <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date" required name="date" data-select="datepicker" class="form-control">
 									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="sourceBank">بانک منبع <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='sourceBank' required  onchange = "transferBankAdjustment(this.value)"  autocomplete="off" id='sourceBank'>
									    	<option Value="">انتخاب بانک منبع</option>
											<?php
											 
 											$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE  deleted = 0 ORDER BY id DESC");
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="existanceAmount1">موجودی بانک منبع </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="موجودی بانک منبع" autocomplete="off" id="existanceAmount1" readonly name="existanceAmount1" onKeyPress="return isNumericKey(event)" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">مقدار قابل انتقال <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار قابل انتقال" autocomplete="off" id="amount" required name="amount"   onKeyPress="return isNumericKey(event)" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="destinationBank">بانک مقصد <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='destinationBank' required autocomplete="off"   id='destinationBank'>
									    	<option Value="">بانک مقصد</option>
											<?php
											 
 										 	$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = "توضیحات" autocomplete="off" name="description" name="description" class="form-control"></textarea>
 									<p class="help-block"></p>
								 </div> 
							</div>	
							<?php
								fetchFormSubmissionActionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						
						<?php
							}
							listTransferExchangeBanks($validationEditCondition,$validationRemoveCondition);
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
	function transferBankAdjustment(bankId){
		$.post("AjaxReadExistanceBankETQ.php",{"bankId":bankId},function(data){
			 $("#existanceAmount1").val(parseFloat(data).toFixed(2));
 		});	
	}
	function currenciesDestinationBank(bankId){
		$.post("AjaxReadCurrenciesDesiBankACI.php",{"bankId":bankId},function(data){
            var destinationBank = data.split("-");
            var currenciesDesCode = destinationBank[0];
            var currenciesDesId = destinationBank[1];
            var currenciesRate = destinationBank[2];

            $("#currenciesCodeDestinationBank").val(currenciesDesCode); 
            $("#desCurrenciesId").val(currenciesDesId); 
            $("#destinationRate").val(currenciesRate); 
		});	
	}
	function existanceDistinationBank(bankId){
		$.post("AjaxReadExistanceDistinationBankETQ.php",{"bankId":bankId},function(data){
			 $("#existanceAmount2").val(parseFloat(data).toFixed(2));
		});	
	}
   
 </script>
<?php
	require_once("_extraScripts.php");	
?>
</body>
</html>