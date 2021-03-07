<?php
	require_once("_header.php");
	$menu = "definationAT";
	$formHeader = "ثبت چندین مستحق";
	
 ?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>

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
			<li class="active"><i class="fa fa-list-ul"></i>ثبت افراد مستحق</li> 
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
							
							<input name="formTable" value="<?php echo encryptIt("h_tbl_helps_transactions2"); ?>" type="hidden"  />
							
							 
							
							<div class="alert" style="background-color: #efeaea;">
							
								<div class="form-group">
								
									<div class="col-lg-1 col-md-2 col-sm-3">
										<h4 class="text-center">شماره</h4>
									</div>
									
									<div class="col-lg-1 col-md-4 col-sm-6">
										<h4 class="text-center">تاریخ</h4>
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6">
										<h4 class="text-center">نام</h4>
									</div> 
								  
									<div class="col-lg-1 col-md-4 col-sm-6"> 
										<h4 class="text-center">نام پدر</h4>
									</div> 
									 
									<div class="col-lg-1 col-md-4 col-sm-6"> 
										<h4 class="text-center">شماره تذکره</h4>
									</div> 
									 
									<div class="col-lg-1 col-md-4 col-sm-6"> 
										<h4 class="text-center">شماره تماس</h4>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
										<h4 class="text-center">انتخاب ناحیه</h4>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
										<h4 class="text-center">فرد رابط</h4>
									</div> 
									
									<div class="col-lg-2 col-md-4 col-sm-6"> 
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
 											<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date[]" value="<?php  echo pdate("Y-m-d"); ?>" data-select="datepicker" class="form-control">
										<p class="help-block"></p>
									</div> 
									<div class="col-lg-2 col-md-4 col-sm-6"> 
 											<input type="text" placeholder="نام" autocomplete="off" id="name" name="name[]"  class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 											<input type="text" placeholder="نام پدر" autocomplete="off" id="father" name="father[]"  class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 											<input type="text" placeholder="شماره تذکره" autocomplete="off" id="SSN" name="SSN[]"  class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 											<input type="text" placeholder="شماره تماس" autocomplete="off" id="contact" name="contact[]" required class="form-control">
										<p class="help-block"></p>
									</div> 
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 										<select class="select2 form-control" name='districtsId[]'>
									    	<option Value="">انتخاب ناحیه</option>
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
										</select>
										<p class="help-block"></p>
									</div>
									
									<div class="col-lg-1 col-md-4 col-sm-6"> 
 										<select class="select2 form-control" name='staffsId[]' autocomplete="off">
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
										</select>
										<p class="help-block"></p>
									</div> 
								  
									<div class="col-lg-3 col-md-4 col-sm-6"> 
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
								fetchFormSubmissionButtons();
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
