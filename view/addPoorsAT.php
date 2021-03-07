<?php
	require_once("_header.php");
	$menu = "definationAT";
	$formHeader  = "ثبت افراد مستحق";
	 
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
			<span>موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>ثبت افراد مستحق</li> 
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
						<?php  
							require_once('alerts.php'); 
						 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal"  id="insertForm" method="POST">
						
							<input name="formTable" value="<?php echo encryptIt("h_tbl_helps_transactions"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date" data-select="datepicker" value="<?php  echo pdate("Y-m-d"); ?>" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
 							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام" id="name" autocomplete="off" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام پدر </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام پدر" id="father" autocomplete="off" name="father" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name"> شماره تذکره</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="شماره تذکره" id="SSN" autocomplete="off" name="SSN" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name"> شماره تماس</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="شماره تماس" id="contact" autocomplete="off" name="contact" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="vendorType">انتخاب ناحیه/ ولسوالی</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='districtsId'  id="districtsId" autocomplete="off">
									    <option value="">انتخاب ولسوالی / ناحیه</option>
										<?php
										 
										$distictsSql= $conn->query("SELECT * FROM `h_tbl_districts` WHERE deleted = 0 ORDER BY id DESC");
										while($row = $distictsSql->fetch_array()){
											
											$id   = $row['id'];
											$name = $row['name'];
											$defaults = $row['defaults'];
											if($defaults == 1){
												echo "<option value='$id' selected >$name</option>";
											}else{
												echo "<option value='$id' selected >$name</option>";

											}
								 
										}   
									
										?>
									</select>
									<p class="help-block"></p>
								 </div>
								 <!---
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_category" >اضافه<i class="fa fa-plus"></i></button>
								</div>	
								-->
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="vendorType">فرد رابط</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='staffsId'  id="staffsId" autocomplete="off">
									    <option value="">فرد رابط</option>
										<?php
										 
										$distictsSql= $conn->query("SELECT * FROM `h_tbl_staff_managers` WHERE deleted = 0 ORDER BY id DESC");
										while($row = $distictsSql->fetch_array()){
											
											$id   = $row['id'];
											$name = $row['name'];
											$defaults = $row['defaults'];
											if($defaults == 1){
												echo "<option value='$id' selected >$name</option>";
											}else{
												echo "<option value='$id' selected >$name</option>";

											}
								 
										}   
									
										?>
									</select>
									<p class="help-block"></p>
								 </div>
								 							
							</div>	
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'توضیحات' autocomplete="off" id='description' name='description' class='form-control'></textarea>
 									<p class="help-block"></p>
								 </div> 
							</div>
							
							<?php
							//	fetchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						
						<?php
							}
							listHelpingAT('addPoorsAT.php',$validationEditCondition,$validationRemoveCondition);
						
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

//Insert Item Inventory
$(document).ready(function(){
	$("#vendorCategory").on('submit',function(){
		event.preventDefault();
		if($('#name').val()==''){
			alert("Please fill the action name");
		} 
		else{
			$.post("AjaxAddPlusFormACI.php",$('#vendorCategory').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#vendorType").append(data);
					$("#feedback").css("background-color","green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_category').fadeOut(1000,function(){
						$('#add_data_category').modal('hide');
					});
					$("#name").val('');
 					$("#feedback").fadeOut(1000); 

				 }
				else{
					$("#feedback").css("background-color", "red");
					$("#feedback").html("Your Data is duplicated");
				}
			 
			});
		}
	});
});

</script>
</body>
</html>
