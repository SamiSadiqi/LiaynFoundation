<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader  = "تمویل محافل";
	if(isset($_POST['name'])){
		$_SESSION['schoolId'] = $_POST['name'];
		$temp                 = explode("-", $_SESSION['schoolId']);
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
					 
					 
					 
						
						$banksRawSQLQuery    = "SELECT * FROM tbl_schools_requests_equipments_title WHERE deleted = 0 AND schools_id = $schoolId ORDER BY id";
						$requestConstructionSQLQuery       = $conn->query($banksRawSQLQuery);
						if($requestConstructionSQLQuery->num_rows > 0){
						
						?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
									 
										<?php
									
										while($row = $requestConstructionSQLQuery->fetch_array()){
											++$counter;
											$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
											$titleId = $row['id'];
										?>
										<tr>
											<th class="text-center table-title" colspan="17">
												مجموعه درخواستی ها بخاطر توزیع اجناس <?php  echo "<b>".$rowSchools['name']."<b>";   ?>
											</th>
										</tr>
										
										<tr class="table-header"> 
  											<th class="text-center">تاریخ درخواست</th>
 											<th class="text-center">فایل</th>
											<th class="text-center">شماره درخواستی</th>
										</tr> 
									</thead> 
									<tbody> 
									
										<tr id='row-<?php echo $row['id']; ?>'> 
 											<td class='text-center'><?php echo $row['date']; ?></td>
 											<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
											<td class='text-center'><?php echo $row['request_number']; ?></td>
										</tr>
										<tr>
										<td colspan="1" class="text-center" style="vertical-align:middle;font-weight:bold;font-size:18px">جزئیات درخواستی اجناس</td>
										<td colspan='5'>
											<table class="table table-bordered table-hover">
												 
													<?php
														$requestDetailsSql   = "SELECT * FROM tbl_schools_requests_equipments_details WHERE deleted = 0 AND  request_title_id = $titleId ORDER BY id";
														$requestDetailsQuery       = $conn->query($requestDetailsSql);
														if($requestDetailsQuery->num_rows > 0){
													?>
													
													<tr style='background-color:#099'>
														<th class="text-center">شماره</th>
														<th class="text-center">اجناس</th>
														<th class="text-center">واحد</th>
														<th class="text-center">مقدار</th>
														<th class="text-center">توضیحات درخواستی</th>
														<th class="text-center" colspan="3">جزئیات توزیع</th>
													</tr>
														<?php
														while($detailsRow = $requestDetailsQuery->fetch_array()){
															++$counter2;
															$rowItems = $conn->selectRecord ("tbl_items","id  = ". $detailsRow['items_id']);
															$rowItemUnits = $conn->selectRecord ("tbl_item_units","id  = ". $detailsRow['items_unit_id']);
															$table = 'tbl_schools_requests_equipments_details';
 														?>
														
														<tr id='row-<?php echo $row['id']; ?>'> 
															<td class='text-center'><?php echo $counter2; ?></td>
															<td class='text-center'><?php echo $rowItems['name']; ?></td>
															<td class='text-center'><?php echo $rowItemUnits['name']; ?></td>
															<td class='text-center'><?php echo $detailsRow['quantity']; ?></td>
															<td class='text-center'><?php echo $detailsRow['description']; ?></td>
															<?php if($detailsRow['distributed'] != 1){  ?>
															<td class='text-center'> <button   class="edit_data btn btn-success btn-outline" type="button"   id="<?php   echo $detailsRow['id']."+".$table;  ?>" >توزیع اجناس</button></td>
															<?php 
																}else{
															?>
															<td class='text-center'><?php echo $detailsRow['dist_date']; ?></td>
															<td class='text-center'><?php echo number_format($detailsRow['dist_quantity'],2); ?></td>
															<td class='text-center'><?php echo $detailsRow['dist_description']; ?></td>
																
															<?php	
																} 
															?>
														</tr>
														<?php  
														} 
														} 
														?>	
													
												 
											</table>
										</td>										
										</tr>
										<?php
											
										}
									
									?>
									
									</tbody> 
								</table>
							</div>
					 
					  	
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