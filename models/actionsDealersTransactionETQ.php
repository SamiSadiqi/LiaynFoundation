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
		$validDueDate        = $conn->safeInput($_POST['dueDate']);
		$validType           = $conn->safeInput($_POST['type']);
 		$validAmount  		 = $conn->safeInput($_POST['amount']);
  		$validBankId         = $conn->safeInput($_POST['bankId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
		$validDealerId  	 = $conn->safeInput($_POST['dealerId']);
 
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
	 
 		if($validParam === "insertDealerPaymentETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_dealer_transaction` WHERE deleted = 0 AND date = '$validDate' AND due_date = '$validDueDate' AND dealers_id = '$validDealerId' AND banks_id = '$validBankId' AND  amount ='$validAmount' AND type = 'validType' AND  description = '$validDescription' ";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/dealerPaymentETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query ("INSERT INTO tbl_dealer_transaction (date,due_date,dealers_id,amount,banks_id,type,description,users_id,deleted,created_at)VALUES
			('$validDate','$validDueDate','$validDealerId','$validAmount','$validBankId','$validType','$validDescription',$userId,0,'$currentTime')"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_dealer_transaction` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
 			$dealerStatement ="INSERT into tbl_dealer_statement(date,place,reference,transaction_type,amount,dealers_id,deleted,description,created_at,users_id)values
															('$validDate','Dealer Transaction','$lastId','$validType','$validAmount',$validDealerId ,0,'$validDescription','$currentTime',$userId)";
 			$dealerStatementQuery = $conn->query($dealerStatement);
 
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,description,categories_id,deleted,created_at,users_id)values('$validDate','Dealer Transaction','$lastId','$validType','$validAmount','$validBankId','$validDescription','$validDealerId',0,'$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			 
	 		
       		if($insertSQLQuery && $dealerStatementQuery && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/dealerPaymentETQ.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/dealerPaymentETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "editDealerPaymentETQ"){
			
			$conn->query("BEGIN");
			 
			$validEditId           	 = decryptIt($conn->safeInput($_POST['id']));	
  			$validCurrenciesId       = decryptIt($conn->safeInput($_POST['currenciesId']));	
			
			
			 
      			
 		    	$editDealerPayment          = $conn->query("UPDATE `tbl_dealer_transaction` SET date='$validDate',due_date = '$validDueDate',dealers_id = '$validDealerId',type = '$validType',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId', description = '$validDescription',home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE id = $validEditId");
      			$editDealerStatement        = $conn->query("UPDATE `tbl_dealer_statement` SET date='$validDate',transaction_type = '$validType',amount = '$validAmount',dealers_id = '$validDealerId',rate = '$validRate',home_amount = '$validHomeAmount',deleted = 0,description = '$validDescription',changed_at = '$currentTime' WHERE   reference = $validEditId AND place = 'Dealer Transaction'");
    			$bankStatementQuery         = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',transaction_type='$validType',rate='$validRate',banks_id = '$validBankId',categories_id='$validDealerId', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE reference = $validEditId AND place = 'Dealer Transaction'");
     	
			if($editDealerPayment && $editDealerStatement && $bankStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editDealerTransactionETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editDealerTransactionETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_dealer_transaction';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
  		
				$selectExistedData  = "SELECT * FROM `tbl_dealer_transaction` WHERE id = $validDeleteId AND approved !=0 ";
				$existedQuery = $conn->query($selectExistedData);
				if($existedQuery->num_rows> 0){
				header("location: ../view/dealerPaymentETQ.php?error");
				exit();
			}else{
				$deleteRow  = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");
				$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Dealer Transaction'");
				$requestStatementDelete = $conn->query("UPDATE `tbl_request_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Dealer Transaction'");
				$dealerStatementDelete = $conn->query("UPDATE `tbl_dealer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Dealer Transaction'");
			
				if($deleteRow && $bankStatementQueryDelete && $requestStatementDelete && $dealerStatementDelete){
							header("location: ../view/paymentToSubContractorACI.php?deleted");
						} 
				}
		}
		
	
	 
?>