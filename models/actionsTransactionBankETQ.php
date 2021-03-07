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
 		$validTransactionType = $conn->safeInput($_POST['transactionType']);
 		$validAmount = $conn->safeInput($_POST['amount']);
  		$validCurrenciesId = $conn->safeInput($_POST['currenciesId']);
 		$validBankId = $conn->safeInput($_POST['bankId']);
  		$validRate = $conn->safeInput($_POST['rate']);
 		$validDescription = $conn->safeInput($_POST['description']);
  		$validHomeAmount = $validAmount * $validRate;
	 
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		 
		if($validParam === "insertTransactionBankETQ"){
			$conn->query("BEGIN");
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_bank_statement` WHERE deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow= $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'] + 1;
			
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)
			values('$validDate','انتقالات بانکی','$lastId','$validTransactionType','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			 
		  
 			if($bankStatementInsert){
				$conn->query('COMMIT');
				header("location: ../view/bankTransactionETQ.php?save");
				exit();
			}else{
				$conn->query('ROLLBACK');
				header("location: ../view/bankTransactionETQ.php?error");
				exit();
			}	
		
		}elseif($validParam === "editBankTransactionETQ"){

			$conn->query("BEGIN");

			$validEditId  	 	 = decryptIt($conn->safeInput($_POST['id']));
			$bankStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',transaction_type = '$validTransactionType', rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = '$currentTime' WHERE id = $validEditId AND place = 'انتقالات بانکی'");
			
 	
			if($bankStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editTransactionBankETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editTransactionBankETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_bank_statement';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		 
		$bankStatment  = $conn->query( "SELECT * FROM tbl_bank_statement  where id='$validDeleteId' AND transaction_type = 2 AND approved !=1 AND deleted='0'");
		 
		 

		if($bankStatment->num_rows>0){
			header("location: ../view/bankTransactionETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
 			$deleteRequestStatement           = $conn->query("UPDATE tbl_request_statement SET deleted = 1 WHERE place = 'Bank Transaction' AND reference = $validDeleteId");			 
			if($deleteRow && $deleteRequestStatement){
				header("location: ../view/bankTransactionETQ.php?deleted");
			}
		}
	}
	

?>