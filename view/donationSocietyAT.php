<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader  = "تمویل محافل";
	if(isset($_POST['name'])){
		$_SESSION['schoolId'] = $_POST['name'];
		echo $temp                 = explode("-", $_SESSION['schoolId']);
		$schoolId           = $temp[0];
		$schoolName         = $temp[1];
	}else{
		$temp                 = explode("-", $_SESSION['schoolId']);
		$schoolId           = $temp[0];
		$schoolName         = $temp[1];
	}
	
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
			<span>موقعیت فعلی: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>بانکداری</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php  goBackward('schoolAccountHomeAT.php');  ?>

						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php  
						require_once('alerts.php'); 
						if($validationAddForm == 1){
						?>
						<form class="form-horizontal"  id="insertForm" method="POST">
						
							<input name="formTable" value="<?php echo encryptIt("tbl_literary_circle_requests_helped"); ?>" type="hidden"  />
 							<input name="schoolId" value="<?php echo   $schoolId; ?>" type="hidden"  />

							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="denotionDate">تاریخ تمویل</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ تمویل" autocomplete="off" id="date" required data-select='datepicker' name="denotionDate" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="circleId">نام محفل</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='circleId' required autocomplete="off" id='circleId'>
									    	<option Value="">نام محفل</option>
											<?php
											 
 											$bankRow= $conn->query("SELECT * FROM `tbl_literary_circle_requests` WHERE  deleted = 0 AND status = 0 AND schools_id = '$schoolId' ORDER BY id DESC");
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="amount">مقدار</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="مقدار" autocomplete="off" id="amount" onKeyPress="return isNumericKey(event)"  name="amount" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="currenciesId">واحد پولی</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<select class="select2 form-control" name='currenciesId' autocomplete="off" onchange="readCurrencyRate(this.value),selectBanks(this.value)"  id='currenciesId'>
											<option Value="">واحد پولی</option>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="bankId">بانک</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<select class="select2 form-control" name='bankId'  autocomplete="off" id='bankId'>
									    	<option Value="">انتخاب بانک</option>
											<?php
										   
 											 
											?>
									</select>
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="rate">نرخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نرخ" autocomplete="off" id="rate" onKeyPress="return isNumericKey(event)"  name="rate" value="<?php echo $rate;     ?>" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="description">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = "توضیحات" autocomplete="off" name="description" name="description" class="form-control"></textarea>
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
							donationsTransactionList($schoolId,$validationEditCondition,$validationRemoveCondition);
						
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
<script>
 
function selectBankCurrency(bankId){
	$.post("AjaxSelectBankCurrencyAT.php",{"bankId":bankId},function(data){
 	$("#currenciesId").append(data);
	});
}
</script>
<?php


	require_once("_extraScripts.php");	
?>
</body>
</html>