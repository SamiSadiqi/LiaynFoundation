<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$today = date("Y-m-d");
	
	$requestTransactionDealer = $conn->query("SELECT * FROM tbl_dealer_transaction WHERE  '$today' >= tbl_dealer_transaction.due_date AND tbl_dealer_transaction.deleted = 0 AND tbl_dealer_transaction.status = 0");
 	$numRows =  $requestTransactionDealer->num_rows;
	
	echo $numRows;
	exit();
  
?>