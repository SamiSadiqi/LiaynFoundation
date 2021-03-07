<?php
	require_once("_header.php");
	$menu = "helpingAT";
	$formHeader  = "پرداخت کمک به کمک گیرنده";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>

<!-- Item Expense Category -->
<div id="add_expense_category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
				<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
					 
					<form class="form-horizontal" id="category_form"  method="POST">
							<input name="table" value="<?php echo encryptIt("tbl_org_expense_categories"); ?>" type="hidden"  />

							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">کتگوری مصرف</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="کتگوری مصرف" autocomplete="off" id="categoryName" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
									<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه کردن <i class="fa fa-paste"></i>  </button>
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
			<li class="active"><i class="fa fa-list-ul"></i>کمک رسانی</li> 
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
						<form method="post"   enctype="multipart/form-data" action="<?php echo getRootModel(); ?>newActionsRecipientPaymentAT.php" class="form-horizontal" role="form">

							<input name="formTable" value="<?php echo encryptIt("tbl_recipients_payment"); ?>" type="hidden"  />
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  for="data">تاریخ <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" data-select='datepicker' onkeyup="checkDate(this.value)" name="date" id="date" required class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="unit">نام کمک گیرنده<span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='recipientId' required autocomplete="off" id='recipientId'>
									    	<option Value="">انتخاب کمک گیرنده</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_recipients` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													$rowInterface    = $conn->selectRecord("tbl_interface", "id = " . $row['interface_id']);
													$interfaceName = $rowInterface['name'];
													$rowDegree    = $conn->selectRecord("tbl_degree", "id = " . $row['degree_id']);
													$rowDegree = $rowDegree['name'];
													echo "<option value='$id' > ".$name."--".$interfaceName."--".$rowDegree."</option>";
											}   
										
											?>
									</select>
									<p class="help-block"></p>
								 </div>
								  
							</div> 
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">مقدار کمک<span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار کمک" autocomplete="off" id="amount" required onKeyPress="return isNumericKey(event)"  name="amount" class="form-control">
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">بانک <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId' required autocomplete="off" id='bankId'>
									    	<option Value="">انتخاب بانک</option>
											<?php
											 
											$bankQuery= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $bankQuery->fetch_array()){
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'></textarea>
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
							allRecipientPaymentAT('recipentPaymentAidAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
 
//Insert Expense Category
$(document).ready(function(){
	$("#category_form").on('submit',function(){
		event.preventDefault();
		if($('#categoryName').val()==''){
			alert("لطفا خانه پوری نمایید.");
		} 
		else{
			$.post("AjaxAddPlusFormACI.php",$('#category_form').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#expenseCategory").append(data);
					$("#feedback").css("background-color","green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_expense_category').fadeOut(1000,function(){
						$('#add_expense_category').modal('hide');
					});
					$("#categoryName").val('');
 					$("#feedback").fadeOut(1000); 
				 }
				else{
					$("#feedback").css("background-color", "red");
					$("#feedback").html("این کتگوری قبلا به سیستم ذخیره شده است.");
				}
			 
			});
		}
	});
});

</script>
</body>
</html>