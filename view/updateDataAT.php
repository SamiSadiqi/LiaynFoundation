<?php
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();

	$validUpdateId = decryptIt($conn->safeInput($_POST['id']));
	$table = decryptIt($conn->safeInput($_POST['table']));
	 if($table === "tbl_item_categories"){
		
		$validName = $conn->safeInput($_POST['name']);
		
		 /*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_item_categories` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
			
		$editData = $conn->query("UPDATE `$table` SET name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId AND deleted = 0");
		if($editData){
			echo "done";
			exit();
		}else{
			echo "no";	
			exit();
		}

	}elseif($table === "tbl_item_units"){
		
		$validName = $conn->safeInput($_POST['name']);
		
		/*======================= Check For duplicate2 ================= */
		$selectExistedData  = "SELECT * FROM `tbl_item_units` WHERE deleted = 0 AND name = '$validName'";
		$existedQuery = $conn->query($selectExistedData);
		
		if($existedQuery->num_rows> 0 ){
			echo "duplicate2";
			exit();
		}
		/*======================= End Check For duplicate2 ================= */
		

		$editData = $conn->query("UPDATE `$table` SET name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId AND deleted = 0");
		if($editData){
			echo "done";
			exit();
		}else{
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_items"){
		
		$validDate           = $conn->safeInput($_POST['date']);
		$validName           = $conn->safeInput($_POST['name']);
 		$validItemUnit       = $conn->safeInput($_POST['itemUnit']);
		$validStockId        = $conn->safeInput($_POST['stockId']);
		$validItemCategory   = $conn->safeInput($_POST['itemCategory']);
		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
		$validDescription    = $conn->safeInput($_POST['description']);
		$oldAmount           = decryptIt($conn->safeInput($_POST['oldAmount']));
		$oldInventory        = decryptIt($conn->safeInput($_POST['oldInventory']));
		
		
		
		/*======================= Check For duplicate2 ================= */
		$selectExistedData  = "SELECT * FROM `tbl_items` WHERE deleted = 0 AND data = $validDate AND name = '$validName'  AND item_units_id= '$validItemUnit' AND item_categories_id = '$validItemCategory' AND stocks_id = '$validStockId' AND opening_balance = '$validOpeningBalance' AND description = '$validDescription'";
		$existedQuery = $conn->query($selectExistedData);
		
		if($existedQuery->num_rows> 0 ){
			echo "duplicate2";
			exit();
		}
		/*======================= End Check For duplicate2 ================= */
	

		$conn->query("BEGIN");
		 
		$editSQLQuery           = $conn->query("UPDATE `tbl_items` SET date='$validDate',name='$validName',item_units_id = '$validItemUnit',item_categories_id = '$validItemCategory',stocks_id = '$validStockId',opening_balance = '$validOpeningBalance',description = '$validDescription',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		 
		$stockStatementQuery = $conn->query("UPDATE `tbl_stock_statement` SET  date = '$validDate',amount='$validOpeningBalance',stocks_id = '$validStockId',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'حساب افتتاحیه جنس'");

		$decreaseStockAmount = $conn->changeStockAmount($validUpdateId,$oldInventory,$oldAmount,2,$userId);
		$increaseStockAmount = $conn->changeStockAmount($validUpdateId,$validStockId,$validOpeningBalance,1,$userId);
		 
		if($editSQLQuery && $stockStatementQuery & $decreaseStockAmount && $increaseStockAmount){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "h_tbl_staff_managers"){
		

		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
 		
		$editData = $conn->query("UPDATE `$table` SET date='$validDate',name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId AND deleted = 0");
		if($editData){
			echo "done";
			exit();
		}else{
			echo "no";	
			exit();
		}
	}elseif($table === "h_tbl_districts"){
		
		$validName        = $conn->safeInput($_POST['name']);
 
		$conn->query("BEGIN");
		 
		$editSQLQuery = $conn->query("UPDATE `h_tbl_districts` SET name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		
	 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "h_tbl_helps_transactions"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
		$validFather = $conn->safeInput($_POST['father']);
		$validSSN = $conn->safeInput($_POST['SNN']);
		$validStaffsId = $conn->safeInput($_POST['staffsId']);
		$validContact = $conn->safeInput($_POST['contact']);
		$validDistrictsId = $conn->safeInput($_POST['districtsId']);
 		$validDescription = $conn->safeInput($_POST['description']);
 
		$conn->query("BEGIN");
		 
 		 
		$editSQLQuery   = $conn->query("UPDATE `h_tbl_helps_transactions` SET date='$validDate',name = '$validName', father = '$validFather',SSN = '$validSSN',staffs_id = '$validStaffsId',contact = '$validContact',districts_id = '$validDistrictsId',description = '$validDescription',changed_at = '$currentTime' WHERE id = $validUpdateId");
   			 
	 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}
	elseif($table === "tbl_stocks"){
		
		$validName        = $conn->safeInput($_POST['name']);
		$validDescription = $conn->safeInput($_POST['description']);

		$conn->query("BEGIN");
		 
		$editSQLQuery = $conn->query("UPDATE `tbl_stocks` SET name='$validName', description = '$validDescription',changed_at = '$currentTime' WHERE id = $validUpdateId");
		
	 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_stock_transaction"){
		$validDate    = $conn->safeInput($_POST['date']);
 		$validSourceStocksId   = $conn->safeInput($_POST['sourceStocksId']);
		$validItemsId = $conn->safeInput($_POST['itemsId']);
 		$validTransferAmount   = $conn->safeInput($_POST['transferAmount']);
		$validDestinationStocksId = $conn->safeInput($_POST['destinationStocksId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
		
		$validOldSourceStockId    = decryptIt($conn->safeInput($_POST['sourceStockId']));
		$validOldDestinationStockId    = decryptIt($conn->safeInput($_POST['destinationStockId']));
		$validOldAmount    = decryptIt($conn->safeInput($_POST['oldAmount']));
		$validOldItem    = decryptIt($conn->safeInput($_POST['oldItemId']));

		$conn->query("BEGIN");
		 
		$editSQLQuery           = $conn->query("UPDATE `tbl_stock_transaction` SET date = '$validDate',source_stocks_id='$validSourceStocksId',items_id = '$validItemsId',transfer_amount = '$validTransferAmount',destination_stocks_id = '$validDestinationStocksId',description = '$validDescription',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		
		//balance old stocks.
		$increaseSourceAmount = $conn->changeStockAmount($validOldItem,$validOldSourceStockId,$validOldAmount,1,$userId);
		$decreaseDestinationAmount = $conn->changeStockAmount($validOldItem,$validOldDestinationStockId,$validOldAmount,2,$userId);
		
		//add to new stocks.
		$decreaseSourceStockAmount = $conn->changeStockAmount($validItemsId,$validSourceStocksId,$validTransferAmount,2,$userId);
		$increaseDestinationStockAmount = $conn->changeStockAmount($validItemsId,$validDestinationStocksId,$validTransferAmount,1,$userId);

		
		//Edit source Stock Statement.
		$sourceStocksStatementQuery = $conn->query("UPDATE `tbl_stock_statement` SET  date = '$validDate',amount='$validTransferAmount',stocks_id = '$validSourceStocksId', items_id='$validItemsId',description ='$validDescription',categories_id='$validDestinationStocksId',changed_at = '$currentTime' WHERE reference = $validUpdateId  AND place = 'Stock Transfer' AND transaction_type = 2");
		
		$destinationStocksStatementQuery = $conn->query("UPDATE `tbl_stock_statement` SET date = '$validDate',amount='$validTransferAmount',stocks_id = '$validDestinationStocksId', items_id ='$validItemsId',description ='$validDescription',categories_id='$validSourceStocksId',changed_at = '$currentTime' WHERE reference = $validUpdateId  AND place = 'Stock Transfer' AND transaction_type = 1");
		//End Edit bank statement.

		
		
		if($editSQLQuery && $increaseSourceAmount && $decreaseDestinationAmount && $decreaseSourceStockAmount && $increaseDestinationStockAmount && $sourceStocksStatementQuery && $destinationStocksStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_schools"){
		
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
		$validManagerId = $conn->safeInput($_POST['managerId']);
		$validDistrictId = $conn->safeInput($_POST['districtId']);
		$validContact = $conn->safeInput($_POST['contact']);
		$validSchoolGender = $conn->safeInput($_POST['schoolGender']);
		$validTotalStudent = $conn->safeInput($_POST['totalStudent']);
		$validDescription = $conn->safeInput($_POST['address']);
		

		$conn->query("BEGIN");
		 
		$editSQLQuery   = $conn->query("UPDATE `tbl_schools` SET date='$validDate',name='$validName',manager_name = '$validManagerId',districts_id = '$validDistrictId',contact = '$validContact',school_type = '$validSchoolGender',total_students='$validTotalStudent',address = '$validDescription',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_vendor_categories"){
		
		$validName        = $conn->safeInput($_POST['name']);
 
		$conn->query("BEGIN");
		 
		$editSQLQuery = $conn->query("UPDATE `tbl_vendor_categories` SET name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		
	 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_vendors"){
		
		$validDate           = $conn->safeInput($_POST['date']);
 		$validName           = $conn->safeInput($_POST['name']);
  		$validContact		= $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrneny       = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validVendorType     = $conn->safeInput($_POST['vendorType']);
 		$validAddress        = $conn->safeInput($_POST['address']);
 		$validHomeAmount     = $validOpeningBalance * $validRate;
 
		$conn->query("BEGIN");
		 
 		
		$editSQLQuery         = $conn->query("UPDATE `tbl_vendors` SET date='$validDate',vendor_type = '$validVendorType', name = '$validName',contact = '$validContact',opening_balance = '$validOpeningBalance',currencies_id = '$validCurrneny',rate = '$validRate',address = '$validAddress',changed_at = '$currentTime' WHERE id = $validUpdateId");
		$vendorStatementQuery = $conn->query("UPDATE `tbl_vendor_statement` SET  date = '$validDate',amount='$validOpeningBalance',currencies_id = '$validCurrneny', rate='$validRate', home_amount='$validHomeAmount',description ='$validAddress',changed_at = '$currentTime'  WHERE reference = $validUpdateId AND place = 'Opening Balance of Vendor'");
  			 
	 
		if($editSQLQuery && $vendorStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_vendor_payment"){
		
		$validDate           = $conn->safeInput($_POST['date']);
		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validVendorId   	= $conn->safeInput($_POST['vendorId']);
     	$validAmount  		 = $conn->safeInput($_POST['amount']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId         = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
 		$validFactorNumber    = $conn->safeInput($_POST['factorNumber']);
  		$validHomeAmount     = $validAmount * $validRate;
		
		$conn->query("BEGIN");
			
			$editVendorPayment          = $conn->query("UPDATE `tbl_vendor_payment` SET date='$validDate',currencies_id	= '$validCurrenciesId',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId', description = '$validDescription',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
			$editVendorStatement        = $conn->query("UPDATE `tbl_vendor_statement` SET date='$validDate',currencies_id='$validCurrenciesId',amount = '$validAmount',rate = '$validRate',home_amount = '$validHomeAmount',description = '$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Vendor Payment'");
			$bankStatementQuery         = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id='$validCurrenciesId',banks_id='$validBankId',rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Vendor Payment'");
				
		if($editVendorPayment && $editVendorStatement && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_customer_categories"){
		
		$validName        = $conn->safeInput($_POST['name']);
 
		$conn->query("BEGIN");
		 
		$editSQLQuery = $conn->query("UPDATE `tbl_customer_categories` SET name='$validName',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		
	 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_customers"){
		
		$validDate           = $conn->safeInput($_POST['date']);
 		$validName           = $conn->safeInput($_POST['name']);
  		$validContact  		 = $conn->safeInput($_POST['contact']);
  		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validAddress        = $conn->safeInput($_POST['address']);
 		$validCustomerType   = $conn->safeInput($_POST['customerType']);
 		$validHomeAmount     = $validOpeningBalance * $validRate;
 
		$conn->query("BEGIN");
		 
 		$editSQLQuery           = $conn->query("UPDATE `tbl_customers` SET date='$validDate', name = '$validName',contact = '$validContact',opening_balance = '$validOpeningBalance',currencies_id = '$validCurrenciesId',rate = '$validRate', address = '$validAddress' ,customer_type = '$validCustomerType',changed_at = '$currentTime'  WHERE id = $validUpdateId");
		$customerStatementQuery = $conn->query("UPDATE `tbl_customer_statement` SET  date = '$validDate',amount='$validOpeningBalance',currencies_id = '$validCurrenciesId', rate='$validRate', home_amount='$validHomeAmount',description ='$validAddress',changed_at = '$currentTime'  WHERE reference = $validUpdateId AND place = 'Customer Opening Balance'");
  			 
		if($editSQLQuery && $customerStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_customer_payment"){
		
			
		$validDate           = $conn->safeInput($_POST['date']);
		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validCustomerId   	= $conn->safeInput($_POST['customerId']);
     	$validAmount  		 = $conn->safeInput($_POST['amount']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId           = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
 		$validFactorNumber    = $conn->safeInput($_POST['factorNumber']);
  		$validHomeAmount     = $validAmount * $validRate;
		
		$conn->query("BEGIN");
		 
			
			$editCustomerPayment          = $conn->query("UPDATE `tbl_customer_payment` SET date='$validDate',customers_id = '$validCustomerId',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId', description = '$validDescription',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
  			$editCustomerStatement        = $conn->query("UPDATE `tbl_customer_statement` SET date='$validDate',amount = '$validAmount',customers_id = '$validCustomerId',rate = '$validRate',home_amount = '$validHomeAmount',description = '$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Customer Payment'");
			$bankStatementQuery         =   $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at =  '$currentTime' WHERE reference = $validUpdateId AND place = 'Customer Payment'");
  			 
		if($editCustomerPayment && $editCustomerStatement && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_banks"){
		
			
		$validDate = $conn->safeInput($_POST['date']);
 		$validName = $conn->safeInput($_POST['name']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrenciesId = $conn->safeInput($_POST['currenciesId']);
 		$validRate = $conn->safeInput($_POST['rate']);
 		$validDescription = $conn->safeInput($_POST['description']);
 		$validBankCategory = $conn->safeInput($_POST['bankCategory']);
  		$validHomeAmount = $validOpeningBalance * $validRate;
	 
		$conn->query("BEGIN");
		  
			$editSQLQuery       = $conn->query("UPDATE `tbl_banks` SET date='$validDate', name = '$validName',category_id = '$validBankCategory',opening_balance = '$validOpeningBalance',currencies_id = '$validCurrenciesId',rate = '$validRate', description = '$validDescription',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
			$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validOpeningBalance',currencies_id = '$validCurrenciesId', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Opening Balance'");
 
		if($editSQLQuery && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_banks_category"){
		
 		$validCategory = $conn->safeInput($_POST['name']);
		$conn->query("BEGIN");
		  
		$editSQLQuery = $conn->query("UPDATE `tbl_banks_category` SET name = '$validCategory' WHERE  id = $validUpdateId");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_bank_statement"){
		
		$validDate = $conn->safeInput($_POST['date']);
 		$validTransactionType = $conn->safeInput($_POST['transactionType']);
 		$validAmount = $conn->safeInput($_POST['amount']);
  		$validCurrenciesId = $conn->safeInput($_POST['currenciesId']);
 		$validBankId = $conn->safeInput($_POST['bankId']);
  		$validRate = $conn->safeInput($_POST['rate']);
 		$validDescription = $conn->safeInput($_POST['description']);
  		$validHomeAmount = $validAmount * $validRate;
	 
		$conn->query("BEGIN");
		  
 		$editSQLQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',transaction_type = '$validTransactionType', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE id = $validUpdateId AND place = 'Bank Transaction'");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_bank_exchange"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validSourceBank = $conn->safeInput($_POST['sourceBank']);
		$validDestinationBank = $conn->safeInput($_POST['destinationBank']);
		$validCurrenciesId =  $conn->safeInput($_POST['currenciesId']);
		$validDesCurrenciesId =  $conn->safeInput($_POST['desCurrenciesId']);
		$validAmount = $conn->safeInput($_POST['amount']);
		$validDestinationAmount =  $conn->safeInput($_POST['transferableAmount']);
		$validRate = $conn->safeInput($_POST['rate']);
		$validExchangeRate = $conn->safeInput($_POST['exchanageRate']);
		$validDestinationRate = $conn->safeInput($_POST['destinationRate']);
		$validDescription = $conn->safeInput($_POST['description']);
		$validHomeAmount = $validAmount * $validRate;
		
		$rowSourceEditBanks = $conn->selectRecord ("tbl_banks","id  = ". $validSourceBank);
		$validCurrenciesIdEdit = 	$rowSourceEditBanks['currencies_id'];
		
		$rowDestinationsEditBanks = $conn->selectRecord ("tbl_banks","id  = ". $validDestinationBank);
		$validCurrenciesIdDestEdit = 	$rowDestinationsEditBanks['currencies_id'];
 
		$homeAmountOfDestinationBank = $validDestinationAmount * $validDestinationRate;
		 
		$conn->query("BEGIN");
	  
		$bankExchangeQuery = $conn->query("UPDATE `tbl_bank_exchange` SET  date = '$validDate',source_bank_id  ='$validSourceBank',destination_banks_id = '$validDestinationBank',currencies_id = '$validCurrenciesIdEdit',des_currencies_id='$validCurrenciesIdDestEdit',amount='$validAmount',des_amount='$validDestinationAmount',rate = '$validRate',exchange_rate ='$validExchangeRate',des_rate= '$validDestinationRate',home_amount='$validHomeAmount',des_home_amount= '$homeAmountOfDestinationBank',description ='$validDescription',changed_at = '$currentTime' WHERE id = $validUpdateId");
		//Edit bank statement.
		$sourceBanksStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id = '$validCurrenciesIdEdit', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',categories_id='$validDestinationBank',banks_id = '$validSourceBank',changed_at = '$currentTime' WHERE reference = $validUpdateId  AND place = 'Bank Transfer' AND transaction_type = 2");
		
		$destinationBanksStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validDestinationAmount',currencies_id = '$validCurrenciesIdDestEdit', rate='$validDestinationRate', home_amount='$homeAmountOfDestinationBank',description ='$validDescription',categories_id='$validSourceBank',banks_id = '$validDestinationBank',changed_at = '$currentTime' WHERE reference = $validUpdateId  AND place = 'Bank Transfer' AND transaction_type = 1");
		//End Edit bank statement.

		if($bankExchangeQuery && $sourceBanksStatementQuery && $destinationBanksStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_expense_categories"){
		
		$conn->query("BEGIN");
		
		$validCategory = $conn->safeInput($_POST['name']);  
		$editSQLQuery = $conn->query("UPDATE `tbl_expense_categories` SET name = '$validCategory',changed_at = '$currentTime' WHERE id = $validUpdateId");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_expense_types"){
		
		$conn->query("BEGIN");
		
		$validExpenseCategory = $conn->safeInput($_POST['expenseCategory']);  
		$validExpense        = $conn->safeInput($_POST['name']); 
		
		$editSQLQuery = $conn->query("UPDATE `tbl_expense_types` SET expense_categories_id='$validExpenseCategory',name = '$validExpense',changed_at = '$currentTime' WHERE id = $validUpdateId");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_expenses"){
		
		$conn->query("BEGIN");
		
		$validDate           = $conn->safeInput($_POST['date']);
 		$validExpenseCategory= $conn->safeInput($_POST['expenseCategory']);
 		$validExpenseType    = $conn->safeInput($_POST['expenseType']);
    	$validAmount 		 = $conn->safeInput($_POST['amount']);
  	 	$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId         = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
  
		$validOldDocument = $conn->safeInput($_POST['oldDocument']);
        $validHomeAmount  = $validAmount * 	$validRate;
		
		$file=$_FILES['upoladeFile']['name'];
		$path ="documents/".$file;
		$ext=pathinfo($path,PATHINFO_EXTENSION);
		$name=pathinfo($path,PATHINFO_FILENAME);
		
 		$path1="../documents/";
		
		$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
		move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
		 
			// Edit Profile User Photo.
		if(isset($_FILES['fileName']['name']) && ($_FILES['fileName']['name'] !="")){
			
			 
			unlink($validOldDocument);
			$file=$_FILES['fileName']['name'];
			$path ="documents/".$file;
			$ext=pathinfo($path,PATHINFO_EXTENSION);
			$name=pathinfo($path,PATHINFO_FILENAME);
			 
			
			$path1="../documents/";
		 
			$validOldDocumentName = $path1.$name.$currentTime.rand(1,500).".".$ext;
			move_uploaded_file($_FILES['fileName']['tmp_name'],$validOldDocumentName);
			 
		}else{
			
			 $validOldDocumentName = $validOldDocument;
		}
	 	
 		$editSQLQuery           = $conn->query("UPDATE `tbl_expenses` SET date='$validDate', expense_category_id = '$validExpenseCategory',expense_type_id = '$validExpenseType',amount = '$validAmount',currencies_id = '$validCurrenciesId',rate='$validRate', banks_id = '$validBankId',description = '$validDescription',document = '$validOldDocumentName', home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE  id = $validUpdateId");
		$expenseStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validExpenseCategory',sub_categories_id='$validExpenseType',home_amount='$validHomeAmount',description ='$validDescription', banks_id = '$validBankId',changed_at = '$currentTime'  WHERE reference = $validUpdateId AND place = 'Office Expenses Transaction'");
		 
		if($editSQLQuery && $expenseStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_income_categories"){
		
		$conn->query("BEGIN");
		
		$validCategory = $conn->safeInput($_POST['name']);  
		$editSQLQuery = $conn->query("UPDATE `tbl_income_categories` SET name = '$validCategory',changed_at = '$currentTime' WHERE id = $validUpdateId");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_income_types"){
		
		$conn->query("BEGIN");
		
		$validIncomeCategory = $conn->safeInput($_POST['incomeCategory']);  
		$validIncome         = $conn->safeInput($_POST['name']); 
		
 		$editSQLQuery = $conn->query("UPDATE `tbl_income_types` SET income_categories_id='$validIncomeCategory',name = '$validIncome',changed_at = '$currentTime' WHERE id = $validUpdateId");

		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_incomes"){
		
		$conn->query("BEGIN");
		
		 		
		$validDate           = $conn->safeInput($_POST['date']);
  		$validIncomeCategory= $conn->safeInput($_POST['incomeCategory']);
 		$validIncomeType    = $conn->safeInput($_POST['incomeType']);
  		$validAmount  		 = $conn->safeInput($_POST['amount']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId          = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
  		$validHomeAmount     = $validAmount * $validRate;
		
	 	
 		$editSQLQuery           = $conn->query("UPDATE `tbl_incomes` SET date='$validDate', income_category_id = '$validIncomeCategory',income_type_id = '$validIncomeType',amount = '$validAmount',currencies_id = '$validCurrenciesId',rate='$validRate', banks_id = '$validBankId',description = '$validDescription', home_amount = '$validHomeAmount',changed_at ='$currentTime' WHERE id = $validUpdateId");
		$incomeStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',banks_id='$validBankId',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validIncomeCategory',sub_categories_id='$validIncomeType', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Incomes Transaction'");
		 
		if($editSQLQuery && $incomeStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_dealers"){
		
		$conn->query("BEGIN");
		
		$validDate   = $conn->safeInput($_POST['date']);
 		$validName   = $conn->safeInput($_POST['name']);
 		$validFamily = $conn->safeInput($_POST['family']);
  		$validContact= $conn->safeInput($_POST['contact']);
  		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
  		$validAddress= $conn->safeInput($_POST['address']);
 	 
	 
		$validCurrenciesIdOld            =  decryptIt($conn->safeInput($_POST['currenciesIdOld']));	
		$selectCheckingTheCurrencyExisting =  $conn->query("SELECT * FROM `tbl_dealer_transaction` WHERE dealers_id = $validUpdateId AND currencies_id = $validCurrenciesIdOld AND deleted = 0");
		
		if($selectCheckingTheCurrencyExisting->num_rows>0){
			 $editSQLQuery           = $conn->query("UPDATE `tbl_dealers` SET date='$validDate', name = '$validName',family = '$validFamily',contact = '$validContact',address = '$validAddress',changed_at = '$currentTime' WHERE id = $validUpdateId");
		}else{
			$editSQLQuery           = $conn->query("UPDATE `tbl_dealers` SET date='$validDate', name = '$validName',family = '$validFamily',contact = '$validContact',currencies_id = '$validCurrenciesId',address = '$validAddress',changed_at = '$currentTime' WHERE id = $validUpdateId");
		}
		 
		if($editSQLQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_dealer_transaction"){
		
		$conn->query("BEGIN");
		
		$validDate           = $conn->safeInput($_POST['date']);
		$validDueDate        = $conn->safeInput($_POST['dueDate']);
		$validType           = $conn->safeInput($_POST['type']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validAmount  		 = $conn->safeInput($_POST['amount']);
 		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId         = $conn->safeInput($_POST['bankId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
		$validDealerId  	 = $conn->safeInput($_POST['dealerId']);
  		$validHomeAmount     = $validAmount * $validRate;

	 
		$editDealerPayment          = $conn->query("UPDATE `tbl_dealer_transaction` SET date='$validDate',due_date = '$validDueDate',dealers_id = '$validDealerId',type = '$validType',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId',currencies_id = '$validCurrenciesId', description = '$validDescription',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
		$editDealerStatement        = $conn->query("UPDATE `tbl_dealer_statement` SET date='$validDate',transaction_type = '$validType',amount = '$validAmount',dealers_id = '$validDealerId',rate = '$validRate',currencies_id = '$validCurrenciesId',home_amount = '$validHomeAmount',description = '$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Dealer Transaction'");
		$bankStatementQuery         = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',transaction_type='$validType',rate='$validRate',banks_id = '$validBankId',categories_id='$validDealerId', home_amount='$validHomeAmount',description ='$validDescription',currencies_id = '$validCurrenciesId',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Dealer Transaction'");

		if($editDealerPayment && $editDealerStatement && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_asset_types"){
		
		$conn->query("BEGIN");
		
		$validName = $conn->safeInput($_POST['name']);
		$editSQLQuery = $conn->query("UPDATE `tbl_asset_types` SET name='$validName' WHERE id = $validUpdateId");

		if($editSQLQuery ){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_assets"){
		
		$conn->query("BEGIN");
		
		$validDate          = $conn->safeInput($_POST['date']);
 		$validAssetType     = $conn->safeInput($_POST['assetType']);
  		$validAmount        = $conn->safeInput($_POST['cost']);
 		$validCurrenciesId  = $conn->safeInput($_POST['currenciesId']);
 		$validRate          = $conn->safeInput($_POST['rate']);
 		$validBankId        = $conn->safeInput($_POST['bankId']);
 		$validUsefulAge     = $conn->safeInput($_POST['usefulAge']);
 		$validDescription   = $conn->safeInput($_POST['description']);
  		$validHomeAmount    = $validAmount * $validRate;
		
			
		$editSQLQuery           = $conn->query("UPDATE `tbl_assets` SET date='$validDate', asset_types_id = '$validAssetType',cost = '$validAmount',currencies_id = '$validCurrenciesId',rate = '$validRate',banks_id='$validBankId',useful_age='$validUsefulAge', description = '$validDescription',home_amount = '$validHomeAmount' WHERE id = $validUpdateId");
		$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validAssetType', home_amount='$validHomeAmount',description ='$validDescription', banks_id = '$validBankId',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Procurement Assets'");
 			 
	
		if($editSQLQuery && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_vendor_bill_title"){
		
		$conn->query("BEGIN");
		
		
		$validDate           = $conn->safeInput($_POST['date']);
 		$validVendorId       = $conn->safeInput($_POST['vendorId']);
  		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validFactorNumber 	 = $conn->safeInput($_POST['factorNumber']);
 		$validBankId     	 = $conn->safeInput($_POST['bankId']);
		$validDescription    = $conn->safeInput($_POST['description']); 
		
  		$validFactorPayment  = $conn->safeInput($_POST['factorPayment']); 
		 
		 
		$validHomeAmount     = $validFactorPayment * $validRate;
 
	 
 		$updateFactorTitle = $conn->query("UPDATE `tbl_vendor_bill_title` SET  date = '$validDate',vendors_id='$validVendorId',currencies_id = '$validCurrenciesId', rate='$validRate',factor_number='$validFactorNumber',banks_id='$validBankId', factor_payment = '$validFactorPayment',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
		$updateVendorPayment = $conn->query("UPDATE `tbl_vendor_payment` SET  date = '$validDate',vendors_id='$validVendorId',currencies_id = '$validCurrenciesId',amount='$validFactorPayment', rate='$validRate',banks_id = '$validBankId',factor_number = '$validFactorNumber',description ='$validDescription',payment_type = '1',home_amount='$validHomeAmount' ,changed_at = '$currentTime' WHERE reference_id = $validUpdateId AND payment_type = '1'");
 		$updateVendorStatementPayment = $conn->query("UPDATE `tbl_vendor_statement` SET  date = '$validDate',amount = '$validFactorPayment',vendors_id='$validVendorId',currencies_id = '$validCurrenciesId', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Vendor Payment' AND transaction_type = 2");
		$updateVendorStatementTotalFactors = $conn->query("UPDATE `tbl_vendor_statement` SET  date = '$validDate',vendors_id='$validVendorId',currencies_id = '$validCurrenciesId', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Total Vendor Factor Price' AND transaction_type = 1");
		$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET date = '$validDate',amount='$validFactorPayment',banks_id = '$validBankId',currencies_id = '$validCurrenciesId', rate='$validRate',home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validUpdateId AND place = 'Vendor Payment Bill' AND transaction_type = 2 ");
 		 
		if($updateFactorTitle && $updateVendorPayment && $updateVendorStatementPayment && $updateVendorStatementTotalFactors && $bankStatementQuery){
			$conn->query("COMMIT");
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_vendor_bill_details"){
		
		$conn->query("BEGIN");

		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
 		if(isset($totalFee)){
			$totalFee = $_POST['totalFee'];
		}else{
			$totalFee = $fee * $amount;
		}
		$subDescription = $_POST['subDescription'];
		$stockId		= $_POST['stockId'];
		$oldStockAmount		= $_POST['oldStockAmount'];
		$titleId		= $_POST['titleId'];
 		
		  
  		$vendorDetailsBillUpdate = $conn->query("UPDATE `tbl_vendor_bill_details` SET items_id = '$itemId',items_unit_id = '$itemUnit',amount='$amount',fee = '$fee', stocks_id='$stockId', total_amount='$totalFee',description ='$subDescription',changed_at = '$currentTime' WHERE id = $validUpdateId");
   		
		$stockAmountDecress = $conn->changeStockAmount($itemId,$stockId,$oldStockAmount,2,$userId);
   		$stockAmountIncrease = $conn->changeStockAmount($itemId,$stockId,$amount,1,$userId);
		//select total factor price.
		 
		 
		$selectTotalPriceAmount = $conn->query("SELECT SUM(total_amount) as amountSummation FROM tbl_vendor_bill_details where title_bills_id = $titleId AND deleted = 0");
		$fetchFactorPrice = $selectTotalPriceAmount->fetch_array();
		$totalFacorPrice = $fetchFactorPrice['amountSummation'];
		 
		//update factor Price of title factor.
 		$updateFactorPriceTitle = $conn->query("UPDATE `tbl_vendor_bill_title` SET factor_price = '$totalFacorPrice', changed_at = '$currentTime' WHERE id = $titleId");
		
		$updateStockBalance = $conn->query("UPDATE `tbl_stock_statement` SET amount='$amount',stocks_id = '$stockId',items_id='$itemId',changed_at = '$currentTime' WHERE reference = $validUpdateId  AND place = 'Buy Vendors Items' AND transaction_type = 1");

		//   
		/* echo $vendorDetailsBillUpdate;
		echo "<BR>";
		echo $stockAmountDecress;
		echo "<BR>";
		echo $stockAmountIncrease;
		echo "<BR>";
		echo $updateFactorPriceTitle;
		die;
		 */
		if($vendorDetailsBillUpdate && $stockAmountDecress && $stockAmountIncrease && $updateFactorPriceTitle && $updateStockBalance){
			$conn->query("COMMIT"); 	
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_schools_requests_equipments_details"){
		
		$conn->query("BEGIN");

		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
 		if(isset($totalFee)){
			$totalFee = $_POST['totalFee'];
		}else{
			$totalFee = $fee * $amount;
		}
		$validDistributionDate = $_POST['distributionDate'];
		$validDistributionQuantity		= $_POST['distributionQuantity'];
		$validDescription		= $_POST['distDescription'];
  		
		   
 		$updateRemainParts = $conn->query("UPDATE `tbl_schools_requests_equipments_details` SET dist_date = '$validDistributionDate',dist_quantity = '$validDistributionQuantity',dist_description = '$validDescription',distributed = 1, changed_at = '$currentTime' WHERE id = $validUpdateId");
		 
		if($updateRemainParts){
			$conn->query("COMMIT"); 	
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}elseif($table === "tbl_staff"){
		
		$conn->query("BEGIN");
		
		$validDate    = $conn->safeInput($_POST['date']);
 		$validName    = $conn->safeInput($_POST['name']);
 		$validFamily  = $conn->safeInput($_POST['family']);
 		$validSsn     = $conn->safeInput($_POST['ssn']);
 		$validContact = $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrenciesId    = $conn->safeInput($_POST['unit']);
 		$validRate    = $conn->safeInput($_POST['rate']);
 		$validJobType = $conn->safeInput($_POST['jobType']);
 		$validAddress = $conn->safeInput($_POST['address']);
 		$validHomeAmount = $validOpeningBalance * $validRate;
	 
  		
		$updateStaff = $conn->query("UPDATE `tbl_staff` SET date = '$validDate',name='$validName',family = '$validFamily',ssn = '$validSsn',contact = '$validContact',currencies_id = '$validCurrenciesId',rate = '$validRate',job_type='$validJobType',opening_balance= '$validOpeningBalance',address='$validAddress',home_amount='$validHomeAmount',changed_at = '$currentTime' WHERE id = $validUpdateId");
		 
		if($updateStaff){
			$conn->query("COMMIT"); 	
			echo "done";
			exit();
		}else{
			$conn->query("ROLLBACK");
			echo "no";	
			exit();
		}
	}  	
?>