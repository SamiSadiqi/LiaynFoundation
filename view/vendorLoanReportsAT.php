<?php
	require_once("_header.php");
	$menu = "reportsAT";
 	$formHeader  = "Vendor's Balance";
 ?>
<title><?php echo $pageTitle; ?></title>

<style type="text/css">

    .bs-example{
    	margin: 20px;
    }
	
	@media print {
		.dontPrint {
			display:none;
		}
    }
	
	@media all{
		.page-break{display:none;}
	}
	
	@media print{
		.page-break{display:block;page-break-after:always;}
		.dote img {visibility: visible;}
	}
 
	@page {
		size: auto;   /* auto is the initial value */
		margin: 3mm;  /* this affects the margin in the printer settings */
	}
	
	@media print {
		html, body {
			height: 99%;    
		}
	} 
</style>

</head>


<body>
 
<!-- Page container -->
<div class="page-container">

	<!-- Main container -->
	<div class="main-container">
  
	
		<!-- Main content -->
		<div class="main-content">
			
			<div class="row">
			
				<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
					<h1 class="text-center"><?php echo $companyName; ?></h1>
				
					<h3 class="text-center">Vendor's Loan</h3>
				
 				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						$table  = "tbl_vendors";       
						$targetPage = "vendorListReportETQ.php";    
						$limit      = 20;  
						
						if($currencyId == 'all'){
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE  deleted = 0 ORDER BY id DESC");
						}elseif($currencyId != 'all'){
 							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE currencies_id = '$currencyId' AND deleted = 0 ORDER BY id DESC");

						}
						$row_count_row  = $row_count_sql->fetch_array();
						$totalPages    = $row_count_row['totalRows'];
						
						$stages = 3;

						$page  = (isset($_GET['page']) ? $page = validate($connection,$_GET['page'],'صفحه',0,"number",false) : $page = 0);
						$start = ($page ? $start = (($page - 1) * $limit) : $start = 0); 
						
						//Get Page Data
					   	if($currencyId == 'all'){
							$vendorsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
						}elseif($currencyId != 'all'){
							
							$vendorsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND  currencies_id = '$currencyId' ORDER BY id DESC LIMIT $start, $limit";
						}
						
						$vendorsRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
						$vendorsSQLQuery       = $conn->query($vendorsRawSQLQuery);
						
						if ($vendorsSQLQuery->num_rows > 0) {
							
					
					?>
					<div class="panel-body table-responsive" id="page-content"> 
    					<div class="form-group dontPrint"> 
        					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								
								<form method="post" action="excelReportsVendorLoanAT.php">
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
									<th class="text-center table-title" colspan="13">
										Vendor's Loan List
									</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">No.</th>
									<th class="text-center">Name</th>
									<th class="text-center">Vendor Type</th>
   									<th class='text-center'>Contact</th>
   									<th class='text-center'>Currency</th>
									<th class='text-center'>Debit (USD)</th>
									<th class='text-center'>Credit (USD)</th>
									<th class='text-center'>Current Balance (USD)</th>
									<th class='text-center'>Debit</th>
									<th class='text-center'>Credit</th>
									<th class='text-center'>Current Balance</th>
   								</tr>
							</thead>
							<tbody>
							<?php
							$counter = $start;
								while($row = $vendorsSQLQuery->fetch_array()){
									++$counter;
									
										$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										$vendorId = $row['id'];
										$selectSumVendorTransactionn  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='1'");
										$rowVendorTransaction = $selectSumVendorTransactionn->fetch_array();
										$incomeVendorTransaction = $rowVendorTransaction['home_amountIcome'];
										$totalIncome += $incomeVendorTransaction;
										
										$selectSumVendorTransactionnGoing  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='2'");
										$rowVendorTransactionGoing = $selectSumVendorTransactionnGoing->fetch_array();
										$outcomeVendorTransaction = $rowVendorTransactionGoing['home_amountIcome'];
										$totalOutcome +=  $outcomeVendorTransaction;
									 
										$blanceSheet  = $incomeVendorTransaction - $outcomeVendorTransaction;
										//self Currency 
										$selfVendorsQurey  = $conn->query("SELECT SUM(amount)as creditAmount FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='1'");
										$selfVendorFetch = $selfVendorsQurey->fetch_array();
										$selfVendorFetchTransaction = $selfVendorFetch['creditAmount'];
										$totalCreditSelf += $selfVendorFetchTransaction;
										
										$selfVendorsQueryDebit  = $conn->query("SELECT SUM(amount)as amountDebit FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='2'");
										$selfVendorsDebitFetch = $selfVendorsQueryDebit->fetch_array();
										$vendorDebitTransaction = $selfVendorsDebitFetch['amountDebit'];
										$totalDebit +=  $vendorDebitTransaction;
									 
										$blanceSheetSelf  = $selfVendorFetchTransaction - $vendorDebitTransaction;
										
										$rowVendorType = $conn->selectRecord ("tbl_vendor_categories","id  = ". $row['vendor_type']);

								?>
								<tr>
									<td class="small text-center p-number"><?php echo $counter; ?></td>
									<td class='text-center'><?php echo $row['name']; ?></td>
									<td class='text-center'><?php echo $rowVendorType['name']; ?></td>
									<td class='text-center'><?php echo $row['contact']; ?></td>
									<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
									<td class='text-center'><?php echo number_format($outcomeVendorTransaction,2); ?></td>
									<td class='text-center'><?php echo number_format($incomeVendorTransaction,2); ?></td>
									<td class='text-center'><?php echo number_format($blanceSheet,2); ?></td>
									<td class='text-center'><?php echo number_format($vendorDebitTransaction,2); ?></td>
									<td class='text-center'><?php echo number_format($selfVendorFetchTransaction,2) ?></td>
									<td class='text-center'><?php echo number_format($blanceSheetSelf,2); ?></td>
								</tr>
								<?php 
									}
								?>
								<tr>
									<td class='text-center' colspan='4' ><b>Total Vendor Accounts</b></td>
									<td  class='text-center number'><?php  echo number_format($totalOutcome,2);  ?></td>
									<td  class='text-center number'><?php  echo number_format($totalIncome,2);  ?></td>
									<td  class='text-center number' dir ="ltr"><?php  echo  number_format($totalIncome - $totalOutcome,2);   ?></td>
								</tr>
							</tbody>
							<?php
							// Initial page num setup
							if ($page == 0){
								$page = 1;
							}

							$prev     = $page - 1;  
							$next     = $page + 1;                          
							$lastpage = ceil($totalPages/$limit);      
							$LastPagem1 = $lastpage - 1;                    
							
							$paginate = '';

							if($lastpage > 1){
								$paginate .= "<div class='paginate'>";
								
								// Previous
								if ($page > 1){
									$paginate.= "<a href='$targetPage?page=$prev'>Previous</a>";
								}else{
									$paginate.= "<span class='disabled'>Previous</span>";
								}
							   
								// Pages  
								if ($lastpage < 7 + ($stages * 2)){     // Not enough pages to breaking it up  
									for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $page){
											$paginate.= "<span class='current'>$counter</span>";
										}else{
											$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
									}
								}elseif($lastpage > 5 + ($stages * 2)){ // Enough pages to hide a few?
									// Beginning only hide later pages
									if($page < 1 + ($stages * 2))        {
										for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}

										$paginate.= "...";
										$paginate.= "<a href='$targetPage?page=$LastPagem1'>$LastPagem1</a>";
										$paginate.= "<a href='$targetPage?page=$lastpage'>$lastpage</a>";       
									}elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){ // Middle hide some front and some back
										$paginate.= "<a href='$targetPage?page=1'>1</a>";
										$paginate.= "<a href='$targetPage?page=2'>2</a>";
										$paginate.= "...";
										for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}
										$paginate.= "...";
										$paginate.= "<a href='$targetPage?page=$LastPagem1'>$LastPagem1</a>";
										$paginate.= "<a href='$targetPage?page=$lastpage'>$lastpage</a>";       
									}else{ // End only hide early pages
										$paginate.= "<a href='$targetPage?page=1'>1</a>";
										$paginate.= "<a href='$targetPage?page=2'>2</a>";
										$paginate.= "...";
										for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}
									}
								}
											
								// Next
								if ($page < $counter - 1){ 
									$paginate.= "<a href='$targetPage?page=$next'>Next</a>";
								}else{
									$paginate.= "<span class='disabled'>Next</span>";
								}
									
								$paginate.= "</div>";       
							}
							
							$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalPages;
							$start = ($start == 0) ? $start = ++$start : $start = $start;
						?>
						</table>
					</div>
				
					<div>
						<div class="col-md-6 col-sm-12 dontPrint" style="padding-top: 5px;color: #aaa; float: left">Showing<span class="adad"> <?php echo $start . '</span> From <span class="adad">' . $end; ?></span></div>
						<div class="col-md-6 col-sm-12 p-number dontPrint" id="retrieved_info" style="float: right"><span class='adad'><?php echo $paginate ?></span></div>
					</div>
					<?php   }  ?>
				
				</div>
					
			</div>
			
			<!-- Footer -->
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
			
					<?php  require_once('_footer.php');  ?>
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

 
function customerState(vendorId){
	$.post("AjaxCreateVendorSelfLoanListStatement.php",{"vendorId":vendorId},function(data){
 	 $("#myModal").modal('show');
	 $('#myModalData').html(data);
	});
} 
</script>
</body>
</html>