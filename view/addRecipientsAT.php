<?php
	require_once("_header.php");
	$menu = "helpingAT";
	$formHeader  = "ثبت کمک گیرنده";
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
			<span>موقعیت فعلی</span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i><strong>کمک ها </strong></li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
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
							
							<input name="formTable" value="<?php echo encryptIt("tbl_recipients"); ?>" type="hidden"  />
							
							<div class="form-group"> 
							
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="date"> تاریخ ثبت  <span class="text-danger" style="font-size:20px;">*</span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date" onchange="checkDate(this.value)" required name="date" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
	
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  required for="name">نام<span class="text-danger" style="font-size:20px;">*</span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام" autocomplete="off" id="name" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
	  
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">شماره تماس</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="شماره تماس" autocomplete="off" id="contact" name="contact"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
	
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" required for="districtId">مرتبط <span class="text-danger" style="font-size:20px;">   * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='interface' autocomplete="off" id='interface'>
									    	<option Value="">مرتبط به</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_interface` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
												$id = $row['id'];
												$name = $row['name'];
												echo "<option value='$id' >$name</option>";
											}   
										
											?>
									</select>
									<p class="help-block"></p>
								 </div>
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" required for="districtId"> رشته تحصیلی <span class="text-danger" style="font-size:20px;">   * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='degree' autocomplete="off" id='interface'>
									    	<option Value="">رشته تحصیلی</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_degree` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
												$id = $row['id'];
												$name = $row['name'];
												echo "<option value='$id' >$name</option>";
											}   
										
											?>
									</select>
									<p class="help-block"></p>
								 </div>
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="schoolGender">جنسیت</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='gender' autocomplete="off" id='schoolGender'>
									    	<option Value="">انتخاب جنسیت</option>
											<option value="1">مذکر</option>
											<option value="2">مؤنث</option>
 									</select>
									<p class="help-block"></p>
								 </div>
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="schoolGender">درجه فقر</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='povertyDegree' autocomplete="off" id='povertyDegree'>
									    	<option Value="">انتخاب درجه فقر</option>
											<option value="1">شدید</option>
											<option value="2">متوسط</option>
											<option value="3">خوب</option>
 									</select>
									<p class="help-block"></p>
								 </div>
							</div> 
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">آدرس<span class="text-danger" style="font-size:20px;">*</span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = "آدرس" autocomplete="off" name="description" id="description" required class="form-control"></textarea>
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
							recipientsList('addRecipientsAT.php',$validationEditCondition,$validationRemoveCondition);
						
						?>
						
					</div> 
				</div> 
			</div>
		</div>
		<!-- Footer -->
		<footer class="animatedParent animateOnce z-index-10"> 
		
		<?php
			//require_once("_footer.php");
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
 $(document).on('click','#insertId',function(){
	var date = $("#date").val();
	var name = $("#name").val();
	var interfaceOrg = $("#interfaceOrg").val();
	var gender = $("#gender").val();
	var description =  $("#description").val();
 
	if (date ==""){
        $("#date").addClass("c-error");
	}else if(name == ""){
		$("#name").addClass("c-error");
	}else if(interfaceOrg == ""){
		$("#interfaceOrg").addClass("c-error");
	}else if(gender == ""){
		$("#gender").addClass("c-error");
	}else if(description == ""){
		$("#description").addClass("c-error");
	}else{
		
		$("#date").removeClass("c-error");
 		$("#name").removeClass("c-error");
 		$("#interfaceOrg").removeClass("c-error");
 		$("#gender").removeClass("c-error");
 		$("#description").removeClass("c-error");
		
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