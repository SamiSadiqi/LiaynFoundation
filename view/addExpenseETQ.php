<?php
	require_once("_header.php");
	$menu = "expensesETQ";
	$formHeader = "ثبت مصارف";
	
 ?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<!---Modals Form Expense Category -->
<div id="add_data_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="expense_form"  method="POST">
					<input name="formParameter" value="<?php echo encryptIt("insertExpenseCategoryETQAJAX"); ?>" type="hidden"  />

					<div class="form-group"> 
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0  control-label" for="data">کتگوری مصرف</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<input type="text" placeholder="کتگوری مصرف" autocomplete="off" id="name" name="name" class="form-control">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
             </div>
        </div>
    </div>
</div>
</div>
<!---Add Expnse Type-->
<div id="add_data_modal_expense_type" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="expense_type_form"  method="POST">
					<input name="formParameter" value="<?php echo encryptIt("insertExpenseTypeETQAJAX"); ?>" type="hidden"  />
					
					<div class="form-group"> 
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0 control-label" for="unit">کتگوری</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<select class="select2 form-control" name='expenseCategory' autocomplete="off" id='expenseCategory'>
								<option Value="">انتخاب کتگوری مصرف</option>
								<?php
								 
								$categoryRow= $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
								while($row = $categoryRow->fetch_array()){
									
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
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0  control-label" for="data">نوع مصرف</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<input type="text" placeholder="نوع مصرف" autocomplete="off" id="name" name="name" class="form-control">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
             </div>
        </div>
    </div>
</div>
</div>
<!-- end modal --
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
			<li class="active"><i class="fa fa-list-ul"></i>مصارف</li> 
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
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsExpenseETQ.php" method="POST"  enctype="multipart/form-data">
						
									<input name="formParameter" value="<?php echo encryptIt("insertExpenseETQ"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">تاریخ <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" id="date" data-select='datepicker' required name="date" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label	class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="expenseCategory">کتگوری <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='expenseCategory' autocomplete="off" onchange ="readExpenses(this.value)" required id='expenseCategoryAppend'>
									    	<option Value="">انتخاب کتگوری</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													echo "<option   value='$id'>$name</option>";
									 
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" required for="expenseType">نوع مصرف <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='expenseType' autocomplete="off" id='expenseType'>
									    	<option Value="">انتخاب نوع مصرف</option>
											 
									</select>
									<p class="help-block"></p>
								  </div>
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal_expense_type" >اضافه<i class="fa fa-plus"></i></button>
								</div>								  
							</div>
						     
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">مقدار <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار" autocomplete="off" id="amount" name="amount"  onKeyPress="return isNumericKey(event)"  required onchange  = "exchangerUsd()" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">بانک <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId' autocomplete="off" required id='bankId'>
									    	<option Value="">انتخاب بانک</option>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="checkCash">فاکتور </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<input type="file" placeholder="آپلود مصرف" autocomplete="off" id="upoladeFile" name="upoladeFile"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">توضیحات <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' required class='form-control'></textarea>
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
								listExpenses("addExpenseETQ.php",$validationEditCondition,$validationRemoveCondition);
						
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
 function exchangerUsd(){
       var Usd =  $("#amount").val();
       var Rate =  $("#rate").val();
	   var total  = parseFloat(Usd) * parseFloat(Rate);
	   var roundOfResult =  total.toFixed(2);
	   $("#usdAmount").val(roundOfResult);
 }

function readExpenses(categoryId){
	$.post("AjaxReadExpenses.php",{"categoryId":categoryId},function(data){
  		 $("#expenseType:not(:first-child)").empty();
  		 $("#expenseType").append(data);
	});
}
//Insert Expense Category Form
$(document).ready(function(){
	$("#expense_form").on('submit',function(){
		event.preventDefault();
		if($('#name').val()==''){
			alert("Please fill the action name");
		} 
		else{
			$.post("../models/actionsExpenseCetagoryETQ.php",$('#expense_form').serialize(),function(data){
				 
 			  if(data != "duplicated"){
					$("#expenseCategoryAppend").append(data);
					$("#expenseCategory").append(data);
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
//Insert expnese type Form
 
$(document).ready(function(){
	$("#expense_type_form").on('submit',function(){
		 event.preventDefault();
		if($('#expenseCategory').val()==''){
			alert("Please fill the action name");
		} 
		else{
			$.post("../models/actionsExpenseTypeETQ.php",$('#expense_type_form').serialize(),function(data){
				alert(data);
 			  if(data != "duplicated"){
					$("#expenseType").append(data);
					$("#feedback").css("background-color", "green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_modal_expense_type').fadeOut(1000,function(){
						$('#add_data_modal_expense_type').modal('hide');
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
