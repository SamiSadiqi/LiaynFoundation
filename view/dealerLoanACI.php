<?php
	require_once("_header.php");
 	$formHeader  = "Dealer Loan";
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
 
@page 
{
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
   
<!-- /main header -->
	<div id="myModal" class="modal fade">
		<div class="modal-dialog lg-model">
			<div class="modal-content">
				<div class="modal-header" style='height:40px;'>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5 class="modal-title" Style='float:left;'>Dealer Loan</h5>
				</div>
				<div class="modal-body" id='myModalData'>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				 </div>
			</div>
		</div>
	</div>
<!-- Main content -->
<div class="main-content">
	<div class="row">
		<table class='table' border='0'>
			<th  style='text-align:center;border:none'></th>
			<th style='text-align:center;border:none'>
			<?php echo $companyName;  ?>
			<br>
			Dealers Loan list
			<br>
			<p class='adad'><?php  echo date("d-m-Y");  ?></p>
			</th>
			<th  style='text-align:center;border:none'></th>
		</table>
		 
				<?php
					$table  = "tbl_dealers";       
					$targetPage = "dealerLoanACI.php";    
					$limit      = 20;  
					
					$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE deleted = 0 ORDER BY id DESC");
					$row_count_row  = $row_count_sql->fetch_array();
					$totalPages    = $row_count_row['totalRows'];
					
					$stages = 3;

					$page  = (isset($_GET['page']) ? $page = validate($connection,$_GET['page'],'صفحه',0,"number",false) : $page = 0);
					$start = ($page ? $start = (($page - 1) * $limit) : $start = 0); 
					
					//Get Page Data
				   
					$customersRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
					$customersSQLQuery       = $conn->query($customersRawSQLQuery);
					
					
					if ($customersSQLQuery->num_rows > 0) {
						
				
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
							<th class="small text-center">NO.</th>
							<th class='text-center'> Name </th>
							<th class='text-center'>Contact</th>
							<th class='text-center'>Currency</th>
							<th class="text-center">Address</th>
							<th class="text-center">Debit</th>
							<th class="text-center">Credit</th>
							<th class="text-center">Balance</th>
							<!---
							<th class="text-center">Debit (AFG)</th>
							<th class="text-center">Credit (AFG)</th>
							<th class="text-center">Balance (AFG)</th>
							--->
							<th class="text-center dontPrint">Details Account</th>
 						</tr>
						</thead>
					<tbody>
					<?php
						$counter = $start;
							while($row = $customersSQLQuery->fetch_array()){
								++$counter;
								$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										$dealerId = $row['id'];
										/* $selectSumCustomerTransactionn  =$conn->query("SELECT SUM(home_amount)as home_amountIcome,sum(amount) as selfAmoutn FROM tbl_dealer_transaction WHERE  deleted='0' AND dealers_id='$dealerId' AND type='1'");
										$rowCustomerTransaction = $selectSumCustomerTransactionn->fetch_array();
										$incomeCustomerTransaction = $rowCustomerTransaction['home_amountIcome'];
										$incomeDealerTransactionSelf = $rowCustomerTransaction['selfAmoutn'];
										$incomeDealerTransactionSelfTotal += $incomeDealerTransactionSelf;
										$totalIncome += $incomeCustomerTransaction;
										
										$selectSumCustomerTransactionnGoing  =$conn->query("SELECT SUM(home_amount)as home_amountIcome ,sum(amount) as selfAmountIcome FROM tbl_dealer_transaction WHERE  deleted='0' AND dealers_id='$dealerId' AND type='2'");
										$rowCustomerTransactionGoing = $selectSumCustomerTransactionnGoing->fetch_array();
										$outcomeCustomerTransaction = $rowCustomerTransactionGoing['home_amountIcome'];
										$outcomeCustomerTransactionIcome = $rowCustomerTransactionGoing['selfAmountIcome'];
										$outcomeCustomerTransactionIcomeTotal += $outcomeCustomerTransactionIcome;
										$totalOutcome +=  $outcomeCustomerTransaction;
									
									 
										$blanceSheet  = $outcomeCustomerTransaction - $incomeCustomerTransaction;
										$blanceSheetSelf  = $outcomeCustomerTransactionIcomeTotal - $incomeDealerTransactionSelfTotal;
									  */
									 ?>
									<tr>
									<td class="small text-center"><?php echo $counter; ?></td>
									<td class='text-center'><?php echo $row['name'] . " " . $row['family']; ?></td>
									<td class='text-center'><?php echo $row['contact']; ?></td>
 									<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
 									<td class='text-center'><?php echo $row['address']; ?></td>
 									<td class='text-center'><?php echo number_format($incomeDealerTransactionSelf,2); ?></td>
 									<td class='text-center'><?php echo number_format($outcomeCustomerTransactionIcomeTotal,2); ?></td>
									
 									<td class='text-center'><?php echo number_format($blanceSheetSelf,2); ?></td>
									<!--
 									<td class='text-center'><?php echo number_format($outcomeCustomerTransaction,2); ?></td>
									<td class='text-center'><?php echo number_format($incomeCustomerTransaction,2); ?></td>
									<td class='text-center' dir = 'ltr'><?php echo number_format($blanceSheet,2); ?></td>
									--->
									<td class="small text-center dontPrint"><a title="See Details"  href="detailsofDealerBalancesheetACI.php?id=<?php echo encryptIt($row['id']);   ?>"><i class="glyphicon glyphicon-send btn btn-blue btn-outline"></i></a></td>

									 
									</tr>
						<?php 
							}
						?>
					</tbody>
					<!--
					<tfoot>
						<tr>
							<td class='text-center' colspan='8'  >Dealer Status (AFG)</td>
							<td  class='text-center number'  style="background-color:#54a960;color:#FFF"><?php  echo number_format($totalOutcome,2);  ?></td>
							<td  class='text-center number'  style="background-color:#54a960;color:#FFF"><?php  echo number_format($totalIncome,2);  ?></td>
							<td  class='text-center number'  style="background-color:#54a960;color:#FFF"><?php  echo number_format($totalOutcome - $totalIncome,2);   ?></td>
							<td  colspan='1' class='dontPrint'></td>
						</tr>
					</tfoot>
					--->
					<?php
					// Initial page num setup
					if ($page == 0){
						$page = 1;
					}

					$prev = $page - 1;  
					$next = $page + 1;                          
					$lastpage = ceil($totalPages/$limit);      
					$LastPagem1 = $lastpage - 1;                    
					
					$paginate = '';

					if($lastpage > 1){
						$paginate .= "<div class='paginate'>";
						
						// Previous
						if ($page > 1){
							$paginate.= "<a href='$targetPage?page=$prev'>Before</a>";
						}else{
							$paginate.= "<span class='disabled'>Before</span>";
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

					echo "<div class='row'>";
					// pagination
					$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalPages;
					$start = ($start == 0) ? $start = ++$start : $start = $start;
								?>
				  </table> 
			
					<div>
						<div class="col-md-6 col-sm-12" style="padding-top: 5px;color: #aaa; float: left">Showing from <span class="adad"> <?php echo $start . '</span> to <span class="adad">' . $end; ?></span></div>
						<div class="col-md-6 col-sm-12 adad" id="retrieved_info" style="float: right"><span class='adad'><?php echo $paginate ?></span></div>
					</div>
				<?php   }  ?>
			</div>
		</div>
	</div>
</div>
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