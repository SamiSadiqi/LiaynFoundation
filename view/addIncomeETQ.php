<?php
	require_once("_header.php");
	$menu = "incomesETQ";
	$formHeader = "Add Incomes Transaction";
	
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
				 
				<form class="form-horizontal" id="income_form"  method="POST">
					<input name="formParameter" value="<?php echo encryptIt("insertIncomeCategoryETQAJAX"); ?>" type="hidden"  />

					<div class="form-group"> 
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0  control-label" for="data">Income Category Name</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<input type="text" placeholder="Income Category Name" autocomplete="off" id="name" name="name" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div>
					<div class="form-group"> 
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
							<button class="btn btn-success btn-outline" name="insert"   type="submit"> Add <i class="fa fa-paste"></i>  </button>
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
<!---Add income Type-->
<div id="add_data_modal_income_type" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="income_type_form"  method="POST">
					<input name="formParameter" value="<?php echo encryptIt("insertIncomeTypeETQAJAX"); ?>" type="hidden"  />
					
					<div class="form-group"> 
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0 control-label" for="unit">Category</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<select class="select2 form-control" name='incomeCategory' autocomplete="off" id='incomeCategory'>
								<option Value="">Select Income Category</option>
								<?php
								 
								$categoryRow= $conn->query("SELECT * FROM `tbl_income_categories` WHERE deleted = 0 ORDER BY id DESC");
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
						<label class="col-lg-3 col-md-2 col-sm-2 col-lg-offset-0 col-md-offset-1 col-sm-offset-0  control-label" for="data">Income Type Name</label> 
						<div class="col-lg-8 col-md-8 col-sm-10"> 
							<input type="text" placeholder="Income Type Name" autocomplete="off" id="name" name="name" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div>
					<div class="form-group"> 
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
							<button class="btn btn-success btn-outline" name="insert"   type="submit"> Add <i class="fa fa-paste"></i>  </button>
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
<!-- end modal -->
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
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Incomes</li> 
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
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsIncomeETQ.php" method="POST">
						
									<input name="formParameter" value="<?php echo encryptIt("insertIncomeETQ"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">Date</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Date" autocomplete="off" id="date" data-select='datepicker' name="date" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="incomeCategory">Income Category</label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='incomeCategory' autocomplete="off" onchange ="readIncomes(this.value)" id='incomeCategoryId'>
									    	<option Value="">Income Category</option>
											<?php
											 
 											$categoryRow= $conn->query("SELECT * FROM `tbl_income_categories` WHERE deleted = 0 ORDER BY id DESC");
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
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal" ><i class="fa fa-plus">Add</i></button>
								</div>									 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="incomeType">Income Type</label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='incomeType' autocomplete="off" id='incomeType'>
									    	<option Value="">Income Type</option>
											 
									</select>
									<p class="help-block"></p>
								 </div> 
								 <div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal_income_type" ><i class="fa fa-plus">Add</i></button>
								</div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">Amount</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount"onKeyPress="return isNumericKey(event)" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currenciesId">Currency</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='currenciesId'  onchange="readCurrencyRate(this.value),selectBanks(this.value)" autocomplete="off" id='currenciesId'>
									    <option value="">Currency</option>
										<?php
										 
										$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
										while($row = $currenciesRow->fetch_array()){
											
											$id   = $row['id'];
											$name = $row['code'];
											echo "<option value='$id'>$name</option>";
								 
										}   
									
										?>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">Rate</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
						
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">Bank</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
									    	<option Value="">Select Bank</option>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">Description</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'Description' autocomplete="off" name='description' name='description' class='form-control'></textarea>
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
								listIncomes($validationEditCondition,$validationRemoveCondition);
						
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
function readIncomes(categoryId){
	$.post("AjaxReadIncomes.php",{"categoryId":categoryId},function(data){
  		 $("#incomeType").html("");
  		 $("#incomeType").append(data);
	});
}
//Insert Expense Category Form
$(document).ready(function(){
	$("#income_form").on('submit',function(){
		event.preventDefault();
		if($('#name').val()==''){
			alert("Please fill the action name");
		} 
	 
		else{
			$.post("../models/actionsIncomeCategoryETQ.php",$('#income_form').serialize(),function(data){
			   
			  if(data != "duplicated"){
					$("#incomeCategoryId").append(data);
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
	$("#income_type_form").on('submit',function(){
		event.preventDefault();
		if($('#expenseCategory').val()==''){
			alert("Please fill the action name");
		} 
		else{
			$.post("../models/actionsIncomeTypeETQ.php",$('#income_type_form').serialize(),function(data){
		 
			  if(data != "duplicated"){
					$("#incomeType").append(data);
					$("#feedback").css("background-color", "green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_modal_income_type').fadeOut(1000,function(){
						$('#add_data_modal_income_type').modal('hide');
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
