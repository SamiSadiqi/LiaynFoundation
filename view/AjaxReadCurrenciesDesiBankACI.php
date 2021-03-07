<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$bankId = $_POST['bankId'];
	 
		$selectBankId = $conn->query("SELECT * FROM tbl_banks WHERE id ='$bankId'");
		$totalBankRow = $selectBankId ->fetch_array();
		$name = $totalBankRow['name'];
 		$currenciesId = $totalBankRow['currencies_id'];
	
			$selectCurrency = $conn->query("SELECT * FROM  tbl_currencies WHERE  id = $currenciesId and deleted = 0");
			$rowCurrency = $selectCurrency->fetch_array();
			
			$selectDate = $conn->query("SELECT * FROM tbl_currency_rate WHERE currencies_id ='$currenciesId'  AND deleted = 0 ORDER BY id desc");
			$totalRow = $selectDate ->fetch_array();
			$currecyRate = $totalRow['rate'];
			
			echo $currencieCode = $rowCurrency['code']."-".$currenciesId."-".$currecyRate;
		 
 ?>