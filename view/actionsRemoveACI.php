<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$validDeleteId = $_POST['id'];
	$table = $_POST['title'];
 	$currentTime =  time();
	
	if($table ==='tbl_item_categories'){

		$categoryItems  = $conn->selectRecord("tbl_items","item_categories_id = " . $validDeleteId);
 		
		if($categoryItems){
			echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_item_units'){
		
		$categoryItems  = $conn->selectRecord("tbl_items","item_units_id = " . $validDeleteId);
 
		if($categoryItems){
			echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_items'){
		
		$cashFactorItems       = $conn->selectRecord("tbl_cash_factor_details","items_id = " . $validDeleteId);
		$BillCustomerItems       = $conn->selectRecord("tbl_customer_bill_details","items_id = " . $validDeleteId);
		$cashVendorItems       = $conn->selectRecord("tbl_vendor_bill_details","items_id = " . $validDeleteId);
		
		if($cashFactorItems || $BillCustomerItems || $cashVendorItems){
			echo "error";
			exit();
		}else{
			$transferQuery  = $conn->query("SELECT * FROM  tbl_items WHERE id = $validDeleteId AND deleted = 0");
			$transferRow  = $transferQuery->fetch_array();
			$stockId = $transferRow['stocks_id'];
			$validOpeningBalance = $transferRow['opening_balance'];
 
			$decreaseStockAmount = $conn->changeStockAmount($validDeleteId,$stockId,$validOpeningBalance,2,$userId);
			
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
			
			$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Opening Balance Item'");
			
			if($deleteRow && $deleteStockStatement && $decreaseStockAmount){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_stocks'){
		
		$cashFactorItems  = $conn->query("SELECT * FROM  tbl_customer_bill_title WHERE stocks_id = $validDeleteId AND deleted = 0");
		$billCashCustomerItems  = $conn->query("SELECT * FROM  tbl_cash_factor WHERE stocks_id = $validDeleteId AND deleted = 0");
		$stockVendorItems  = $conn->query("SELECT * FROM  tbl_vendor_bill_title WHERE stocks_id = $validDeleteId AND deleted = 0");
		$ItemsStock  = $conn->query("SELECT * FROM  tbl_items WHERE stocks_id = $validDeleteId AND deleted = 0");
		
	
	if($cashFactorItems->num_rows> 0  ||    $billCashCustomerItems->num_rows > 0    ||   $stockVendorItems->num_rows> 0  || $ItemsStock->num_rows> 0 ){
		echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
			if($deleteRow){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_stock_transaction'){
		
		$table = 'tbl_stock_transaction';
		$transferQuery  = $conn->query("SELECT * FROM  tbl_stock_transaction WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$sourceStocksId = $transferRow['source_stocks_id'];
		$destinationStockId = $transferRow['destination_stocks_id'];
		$transferAmount = $transferRow['transfer_amount'];
		$itemsId = $transferRow['items_id'];
		
		$addToSourceAmount = $conn->changeStockAmount($itemsId,$sourceStocksId,$transferAmount,1,$userId);
		$subtractDestinationAmount = $conn->changeStockAmount($itemsId,$destinationStockId,$transferAmount,2,$userId);
		 
	if($addToSourceAmount && $subtractDestinationAmount){
		 
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
			$deleteStockStatement2 = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Stock Transfer' AND transaction_type = 2");
			$deleteStockStatement1 = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Stock Transfer' AND transaction_type = 1");
			if($deleteRow && $deleteStockStatement2 && $deleteStockStatement1){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}else{
				echo "programmer_error";
				exit();
			}
	}elseif($table ==='tbl_expense_equipments'){
		
		$table = 'tbl_expense_equipments';
		$transferQuery  = $conn->query("SELECT * FROM  tbl_expense_equipments WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['amount'];
 		
		$addToSourceAmount = $conn->changeStockAmount($itemsId,$stockId,$amount,1,$userId);
 		

	if($addToSourceAmount){
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
			$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Expense Equipments'");

			if($deleteRow && $deleteStockStatement){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}else{
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_salvage_equipments'){
		
		$table = 'tbl_salvage_equipments';
		$transferQuery  = $conn->query("SELECT * FROM  tbl_salvage_equipments WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['amount'];
 		
		$addToSourceAmount = $conn->changeStockAmount($itemsId,$stockId,$amount,2,$userId);
 		

	if($addToSourceAmount){
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
			$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Add Recycling Items'");

			if($deleteRow && $deleteStockStatement){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}else{
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_production_title'){
		$transferQuery  = $conn->query("SELECT * FROM $table WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
 		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['pure_amount'];
		
		 $deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId,removed_by = $userId  WHERE id = $validDeleteId");
		 $deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Produce Items'");
		 $addProductToStock = $conn->changeStockAmount($itemsId,$stockId,$amount,2,$userId);
		 
			if($deleteRow && $deleteStockStatement){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
	 
	}elseif($table ==='tbl_production_details'){
	 
		$transferQuery  = $conn->query("SELECT * FROM tbl_production_details WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
  		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['amount'];

 		$addToSourceAmount = $conn->changeStockAmount($itemsId,$stockId,$amount,1,$userId);
 		

	if($addToSourceAmount){
		
			$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Consume Production Item'");
			$deleteRow = $conn->query("UPDATE tbl_production_details SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
  		 
				if($deleteRow && $deleteStockStatement){
					echo "done";
					exit();
				}else{
					echo "programmer_error";
					exit();
				}
		}else{
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_vendor_categories'){
		 
		$checkVendor       = $conn->selectRecord("tbl_vendors","vendor_type = " . $validDeleteId);
 
		if($checkVendor){
			echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
			if($deleteRow){
				echo "done";
				exit();
			}else{
 				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_vendors'){
		 
		$vendorBillTitle       = $conn->selectRecord("tbl_vendor_bill_title","vendors_id = " . $validDeleteId);
		$vendorPayment       = $conn->selectRecord("tbl_vendor_payment","vendors_id = " . $validDeleteId);
		
		$vendorStatment  = $conn->query("SELECT * FROM tbl_vendor_statement  where vendors_id='$validDeleteId' AND place != 'Opening Balance of Vendor' and deleted='0'");
		$rowVendorStatment  = $vendorStatment->fetch_array();
		$vendorsIdCheck= $rowVendorStatment['vendors_id'];

		if($vendorBillTitle || $vendorPayment || $vendorsIdCheck){
			echo "error";
			exit();
		}else{
			$conn->query("BEGIN");
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
 			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_vendor_statement` SET deleted = 1,removed_by = $userId WHERE reference = $validDeleteId AND place = 'Opening Balance of Vendor'");
			
			if($deleteRow && $vendorStatementQueryDelete){
					$conn->query("COMMIT");
					echo "done";
					exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_vendor_bill_details'){
		
		$conn->query("BEGIN");
		$transferQuery  = $conn->query("SELECT * FROM  tbl_vendor_bill_details WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['amount'];
		$amount = $transferRow['amount'];
		$titleId = $transferRow['title_bills_id'];
  		
		$stockAmountDecress = $conn->changeStockAmount($itemsId,$stockId,$amount,2,$userId);
		$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Buy Vendors Items'");
		
		$deleteRow   = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
		
		
		$selectTotalPriceAmount = $conn->query("SELECT SUM(total_amount) as amountSummation FROM tbl_vendor_bill_details where title_bills_id = $titleId AND deleted = 0");
		$fetchFactorPrice = $selectTotalPriceAmount->fetch_array();
		$totalFacorPrice = $fetchFactorPrice['amountSummation'];
		 
		//update factor Price of title factor.
		
 		$updateFactorPriceTitle = $conn->query("UPDATE `tbl_vendor_bill_title` SET factor_price = '$totalFacorPrice', changed_at = '$currentTime' WHERE id = $titleId");

		if($stockAmountDecress && $deleteRow && $updateFactorPriceTitle && $deleteStockStatement){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_vendor_bill_title'){
		$conn->query("BEGIN");
		$updateFactorTitle = $conn->query("UPDATE `tbl_vendor_bill_title` SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
		$updateVendorPayment = $conn->query("UPDATE `tbl_vendor_payment` SET deleted = 1 WHERE reference_id = $validDeleteId AND payment_type = '1'");
 		$updateVendorStatementPayment = $conn->query("UPDATE `tbl_vendor_statement` SET  deleted = 1 WHERE reference = $validDeleteId AND place = 'Vendor Payment' AND transaction_type = 2");
		$updateVendorStatementTotalFactors = $conn->query("UPDATE `tbl_vendor_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Total Vendor Factor Price' AND transaction_type = 1");
		$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Vendor Payment Bill' AND transaction_type = 2 ");
 		  
		if($updateFactorTitle && $updateVendorPayment && $updateVendorStatementPayment && $updateVendorStatementTotalFactors && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_vendor_payment'){
		$conn->query("BEGIN");
		$editVendorPayment          = $conn->query("UPDATE `tbl_vendor_payment` SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
		$editVendorStatement        = $conn->query("UPDATE `tbl_vendor_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Vendor Payment'");
		$bankStatementQuery         = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Vendor Payment'");
		if($editVendorPayment && $editVendorStatement && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_customer_categories'){
		 
		$checkVendor       = $conn->selectRecord("tbl_customers","customer_type = " . $validDeleteId);
 
		if($checkVendor){
			echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
			if($deleteRow){
				echo "done";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_customers'){
		 
		$vendorBillTitle       = $conn->selectRecord("tbl_customer_bill_title","customers_id = " . $validDeleteId);
		$vendorPayment       = $conn->selectRecord("tbl_customer_payment","customers_id = " . $validDeleteId);
		
		$vendorStatment  = $conn->query("SELECT * FROM tbl_customer_statement where customers_id = '$validDeleteId' AND place != 'Customer Opening Balance' and deleted='0'");
		$rowVendorStatment  = $vendorStatment->fetch_array();
		$vendorsIdCheck= $rowVendorStatment['vendors_id'];

		if($vendorBillTitle || $vendorPayment || $vendorsIdCheck){
			echo "error";
			exit();
		}else{
			$conn->query("BEGIN");
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
 			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_customer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Customer Opening Balance'");
			
			if($deleteRow && $vendorStatementQueryDelete){
				$conn->query("COMMIT");
				echo "done";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_customer_bill_details'){ 
		
		$conn->query("BEGIN");

		 
		$transferQuery  = $conn->query("SELECT * FROM  tbl_customer_bill_details WHERE id = $validDeleteId AND deleted = 0");
		$transferRow  = $transferQuery->fetch_array();
		$stockId = $transferRow['stocks_id'];
		$itemsId = $transferRow['items_id'];
		$amount = $transferRow['amount'];
		$titleId = $transferRow['title_bills_id'];
  		
		$stockAmountDecress = $conn->changeStockAmount($itemsId,$stockId,$amount,1,$userId);
		 
		$deleteStockStatement = $conn->query("UPDATE tbl_stock_statement SET deleted = 1,removed_by = $userId WHERE reference = $validDeleteId AND place='Sell Customer Items'");

		
		$deleteRow   = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
		
		
		$selectTotalPriceAmount = $conn->query("SELECT SUM(total_amount) as amountSummation FROM tbl_customer_bill_details where title_bills_id = $titleId AND deleted = 0");
		$fetchFactorPrice = $selectTotalPriceAmount->fetch_array();
		$totalFacorPrice = $fetchFactorPrice['amountSummation'];
		 
		//update factor Price of title factor.
		
 		$updateFactorPriceTitle = $conn->query("UPDATE `tbl_customer_bill_title` SET factor_price = '$totalFacorPrice', changed_at = '$currentTime' WHERE id = $titleId");
  
		if($stockAmountDecress && $deleteRow && $updateFactorPriceTitle && $deleteStockStatement){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_customer_bill_title'){
		$conn->query("BEGIN");
		$updateFactorTitle = $conn->query("UPDATE `tbl_customer_bill_title` SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
		$updateVendorPayment = $conn->query("UPDATE `tbl_customer_payment` SET deleted = 1 WHERE reference_id = $validDeleteId AND payment_type = '1'");
 		$updateVendorStatementPayment = $conn->query("UPDATE `tbl_customer_statement` SET  deleted = 1 WHERE reference = $validDeleteId AND place = 'Customer Payment' AND transaction_type = 1");
		$updateVendorStatementTotalFactors = $conn->query("UPDATE `tbl_customer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Total Customer Factor Amount' AND transaction_type = 2");
		$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Customer Payment Invoice' AND transaction_type = 1 ");
 
		if($updateFactorTitle && $updateVendorPayment && $updateVendorStatementPayment && $updateVendorStatementTotalFactors && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_customer_payment'){
		$conn->query("BEGIN");
		$editVendorPayment          = $conn->query("UPDATE `tbl_customer_payment` SET deleted = 1,removed_by = $userId WHERE id = $validDeleteId");
		$editVendorStatement        = $conn->query("UPDATE `tbl_customer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Customer Payment'");
		$bankStatementQuery         = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Customer Payment'");
		if($editVendorPayment || $editVendorStatement || $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_service_categories'){
		 
		$checkTable  = $conn->selectRecord("tbl_service_provider","	service_provider_type_id = " . $validDeleteId);
 
		if($checkTable){
			echo "error";
			exit();
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
			if($deleteRow){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_service_provider'){
		 
		$checkServiceTransaction  = $conn->selectRecord("tbl_service_transaction","service_provider_id = " . $validDeleteId);
		$checkServicePayment  = $conn->selectRecord("tbl_service_payment","service_provider_id = " . $validDeleteId);
 		
		$serviceProviderPayment  = $conn->query("SELECT * FROM tbl_service_provider_statement where  place != 'Opening Balance of Service Provider' AND service_provider_id = '$validDeleteId' AND deleted='0'");
		$rowVendorStatment  = $serviceProviderPayment->fetch_array();
		$serviceStatementId = $rowVendorStatment['id'];

		if($checkServiceTransaction || $checkServicePayment || $serviceStatementId){
			echo "error";
			exit();
		}else{
		$deleteRow = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
		$deletedProviderStatement = $conn->query("UPDATE tbl_service_provider_statement SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Opening Balance of Service Provider'");
		if($deleteRow && $deletedProviderStatement){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_service_transaction'){
		 
	
 		$updateServiceTransaction  = $conn->query("UPDATE tbl_service_transaction SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
		$updateServiceTransactionPayment  = $conn->query("UPDATE tbl_service_payment SET deleted = 1 WHERE service_transactions_id = $validDeleteId");
 		$updateServiceTransactionProviderStatement  = $conn->query("UPDATE tbl_service_provider_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Total Service Amount'");
		$updateServiceTransactionProviderStatementPayment  = $conn->query("UPDATE tbl_service_provider_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Service Payment'");
		$updateServiceTransactionBankStatment  = $conn->query("UPDATE tbl_bank_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Payment to Service Provider'");
	 
		if($updateServiceTransaction || $updateServiceTransactionPayment || $updateServiceTransactionProviderStatement || $updateServiceTransactionProviderStatementPayment || $updateServiceTransactionBankStatment){
			echo "done";
			exit();
		}else{
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_service_payment'){
		 
	
 		$updateServiceTransaction  = $conn->query("UPDATE tbl_service_payment SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
		$updateServiceTransactionPayment  = $conn->query("UPDATE tbl_service_provider_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Services Provider Payment'");
		$updateServiceTransactionBankStatment  = $conn->query("UPDATE tbl_bank_statement SET deleted = 1 WHERE reference = $validDeleteId AND place='Services Provider Payment'");
	 
		if($updateServiceTransaction || $updateServiceTransactionPayment || $updateServiceTransactionBankStatment){
			echo "done";
			exit();
		}else{
			echo "programmer_error";
			exit();
		}
	}elseif($table ==='tbl_currencies'){
	  	 
			$vendorDefinition       = $conn->selectRecord("tbl_vendors","currencies_id = " . $validDeleteId);
			$vendorBillTitle       = $conn->selectRecord("tbl_vendor_bill_title","currencies_id = " . $validDeleteId);
			$customerBillTitle       = $conn->selectRecord("tbl_customer_bill_title","currencies_id = " . $validDeleteId);
			$serviceTransaction       = $conn->selectRecord("tbl_service_transaction","currencies_id = " . $validDeleteId);
			$banks       = $conn->selectRecord("tbl_banks","currencies_id = " . $validDeleteId);
			$incomes       = $conn->selectRecord("tbl_incomes","currencies_id = " . $validDeleteId);
			$expenses       = $conn->selectRecord("tbl_expenses","currencies_id = " . $validDeleteId);
			$dealers       = $conn->selectRecord("tbl_dealers","currencies_id = " . $validDeleteId);
			if($vendorDefinition || $vendorBillTitle ||$customerBillTitle  || $serviceTransaction || $banks || $incomes || $expenses  || $dealers){
					echo "error";
					exit();
			}else{
				$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
				if($deleteRow){
					echo "done";
					exit();
				}else{
					echo "programmer_error";
					exit();
				}
			}
	}elseif($table ==='tbl_currency_rate'){

			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
	}elseif($table ==='tbl_banks'){
 
 		$vendorBillTitle       = $conn->selectRecord("tbl_vendor_bill_title","banks_id = " . $validDeleteId);
		$vendorPayment       = $conn->selectRecord("tbl_vendor_payment","banks_id = " . $validDeleteId);
		$customerBillTitle       = $conn->selectRecord("tbl_customer_bill_title","banks_id = " . $validDeleteId);
		$customerPayment       = $conn->selectRecord("tbl_customer_payment","banks_id = " . $validDeleteId);
		$serviceTransaction       = $conn->selectRecord("tbl_service_transaction","banks_id = " . $validDeleteId);
		$servicePayment       = $conn->selectRecord("tbl_service_payment","banks_id = " . $validDeleteId);
		$exchange1       = $conn->selectRecord("tbl_bank_exchange","source_bank_id = " . $validDeleteId);
		$exchange2       = $conn->selectRecord("tbl_bank_exchange","destination_banks_id = " . $validDeleteId);
 		$dealerTransaction       = $conn->selectRecord("tbl_dealer_transaction","banks_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","banks_id = " . $validDeleteId);
		$expenses       = $conn->selectRecord("tbl_expenses","banks_id = " . $validDeleteId);
  		
		$bankStatment  = $conn->query("SELECT * FROM tbl_bank_statement where banks_id ='$validDeleteId' AND place != 'Opening Balance' AND deleted='0'");
		 
		 

		if($vendorBillTitle || $vendorPayment ||$customerBillTitle ||$customerPayment ||$serviceTransaction || $servicePayment || $bankStatment->num_rows>0 || $exchange1 || $exchange2 ||  $dealerTransaction || $incomes || $expenses){
				echo "error";
				exit();
		}else{
			$conn->query("BEGIN");
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			$deleteBankStatement           = $conn->query("UPDATE tbl_bank_statement SET deleted = 1 WHERE place = 'Opening Balance' AND reference = $validDeleteId");			 
			if($deleteRow && $deleteBankStatement){
				$conn->query("COMMIT");
				echo "done";
					exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_banks_category'){
  
		$bankCheck       = $conn->selectRecord("tbl_banks","category_id = " . $validDeleteId);
 		 
		if($bankCheck){
				echo "error";
				exit();
		}else{
			$deleteRow   = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_bank_statement'){
		
			$conn->query("BEGIN");
			$deleteRow   = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
 			if($deleteRow){
				$conn->query("COMMIT");
				echo "done";
					exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			}
	}elseif($table ==='tbl_bank_exchange'){
   
			$deletedQuery = $conn->query("SELECT * FROM `tbl_bank_exchange` WHERE id = $validDeleteId AND deleted = 0");
            $deletedRow			= $deletedQuery->fetch_array();
            $sourceBankId    = $deletedRow['source_bank_id'];
            $destinationBankId    = $deletedRow['destination_banks_id'];
  		
			$conn->query("BEGIN");
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
 
			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND banks_id = $sourceBankId  AND place = 'Bank Transfer' AND transaction_type = 2");
			$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND banks_id = $destinationBankId AND place = 'Bank Transfer' AND transaction_type = 1");
 
			if($deleteRow && $vendorStatementQueryDelete && $bankStatementQueryDelete){
				$conn->query("COMMIT");
				echo "done";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();

			}
		
	}elseif($table ==='tbl_expense_categories'){
		  
			$selectExistedData  = "SELECT * FROM `tbl_expense_types` WHERE expense_categories_id = $validDeleteId  AND deleted = 0";
			$existedQuery = $conn->query($selectExistedData);
			 
			$selectExistedDataExpenses  = "SELECT * FROM `tbl_expenses` WHERE expense_category_id = $validDeleteId  AND deleted = 0";
			$existedQueryExpenses = $conn->query($selectExistedDataExpenses);
		 
			if($existedQuery->num_rows> 0 || $existedQueryExpenses->num_rows> 0){
				echo "error";
				exit();
			}else{
				 
				$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
				if($deleteRow){
					echo "done";
					exit();
				}else{
					echo "programmer_error";
					exit();
				}
			}
	}elseif($table ==='tbl_expense_types'){
		 
 		$expensees       = $conn->selectRecord("tbl_expenses","expense_type_id = " . $validDeleteId);
		if($expensees){
				echo "error";
				exit();
		}else{
			$deleteRow	 = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_expenses'){
		 
			$selectExistedData  = "SELECT * FROM `tbl_expenses` WHERE id = $validDeleteId AND approved != 0";
			$existedQuery = $conn->query($selectExistedData);
			if($existedQuery->num_rows> 0){
				echo "error";
				exit();
		}else{
			$conn->query("BEGIN");
			$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Office Expenses Transaction'");
			$deleteRow  = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			 
			if($deleteRow && $bankStatementQueryDelete){
				$conn->query("COMMIT");
					echo "done";
					exit();
				}else{
					$conn->query("ROLLBACK");
					echo "programmer_error";
					exit();
				} 
			}
	}elseif($table ==='tbl_income_categories'){
		 
		$incomeType       = $conn->selectRecord("tbl_income_types","income_categories_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","income_category_id = " . $validDeleteId);
		 
		if($incomeType || $incomes){
				echo "error";
				exit();
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_income_types'){
		  
 		$incomes       = $conn->selectRecord("tbl_incomes","income_type_id = " . $validDeleteId);
		 
		if($incomes){
				echo "error";
				exit();
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_incomes'){
		 
		$conn->query("BEGIN");
		$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Incomes Transaction'");
		$deleteRow  = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
		 
		if($deleteRow && $bankStatementQueryDelete){
			$conn->query("COMMIT");
				echo "done";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "programmer_error";
				exit();
			} 
	}elseif($table ==='tbl_staff'){
		
		$expenses       = $conn->selectRecord("tbl_expenses","expensers_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","incomers_id = " . $validDeleteId);
		if($expenses || $incomes  ){
				echo "error";
				exit();
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_dealers'){
		  
		$transactionDealers       = $conn->selectRecord("tbl_dealer_transaction","dealers_id = " . $validDeleteId);
 		
		$dealerStatment  = $conn->query("SELECT * FROM tbl_dealer_statement  where dealers_id='$validDeleteId' AND  deleted='0'");
  
		if($transactionDealers->num_rows>0 || $dealerStatment->num_rows>0){
				echo "error";
				exit();
		}else{
 			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_dealer_transaction'){
	 
			$selectExistedData  = "SELECT * FROM `tbl_dealer_transaction` WHERE id = $validDeleteId AND approved !=0 ";
			$existedQuery = $conn->query($selectExistedData);
			if($existedQuery->num_rows> 0){
				echo "error";
				exit();
			}else{
				$conn->query("BEGIN");
				$deleteRow  = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");
				$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Dealer Transaction'");
				$dealerStatementDelete = $conn->query("UPDATE `tbl_dealer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Dealer Transaction'");
			
				if($deleteRow && $bankStatementQueryDelete && $dealerStatementDelete){
					$conn->query("COMMIT");
					echo "done";
					exit();
				}else{
					$conn->query("ROLLBACK");
					echo "programmer_error";
					exit();
				}
			}
			
		}elseif($table ==='tbl_asset_types'){
	  
		$assetsType       = $conn->selectRecord("tbl_assets","asset_types_id = " . $validDeleteId);
 		 
		if($assetsType){
				echo "error";
				exit();
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_assets'){
			
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
				echo "done";
				exit();
			}else{
				echo "programmer_error";
				exit();
			}
	}elseif($table ==='tbl_users'){
			
			$vendorBillTitle       = $conn->selectRecord("tbl_vendor_bill_title","banks_id = " . $validDeleteId);
			$vendorPayment       = $conn->selectRecord("tbl_vendor_payment","banks_id = " . $validDeleteId);
			$customerBillTitle       = $conn->selectRecord("tbl_customer_bill_title","banks_id = " . $validDeleteId);
			$customerPayment       = $conn->selectRecord("tbl_customer_payment","banks_id = " . $validDeleteId);
			$serviceTransaction       = $conn->selectRecord("tbl_service_transaction","banks_id = " . $validDeleteId);
			$servicePayment       = $conn->selectRecord("tbl_service_payment","banks_id = " . $validDeleteId);
			$exchange1       = $conn->selectRecord("tbl_bank_exchange","users_id = " . $validDeleteId);
 			$dealerTransaction       = $conn->selectRecord("tbl_dealer_transaction","users_id = " . $validDeleteId);
			$incomes       = $conn->selectRecord("tbl_incomes","users_id = " . $validDeleteId);
			$expenses       = $conn->selectRecord("tbl_expenses","users_id = " . $validDeleteId);
			 

			if($vendorBillTitle || $vendorPayment ||$customerBillTitle  || $customerPayment || $serviceTransaction || $servicePayment ||  $dealerTransaction ||  $exchange1 || $incomes || $expenses){
				echo "error";
				exit();
			}else{
			    
				$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
				if($deleteRow){
					echo "done";
					exit();
				}else{
					echo "programmer_error";
					exit();
				}
			}
	}elseif($table ==='tbl_positions'){
			 
 		$validPositionId       = $conn->selectRecord("tbl_users","position_id = " . $validDeleteId);
		if($validPositionId){
			echo "error";
			exit();
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1,removed_by = $userId  WHERE id = $validDeleteId");			 
			if($deleteRow){
					echo "done";
					exit();
			}else{
				echo "programmer_error";
				exit();
			}
		}
	}elseif($table ==='tbl_safe_box'){
		
		$transactionDealers       = $conn->selectRecord("tbl_safe_box_statement","safe_box_id = " . $validDeleteId);
		if($transactionDealers->num_rows>0 ){
			echo "error";
			exit();
		}else{
 			$deleteRow  = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
					echo "done";
					exit();
			}
		}
	}elseif($table ==='tbl_safe_box_statement'){
	
		$dealerStatementDelete = $conn->query("UPDATE `tbl_safe_box_statement` SET deleted = 1 WHERE id = $validDeleteId");

		if($dealerStatementDelete){
				echo "done";
				exit();
		} 
	}elseif($table ==='tbl_staff'){
	
		$staffDelete = $conn->query("UPDATE `tbl_staff` SET deleted = 1 WHERE id = $validDeleteId");

	
		if($staffDelete){
				echo "done";
				exit();
		} 
	}
	 
 ?>