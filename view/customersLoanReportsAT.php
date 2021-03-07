<?php
	require_once("_header.php");
	$menu = "reportsAT";
 	$formHeader  = "Customer's Loan Reports";
	$currencyId = $_POST['currencyId'];
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
				
					<h3 class="text-center">Customer's Loan List</h3>
				
 				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						$table      = "tbl_customers";       
						$targetPage = "customerListReportETQ.php";    
						$limit      = 40;  
						if($currencyId == 'all'){
							$rowCountSQL  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE  deleted = 0 ORDER BY id DESC");
						}elseif($currencyId != 'all'){
 							$rowCountSQL  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE currencies_id = '$currencyId' AND deleted = 0 ORDER BY id DESC");

						}
						$rowCountSQL  = $rowCountSQL->fetch_array();
						$totalPages   = $rowCountSQL['totalRows'];
						
						$stages = 3;
				    	$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
	                	$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
						
						//Get Page Data
						if($currencyId == 'all'){
							$customersRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
						}elseif($currencyId != 'all'){
							
							$customersRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND  currencies_id = '$currencyId' ORDER BY id DESC LIMIT $start, $limit";
						}
						$customersSQLQuery       = $conn->query($customersRawSQLQuery);
						
						
						if ($customersSQLQuery->num_rows > 0) {
							
					
					?>
					<div class="panel-body table-responsive" id="page-content"> 
    					<div class="form-group dontPrint"> 
        					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
							
								<form method="post" action="excelReportsCustomerLoanAT.php">
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
										Customer's Loan
									</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">No.</th>
									<th class="text-center">Name</th>
									<th class="text-center">Customer Type</th>
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
								while($row = $customersSQLQuery->fetch_array()){
									++$counter;
									
										$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										$customerId = $row['id'];
										
										$selectSumCustomerTransactionn  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='1'");
										$rowCustomerTransaction = $selectSumCustomerTransactionn->fetch_array();
										$incomeCustomerTransaction = $rowCustomerTransaction['home_amountIcome'];
										$totalIncome += $incomeCustomerTransaction;
										
										$selectSumCustomerTransactionnGoing  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='2'");
										$rowCustomerTransactionGoing = $selectSumCustomerTransactionnGoing->fetch_array();
										$outcomeCustomerTransaction = $rowCustomerTransactionGoing['home_amountIcome'];
										$totalOutcome +=  $outcomeCustomerTransaction;
									
									 
										$blanceSheet  = $outcomeCustomerTransaction - $incomeCustomerTransaction;
										
										
										//--------------------------self Currency ------------
											
										$sumIncomeCustomerTransaction  =$conn->query("SELECT SUM(amount)as totalCredit FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='1'");
										$sumIncomeCustomerFetch = $sumIncomeCustomerTransaction->fetch_array();
										$incomeCustomerData = $sumIncomeCustomerFetch['totalCredit'];
										$totalCredit += $incomeCustomerData;
										
										$sumDebitCustomerTransaction  =$conn->query("SELECT SUM(amount)as debitAmount FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='2'");
										$rowCustomerTransactionDebit = $sumDebitCustomerTransaction->fetch_array();
										$outcomeCustomerTransactionDebit = $rowCustomerTransactionDebit['debitAmount'];
										$totalDebit +=  $outcomeCustomerTransactionDebit;
									
									 
										$blanceSheetSelfCurrency  = $totalDebit - $totalCredit;
										
										$rowCustomerType = $conn->selectRecord ("tbl_customer_categories","id  = ". $row['customer_type']);


										 ?>
									<tr>
										<td class="small text-center p-number"><?php echo $counter; ?></td>
										<td class='text-center'><?php echo $row['name']; ?></td>
										<td class='text-center'><?php echo $rowCustomerType['name']; ?></td>
										<td class='text-center'><?php echo $row['contact']; ?></td>
										<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
										<td class='text-center'><?php echo number_format($outcomeCustomerTransaction,2); ?></td>
										<td class='text-center'><?php echo number_format($incomeCustomerTransaction,2); ?></td>
										<td class='text-center'><?php echo number_format($blanceSheet,2); ?></td>
										<td class='text-center'><?php echo number_format($outcomeCustomerTransactionDebit,2); ?></td>
										<td class='text-center'><?php echo number_format($incomeCustomerData,2); ?></td>
										<td class='text-center'><?php echo number_format($blanceSheetSelfCurrency,2); ?></td>
 									  
									</tr>
								<?php 
									}
								?>
								<tr>
									<td class='text-center' colspan='4' ><b>Total Customer Account</b></td>
									<td  class='text-center number'><b><?php  echo number_format($totalOutcome,2);  ?> USD</b></td>
									<td  class='text-center number'><b><?php  echo number_format($totalIncome,2);  ?>  USD</b></td>
									<td  class='text-center number' dir ="ltr"><b><?php  echo number_format($totalOutcome - $totalIncome,2);   ?>  USD</b></td>
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

</script>

</body>
</html>