<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader  = "Add Bank";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<!---Modals Form Income Category -->

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
			<span>Your Now Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Banking</li> 
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
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
							
						<form class="form-horizontal"  method="POST">
						
							 <div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="incomeCategory">Item Category</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_item_categories',this.value)" >
									    	<option Value="">Item Category</option>
											<?php
											 
 											$itemCategoryRow= $conn->query("SELECT * FROM `tbl_item_categories` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $itemCategoryRow->fetch_array()){
											
												$id   = $row['id'];
												$name = $row['name'];
												$defaults = $row['defaults'];
												if($defaults == 1){
													echo "<option  value='$id' selected>$name</option>";
												}else{
													echo "<option  value='$id' >$name</option>";

												}
									 
											}   
										
										?>
									</select>
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankCategory">Item Unit</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control"  onchange="changeDefaluts('tbl_item_units',this.value)">
									    	<option Value="">Item Unit</option>
											<?php
											 
 											$itemUnitRow= $conn->query("SELECT * FROM `tbl_item_units` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $itemUnitRow->fetch_array()){
												
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
									<p class="help-block"></p>
								 </div>
							</div>
							
							
							 <div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Item</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_items',this.value)" >
									    	<option Value="">Select Item</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Stock</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_stocks',this.value)" >
									    	<option Value="">Select Stock</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Vendor Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_vendor_categories',this.value)" >
									    	<option Value="">Select Vendor Type</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_vendor_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Vendor</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_vendors',this.value)" >
									    	<option Value="">Select Vendor</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_vendors` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Customer Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_customer_categories',this.value)" >
									    	<option Value="">Select Customer Type</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_customer_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Customer</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_customers',this.value)" >
									    	<option Value="">Select Customer</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_customers` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Service Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_service_categories',this.value)" >
									    	<option Value="">Select Service Type</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_service_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Service Provider</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_service_provider',this.value)" >
									    	<option Value="">Select Service Provider</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_service_provider` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Bank</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_banks',this.value)" >
									    	<option Value="">Select Bank</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Bank Category</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_banks_category',this.value)" >
									    	<option Value="">Select Bank Category</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_banks_category` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Expense Category</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_expense_categories',this.value)" >
									    	<option Value="">Select Category</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Expense Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_expense_types',this.value)" >
									    	<option Value="">Select Type</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_expense_types` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							  
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Income Category</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_income_categories',this.value)" >
									    	<option Value="">Select Category</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_income_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							   
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Income Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_income_types',this.value)" >
									    	<option Value="">Select Type</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_income_types` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
							 	   
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Dealer</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_dealers',this.value)" >
									    	<option Value="">Select Dealer</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_dealers` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
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
									<p class="help-block"></p>
								 </div>
							</div>
													 	   
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label">Asset Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" onchange="changeDefaluts('tbl_asset_types',this.value)" >
									    	<option Value="">Select Asset</option>
											<?php
											 
 											$categoryRow = $conn->query("SELECT * FROM `tbl_asset_types` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													$defaults = $row['defaults'];
													if($defaults == 1){
														echo "<option  value='$id' selected > $name </option>";
													}else{
														echo "<option  value='$id'> $name </option>";

												}
											}
											?>
									</select>
									<p class="help-block"></p>
								 </div>
							</div>
							 
						</form>
						<div class="blank"></div>
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
function changeDefaluts(table,id){
 	$.post("AjaxSetDefaulstsAT.php",{"table":table,"id":id},function(data){
		if(data == 'done'){
			alert("Successfully done");
			 
		}else if(data == 'error'){
			alert("Error Occurred!");
		}
	});
}
</script>
</body>
</html>