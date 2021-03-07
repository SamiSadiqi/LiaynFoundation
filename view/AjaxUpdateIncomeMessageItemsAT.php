<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$today = date("Y-m-d");
	
	$requestRawSQLQuery    = $conn->query("SELECT * FROM tbl_stock_balance");
	while($row = $requestRawSQLQuery->fetch_array()){
		$minimumAmount = $row['amount'];
		$itemId = $row['items_id'];
		$rowItems = $conn->query("SELECT * from tbl_items where deleted = 0 AND minimum > ".$minimumAmount." AND id = ".$row['items_id']);
		$numRows =  $rowItems->num_rows;
		$totalNumRow += $numRows;

	}
	echo $totalNumRow;
	exit();
?>