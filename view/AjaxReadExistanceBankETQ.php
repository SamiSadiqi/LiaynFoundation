<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$bankId = $_POST['bankId'];
	  
			 
 			//Money going to account of dealer.	
			$selectSumStatment = $conn->query("SELECT SUM(amount) as goingMoney FROM tbl_bank_statement where banks_id = $bankId AND transaction_type = 2  AND deleted = 0 ");
			$fetchSumCustomer = $selectSumStatment->fetch_array();
			$goingMoney = $fetchSumCustomer['goingMoney'];
			
			//Money comming to account of own business shop.	
			$selectSumStatmentComing = $conn->query("SELECT SUM(amount) as comingMoney FROM tbl_bank_statement where banks_id = $bankId AND transaction_type = 1 AND deleted = 0");
			$fetchSumCustomerComing = $selectSumStatmentComing->fetch_array();
			$comingMoney = $fetchSumCustomerComing['comingMoney'];
			
			$balaceSheetBank = $comingMoney - $goingMoney;
 			
			
			
			
			echo   $balaceSheetBank;
			
						 
?>