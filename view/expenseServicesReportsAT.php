<?php
	require_once("_header.php");
 	$formHeader  = "Service Provider Reports";
	$providerId = $_POST['serviceAssets'];
	$title = "All Services Expenses";

		 
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
					
					<h3 class="text-center"> <?php echo $title ?> </h3>
					<h4 class="text-center"> </h4>
				</div>
				 
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						
						$table  = "tbl_service_provider";       
						$targetPage = "assetsServicesReportsAT.php";    
						$limit      = 35;  
						if($providerId == "all"){ 
 							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE  deleted = 0 AND transaction_type = 1 ORDER BY id DESC");
						}elseif($providerId != "all"){
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE  deleted = 0 AND transaction_type = 1 AND id = $providerId ORDER BY id DESC");
						}
						$row_count_row  = $row_count_sql->fetch_array();
						$totalPages    = $row_count_row['totalRows'];
						
						$stages = 3;

						$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
						$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
						//Get Page Data
						if($providerId == "all"){ 
							$requestRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND transaction_type = 1  ORDER BY id DESC LIMIT $start, $limit";
						}elseif($providerId != "all"){
							$requestRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND transaction_type = 1 AND id = $providerId  ORDER BY id DESC LIMIT $start, $limit";
						}	
						$requestSQLQuery       = $conn->query($requestRawSQLQuery);
						
						if ($requestSQLQuery->num_rows > 0) {
					?>
				 
					<div class="panel-body" id="page-content"> 
						<div class="form-group dontPrint"> 
							<label class="col-lg-8 col-md-6 col-sm-4control-label" for="search"></label> 
							<div class="col-lg-4 col-md-6 col-sm-8"> 
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
 
							 </div> 
						</div>
						<table  class="table table-striped table-bordered" id ="example" >
							<thead>
								<tr>
									<th class='text-center'>NO.</th>
									<th class='text-center'>Date</th>
									<th class='text-center'>Reference</th>
									<th class='text-center'>Name</th>
									<th class='text-center'>Done Service Amount (USD)</th>
									<th class='text-center'>Payment Amount (USD)</th>
									<th class='text-center'>Currency</th>
									<th class='text-center'>Rate</th>
									<th class='text-center'>Done Service Amount</th>
									<th class='text-center'>Payment Amount</th>
									<th class='text-center'>Description</th>
  									 
 								</tr>
							</thead>
							<tbody>
							<?php
								$counter = $start;
									while($fetchRow = $requestSQLQuery->fetch_array()){
										$providerId = $fetchRow['id'];
										
										$selectAssetReportsAT = $conn->query("SELECT * FROM tbl_service_provider_statement where service_provider_id = $providerId AND deleted = 0");
										while($row = $selectAssetReportsAT->fetch_array()){
										
										++$counter;
										$rowServiceProvider = $conn->selectRecord ("tbl_service_provider","id  = ". $row['service_provider_id']);
										$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										
										if($row['transaction_type'] == 1){
											$credit = $row['amount'];
											$totalCredt += $credit;
											$debit = 0;
											
											$creditHomeAmount = $row['home_amount'];
											$debitHomeAmount = 0;
										}elseif($row['transaction_type'] == 2){
											$debit = $row['amount'];
											$totalDebit += $debit;
											$credit = 0;
											
											$debitHomeAmount = $row['home_amount'];
											$creditHomeAmount = 0;
										}
  									  ?>
										<tr>
											<td class="small text-center"><?php echo $counter; ?></td>
											<td class='text-center'><?php echo $row['date'];?></td>
											<td class='text-center'><?php echo $row['place'];?></td>
 											<td class='text-center'><?php echo $rowServiceProvider['name']; ?></td>
											<td class='text-center'><?php echo $credit; ?></td>
											<td class='text-center'><?php echo $debit; ?></td>
											<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
											<td class='text-center'><?php echo $row['rate']; ?></td>
											<td class='text-center'><?php echo $creditHomeAmount; ?></td>
											<td class='text-center'><?php echo $debitHomeAmount; ?></td>
											<td class='text-center'><?php echo $row['description']; ?></td>
										</tr>
										
								<?php 
									}
									}
								?>
								<tr>
									<td  class='text-center' colspan="4">Total Balance Sheet</td>
									<td class='text-center'><?php echo number_format($totalDebit,2);  ?></td>
									<td class='text-center'><?php echo number_format($totalCredt,2);  ?></td>
 									<td class='text-center'><?php echo number_format($totalDebit - $totalCredt,2);  ?></td>
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
						<div class="col-md-6 col-sm-12 dontPrint" style="padding-top: 5px;color: #aaa; float: left">Showing<span class="adad"> <?php echo $start . '</span> Up to <span class="adad">' . $end; ?></span></div>
						<div class="col-md-6 col-sm-12 p-number dontPrint" id="retrieved_info" style="float: right"><span class='adad'><?php echo $paginate ?></span></div>
					</div>
					<?php   }  ?>
					 
				</div>
			</div>
			<!-- Footer -->
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
					<?php   include("_footer.php");  ?>
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