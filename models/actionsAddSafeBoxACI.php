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
	
		$validDate   = $conn->safeInput($_POST['date']);
 	 	$validOwnersId   = $conn->safeInput($_POST['ownersId']);
		$validName =  $conn->safeInput($_POST['name']);
  		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
  		$validDescription = $conn->safeInput($_POST['description']);
 		$validParam = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertSafeBoxACI"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_safe_box` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addSafeBoxSS.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			 
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_safe_box (date,name,currencies_id,description,owners_id,users_id, deleted, created_at) VALUES 
			('$validDate', '$validName','$validCurrenciesId','$validDescription',$validOwnersId,$userId, 0,'$currentTime')"); 
			
			if($insertSQLQuery){
				header("location: ../view/addSafeBoxSS.php?save");
				exit();
			}else{
				header("location: ../view/addSafeBoxSS.php?error");
				exit();
			}
 
		}elseif($validParam === "editSafeBoxACI"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
		  	$validCurrenciesIdOld            =  decryptIt($conn->safeInput($_POST['currenciesIdOld']));	

			$selectCheckingTheCurrencyExisting =  $conn->query("SELECT * FROM `tbl_safe_box_statement` WHERE safe_box_id = $validEditId AND currencies_id = $validCurrenciesIdOld AND deleted = 0");
 			
			if($selectCheckingTheCurrencyExisting->num_rows>0){
				$conn->query("ROLLBACK");
				header("location: ../view/editSafeBoxACI.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}else{
				$editSQLQuery           = $conn->query("UPDATE `tbl_safe_box` SET date='$validDate', name = '$validName',owners_id = '$validOwnersId',currencies_id = '$validCurrenciesId',description = '$validDescription',changed_at = '$currentTime' WHERE id = $validEditId");
			}
			if($editSQLQuery){
				$conn->query("COMMIT");
				header("location: ../view/editSafeBoxACI.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{	
				$conn->query("ROLLBACK");
				header("location: ../view/editSafeBoxACI.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_safe_box';
  		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$transactionDealers       = $conn->selectRecord("tbl_safe_box_statement","safe_box_id = " . $validDeleteId);
 		
  
		if($transactionDealers->num_rows>0 ){
		
			header("location: ../view/addSafeBoxSS.php?error");
		}else{
 			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addSafeBoxSS.php?deleted");
			}
		}
	}
	
	
	

?>


