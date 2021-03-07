<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
   	$currenciesId = $_POST['currenciesId'];
  	$selectDate = $conn->query("SELECT * FROM tbl_currency_rate WHERE currencies_id ='$currenciesId' AND deleted = 0 ORDER BY id desc");
	$totalRow = $selectDate ->fetch_array();
	echo $existanceAmount1 = $totalRow['rate'];
	exit();
 ?>