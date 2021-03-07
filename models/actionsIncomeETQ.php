<?php
ob_start();
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$validDate           = $conn->safeInput($_POST['date']);
 		$validIncomeCategory= $conn->safeInput($_POST['incomeCategory']);
 		$validIncomeType    = $conn->safeInput($_POST['incomeType']);
  		$validAmount  		 = $conn->safeInput($_POST['amount']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId           = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
  		$validHomeAmount     = $validAmount * $validRate;
		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertIncomeETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_incomes` WHERE deleted = 0 AND date = '$validDate' AND income_category_id = '$validIncomeCategory' AND income_type_id = '$validIncomeType' AND  amount ='$validAmount' AND currencies_id = '$validCurrenciesId' AND rate = '$validRate' AND banks_id = '$validBankId' AND  description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addIncomeETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_incomes (date,income_category_id, income_type_id, amount,currencies_id,rate,banks_id,description,home_amount,users_id, deleted, created_at) 
			VALUES ('$validDate', '$validIncomeCategory', '$validIncomeType', '$validAmount', '$validCurrenciesId', '$validRate', '$validBankId','$validDescription','$validHomeAmount',$userId, 0, '$currentTime')"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_incomes` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
	 
            //Insert Record To bank Statement 
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,categories_id,sub_categories_id,home_amount,description,deleted,created_at,users_id)
			values('$validDate','Incomes Transaction','$lastId','1','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validIncomeCategory','$validIncomeType','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
		  
       		if($insertSQLQuery  && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addIncomeETQ.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addIncomeETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "editIncomeETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
 			$validOldAmount            = decryptIt($conn->safeInput($_POST['oldAmount']));			
 			$validOldCurrenciesId            = decryptIt($conn->safeInput($_POST['oldCurrenciesId']));	
 			$validOldBankId            = decryptIt($conn->safeInput($_POST['oldBankId']));	
			
 			$editSQLQuery           = $conn->query("UPDATE `tbl_incomes` SET date='$validDate', income_category_id = '$validIncomeCategory',income_type_id = '$validIncomeType',amount = '$validAmount',currencies_id = '$validCurrenciesId',rate='$validRate', banks_id = '$validBankId',incomers_id = '$validIncomersId',description = '$validDescription', home_amount = '$validHomeAmount',changed_at ='$currentTime' WHERE users_id = '$userId' AND id = $validEditId");
			$incomeStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',banks_id='$validBankId',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validIncomeCategory',sub_categories_id='$validIncomeType', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validEditId AND place = 'Incomes Transaction'");
 
			 
			if($editSQLQuery  && $incomeStatementQuery && $requestStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editIncomeETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editIncomeETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_incomes';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
				
				$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Incomes Transaction'");
				$requestStatementDelete = $conn->query("UPDATE `tbl_request_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Income From the Office Way'");
				$deleteRow  = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
				 
				if($deleteRow && $bankStatementQueryDelete && $requestStatementDelete){
							header("location: ../view/addIncomeETQ.php?deleted");
						} 
	}
	
	 
	

?>