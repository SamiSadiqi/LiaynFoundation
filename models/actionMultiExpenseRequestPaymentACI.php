<?php
ob_start();
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime = time();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
			$validDate				= $_POST['date'];
 			$validExpenseId  		= $_POST['expenseId'];
			$validCurrenciesId 		= $_POST['currenciesId'];
			$validAwardAmount  		= $_POST['awardAmount'];
			$validRate  			= $_POST['rate'];
			$validAFAAmount  		= $_POST['awardAmountAfg'];
			$validCheckCash			= $_POST['checkCash'];
			$validBankId    		= $_POST['bankId'];
			$validRequestType   	= $_POST['requestType'];
			$validDescription  		= $_POST['description'];
			$validProjectId      	= $_POST['projectId'];
			 
			$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
			
 		if($validParam === "insertMultiRequestExpensesPayments"){
			$conn->query("BEGIN");
			$insertSQLQuery  = true;
			$bankStatementInsert = true;
			$requestStatementInsert = true;
 			
 		
			for($i=0;$i<sizeof($validDate);$i++){
				if(!empty($validDate[$i])){
				
					 if($validCurrenciesId[$i] == 144){ // USD
						$validAmount = $validAwardAmount[$i];
					 }elseif($validCurrenciesId[$i] == 3){ // AFA
						$validAmount = $validAFAAmount[$i];
					 }elseif($validCurrenciesId[$i] == 47){ //EUR
						echo $validAmount = $validAFAAmount[$i];
					 }elseif($validCurrenciesId[$i] == 2){ // AED
						$validAmount = $validAFAAmount[$i];
					 }
					
					$insertSQLQuery =  $conn->query("INSERT INTO tbl_expense_project_statement (date,expenses_id,usd_amount,rate,projects_id, banks_id,currencies_id,description,users_id,deleted,approved,afa_amount,check_cash,request_type,created_at)VALUES
					('$validDate[$i]','$validExpenseId[$i]','$validAwardAmount[$i]','$validRate[$i]','$validProjectId[$i]' ,'$validBankId[$i]','$validCurrenciesId[$i]', '$validDescription[$i]','$userId','0','1','$validAFAAmount[$i]','$validCheckCash[$i]','$validRequestType',$currentTime)"); 
					 
					 
					if(!$insertSQLQuery){
						$insertSQLQuery  = false;
					}
				  
					//Get Last Record Id
					$lastQuery = $conn->query("SELECT * FROM `tbl_expense_project_statement` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRow = $lastQuery->fetch_array();
					$lastId    = $lastIdRow['id'];
					
					//Insert Record To bank Statement 
					$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,categories_id,sub_categories_id,check_cash,home_amount,description,deleted,approved,created_at,users_id)values
							('$validDate[$i]','project Expenses','$lastId','2','$validAmount','$validBankId[$i]','$validCurrenciesId[$i]','$validRate[$i]','$validProjectId[$i]','$validExpenseId[$i]','$validCheckCash[$i]','$validAwardAmount[$i]','$validDescription[$i]','0','1','$currentTime','$userId')";
					
					$bankStatementInsert = $conn->query($bankStatementSql);
					if(!$bankStatementInsert){
						$bankStatementInsert  = false;
					}
				 
			 
					$requestStatement ="INSERT into tbl_request_statement(date,place,reference,transaction_type,request_type,amount,banks_id,currencies_id,rate,home_amount,deleted,approved,created_at,users_id)values
							('$validDate[$i]','Request Payment to Project Expenses','$lastId','2','$validRequestType[$i]','$validAmount','$validBankId[$i]','$validCurrenciesId[$i]','$validRate[$i]','$validAwardAmount[$i]','0','1','$currentTime','$userId')";
					 
					$requestStatementInsert = $conn->query($requestStatement);
					if(!$requestStatementInsert){
						$requestStatementInsert  = false;
					}
				 	 
				}
			}
	 
       		if($insertSQLQuery && $bankStatementInsert && $requestStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/multipleRequestExpenseACI.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/multipleRequestExpenseACI.php?error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		} 
	
	}
?>