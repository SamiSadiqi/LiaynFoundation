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
	
		$validDate = $conn->safeInput($_POST['date']);
 		$validName = $conn->safeInput($_POST['name']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
  		$validDescription = $conn->safeInput($_POST['description']);
 		$validBankCategory = $conn->safeInput($_POST['bankCategory']);
 	 
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertBankETQ"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_banks` WHERE  deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addBankETQ.php?duplicate");
				exit();
			}
		
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			$insertSQLQuery = $conn->query("INSERT INTO	tbl_banks (date,name,category_id,opening_balance,users_id,description, deleted, created_at) VALUES 
			('$validDate', '$validName','$validBankCategory','$validOpeningBalance',$userId,'$validDescription' ,0, '$currentTime')"); 
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_banks` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,description,deleted,created_at,users_id)
			values('$validDate','حساب افتتاحیه','$lastId','1','$validOpeningBalance','$lastId','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
		 
 			if($insertSQLQuery && $bankStatementInsert){
				$conn->query('COMMIT');
				header("location: ../view/addBankETQ.php?save");
				exit();
			}else{
				$conn->query('ROLLBACK');
				header("location: ../view/addBankETQ.php?error");
				exit();
			}	
		
		}elseif($validParam === "editBankETQ"){
			
			$validEditId          = decryptIt($conn->safeInput($_POST['id']));

			$conn->query("BEGIN");

  
			$editSQLQuery           = $conn->query("UPDATE `tbl_banks` SET date='$validDate', name = '$validName',category_id = '$validBankCategory',opening_balance = '$validOpeningBalance',description = '$validDescription',changed_at = '$currentTime' WHERE   id = $validEditId");
			$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validOpeningBalance',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validEditId AND place = 'Opening Balance'");
			$requestStatementQuery =   $conn->query("UPDATE `tbl_request_statement` SET  date = '$validDate',amount='$validOpeningBalance',changed_at = '$currentTime' WHERE reference = $validEditId AND place = 'Opening Balance Bank'");

			if($editSQLQuery && $bankStatementQuery && $requestStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editBankETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editBankETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_banks';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$paymentToSubContractor       = $conn->selectRecord("tbl_payment_to_sbc","banks_id = " . $validDeleteId);
		$banksIdClient       = $conn->selectRecord("tbl_given_from_client","banks_id = " . $validDeleteId);
		$exchange1       = $conn->selectRecord("tbl_bank_exchange","source_bank_id = " . $validDeleteId);
		$exchange2       = $conn->selectRecord("tbl_bank_exchange","destination_banks_id = " . $validDeleteId);
 		$dealerTransaction       = $conn->selectRecord("tbl_dealer_transaction","banks_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","banks_id = " . $validDeleteId);
		$expenses       = $conn->selectRecord("tbl_expenses","banks_id = " . $validDeleteId);
		$projectExpenses       = $conn->selectRecord("tbl_expense_project_statement","banks_id = " . $validDeleteId);
 		
		$bankStatment  = $conn->query("SELECT * FROM tbl_bank_statement  where banks_id='$validDeleteId' AND place != 'Opening Balance' AND deleted='0'");
		 
		 

		if($paymentToSubContractor || $projectExpenses ||$banksIdClient || $bankStatment->num_rows>0 || $exchange1 || $exchange2 ||  $dealerTransaction || $incomes || $expenses){
			header("location: ../view/addbankETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");			 
			$deleteBankStatement           = $conn->query("UPDATE tbl_bank_statement SET deleted = 1 WHERE place = 'Opening Balance' AND reference = $validDeleteId");			 
			$deleteRequestStatement           = $conn->query("UPDATE tbl_request_statement SET deleted = 1 WHERE place = 'Opening Balance Bank' AND reference = $validDeleteId");			 
			if($deleteRow && $deleteBankStatement && $deleteRequestStatement){
				header("location: ../view/addbankETQ.php?deleted");
			}
		}
}
?>