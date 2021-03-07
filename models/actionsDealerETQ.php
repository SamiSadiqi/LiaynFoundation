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
 		$validName   = $conn->safeInput($_POST['name']);
 		$validFamily = $conn->safeInput($_POST['family']);
  		$validContact= $conn->safeInput($_POST['contact']);
  		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
  		$validAddress= $conn->safeInput($_POST['address']);
 	 
 		$validParam = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertDealerETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_dealers` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addDealerETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			 
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_dealers (date,name,family,contact,currencies_id,address,users_id,deleted, created_at) VALUES ('$validDate', '$validName', '$validFamily', '$validContact','$validCurrenciesId','$validAddress',$userId, 0,'$currentTime')"); 
			
			if($insertSQLQuery){
				header("location: ../view/addDealerETQ.php?save");
				exit();
			}else{
				header("location: ../view/addDealerETQ.php?error");
				exit();
			}
 
 		}elseif($validParam === "editDealerETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_dealers` WHERE  AND deleted = 0 AND name = '$validName' AND date = '$validDate' AND family = '$validFamily' AND contact ='$validContact' AND currencies_id = '$validCurrenciesId' AND address = '$validAddress'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editDealerETQ.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			 
			$validCurrenciesIdOld            =  decryptIt($conn->safeInput($_POST['currenciesIdOld']));	
		 
			$selectCheckingTheCurrencyExisting =  $conn->query("SELECT * FROM `tbl_dealer_transaction` WHERE dealers_id = $validEditId AND currencies_id = $validCurrenciesIdOld AND deleted = 0");
 			
			if($selectCheckingTheCurrencyExisting->num_rows>0){
				$conn->query("ROLLBACK");
				header("location: ../view/editDealerETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}else{
				$editSQLQuery           = $conn->query("UPDATE `tbl_dealers` SET date='$validDate', name = '$validName',family = '$validFamily',contact = '$validContact',currencies_id = '$validCurrenciesId',address = '$validAddress',changed_at = '$currentTime' WHERE id = $validEditId");
			}
			if($editSQLQuery){
				$conn->query("COMMIT");
				header("location: ../view/editDealerETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{	
				$conn->query("ROLLBACK");
				header("location: ../view/editDealerETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_dealers';
  		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$transactionDealers       = $conn->selectRecord("tbl_dealer_transaction","dealers_id = " . $validDeleteId);
 		
		$dealerStatment  = $conn->query("SELECT * FROM tbl_dealer_statement  where dealers_id='$validDeleteId' AND  deleted='0'");
  
		if($transactionDealers->num_rows>0 || $dealerStatment->num_rows>0){
		
			header("location: ../view/addDealerETQ.php?error");
		}else{
 			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addDealerETQ.php?deleted");
			}
		}
	}
	
	
	

?>


