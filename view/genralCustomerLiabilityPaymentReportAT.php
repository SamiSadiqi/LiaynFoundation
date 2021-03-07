<?php
	require_once("_header.php");
	$menu = "reportsAT";
 	$formHeader  = "Customer's Loan Payments Reports";
	
	$fromDate = $_GET['fromDate'];
	$toDate   = $_GET['toDate'];
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
						<?php  
						if(!empty($fromDate) && !empty($toDate)){
							$title="Genral Information About Loan Payments From <b> ".$fromDate."  </b> to <b>".$toDate;
							
						}elseif(empty($fromDate) && empty($toDate)){
							$title="Genral Information About Loan Payments";
						}
						?>
					<h3 class="text-center"><?php   echo $title; ?></h3>
 				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						$table      = "tbl_customer_payment";       
						$targetPage = "genralCustomerLiabilityPaymentReportAT.php";    
						$limit      = 40;  
						if(!empty($fromDate) && !empty($toDate)){
							$rowCountSQL  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE (date BETWEEN '$fromDate' AND '$toDate') AND  deleted = 0 AND payment_type = 2 ORDER BY id DESC");
						}elseif(empty($fromDate) && empty($toDate)){
 							$rowCountSQL  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE deleted = 0 AND payment_type = 2 ORDER BY id DESC");
						}
						$rowCountSQL  = $rowCountSQL->fetch_array();
						$totalPages   = $rowCountSQL['totalRows'];
						
						$stages = 3;
				    	$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
	                	$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
						
						//Get Page Data
						if(!empty($fromDate) && !empty($toDate)){
							$dataSql    = "SELECT * FROM $table WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted = 0 AND payment_type = 2 ORDER BY id DESC LIMIT $start, $limit";
						}elseif(empty($fromDate) && empty($toDate)){
							$dataSql    = "SELECT * FROM $table WHERE deleted = 0 AND payment_type = 2 ORDER BY id DESC LIMIT $start, $limit";
						}
						$dataQuery       = $conn->query($dataSql);
						
						
						if ($dataQuery->num_rows > 0) {
							
					
					?>
					<div class="panel-body table-responsive" id="page-content"> 
    					<div class="form-group dontPrint"> 
        					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								 
								<form method="post" action="excelCustomerLoanPaymentReportsAT.php">
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
										All Customer's Cash Payments
									</th>
								</tr>
								<tr class="table-header">
									<th class='text-center'>No</th>
									<th class='text-center'>Date</th>
									<th class='text-center'>Payment Number</th>
									<th class='text-center'>Customer</th>
									<th class='text-center'>Currency</th>
									<th class='text-center'>Amount</th>
									<th class='text-center'>Rate</th>
									<th class='text-center'>Bank</th>
									<th class='text-center'>Amount (USD)</th>
									<th class='text-center'>Description</th>
									<th class='text-center dontPrint'>Print Factor</th>
   								</tr>
							</thead>
							<tbody>
								<?php
								while($row = $dataQuery->fetch_array()){
								++$counter;
											
									$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
									$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
									$rowCustomers = $conn->selectRecord ("tbl_customers","id  = ". $row['customers_id']);
									$totalCustomerPayments += $row['home_amount'];	

									 ?>
								<tr>
									<td class="small text-center"><?php echo $counter; ?></td>
									<td class='text-center'><?php echo $row['date']; ?></td>
									<td class='text-center'><?php  echo $row['factor_number']; ?></td>
									<td class='text-center'><?php  echo $rowCustomers['name']; ?></td>
									<td class='text-center'><?php  echo $rowCurrency['code']; ?></td>
									<td class='text-center'><?php  echo $row['amount']; ?></td>
									<td class='text-center'><?php  echo $row['rate']; ?></td>
									<td class='text-center'><?php  echo $rowBank['name']; ?></td>
									<td class='text-center'><?php  echo $row['home_amount']; ?></td>
									<td class='text-center'><?php  echo $row['description']; ?></td>
									<td class="small text-center dontPrint"><a title="Print Factor" href="printCustomerPaymentFactor.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-print btn btn-blue btn-outline"></i></a></td>
									
								</tr>
								<?php 
								}
								?>
								<tr>
									<td class='text-center' colspan='8' ><b>Total Customers Payments </b></td>
 									<td  class='text-center number'><b><?php  echo number_format($totalCustomerPayments,2);  ?>  USD</b></td>
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