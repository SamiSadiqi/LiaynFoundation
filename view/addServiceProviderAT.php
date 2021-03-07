<?php
	require_once("_header.php");
	$menu = "sevicesAT";
	$formHeader  = "Add Sevice Provider";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<div id="add_data_category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="vendorCategory"  method="POST">
					<input name="table" value="<?php echo encryptIt("tbl_service_categories"); ?>" type="hidden"  />

						<div class="form-group"> 
							<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">Service Type</label> 
							<div class="col-lg-6 col-md-8 col-sm-10"> 
								<input type="text" placeholder="Service Type" autocomplete="off" id="name" name="name" class="form-control">
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
			<li class="active"><i class="fa fa-list-ul"></i>Services Provider</li> 
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
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsServiceProviderAT.php" method="POST">
						
							<input name="formParameter" value="<?php echo encryptIt("insertServiceProviderAT"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">Date</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Date" autocomplete="off" id="date" data-select="datepicker" name="date" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">Name </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Name / Company" id="name" autocomplete="off" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="serviceType">Service Provider Type</label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
									<select class="select2 form-control" name='serviceType' id="serviceType" autocomplete="off">
									    <option value="">Select Service Provider</option>
										<?php
										 
										$vendorCategoryRow= $conn->query("SELECT * FROM `tbl_service_categories` WHERE deleted = 0 ORDER BY id DESC");
										while($row = $vendorCategoryRow->fetch_array()){
											
											$id   = $row['id'];
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
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_category" ><i class="fa fa-plus">Add</i></button>
								</div>									 
							</div>	
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="contact">Contact</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Contact" autocomplete="off" id="contact" name="contact" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
						
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currenciesId">Currency</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='currenciesId'  onchange="readCurrencyRate(this.value)" autocomplete="off" id='currenciesId'>
									    <option value="">Select Currency</option>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="openingBalance">Opening Balance</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Opening Balance" autocomplete="off"  onKeyPress="return isNumericKey(event)"  id="openingBalance" name="openingBalance" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">Rate</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="transactionType" >Service Transaction Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='transactionType' autocomplete="off">
									    <option value="">Select Transaction Type </option>
										<option value="1"> Expenses </option>
										<option value="2"> Assets </option>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">Address</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'Address' autocomplete="off" id='address' name='address' class='form-control'></textarea>
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
							listServiceProvider('addServiceProviderAT.php',$validationEditCondition,$validationRemoveCondition);
						
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
			  if(data != "duplicated"){
					$("#serviceType").append(data);
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