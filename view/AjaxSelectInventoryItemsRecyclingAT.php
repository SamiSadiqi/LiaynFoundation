<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
	$stockId = $_POST['stockId'];
   	$selectDate = $conn->query("SELECT * FROM tbl_stock_balance WHERE stocks_id ='$stockId'");
	echo "<option>Select Item </option>";
	while($totalRow = $selectDate ->fetch_array()){
		$itemsId		= $totalRow ['id'];
		$selectItems = $conn->query("SELECT * FROM tbl_items WHERE id ='$itemsId' AND item_type = 3");
		$itemNameRow = $selectItems->fetch_array();
 		$itemName		= $itemNameRow ['name'];
 		$itemId		= $itemNameRow ['id'];
		if($itemId){
			echo "<option value='$itemId'> $itemName </option>";
		}
 	}
  	
 	
?>