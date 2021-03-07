<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader  = "درخواست تعمیراتی";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
  <!---Modals Form Income Category -->
<div id="add_data_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="form_data"  method="POST">
					<input name="formTable" value="<?php echo encryptIt("tbl_constructions_type"); ?>" type="hidden"  />

					<div class="form-group"> 
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-1 col-md-offset-1 col-sm-offset-0  control-label" for="data">نوع تعمیراتی</label> 
						<div class="col-lg-6 col-md-6 col-sm-8"> 
							<input type="text" placeholder="نوع تعمیراتی" autocomplete="off" id="name" name="name" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div>
					<div class="form-group"> 
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
							<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه <i class="fa fa-paste"></i>  </button>
						</div> 
					</div> 
				</form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بسته</button>
             </div>
			</div>
		</div>
	</div>
</div>
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
			<li class="active"><i class="fa fa-list-ul"></i><strong>درخواست ها </strong></li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('addOrganizationsRequestAT.php');  ?>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
							<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
							?>
							
						<form class="form-horizontal"  id="insertForm" action="<?php echo getRootModel(); ?>newOrgConstructionRequestsAT.php"  enctype="multipart/form-data" method="POST">
						
							<input name="formTable" value="<?php echo encryptIt("tbl_org_construction_requests"); ?>" type="hidden"  />

							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  for="data">تاریخ <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date"  name="date" required class="form-control">
									<span class="text-danger hide" id="dateWarning">فورمت تاریخ اشتباه است.</span>
 									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">شماره درخواستی</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="شماره درخواستی" autocomplete="off" id="requestNumber" name="requestNumber"  onKeyPress="return isNumericKey(event)"   class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="schoolId">مکتب <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='schoolId'  autocomplete="off" id='schoolId'>
									    <option value="">انتخاب مکتب</option>
										<?php
										 
										$schoolsRow= $conn->query("SELECT * FROM `tbl_schools` WHERE deleted = 0 ORDER BY id DESC");
										while($row = $schoolsRow->fetch_array()){
											
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="incomeCategory">نوع تعمیراتی <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='constructionType' autocomplete="off" Required id='constructionType'>
									    	<option Value="">انتخاب نوع تعمیراتی</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_constructions_type` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													$defaults = $row['defaults'];
													if($defaults == 1){
														echo "<option value='$id' selected>$name</option>";
													}else{
														echo "<option value='$id' >$name</option>";

													}
									 
											}   
										
											?>
									</select>
									<p class="help-block"></p>
								 </div>
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal" >اضافه<i class="fa fa-plus"></i></button>
								</div>									 
							</div>
								
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">مقدار / تعداد <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text"   class="form-control" placeholder="مقدار / تعداد" autocomplete="off" Required  onKeyPress="return isNumericKey(event)" id="quantity" name="quantity">
 									<p class="help-block"></p>
								 </div> 
							</div>
							 <div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="upoladeFile"> فایل </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<input type="file" placeholder="آپلود فایل" autocomplete="off" id="upoladeFile" name="upoladeFile"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>	
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">توضیحات درخواستی <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea  placeholder = "توضیحات درخواستی" autocomplete="off" name="description" name="description" Required class="form-control"></textarea>
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
							orgConstructionRequests('$addOrgConstructionsRequestAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
//Insert Expense Category Form
$(document).ready(function(){
	$("#form_data").on('submit',function(){
		event.preventDefault();
		if($('#name').val()==''){
			alert("Please fill the action name");
		} 
	 
		else{
			$.post("AjaxInsertionsModalAT.php",$('#form_data').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#constructionType").append(data);
					$("#feedback").css("background-color", "green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_modal').fadeOut(1000,function(){
						$('#add_data_modal').modal('hide');
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