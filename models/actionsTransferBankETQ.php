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
		    	$validSourceBank = $conn->safeInput($_POST['sourceBank']);
				$validAmount = $conn->safeInput($_POST['amount']);
				$validDestinationBank = $conn->safeInput($_POST['destinationBank']);
 				$validDescription = $conn->safeInput($_POST['description']);
 				
 				 
				$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
			 
  		if($validParam === "insertTransferBankETQ"){
			$conn->query("BEGIN");			
			$bankExcnageSql ="INSERT into tbl_bank_exchange(date,source_bank_id,amount,destination_banks_id,description,deleted,created_at,users_id)
												values('$validDate','$validSourceBank','$validAmount','$validDestinationBank','$validDescription','0','$currentTime','$userId')";
 			 
			$bankExchangeInsert = $conn->query($bankExcnageSql);
			 
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_bank_exchange` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$sourcBankExchangeAmount ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','انتقالات بین بانکها','$lastId','2','$validAmount','$validSourceBank','$validDescription','$validDestinationBank','0','$currentTime','$userId')";
			$sourcBankExchangeAmountQuery = $conn->query($sourcBankExchangeAmount);
			
			$distinationBankExchangeAmount ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','انتقالات بین بانکها','$lastId','1','$validAmount','$validDestinationBank','$validDescription','$validSourceBank','0','$currentTime','$userId')";
			$distinationBankExchangeAmountQuery = $conn->query($distinationBankExchangeAmount);
			 
 			if($bankExchangeInsert && $distinationBankExchangeAmountQuery && $sourcBankExchangeAmountQuery){
				$conn->query('COMMIT');
				header("location: ../view/bankTransferETQ.php?save");
				exit();
			}else{
				$conn->query('ROLLBACK');
				header("location: ../view/bankTransferETQ.php?error");
				exit();
			}	
		
		}
	}
		 
	
?>