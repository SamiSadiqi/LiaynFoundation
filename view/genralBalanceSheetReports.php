<?php
	require_once("_header.php");
 	$formHeader  = "بلانس عمومی قرض گیرنده";
	
	$fromDate = $_POST['fromDate'];
	$toDate   = $_POST['toDate'];
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
			 <?php
					
				   //calculate total Expenses.  
					
					if(!empty($fromDate) && !empty($toDate)){
						 
						//Cash Customer Payments.
						$selectCustomerPayment = $conn->query("select sum(home_amount) as totalAmountPaymentCustomer from tbl_customer_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate')  AND deleted=0 AND payment_type = 1");
						$rowCustomerPayment = $selectCustomerPayment->fetch_array();
						$totalCustomerPayment  = $rowCustomerPayment['totalAmountPaymentCustomer'];
						
						//Liability Customer Payments.              
						$selectCustomerborrow = $conn->query("select sum(home_amount) as totalAmountPaymentCustomerBorrow from tbl_customer_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0 AND payment_type=2");
						$rowCustomerPaymentBorrow = $selectCustomerborrow->fetch_array();
						$totalCustomerPaymentBorrrow  = $rowCustomerPaymentBorrow['totalAmountPaymentCustomerBorrow'];
						
						//--------------End Customer Parts-----------
						
						//Cash payment to Vendor	 
						$selectVendorPayment = $conn->query("select sum(home_amount) as totalVendorPaymentColumn from tbl_vendor_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0 AND payment_type=1");
						$rowVendorPayment = $selectVendorPayment->fetch_array();
						$totalVendorPayment  = $rowVendorPayment['totalVendorPaymentColumn'];
						
						//Liability Given From Vendor
						$selectVendorPaymentLoan = $conn->query("select sum(home_amount) as totalVendorPaymentColumnLoan from tbl_vendor_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0 AND payment_type=2");
						$rowVendorPaymentLoan = $selectVendorPaymentLoan->fetch_array();
						$totalVendorPaymentLoan  = $rowVendorPaymentLoan['totalVendorPaymentColumnLoan'];
						//--------------End Vendor Parts-----------

						//Bank Transaction  Debit
 						$selectBankTransactionDebit = $conn->query("select sum(home_amount) as totalDebit from tbl_bank_statement  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0 AND place='Bank Transaction' AND transaction_type = 2");
						$selectBankTransactionDebitRow = $selectBankTransactionDebit->fetch_array();
						$totalBankTransactionDebit  = $selectBankTransactionDebitRow['totalDebit'];
						
						//Bank Transaction  Credit
 						$selectBankTransactionCredit = $conn->query("select sum(home_amount) as totalCredti from tbl_bank_statement  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted = 0 AND place='Bank Transaction' AND transaction_type = 1");
						$selectBankTransactionCreditRow = $selectBankTransactionCredit->fetch_array();
						$totalBankTransactionCredit  = $selectBankTransactionCreditRow['totalCredti'];
						//End Bank Statement
						//--------------------End Bank Statement --------------
						//Assets Service Transaction
						$serviceTransactionAsset = $conn->query("SELECT * FROM tbl_service_provider WHERE deleted = 0 AND transaction_type = 2");
							while($serviceTransactionAssetRow = $serviceTransactionAsset->fetch_array()){
								$serviceProviderId = $serviceTransactionAssetRow['id'];
								
								$serviceProviderAssests = $conn->query("select * from tbl_service_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted = 0 AND service_provider_id = $serviceProviderId");
								$serviceProviderAssestsFetch = $serviceProviderAssests->fetch_array();
								$serviceProviderAssestsRow  += $serviceProviderAssestsFetch['home_amount'];
								 
								
							}
						//Expenses Servic Transaction
						$serviceTransactionExpense = $conn->query("SELECT * FROM tbl_service_provider WHERE deleted = 0 AND transaction_type = 1");
							while($serviceTransactionExpenseRow = $serviceTransactionExpense->fetch_array()){
								$serviceProviderIdExpense = $serviceTransactionExpenseRow['id'];
 								$serviceProviderExpense = $conn->query("select * from tbl_service_payment  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted = 0 AND service_provider_id = $serviceProviderIdExpense");
								$serviceProviderExpenseFetch = $serviceProviderExpense->fetch_array();
								$serviceProviderExpenseRow  += $serviceProviderExpenseFetch['home_amount'];
								 
								
							}	
						//End services.
						
 						$selectExpense = $conn->query("select sum(home_amount) as totalAmountExpense from tbl_expenses  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0");
						$rowExpenses = $selectExpense->fetch_array();
						$totalExpense  = $rowExpenses['totalAmountExpense'];
						//End Expenses
						
						$selectIncome = $conn->query("select sum(home_amount) as totalAmountIncome from tbl_incomes  WHERE (date BETWEEN '$fromDate' AND '$toDate') AND deleted=0 ");
						$rowIncomes = $selectIncome->fetch_array();
						$totalIncome  = $rowIncomes['totalAmountIncome'];
						//End Income
						
						$selectAssetsQuery = $conn->query("SELECT sum(home_amount) as totalAmountAssets FROM `tbl_assets` WHERE deleted = 0");
						$selectAssetRow = $selectAssetsQuery->fetch_array();
						$totalAssets  = $selectAssetRow['totalAmountAssets'];
						//End Assets
						
					}elseif(empty($fromDate) && empty($toDate)){
						 
						//Cash Customer Payments.
						$selectCustomerPayment = $conn->query("select sum(home_amount) as totalAmountPaymentCustomer from tbl_customer_payment  WHERE  deleted=0 AND payment_type = 1");
						$rowCustomerPayment = $selectCustomerPayment->fetch_array();
						$totalCustomerPayment  = $rowCustomerPayment['totalAmountPaymentCustomer'];
						
						//Liability Customer Payments.              
						$selectCustomerborrow = $conn->query("select sum(home_amount) as totalAmountPaymentCustomerBorrow from tbl_customer_payment  WHERE deleted=0 AND payment_type=2");
						$rowCustomerPaymentBorrow = $selectCustomerborrow->fetch_array();
						$totalCustomerPaymentBorrrow  = $rowCustomerPaymentBorrow['totalAmountPaymentCustomerBorrow'];
						
						//--------------End Customer Parts-----------
						
						//Cash payment to Vendor	 
						$selectVendorPayment = $conn->query("select sum(home_amount) as totalVendorPaymentColumn from tbl_vendor_payment WHERE payment_type = 1");
						$rowVendorPayment = $selectVendorPayment->fetch_array();
						$totalVendorPayment  = $rowVendorPayment['totalVendorPaymentColumn'];
						
						//Liability Given From Vendor
						$selectVendorPaymentLoan = $conn->query("select sum(home_amount) as totalVendorPaymentColumnLoan from tbl_vendor_payment WHERE deleted=0 AND payment_type=2");
						$rowVendorPaymentLoan = $selectVendorPaymentLoan->fetch_array();
						$totalVendorPaymentLoan  = $rowVendorPaymentLoan['totalVendorPaymentColumnLoan'];
						//--------------End Vendor Parts-----------

						//Bank Transaction  Debit
 						$selectBankTransactionDebit = $conn->query("select sum(home_amount) as totalDebit from tbl_bank_statement  WHERE deleted=0 AND place='Bank Transaction' AND transaction_type = 2");
						$selectBankTransactionDebitRow = $selectBankTransactionDebit->fetch_array();
						$totalBankTransactionDebit  = $selectBankTransactionDebitRow['totalDebit'];
						
						//Bank Transaction  Credit
 						$selectBankTransactionCredit = $conn->query("select sum(home_amount) as totalCredti from tbl_bank_statement  WHERE  deleted = 0 AND place='Bank Transaction' AND transaction_type = 1");
						$selectBankTransactionCreditRow = $selectBankTransactionCredit->fetch_array();
						$totalBankTransactionCredit  = $selectBankTransactionCreditRow['totalCredti'];
						//End Bank Statement
						//--------------------End Bank Statement --------------
						//Assets Service Transaction
						$serviceTransactionAsset = $conn->query("SELECT * FROM tbl_service_provider WHERE deleted = 0 AND transaction_type = 2");
							while($serviceTransactionAssetRow = $serviceTransactionAsset->fetch_array()){
								$serviceProviderId = $serviceTransactionAssetRow['id'];
								
								$serviceProviderAssests = $conn->query("select * from tbl_service_payment  WHERE deleted = 0 AND service_provider_id = $serviceProviderId");
								$serviceProviderAssestsFetch = $serviceProviderAssests->fetch_array();
								$serviceProviderAssestsRow  += $serviceProviderAssestsFetch['home_amount'];
								 
								
							}
						//Expenses Servic Transaction
						$serviceTransactionExpense = $conn->query("SELECT * FROM tbl_service_provider WHERE deleted = 0 AND transaction_type = 1");
							while($serviceTransactionExpenseRow = $serviceTransactionExpense->fetch_array()){
								$serviceProviderIdExpense = $serviceTransactionExpenseRow['id'];
 								$serviceProviderExpense = $conn->query("select * from tbl_service_payment  WHERE deleted = 0 AND service_provider_id = $serviceProviderIdExpense");
								$serviceProviderExpenseFetch = $serviceProviderExpense->fetch_array();
								$serviceProviderExpenseRow  += $serviceProviderExpenseFetch['home_amount'];
								 
								
							}	
						//End services.
						
 						$selectExpense = $conn->query("select sum(home_amount) as totalAmountExpense from tbl_expenses  WHERE  deleted=0");
						$rowExpenses = $selectExpense->fetch_array();
						$totalExpense  = $rowExpenses['totalAmountExpense'];
						//End Expenses
						
						$selectIncome = $conn->query("select sum(home_amount) as totalAmountIncome from tbl_incomes  WHERE  deleted=0 ");
						$rowIncomes = $selectIncome->fetch_array();
						$totalIncome  = $rowIncomes['totalAmountIncome'];
						//End Income
						
						$selectAssetsQuery = $conn->query("SELECT sum(home_amount) as totalAmountAssets FROM `tbl_assets` WHERE deleted = 0");
						$selectAssetRow = $selectAssetsQuery->fetch_array();
						$totalAssets  = $selectAssetRow['totalAmountAssets'];
						//End Assets
					}
					 ?>
					 <div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
						<h1 class="text-center"><?php echo $companyName; ?></h1>
						<?php  
						if(!empty($fromDate) && !empty($toDate)){
							$title="Genral Information Balance Sheet from <b> ".$fromDate."  </b> to <b>".$toDate;
							
						}elseif(empty($fromDate) && empty($toDate)){
							$title="Genral Information Balance Sheet ";
						}
						?>
						<h3 class="text-center"><?php   echo $title; ?></h3>
					</div>
				
					<div class="col-lg-12 col-md-12 col-sm-12">
					 <div class="panel-body" id="page-content" style="overflow-x:scroll"> 
						<div class="form-group dontPrint"> 
							<label class="col-lg-8 col-md-6 col-sm-4control-label" for="search"></label> 
							<div class="col-lg-4 col-md-6 col-sm-8"> 
 								<p class="help-block"></p>
							 </div> 
						</div>
						<table  class="table table-striped table-bordered table-responsive" id ="example">
 							<thead>
								<tr><td class='text-center'><b>Account Type</b></td><td class='text-center'><b>Credit</b></td><td class='text-center'><b>Debit</b></td><td class='text-center dontPrint'><b>Details</b></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 01 - Customer</b></td></tr>
								<tr><td class='text-center'>Customer Cash Payments</td><td class='text-center'><span class='number'><b><?php echo   number_format($totalCustomerPayment,2); ?> - USD </b></span></td><td></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralCustomerCashPaymentReportAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td class='text-center'>Customer Liability Payments</td><td class='text-center'><span class='number'><b><?php echo   number_format($totalCustomerPaymentBorrrow,2); ?> - USD </b></span></td><td></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralCustomerLiabilityPaymentReportAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 02 - Vendor</b></td></tr>
								<tr><td class='text-center'>Vendor Cash Payments</td><td class='text-center'></td><td class='text-center'><span class='number'><b><?php echo   number_format($totalCustomerPayment,2); ?> - USD </b></span></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralVendorCashPaymentReportAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
 								<tr><td class='text-center'>Vendor Liability Payments</td><td class='text-center'></td><td class='text-center'><span class='number'><b><?php echo   number_format($totalCustomerPaymentBorrrow,2); ?> - USD </b></span></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary ' href='genralVendorLiabilityPaymentReportAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 03 - Bank Transaction Through (Debit or Credit)</b></td></tr>
								<tr><td class='text-center'>Banks Transaction Credit</td><td class='text-center'><span class='number'><b><?php echo   number_format($totalBankTransactionCredit,2); ?> - USD </span></b></td><td class='text-center'></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralBankTransactionCreditAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td class='text-center'>Banks Transaction Debit</td><td></td><td class='text-center'><span class='number'><b><?php echo   number_format($totalBankTransactionDebit,2); ?> - USD </span></b></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralBankTransactionDebitAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 04 - Service Providers</b></td></tr>
								<tr><td class='text-center'>Service Transaction (Assets)</td><td class='text-center'><span class='number'><b><?php echo   number_format($serviceProviderAssestsRow,2); ?> - USD </b></span></td><td class='text-center'></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralServicesAssetBalanceSheetAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td class='text-center'>Service Transaction (Expenses)</td><td></td><td class='text-center'><span class='number'><b><?php echo   number_format($serviceProviderExpenseRow,2); ?> - USD </b></span></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='genralServicesExpenseBalanceSheetAT.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 05 - Expenses</b></td></tr>
								<tr><td class='text-center'>Miscellaneous Expenses</td><td></td><td class='text-center'><span class='number'><b><?php echo   number_format($totalExpense,2); ?> - USD </b></span></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='expenseBalanceSheet.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 06 - Income</b></td></tr>
								<tr><td class='text-center'>Miscellaneous Income</td><td class='text-center'><span class='number'><b><?php echo   number_format($totalIncome,2); ?> - USD </b></span></td><td></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='incomeBalanceSheet.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
								<tr><td colspan="4" class='text-center'><b>Section 06 - Assets</b></td></tr>
								<tr><td class='text-center'>Assets</td><td></td><td class='text-center'><span class='number'><b><?php echo  number_format($totalAssets,2); ?> - USD </b></span></td><td class='text-center dontPrint'><a target="_blank" class='btn btn-primary  ' href='assetReportETQ.php?fromDate=<?php echo $fromDate;  ?>&toDate=<?Php  echo $toDate; ?>' >Details</button></td></tr>
 							</thead>
							<?php 	$totalBalnceSheet  = $totalCashPayment + $totalIncome + $totalCustomerPaymentBorrrow + $totalCustomerPayment - $totalExpense - $totalVendorPayment - $totalVendorPaymentLoan;     ?>	
							<tfoot>		
								<tr>
									<td class='text-center'>Genral Balance Sheet</td><td class='number text-center' colspan='2' dir='ltr' ><?php   echo  number_format($totalBalnceSheet,2);    ?></td>
								</tr>
							</tfoot>
						</table>
 				
				</div>
			</div>
			<!-- Footer -->
			<?php
				require_once("_footer.php");
			?>
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
	jQuery(document).ready(function() {
		$("#search").keyup(function () {
			var value = this.value.toLowerCase().trim();
			$("#example tbody tr").each(function (index) {
				if (!index) return;
				$(this).find("td").each(function () {
					var id = $(this).text().toLowerCase().trim();
					var not_found = (id.indexOf(value) == -1);
					$(this).closest('tr').toggle(!not_found);
					return not_found;
				});
			});
		});
	});
	function detailsCashState(id){
		$.post("AjaxCustomerFactorDetailsLisETQ.php",{"id":id},function(data){
		 $("#myModal").modal('show');
		 $('#myModalData').html(data);
		});
	} 
</script>

</body>
</html>
