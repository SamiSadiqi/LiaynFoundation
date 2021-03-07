<?php
ob_start();
session_start();
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime = time();
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$validCurrencyId = $conn->safeInput($_POST['currencyId']);
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertCurrencyETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_currencies` WHERE  deleted = 0 AND id = '$validCurrencyId'";
  			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addCurrencyETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
		 
   			$updateCurrency = $conn->query("UPDATE tbl_currencies SET deleted = 0 where  id = $validCurrencyId");
			if($updateCurrency){
				header("location: ../view/addCurrencyETQ.php?save");
				exit();
			}else{
				header("location: ../view/addCurrencyETQ.php?error");
				exit();
			}
	
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_currencies';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$awardToSubContructors       = $conn->selectRecord("tbl_award_to_sbc","currencies_id = " . $validDeleteId);
		$givenFromClient       = $conn->selectRecord("tbl_given_from_client","currencies_id = " . $validDeleteId);
		$paymentToSubContractor       = $conn->selectRecord("tbl_payment_to_sbc","currencies_id = " . $validDeleteId);
		$expenseProjectStatement       = $conn->selectRecord("tbl_expense_project_statement","currencies_id = " . $validDeleteId);
		$banks       = $conn->selectRecord("tbl_banks","currencies_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","currencies_id = " . $validDeleteId);
		$expenses       = $conn->selectRecord("tbl_expenses","currencies_id = " . $validDeleteId);
		$dealers       = $conn->selectRecord("tbl_dealers","currencies_id = " . $validDeleteId);
		if($awardToSubContructors || $givenFromClient ||$paymentToSubContractor || $banks || $incomes || $expenses  || $dealers || $expenseProjectStatement){
			header("location: ../view/addCurrencyETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addCurrencyETQ.php?deleted");
			}
		}
	}
?>