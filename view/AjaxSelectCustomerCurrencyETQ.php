<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$customerId = $_POST['customerId'];
	
 		$selectCustomer = $conn->query("SELECT * FROM `tbl_customers` WHERE id = $customerId AND deleted = 0 ORDER BY id DESC");
		$rowCustomer = $selectCustomer->fetch_array();
		$currencyId = $rowCustomer['currencies_id'];
		
		$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencyId AND deleted = 0 ORDER BY id DESC");
 			while($row = $currenciesRow->fetch_array()){
					
				$id   = $row['id'];
				$name = $row['code'];
				echo "<option value='$id'>$name</option>";
			}	
?>