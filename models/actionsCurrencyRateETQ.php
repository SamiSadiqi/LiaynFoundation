<?php
ob_start();
session_start();
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$validCurrencyId = $conn->safeInput($_POST['currencyId']);
		$validRate = $conn->safeInput($_POST['rate']);
		$validDate = $conn->safeInput($_POST['date']);
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertCurrencyRateETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_currency_rate` WHERE deleted = 0 AND currencies_id	 = '$validCurrencyId' AND rate = $validRate AND date = '$validDate'";
  			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addCurrencyRateETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
		 
   			$updateCurrency = $conn->query("INSERT INTO  tbl_currency_rate(date,rate,currencies_id,users_id,deleted)VALUES('$validDate','$validRate','$validCurrencyId','$userId',0)");
			if($updateCurrency){
				header("location: ../view/addCurrencyRateETQ.php?save");
				exit();
			}else{
				header("location: ../view/addCurrencyRateETQ.php?error");
				exit();
			}
	
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_currency_rate';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addCurrencyRateETQ.php?deleted");
			}
		}
 
?>