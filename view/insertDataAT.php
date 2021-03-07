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
	$table = decryptIt($conn->safeInput($_POST['formTable']));
  

	if($table === "tbl_item_categories"){
			 
			$validName = $conn->safeInput($_POST['name']);
			
			if($validName == ""){
				echo "required";
				exit();
			}
			
            /*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_item_categories` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
			
   			$insertSQLQuery = $conn->query("INSERT INTO tbl_item_categories (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')");
			if($insertSQLQuery){
				echo "saved";
				exit();
			}else{
				echo "error";	
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
			
   			$insertSQLQuery = $conn->query("INSERT INTO tbl_item_units (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')");
			if($insertSQLQuery){
				echo "saved";
				exit();
			}else{
				echo "error";	
				exit();
			}
	 	
	}elseif($table === "tbl_stocks"){
		
			$validName        = $conn->safeInput($_POST['name']);
			$validDescription = $conn->safeInput($_POST['description']);
		 
			/*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_stocks` WHERE deleted = 0 AND name = '$validName' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
			
 			 $insertSQLQuery  = $conn->query("INSERT INTO tbl_stocks (name,description, users_id, deleted, created_at) VALUES ('$validName','$validDescription', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				echo "saved";
				exit();
			}else{
				echo "error";	
				exit();
			}	
			 	
	}elseif($table === "tbl_items"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName           = $conn->safeInput($_POST['name']);
 		$validItemUnit       = $conn->safeInput($_POST['itemUnit']);
		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
		$validItemCategory   = $conn->safeInput($_POST['itemCategory']);
		$validStockId        = $conn->safeInput($_POST['stockId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
 		$validupoladeFile    = $conn->safeInput($_POST['upoladeFile']);
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
			/*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_items` WHERE deleted = 0 AND data = $validDate AND name = '$validName'  AND item_units_id= '$validItemUnit' AND item_categories_id = '$validItemCategory' AND stocks_id = '$validStockId' AND opening_balance = '$validOpeningBalance' AND description = '$validDescription'";
			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
			/*======================= End Check For duplicate2 ================= */
		
			
			$conn->query("BEGIN");
  			$insertSQLQuery = $conn->query("INSERT INTO tbl_items (date,name,item_units_id,stocks_id,item_categories_id,opening_balance,description,users_id, deleted, created_at) VALUES ('$validDate','$validName','$validItemUnit', '$validStockId','$validItemCategory', '$validOpeningBalance', '$validDescription', $userId, 0,'$currentTime')"); 
			
			 //Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $itemId    = $lastIdRow['id'];
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_items` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$stockStatementSql ="INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
			values('$validDate','حساب افتتاحیه جنس','$lastId','1','$validOpeningBalance','$validStockId','$lastId','$validDescription','0','$currentTime','$userId')";
			$stockStatementInsert = $conn->query($stockStatementSql);
		 
			$increaseStockAmount = $conn->changeStockAmount($itemId,$validStockId,$validOpeningBalance,1,$userId);
			 
			if($insertSQLQuery && $increaseStockAmount && $stockStatementInsert){
				$conn->query("COMMIT");
				echo "saved";
				exit();
 			}else{
				$conn->query("ROLLBACK");
				echo "error";	
				exit();
			}	
	}elseif($table === "tbl_stock_transaction"){
			 
			$validDate    = $conn->safeInput($_POST['date']);
			$validSourceStocksId   = $conn->safeInput($_POST['sourceStocksId']);
			$validItemsId = $conn->safeInput($_POST['itemsId']);
			$validTransferAmount   = $conn->safeInput($_POST['transferAmount']);
			$validDestinationStocksId = $conn->safeInput($_POST['destinationStocksId']);
			$validDescription    = $conn->safeInput($_POST['description']);
 
			/*======================= Check For duplicate2 =================  */
			$selectExistedData  = "SELECT * FROM `tbl_stock_transaction` WHERE deleted = 0 AND date = '$validDate' AND source_stocks_id = '$validSourceStocksId' AND items_id= '$validItemUnit' AND destination_stocks_id = '$validDestinationStocksId' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/* ======================= End Check For duplicate2 ================= */
  			$insertSQLQuery = $conn->query("INSERT INTO tbl_stock_transaction (date,source_stocks_id,items_id,transfer_amount,destination_stocks_id,description,users_id, deleted, created_at) VALUES 
			('$validDate', '$validSourceStocksId', '$validItemsId','$validTransferAmount', '$validDestinationStocksId','$validDescription', $userId, 0, NOW())"); 
			
			 
			$minusAmount = $conn->changeStockAmount($validItemsId,$validSourceStocksId,$validTransferAmount,2,$userId);
			$plusAmount = $conn->changeStockAmount($validItemsId,$validDestinationStocksId,$validTransferAmount,1,$userId);
			
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_stock_transaction` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			
			$sourcStockExchangeAmount = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','Stock Transfer','$lastId','2','$validTransferAmount','$validSourceStocksId','$validItemsId','$validDescription','$validDestinationStocksId','0','$currentTime','$userId')");
			
			$distinationBankExchangeAmount = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','Stock Transfer','$lastId','1','$validTransferAmount','$validDestinationStocksId','$validItemsId','$validDescription','$validSourceStocksId','0','$currentTime','$userId')");
			
		
			if($insertSQLQuery && $minusAmount && $plusAmount && $sourcStockExchangeAmount && $distinationBankExchangeAmount){		
				$conn->query("COMMIT");
				echo "saved";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";	
				exit();
			}	
			 	
	}elseif($table === "tbl_districts"){
		
 		$validName = $conn->safeInput($_POST['name']);
 
			/*======================= Check For duplicate22 ================= */
			$selectExistenDate  = "SELECT * FROM `tbl_districts` WHERE name = '$validName' AND deleted = 0";
			$existenQuery = $conn->query($selectExistenDate);
 			if($existenQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
 
		$insertSQLQuery = $conn->query("INSERT INTO tbl_districts (name,users_id,created_at) VALUES 
														('$validName',$userId,'$currentTime')"); 
		if($insertSQLQuery){
			echo "saved";
			exit();
		}else{
			echo "error";	
			exit();
		}

		 
	}elseif($table === "tbl_schools"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
		$validManagerId = $conn->safeInput($_POST['managerId']);
		$validDistrictId = $conn->safeInput($_POST['districtId']);
		$validSchoolGender = $conn->safeInput($_POST['schoolGender']);
 		$validDescription = $conn->safeInput($_POST['description']);
		$validContact = $conn->safeInput($_POST['contact']);
			//Check for empty FROM
			if($validDate == "" && $validName=="" && $validManagerId==""){
				echo "empty";
			}
			/*======================= Check For duplicate2 ================= */
			$selectExistenDate  = "SELECT * FROM `tbl_schools` WHERE  date = '$validDate' AND name = '$validName' AND manager_name = '$validManagerId' AND contact = '$validContact' AND districts_id = '$validDistrictId' AND school_type = '$validSchoolGender' AND address = '$validDescription'";			$existenQuery = $conn->query($selectExistenDate);
 			if($existenQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
		 
		
		$insertSQLQuery = $conn->query("INSERT INTO tbl_schools (date,name,manager_name,contact,districts_id,school_type,address,users_id,created_at) VALUES 
														('$validDate','$validName','$validManagerId','$validContact','$validDistrictId','$validSchoolGender','$validDescription',$userId,'$currentTime')"); 
		if($insertSQLQuery){
			echo "saved";
			exit();
		}else{
			echo "error";	
			exit();
		}

	}elseif($table === "tbl_schools_requests_equipments_title"){
			
			$conn->query("BEGIN");
			$validDate    = $conn->safeInput($_POST['date']);
			$validSchooLId   = $conn->safeInput($_POST['schoolId']);
			$validDistrictId = $conn->safeInput($_POST['districtId']);
			$validRequestNumber   = $conn->safeInput($_POST['requestNumber']);
			$validItemId = $_POST['itemId'];
			$validItemUnit = $_POST['itemUnit'];
			$validAmount = $_POST['amount'];
			$validDescription = $_POST['description'];
  
			$requestSql = "INSERT INTO tbl_schools_requests_equipments_title(date,schools_id,districts_id,requestNumber, users_id,created_at, deleted) VALUES
															('$validDate','$validSchooLId','$validDistrictId','$validRequestNumber',$userId,'$currentTime',0)";
			$requestQuery = $conn->query($requestSql);
				if(!$requestQuery){
				$requestQuery = false;
			}
			$selectIdTitle       =$conn->query("select id from tbl_schools_requests_equipments_title where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
				

			for($i=0;$i<sizeof($validItemId);$i++){
				if(!empty($validItemId[$i])){
					$schoolRequestSql    = "INSERT INTO `tbl_schools_requests_equipments_details`(request_title_id,items_id,items_unit_id,quantity,description,created_at,users_id,deleted) 
					values('$lastId','$validItemId[$i]','$validItemUnit[$i]','$validAmount[$i]','$validDescription[$i]','$currentTime',$userId, 0)";
					$schoolRequestRow  = $conn->query($schoolRequestSql);
					 
					if(!$schoolRequestRow){
						$schoolRequestRow  = false;
					}
				}
			}
			 
			if($requestQuery && $schoolRequestRow){		
				$conn->query("COMMIT");
				echo "saved";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";	
				exit();
			}	
			 	
	}elseif($table === "tbl_org_expense_categories"){
		 
			$validName = $conn->safeInput($_POST['name']);
			
            /*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_org_expense_categories` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
			
   			$insertSQLQuery = $conn->query("INSERT INTO tbl_org_expense_categories (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')");
			if($insertSQLQuery){
				echo "saved";
				exit();
			}else{
				echo "error";	
				exit();
			}
	 	
	}
	/* 
	elseif($table === "tbl_school_expense_transactions"){
		
			$validDate           = $conn->safeInput($_POST['date']);
			$validSchoolId       = $conn->safeInput($_POST['schoolId']);
			$validExpenseCategory = $conn->safeInput($_POST['expenseCategory']);
			$validAmount         = $conn->safeInput($_POST['amount']);
			$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 			$validRate			 = $conn->safeInput($_POST['rate']);
			$validBankId         = $conn->safeInput($_POST['bankId']);
			$validDescription    = $conn->safeInput($_POST['description']);
 			$validHomeAmount     = $validAmount * $validRate;
			
			//Check for empty FROM
			if($validDate == "" && $validSchoolId=="" && $validExpenseCategory=="" && $validAmount == "" && $validCurrenciesId=="" && $validRate=="" && $validBankId==""){
				echo "empty";
				exit();
			}elseif(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$validDate)){
				echo "dateFormatError";
				exit();
			}else{
				 
				 
 				$selectExistedData  = "SELECT * FROM `tbl_school_expense_transactions` WHERE deleted = 0 AND date = '$validDate' AND schools_id='$validSchoolId' AND expense_categories_id ='$validExpenseCategory' AND amount='$validAmount' AND currencies_id='$validCurrenciesId' AND banks_id='$validBankId' AND rate='$validRate' AND description='$validDescription'";
				$existedQuery = $conn->query($selectExistedData);
				
				if($existedQuery->num_rows> 0 ){
					echo "duplicate2";
					exit();
				}
 				 
				
					$conn->query("BEGIN");
					 
					$insertSQLQuery = $conn->query("INSERT INTO tbl_school_expense_transactions (date,schools_id,expense_categories_id, amount,currencies_id,banks_id,rate,description,home_amount,users_id, deleted, created_at)VALUES
											('$validDate', '$validSchoolId', '$validExpenseCategory', '$validAmount','$validCurrenciesId', '$validBankId','$validRate','$validDescription','$validHomeAmount',$userId, 0, '$currentTime' )"); 
					
					//Get Last Record Id
					$lastQuery = $conn->query("SELECT * FROM `tbl_school_expense_transactions` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRow = $lastQuery->fetch_array();
					$lastId    = $lastIdRow['id'];
					 
					$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)values
					('$validDate','School Expense Transaction','$lastId','2','$validSchoolId','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
					$bankStatementInsert = $conn->query($bankStatementSql);
				  
					if($insertSQLQuery && $bankStatementInsert){
						$conn->query("COMMIT");
						echo "saved";
						exit();
					}else{
						$conn->query("ROLLBACK");
						echo "error";	
						exit();
					}
				 
			}
	 	
	}  */
	elseif($table === "tbl_interface"){
		
 			$validName       = $conn->safeInput($_POST['name']);
			 
			
			//Check for empty FROM
			if($validName == ""){
				echo "empty";
				exit();
			}else{
				 
				 
				/*======================= Check For duplicate2 ================= */
				$selectExistedData  = "SELECT * FROM `tbl_interface` WHERE deleted = 0 AND name = '$validName'";
				$existedQuery = $conn->query($selectExistedData);
				
				if($existedQuery->num_rows> 0 ){
					echo "duplicate2";
					exit();
				}
				/*======================= End Check For duplicate2 ================= */
				 
				
 					 
					$insertSQLQuery = $conn->query("INSERT INTO tbl_interface (name,users_id, deleted, created_at)VALUES
											('$validName',$userId, 0, '$currentTime' )"); 
					 
					if($insertSQLQuery){
						echo "saved";
						exit();
					}else{
						echo "error";	
						exit();
					}
				 
			}
	 	
	}elseif($table === "tbl_degree"){
		
 			$validName       = $conn->safeInput($_POST['name']);
			/*======================= Check For duplicate2 ================= */
			$selectExistedData  = "SELECT * FROM `tbl_degree` WHERE deleted = 0 AND name = '$validName'";
			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
			/*======================= End Check For duplicate2 ================= */
			 	 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_degree (name,users_id, deleted, created_at)VALUES
									('$validName',$userId, 0, '$currentTime' )"); 
			 
			if($insertSQLQuery){
				echo "saved";
				exit();
			}else{
				echo "error";	
				exit();
			}
		 
	}elseif($table === "tbl_recipients"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
		$validContact = $conn->safeInput($_POST['contact']);
		$validInterface = $conn->safeInput($_POST['interface']);
		$validDegree = $conn->safeInput($_POST['degree']);
		$validPovertyDegree = $conn->safeInput($_POST['povertyDegree']);
		$validGender = $conn->safeInput($_POST['gender']);
  		$validDescription = $conn->safeInput($_POST['description']);
			
			
			/*======================= Check For duplicate2 ================= */
			$selectExistenDate  = "SELECT * FROM `tbl_recipients` WHERE  date = '$validDate' AND name = '$validName' AND contact = '$validContact' AND interface_id = '$validInterface' AND degree_id = $validDegree AND poverty_degree = $validPovertyDegree AND gender = '$validGender' AND address = '$validDescription'";	
			$existenQuery = $conn->query($selectExistenDate);
 			if($existenQuery->num_rows> 0 ){
				echo "duplicate2";
				exit();
			}
 			/*======================= End Check For duplicate2 ================= */
		 
		
		$insertSQLQuery = $conn->query("INSERT INTO tbl_recipients (date,name,contact,interface_id,degree_id,poverty_degree,gender,address,users_id,created_at) VALUES 
														('$validDate','$validName','$validContact','$validInterface','$validPovertyDegree','$validDegree','$validGender','$validDescription',$userId,'$currentTime')"); 
		if($insertSQLQuery){
			echo "saved";
			exit();
		}else{
			echo "error";	
			exit();
		}

	}	
?>