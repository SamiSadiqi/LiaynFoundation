<?php
	require_once("_header.php");
	$menu = "vendorsAT";
	$formHeader  = "فاکتور خرید";
?>
<title><?php echo $pageTitle; ?></title>
  
</head>
<body>

<!-- Page container -->
<div class="page-container">

  <!-- Page Sidebar -->
  
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
						<h5 class="modal-title"><b>موجودی اجناس</b></h5>
					</div>
					<div class="modal-body" id='myModalData'>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">بسته کردن</button>
					 </div>
				</div>
			</div>
		</div>
		<!-- Main content -->
	<div class="main-content">
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>فروشنده گان</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
 							<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content">
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsPurchaseBillETQ.php" method="POST">
							
							<input name="formParameter" value="<?php echo encryptIt("insertPurchasesETQ"); ?>" type="hidden"  />
							
							<div class="alert alert-info"  style="padding-bottom: 0px;background-color:#00b8ce">
								<div class="form-group">
									
									<div class="col-lg-3 col-md-3 col-sm-3"> 
										<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date" data-select ='datepicker' class="form-control">
										<p class="help-block"></p>
									</div> 
								
									<div class="col-lg-3 col-md-3 col-sm-3"> 
										<select class="select2 form-control" name='vendorId' style='font-weight: bold;color:red;' required onchange = "selectVendorCurrency(this.value)" autocomplete="off" id='vendorId'>
											<option Value="">انتخاب فروشنده</option>
											<?php
											 
											$vendorRow= $conn->query("SELECT * FROM `tbl_vendors` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $vendorRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'] . " " . $row['family'];
												echo "<option value='$id' >$name</option>";
									 
											}   
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-3 col-md-3 col-sm-3"> 
										<select class="select2 form-control" name='bankId' required autocomplete="off" id='bankId'>
											<option Value="">انتخاب بانک</option>
											<?php
											   
											$banksRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $banksRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}   
										  
											?>
										</select>
										<p class="help-block"></p>
									</div> 

									<div class="col-lg-3 col-md-3 col-sm-3"> 
										<input type="text" placeholder="شماره فاکتور" autocomplete="off" id="factorNumber" required name="factorNumber" class="form-control">
										<p class="help-block"></p>
									</div>									
									
								</div>
								 
							</div>
							
							<div class="alert" style="background-color: #efeaea;">
							
								<div class="form-group">
									<div class="col-lg-1 col-md-2 col-sm-2"> 
										<h4 class="text-center">شماره</h4>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">انتخاب گدام</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-5">
										<h4 class="text-center">کالا</h4>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<h4 class="text-center">واحد</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<h4 class="text-center">مقدار</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<h4 class="text-center">فی واحد</h4>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-6"> 
										<h4 class="text-center">مجموعه</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">توضیحات</h4>
									</div>										
								</div>
								
								<!-- ------------------------------------------------------------------------------------------------- -->
								
								<input type="hidden" id="form-field" value="9" />
								<?php
								
								for($i = 0; $i < 10; $i++){
									
								?>
								<div class="form-group">
									<div class="col-lg-1 col-md-2 col-sm-2"> 
										<input type="text" placeholder="Fee" autocomplete="off" style="text-align:center" value="<?php  echo $i+1;  ?>"  readonly class="form-control">
										<p class="help-block"></p>
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<select class="select2 form-control" name='stockId[]' autocomplete="off"  id='stockId-<?php  echo $i; ?>'>
											<option Value="">انتخاب گدام</option>
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
											<option Value="">انتخاب کالا</option>
											<?php
											 
											$itemsRow= $conn->query("SELECT * FROM `tbl_items` WHERE  deleted = 0 ORDER BY id DESC");
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
										<select class="select2 form-control"  name='itemUnit[]' autocomplete="off" id='itemUnit-<?php echo $i; ?>'>
											<option Value="">انتخاب واحد</option> 
											 
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<input type="text" placeholder="مقدار" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" ondblclick = "getExistanceStock(<?php   echo $i; ?>)" id="amount-<?php echo $i; ?>" name="amount[]" class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-3"> 
										<input type="text" placeholder="فی" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" id="fee-<?php echo $i; ?>" name="fee[]" class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-2 col-sm-6"> 
										<input type="text" placeholder="مجموعه" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" id="totalFee-<?php echo $i; ?>" name="totalFee[]" class="form-control totalFee">
										<p class="help-block"></p>
									</div> 
								 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<input type="text" placeholder="توضیحات" autocomplete="off" id="description-<?php echo $i; ?>" name="subDescription[]" class="form-control">
										<p class="help-block"></p>
									</div>
									 									
								</div>
								
								<?php
								
									}
								
								?>
								
								<!-- ------------------------------------------------------------------------------------------------- -->
								
								<div class="form-group" id="buttons">
									<div class="col-sm-12 col-md-1 col-md-offset-11 col-lg-1 col-lg-offset-11">
										<button id="addRow" class="btn btn-info btn-outline" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</div>
								</div>
								
							</div>
							
							<div class="alert alert-success col-md-4 col-lg-4 col-xs-12 col-sm-12" style="padding-bottom: 0px;background-color:#00b8ce;">
							
								 
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="name">کل قیمت فاکتور</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
											<input type="text" placeholder="کل قیمت فاکتور" onkeyup="calculateFactorRemain()" autocomplete="off" id="totalFactorPrice" name="totalFactorPrice" class="form-control p-number">
											<p class="help-block"></p>
										</div> 
									</div> 
									
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="factorPayment">مقدار پرداختی</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
											<input type="text" placeholder="مقدار پرداختی" onkeyup="calculateFactorRemain()" autocomplete="off" id="factorPayment" name="factorPayment" class="form-control p-number">
											<p class="help-block"></p>
										</div> 
									</div> 
									  
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="factorRemain">مقدار باقی مانده</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
											<input type="text" placeholder="مقدار باقی مانده" onkeyup="calculateFactorRemain()" autocomplete="off" id="factorRemain" name="factorRemain" class="form-control p-number">
											<p class="help-block"></p>
										</div> 
									</div> 
									   
									<div class="form-group"> 
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="factorDescription">توضیحات فاکتور</label> 
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
										<textarea    placeholder = "توضیحات فاکتور" autocomplete="off" name="factorDescription" name="factorDescription" class="form-control"></textarea>

 											<p class="help-block"></p>
										</div> 
									</div> 
									 
							</div>
							 
							
							<?php
								fetchFormSubmissionActionButtons();
							?> 
						</form>
						<div class="blank"></div>
						
						<?php
							}
							listPurchaseBill('purchasesBillAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
function selectVendorCurrency(vendorId){
 	$.post("AjaxSelectVendorCurrencyETQ.php",{"vendorId":vendorId},function(data){
 		$("#currenciesId").html("");
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