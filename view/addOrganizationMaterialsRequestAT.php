<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader  = "درخواست اقلام";
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
	 
	<div class="main-content">
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>  موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i><strong>ثبت درخواست ها</strong> </li> 
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
							<?php   goBackward('addOrganizationsRequestAT.php');  ?>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content">
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
 						<form class="form-horizontal" method="POST" action="<?php echo getRootModel(); ?>newActionsOrgReqMaterialsAT.php" enctype="multipart/form-data">

							<input name="formTable" value="<?php echo encryptIt("tbl_org_req_materials_title"); ?>" type="hidden"  />
							
							<div class="alert alert-info"  style="padding-bottom: 0px;background-color:#00b8ce">
								<div class="form-group">
									
									<div class="col-lg-3 col-md-4 col-sm-4"> 
										<input type="text" placeholder="تاریخ" autocomplete="off" id="date" required name="date" class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-3 col-md-4 col-sm-4"> 
										<select class="select2 form-control" name='schoolId' required  autocomplete="off" id='schoolId'>
											<option Value="">انتخاب مکتب</option>
											<?php
											 
											$itemsRow= $conn->query("SELECT * FROM `tbl_schools` WHERE  deleted = 0 ORDER BY id DESC");
											while($row = $itemsRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option value='$id'>$name</option>";
									 
											}   
										
											?>
										</select>
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-3 col-md-4 col-sm-4"> 
										<input type="file" placeholder="آپلود فایل" autocomplete="off"    name="upoladeFile" class="form-control">
										<p class="help-block"></p>
									</div> 
									 
									 <div class="col-lg-3 col-md-4 col-sm-4"> 
										 	<input type="text" placeholder="شماره درخواست" autocomplete="off"  onKeyPress="return isNumericKey(event)" name="requestNumber" class="form-control">

										<p class="help-block"></p>
									</div> 
									 
									  
									 
								</div>
							</div>
							
							<div class="alert" style="background-color: #efeaea;">
							
								<div class="form-group">
									<div class="col-lg-1 col-md-2 col-sm-2"> 
										<h4 class="text-center">شماره</h4>
									</div>
									
									<div class="col-lg-3 col-md-4 col-sm-6"> 
										<h4 class="text-center">اجناس</h4>
									</div> 
									
									<div class="col-lg-3 col-md-4 col-sm-5">
										<h4 class="text-center">واحد</h4>
									</div> 
								
									<div class="col-lg-2 col-md-4 col-sm-5"> 
										<h4 class="text-center">تعداد</h4>
									</div> 
									
									 
									<div class="col-lg-3 col-md-4 col-sm-6"> 
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
									 
									<div class="col-lg-3 col-md-4 col-sm-5"> 
										<select class="select2 form-control" name='itemId[]' onchange='selectItemUnit(this.value,<?php  echo $i;   ?>)' autocomplete="off" id='itemId-<?php echo $i; ?>'>
											<option Value="">انتخاب اجناس</option>
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
								
									<div class="col-lg-3 col-md-4 col-sm-5"> 
										<select class="select2 form-control"  name='itemUnit[]' autocomplete="off" id='itemUnit-<?php echo $i; ?>'>
											<option Value="">انتخاب واحد</option> 
											 
										</select>
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-2 col-md-2 col-sm-3"> 
										<input type="text" placeholder="مقدار" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" onKeyPress="return isNumericKey(event)"   id="quantity-<?php echo $i; ?>" name="quantity[]" class="form-control">
										<p class="help-block"></p>
									</div> 
									 
									<div class="col-lg-3 col-md-4 col-sm-6"> 
										<input type="text" placeholder="توضیحات" autocomplete="off" id="description-<?php echo $i; ?>"   name="description[]" class="form-control">
										<p class="help-block"></p>
									</div>
									 									
								</div>
								
								<?php
								
									}
								
								?>
								
								<!-- ------------------------------------------------------------------------------------------------- -->
								 
							</div>
							
							<?php
								fetchFormSubmissionActionButtons();
							?> 
						</form>
						<div class="blank"></div>
						
						<?php
							}
							requestOrganizationsMaterials('addOrganizationMaterialsRequestAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
 
 
 
</script>
<?php
	require_once("_extraScripts.php");	
?>
</body>
</html>