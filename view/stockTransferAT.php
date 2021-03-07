<?php
	require_once("_header.php");
	$menu = "stocksAT";
	$formHeader  = "انتقالات بین گدام ها";
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
			<span>موقعیت فعلی : </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>گدام</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader;; ?></div> 
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
						<form class="form-horizontal"  id="insertForm" method="POST">
						
							<input name="formTable" value="<?php echo encryptIt("tbl_stock_transaction"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="date">تاریخ<span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date"  name="date" data-select='datepicker' class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="sourceStocksId">گدام منبع <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10">
									<div id="sourceStocksIdDiv">
										<select id="sourceStocksId" name="sourceStocksId" onchange="readStockAmount(this.value, itemsId.value)" autocomplete="off" class="select2 form-control">
											<option value="">انتخاب گدام منبع</option>
											<?php
												$sourceStock = $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
												while($row = $sourceStock->fetch_array()){
													
													$id   = $row['id'];
													$name = $row['name'];
													$default = $row['defaults'];
													if($default == 1){
														echo "<option  value='$id' selected>$name</option>";
													}else{
														echo "<option  value='$id'>$name</option>";
													}
												}   
											?>
										</select>
									</div>
									<p class="help-block"></p>
								 </div> 
							</div>
							  
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="itemsId">جنس <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10">
									<div id="itemsIdDiv">
										<select id="itemsId" name="itemsId" autocomplete="off" onchange="readStockAmount(sourceStocksId.value, this.value);" class="select2 form-control">
											<option value="">انتخاب جنس</option>
											<?php
												$selectItem = $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC");
												while($row = $selectItem->fetch_array()){
													
													$id   = $row['id'];
													$name = $row['name'];
													$defaults = $row['defaults'];
													if($defaults == 1){
														echo "<option  value='$id' selected>$name</option>";
													}else{
														echo "<option  value='$id'>$name</option>";
													}
												}   
											?>
										</select>
									</div>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="openingBalance">موجودی گدام منبع </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار موجودی جنسی منبع" autocomplete="off" onKeyPress="return isNumericKey(event)"  id="existedSourceAmount" name="existedSourceAmount" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="transferAmount">مقدار قابل انتقال <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار قابل انتقال" autocomplete="off" id="transferAmount" onKeyPress="return isNumericKey(event)"  name="transferAmount" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="destinationStocksId">انتخاب گدام مقصد <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10">
									<div id="destinationStocksIdDiv">
										<select id="destinationStocksId" name="destinationStocksId" autocomplete="off" onchange="readDestanitionStock(this.value,itemsId.value)" class="select2 form-control">
											<option value="">انتخاب گدام مقصد</option>
											<?php
												$sourceStock = $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
												while($row = $sourceStock->fetch_array()){
													
													$id   = $row['id'];
													$name = $row['name'];
													$default = $row['defaults'];
													if($default == 1){
														echo "<option  value='$id' selected>$name</option>";
													}else{
														echo "<option  value='$id'>$name</option>";
													}
												}   
											?>
										</select>
									</div>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="openingBalance">موجودی فعلی گدام مقصد</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="موجودی فعلی گدام مقصد" autocomplete="off" onKeyPress="return isNumericKey(event)"  id="existedDestinationAmount" name="existedDestinationAmount" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'></textarea>
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
							listTransferItem('stockTransferAT.php',$validationEditCondition,$validationRemoveCondition);
						
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

<?php
	require_once("_extraScripts.php");	
?>
<script>
	function readStockAmount(stock, item){
		
		if(stock != " " && item != " " && stock != null && item != null){
			$.ajax({
				url: "AjaxStockSituationAT.php",
				type: "GET",
				data:{itemId: item,stockId:stock},
				success: function(data){
					$("#existedSourceAmount").val(data);
				}
			});
		}
		
	}
	function readDestanitionStock(destinationStock, item){
		
		if(destinationStock != " " && item != " " && destinationStock != null && item != null){
			$.ajax({
				url: "AjaxStockSituationAT.php",
				type: "GET",
				data:{itemId: item,stockId:destinationStock},
				success: function(data){
					$("#existedDestinationAmount").val(data);
				}
			});
		}
		
	}
  
//insert form by this function.
$(document).on('click','#insertId',function(){
	var date = $("#date").val();
	var sourceStocksId = $("#sourceStocksId").val();
	var itemsId =  $("#itemsId").val();
	var transferAmount =  $("#transferAmount").val();
	var destinationStocksId =  $("#destinationStocksId").val();
 
	if (date ==""){
        $("#date").addClass("c-error");
	}else if(sourceStocksId == ""){
		$("#sourceStocksIdDiv").addClass("c-error");
	}else if(itemsId == ""){
		$("#itemsIdDiv").addClass("c-error");
	}else if(transferAmount == ""){
		$("#transferAmount").addClass("c-error");
	}else if(destinationStocksId == ""){
		$("#destinationStocksIdDiv").addClass("c-error");
	}else{
		
		$("#date").removeClass("c-error");
 		$("#sourceStocksIdDiv").removeClass("c-error");
 		$("#itemsIdDiv").removeClass("c-error");
 		$("#destinationStocksIdDiv").removeClass("c-error");
 		$("#transferAmount").removeClass("c-error");
 		
		
		
		var href = document.location.href;
		var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
		$.post("insertDataAT.php",$('#insertForm').serialize(),function(data){
			//alert(data);
			 
			if(data == 'error'){
				 
				$('#error').removeClass('hide').fadeIn(1000).fadeOut(2000)

			}else if(data == 'duplicate2'){
				
				$('#duplicate2').removeClass('hide').fadeIn(1000).fadeOut(2000)

			}else if(data == 'saved'){
				
				$('#saved').removeClass('hide').fadeIn(1000).fadeOut(2000)
				$(".table-responsive").load(lastPathSegment + " .table-responsive > *");
				document.getElementById("insertForm").reset();
				 
			}else{
				
				 alert(data);
			}
		});
	}
});
</script>

</body>
</html>