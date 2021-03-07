<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader  = "درخواست تمویل محافل";
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
			<span> موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i> <strong>درخواست ها </strong></li> 
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
						
						<form class="form-horizontal"  id="insertForm" method="POST" action="<?php echo getRootModel(); ?>newActionsSupportCeremoniesRequestAT.php" enctype="multipart/form-data">
						
							<input name="formTable" value="<?php echo encryptIt("tbl_support_ceremonies_requests"); ?>" type="hidden"   />

							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  for="dateWarning">تاریخ <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date"  name="date" required class="form-control">
									<span class="text-danger hide" id="dateWarning">فورمت تاریخ اشتباه است.</span>
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام محفل <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام محفل" autocomplete="off" id="name" name="name"  required  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="requestNumber">شماره درخواست</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="شماره درخواست" autocomplete="off" id="requestNumber" name="requestNumber"  onKeyPress="return isNumericKey(event)"   class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							  
						 <div class="form-group" id="schoolId2"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="unit">مکتب <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='schoolId' required autocomplete="off" id='schoolId'>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="upoladeFile"> فایل </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<input type="file" placeholder="آپلود فایل" autocomplete="off" id="upoladeFile" name="upoladeFile"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">توضیحات درخواستی <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea  placeholder = "توضیحات درخواستی" autocomplete="off" name="description" name="description" required class="form-control"></textarea>
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
							supportCeremoniesRequestAT($addSupportCeremoniesRequestAT,$validationEditCondition,$validationRemoveCondition);
						
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
function selectOrganization(id){
	if(id ==2){
		$('#organization').removeClass('hide').fadeIn(1000)
		$('#schoolId2').addClass('hide').fadeOut(1000)
	}else if(id==1){
		$('#schoolId2').removeClass('hide').fadeIn(1000)
		$('#organization').addClass('hide').fadeOut(1000)
	}
}
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
					$("#organization2").append(data);
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