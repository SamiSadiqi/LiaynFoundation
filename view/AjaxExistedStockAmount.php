<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$itemId = $_POST['itemId'];
  	$stockId = $_POST['stockId'];
	
	 
  	$selectDate = $conn->query("SELECT * FROM tbl_stock_balance WHERE stocks_id ='$stockId' AND items_id = '$itemId'");
	$totalRow = $selectDate ->fetch_array();
	$existedAmount = $totalRow['amount'];
	if($existedAmount){
		echo $existedAmount;
	}else{
		echo "Inventory is empty from this item";
	}
 	 
  	
 	
?>