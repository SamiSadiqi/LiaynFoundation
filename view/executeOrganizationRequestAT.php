<?php
	require_once("_header.php");
	$menu = "schoolsAT";
	$formHeader = "حسابات مکتب";
	 
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
	
	$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $schoolId);

 ?>
<title><?php echo $pageTitle; ?></title>
 <style>
 table.table-bordered{
    border:1px solid black;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
}
 
 </style>
</head>
<body>


	
<div class="modal fade"tabindex="-1" id="mainModal" style="overflow:hidden;" role="dialog" aria-labelledby="showDetailsDonationsId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><h5>بسته کردن</h5></button> 

        <h5 class="modal-title">اطلاعات</h5>
         </button>
      </div>
	  
 		  <div class="modal-body" id="showDetailsDonationsId">
		  
 		  </div>
		<div class="modal-footer">
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
			<span>موقعیت فعلی : </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>حسابات مکتب/ سازمان</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">نام سازمان / مکتب&nbsp;:  &nbsp; <?php echo $schoolName;?> </div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div>
					
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;"> خلاصه کمک به مکاتب / سازمان </td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">نام مکتب / سازمان</th>
										<td class="text-center"><?php  echo  $schoolName;;    ?></td>
									</tr>
									<tr>
										<th  class="text-center">شماره تماس</th>
										<td class="text-center"><?php echo  $rowSchools['contact']; ?></td>
									</tr>
									<?php
										$organizationExpenseTransactionsTotal    = $conn->query("SELECT sum(amount)as totalOrgExpTrans FROM tbl_organization_expense_transactions WHERE schools_id = $schoolId AND  deleted = 0");
										$rowOrExpenseTranTotal = $organizationExpenseTransactionsTotal->fetch_array();
										$totalAmountOrExpTran = $rowOrExpenseTranTotal['totalOrgExpTrans'];
									?>
									<tr>
										<th class="text-center">مصارف ترمیمات</td>
										<td class="p-number text-center" class="text-center"><?php  echo number_format($totalAmountOrExpTran,2) ."&nbsp;&nbsp;&nbsp;&nbsp; افغانی";   ?></td>
									</tr>
									<?php
										$supportCereResponseTransTitle    = $conn->query("SELECT * FROM tbl_support_ceremonies_requests WHERE schools_id = $schoolId AND  deleted = 0");
										$supportCereResponseTransTitleRow = $supportCereResponseTransTitle->fetch_array();
										$ceremoniesIdTitle  = $supportCereResponseTransTitleRow['id'];

										$supportCereResponseTrans    = $conn->query("SELECT sum(amount) as totalSupportCereResponseTransAmount FROM tbl_support_ceremonies_response_tran WHERE ceremonies_id = $ceremoniesIdTitle AND  deleted = 0");
										$supportCereResponseTransRow = $supportCereResponseTrans->fetch_array();
										$supportCereResponseTransTotal = $supportCereResponseTransRow['totalSupportCereResponseTransAmount'];
									
									?>
									<tr>
										<th class="text-center">مصارف تمویل </td>
										<td class="text-center"><?php  echo number_format($supportCereResponseTransTotal,2)."&nbsp;&nbsp;&nbsp;&nbsp; افغانی";      ?></td>
									</tr>
									<?php
									 
										$organizationExpenseTransactionsTitle    = $conn->query("SELECT sum(factor_price) as orgExpenseTransTitle FROM tbl_donations_materials_title WHERE schools_id = $schoolId AND  deleted = 0");
										$organizationExpenseTransactionsTitleRow = $organizationExpenseTransactionsTitle->fetch_array();
										$totalOrgExpenseTransTitle = $organizationExpenseTransactionsTitleRow['orgExpenseTransTitle'];
									 
									?>
									
									<tr>
										<th class="text-center">مصارف اهدای اجناس</td>
										<td class="text-center"><?php echo number_format($totalOrgExpenseTransTitle,2)."&nbsp;&nbsp;&nbsp;&nbsp; افغانی";   ?></td>
									</tr>
									<tr>
										<th class="text-center">مجموعه کل مصارف</td>
										<td class="text-center"><?php echo number_format($totalOrgExpenseTransTitle + $supportCereResponseTransTotal + $totalAmountOrExpTran,2)."&nbsp;&nbsp;&nbsp;&nbsp; افغانی";     ?></td>
									</tr>
								</table>
							</div>
						</div>
						
						<!--- قسمت نمایش درخواستی ها ---->
						<button class="btn btn-primary" onclick="showRequests()"  ondblclick="hideRequests2()" id="requestButton" >نمایش جزئیات درخواست</button>
 						
							<div class="panel-body hide" id="requestTablId" style="border:1px solid black;margin-top:40px;"> 
								<span style="font-size:17px;color:green;">1-فایل های درخواستی اقلام</span>
								 <table  class="table table-responsive table-bordered table-hover"  style="border:1px solid black;" >
									<thead>
										
										<tr class="table-header">
											<th class="small text-center">شماره</th>
 											<th class="text-center">تاریخ</th>
											<th class="text-center">فایل</th>
  										</tr>
									</thead>
									<tbody>
										<?php
											$counter4 = 0;
											$supportCeremoniesQuery2    = $conn->query("SELECT * FROM tbl_org_req_materials_title WHERE schools_id = $schoolId AND deleted = 0 ORDER BY id desc");
											while($row2 = $supportCeremoniesQuery2->fetch_array()){
												$counter2++;
												 
										?>
										
											<tr>
												<td class="small text-center"><?php echo $counter2; ?></td>
												<td class='text-center'><?php echo $row2['date']; ?></td>
												 
												<td class='text-center'><a href='download.php?name=<?php echo $row2['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							<Br>
								<span style="font-size:17px;color:green;">2-درخواست تمویل محافل</span>
								 <table  class="table table-responsive table-bordered table-hover"  style="border:1px solid black;" >
									<thead>
										
										<tr class="table-header">
											<th class="small text-center">شماره</th>
 											<th class="text-center">تاریخ</th>
											<th class="text-center">فایل</th>
  										</tr>
									</thead>
									<tbody>
										<?php
											$counter2 = 0;
											$ceremoniesRequestSupportShow    = $conn->query("SELECT * FROM tbl_support_ceremonies_requests WHERE schools_id = $schoolId AND deleted = 0 ORDER BY id desc");
											while($ceremoniesRequestSupportRow = $ceremoniesRequestSupportShow->fetch_array()){
												$counter2++;
												 
										?>
										
											<tr>
												<td class="small text-center"><?php echo $counter2; ?></td>
												<td class='text-center'><?php echo $ceremoniesRequestSupportRow['date']; ?></td>
												 
												<td class='text-center'><a href='download.php?name=<?php echo $ceremoniesRequestSupportRow['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
								
								<Br>
								<span style="font-size:17px;color:green;">3-درخواستی های تعمیراتی</span>
								 <table  class="table table-responsive table-bordered table-hover"  style="border:1px solid black;" >
									<thead>
										
										<tr class="table-header">
											<th class="small text-center">شماره</th>
 											<th class="text-center">تاریخ</th>
											<th class="text-center">فایل</th>
  										</tr>
									</thead>
									<tbody>
										<?php
											$counter2 = 0;
											$requestConstractionQuery    = $conn->query("SELECT * FROM tbl_org_construction_requests WHERE schools_id = $schoolId AND deleted = 0 ORDER BY id desc");
											while($requestConstractionRow = $requestConstractionQuery->fetch_array()){
												$counter2++;
												 
										?>
										
											<tr>
												<td class="small text-center"><?php echo $counter2; ?></td>
												<td class='text-center'><?php echo $requestConstractionRow['date']; ?></td>
												 
												<td class='text-center'><a href='download.php?name=<?php echo $requestConstractionRow['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
					</div> 
					
				<?php  
				// شروع جدول تمویل محافل
				$supportCermoneyQuery    = $conn->query("SELECT * FROM tbl_support_ceremonies_requests WHERE schools_id = $schoolId AND  deleted = 0");
				if ($supportCermoneyQuery->num_rows > 0) {

					while($rowCeremoniesTitle = $supportCermoneyQuery->fetch_array()){
					$ceremoniesId = $rowCeremoniesTitle['id'];		
 				?>
					<div class="panel-body " id="page-content" style="overflow-x:scroll;"> 
					
					 <div class="form-group dontPrint"> 
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								<form method="post" action="excelSupportCeremoniesAT.php">
								 <input type="submit" name="export" class="btn btn-primary" value="Export" />
								</form>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
							<!---
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
							---->
							 </div>
						</div>
						 <table  class="table table-responsive table-bordered table-hover"  style="border:1px solid black;" >
							<thead>
								<tr>
								<th class="text-center table-title" colspan="15">
								<span style='font-size:bold'>   جزئیات تمویل محفل    </span> <span style="color:red;font-size:20px">   <?php echo $rowCeremoniesTitle['name'];  ?>   </span></b>
								</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">شماره</th>
									<th class="text-center">تاریخ</th>
									<th class="text-center">نام محفل</th>
 									<th class="text-center">بانک</th>
 									<th class="text-center">فایل</th>
									<th class="text-center">مقدار مصرف</th>
									<th class="text-center">توضیحات</th>
  								</tr>
							</thead>
							<tbody>
								<?php
  									$counter2 = 0;
 									$supportCeremoniesQuery    = $conn->query("SELECT * FROM tbl_support_ceremonies_response_tran WHERE ceremonies_id = $ceremoniesId AND  deleted = 0 ORDER BY id desc");
									while($row = $supportCeremoniesQuery->fetch_array()){
										$counter2++;
										$rowBanks = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
										$rowCeremonies = $conn->selectRecord ("tbl_support_ceremonies_requests","id  = ". $row['ceremonies_id']);
 										$totalSuportCeremonies = $row['amount'];
								?>
								
									<tr>
										<td class="small text-center"><?php echo $counter2; ?></td>
										<td class='text-center'><?php echo $row['date']; ?></td>
										<td class='text-center'><?php echo $rowCeremonies['name']; ?></td>
										<td class='text-center'><?php echo $rowBanks['name']; ?></td>
 										<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
										<td class='text-center'><?php echo $totalSuportCeremonies; ?></td>
										<td class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
 									</tr>
								<?php
									}
								?>
								<tr style="border:1px solid black;">
									<td colspan="5" class='text-center'><b> مجموعه ( افغانی ) </b></td>
									<td class='text-center'><?php  echo number_format($totalSuportCeremonies,2);   ?></td>
								</tr>
								
							</tbody>
						</table>
					</div>
				<?php 
					}
					}
				?>
				
				
				<!---مصارف تعمیراتی--->
				
				
				<?php  
			 
				$organizationExpenseTransactions    = $conn->query("SELECT * FROM tbl_organization_expense_transactions WHERE schools_id = $schoolId AND  deleted = 0");
				if ($organizationExpenseTransactions->num_rows > 0) {

				 
				?>
					<div class="panel-body" id="page-content" style="overflow-x:scroll"> 
					
					 <div class="form-group dontPrint"> 
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								<form method="post" action="excelOrganizationExpenseTransactionsAT.php">
								 <input type="submit" name="export" class="btn btn-primary" value="Export" />
								</form>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
							<!---
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
							---->
							 </div>
						</div>
						 <table  class="table table-responsive table-bordered table-hover" id ="example" >
							<thead>
								<tr>
								<th class="text-center table-title" colspan="15">
									مجموعه مصارف تعمیراتی <span style="color:red;font-size:20px"><?php  echo $schoolName;  ?></span></b>
								</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">شماره</th>
									<th class="text-center">تاریخ</th>
 									<th class="text-center">نام کتگوری مصرف</th>
									<th class="text-center">بانک</th>
 									<th class="text-center">مقدار مصرف</th>
									<th class="text-center">فایل</th>
									<th class="text-center">توضیحات</th>
  								</tr>
							</thead>
							<tbody>
								<?php
									$counter2 = 0;
									while($rowExpenseTransactions = $organizationExpenseTransactions->fetch_array()){
										$counter3 ++;
										$rowCategoryExpense = $conn->selectRecord ("tbl_org_expense_categories","id  = ". $rowExpenseTransactions['expense_categories_id']);
										$rowBanks = $conn->selectRecord ("tbl_banks","id  = ". $rowExpenseTransactions['banks_id']);
 										$totalExpenseConstructionTran += $rowExpenseTransactions['amount'];
								?>
								
									<tr>
										<td class="small text-center"><?php echo $counter3; ?></td>
										<td class='text-center'><?php echo $rowExpenseTransactions['date']; ?></td>
										<td class='text-center'><?php echo $rowCategoryExpense['name']; ?></td>
										<td class='text-center'><?php echo $rowBanks['name']; ?></td>
 										<td class='text-center'><?php echo $rowExpenseTransactions['amount']; ?></td>
										<td class='text-center'><a href='download.php?name=<?php echo $rowExpenseTransactions['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 										<td class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $rowExpenseTransactionsس['description']; ?></div></td>
 									</tr>
								<?php
									}
								?>
								
								<tr style="border:1px solid black;">
									<td colspan="4" class='text-center'><b> مجموعه ( افغانی ) </b></td>
									<td class='text-center'><?php  echo number_format($totalExpenseConstructionTran,2);   ?></td>
								</tr>
							</tbody>
						</table>
						
					</div>
				<?php  
				
				}
				//توزیع اقلام
				$distributionItemsQuery    = $conn->query("SELECT * FROM tbl_donations_materials_title WHERE schools_id = $schoolId AND  deleted = 0");
				if ($distributionItemsQuery->num_rows > 0) {

				 
				?>
					<div class="panel-body table-bordered" id="page-content" style="overflow-x:scroll"> 
						<div class="form-group dontPrint"> 
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								<form method="post" action="excelDistributionItemsAT.php">
								 <input type="submit" name="export" class="btn btn-primary" value="Export" />
								</form>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>

							 </div>
						</div>
						 <table  class="table table-bordered table-hover" id ="example" >
							<thead>
								<tr>
								<th class="text-center table-title" colspan="15">
									توزیع اقلام به <span style="color:red;font-size:20px"><?php  echo $schoolName;  ?></span></b>
								</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">شماره</th>
									<th class="text-center">تاریخ</th>
 									<th class="text-center"> بانک </th>
   									<th class="text-center">کل هزینه اقلام</th>
									<th class="text-center"> شماره درخواستی </th>
 									<th class="text-center">توضیحات</th>
									<th class="text-center">جزئیات اقلام</th>
  								</tr>
							</thead>
							<tbody>
								<?php
								
									$counter3 = 0;
									while($distributionItemsRow = $distributionItemsQuery->fetch_array()){
									$counter3++;
										$rowMaterialsBanks = $conn->selectRecord ("tbl_banks","id  = ". $distributionItemsRow['banks_id']);
 
								?>
								
									<tr>
										<td class="small text-center"><?php echo $counter3; ?></td>
										<td class='text-center'><?php echo $distributionItemsRow['date']; ?></td>
										<td class='text-center'><?php echo $rowMaterialsBanks['name']; ?></td>
  										<td class='text-center'><?php echo $distributionItemsRow['factor_price']; ?></td>
										<td class='text-center'><?php echo $distributionItemsRow['request_number']; ?></td>
   										<td class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $distributionItemsRow['description']; ?></div></td>
										<td class='text-center'><button onclick = "showDetailsDonationMaterials(<?php   echo $distributionItemsRow['id']; ?>,'tbl_donations_materials_title')" >جزئیات</button><?php  ?></td>
									</tr>
								<?php
									}
								?>
								
								
							</tbody>
								
						</table>
					</div>
				<?php  } ?>
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
  function showDetailsDonationMaterials(rowId,table){
	  $.post("AjaxDonationsMaterialsDetailsAT.php",{"rowId":rowId,"table":table},function(data){
			  $("#showDetailsDonationsId").html(data);
			  $("#mainModal").modal('show');
		 	   
		});
  } 
 

  function showRequests(){
  		$("#requestTablId").removeClass("hide");
   }  
   function hideRequests2(){
  		$("#requestTablId").addClass("hide");
   }  
 
 
	$("#search").keyup(function () {
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });
});
 
</script>
</body>
</html>