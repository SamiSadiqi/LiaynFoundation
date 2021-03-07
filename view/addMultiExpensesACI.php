<?php
	require_once("_header.php");
	$menu = "expensesETQ";
	$formHeader = "ثبت چندین مصرف ";
	
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
							<select class="select2 form-control" name='expenseCategory'   autocomplete="off" id='expenseCategory'>
								<option Value="">انتخاب کتگوری</option>
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
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0  control-label" for="data">  مصرف </label> 
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
        </div>
    </div>
</div>
</div>
<!-- end modal --
<!-- Page container -->
<div class="page-container">

  
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
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsMultiExpenseTransactions.php" enctype="multipart/form-data" method="POST">
							
								<input name="formParameter" value="<?php echo encryptIt("insertMultitransactions"); ?>" type="hidden"  />
							
							<div class="alert" style="padding-bottom: 0px;">
							 
								<div class="form-group">
									 
								  
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" > 
											<label class="col-lg-4 col-md-6 col-sm-7 col-xs-6 control-label"  >کتگوری مصرف</label> 
												<div class="col-lg-4 col-md-6 col-sm-5  col-xs-6" >
													<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal" >اضافه<i class="fa fa-plus"></i></button>
												</div>	
										</div> 
								 	  
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6"> 
										<label class="col-lg-4 col-md-6 col-sm-6   col-xs-6 col-sm-offset-0 control-label">نوع مصرف</label> 
											<div class="col-lg-4 col-md-6  col-xs-6 col-sm-6">
												<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal_expense_type" >اضافه<i class="fa fa-plus"></i></button>
											</div>	
										</div> 
								  
								</div>
								 
							</div>
							
							<div class="alert" style="background-color: #efeaea;">
							
								<div class="form-group">
								
									<div class="col-lg-1 col-md-2 col-sm-3">
										<h4 class="text-center">شماره</h4>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6">
										<h4 class="text-center">تاریخ</h4>
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6">
										<h4 class="text-center">کتگوری</h4>
									</div> 
								  
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">نوع مصرف</h4>
									</div> 
									 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">مقدار</h4>
									</div> 
									  
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">بانک</h4>
									</div>
									 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<h4 class="text-center">فاکتور</h4>
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
								<div class="form-group" id="changeColor-<?php echo $i;   ?>" style='border:1px solid black;padding-top:10px;'>
									<div class="col-lg-1 col-md-2 col-sm-3"> 
											<input type="text"  autocomplete="off" value="<?php  echo $i+1;  ?>" style="text-align:center;" readonly class="form-control">
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-1 col-md-4 col-sm-6"> 
											<input type="text" placeholder="تاریخ" autocomplete="off" id="date" data-select='datepicker'   name="date[]" class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 										<select class="select2 form-control expenseCategoryForm" name='category[]' autocomplete="off" onchange ="readExpenses(this.value,<?php  echo $i;    ?>)" id='catergoryId-<?php echo $i; ?>'>
									    	<option Value="">کتگوری</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $categoryRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													echo "<option   value='$id'>$name</option>";
									 
											}   
											?>
										</select>
										</select>
										<p class="help-block"></p>
									</div>
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
 										<select class="select2 form-control" name='expenseType[]' autocomplete="off"  id='typeId-<?php echo $i; ?>'>
									    	<option Value="">نوع مصرف</option>
											<?php
											 
											?>
										</select>
										</select>
										<p class="help-block"></p>
									</div> 
								 
									<div class="col-lg-1 col-md-4 col-sm-6"> 
									<input type="text" placeholder="مقدار" autocomplete="off"  id="amount-<?php echo $i; ?>" name="amount[]" onchange = "exchangerUsd(<?php  echo $i;  ?>)" onKeyPress="return isNumericKey(event)" class="form-control">
										<p class="help-block"></p>
									</div> 
									  
									<div class="col-lg-2 col-md-4 col-sm-6"> 
											<select class="select2 form-control" name='bankId[]' autocomplete="off" id='bankId-<?php echo $i;   ?>'>
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
										</select>
										<p class="help-block"></p>
									</div> 
									 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<input type="file" placeholder="آپلود فایل" autocomplete="off" id="upoladeFile" name="upoladeFile[]"  class="form-control">
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
										<input type="text" placeholder="توضیحات" autocomplete="off"  name="description[]" class="form-control">
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
 						    	listExpenses($addMultiExpensesACI,$validationEditCondition,$validationRemoveCondition);
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
// read expenses category.
function readExpenses(categoryId,rowId){
	$.post("AjaxReadExpenses.php",{"categoryId":categoryId},function(data){
  		 $("#typeId-"+rowId+":not(:first-child)").empty();
  		 $("#typeId-"+rowId).append(data);
  		 $('#changeColor-'+rowId).css('background-color','lightblue');
	});
}
function exchangerUsd(rowId){
       var afa =  $("#amount-"+rowId).val();
       var Rate =  $("#rate-"+rowId).val();
	   var total  = parseFloat(afa) * parseFloat(Rate);
	   var roundOfResult =  total.toFixed(2);
	   $("#usdAmount-"+rowId).val(roundOfResult);
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
					$(".expenseCategoryForm").append(data);
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


function readCurrencyRateDynamic(currenciesId,rowId){
	if(currenciesId != " "  && currenciesId != null){
		$.post("AjaxReadCurrenies.php",{"currenciesId":currenciesId},function(data){
			 var trimmedResponse = $.trim(data)
			$("#rate-"+rowId).val(trimmedResponse);
		});
	}
}

function selectBanksDynamic(currenciesId,rowId){
	if(currenciesId != " "  && currenciesId != null){
		$.post("AjaxSelectSelfBankETQ.php",{"currenciesId":currenciesId},function(data){
			$("#bankId-"+rowId+":first-child").html("");
			$("#bankId-"+rowId+":first-child").html(data);
		});
	}
}

</script>
</body>
</html>
