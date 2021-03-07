<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$dealerId = $_POST['dealerId'];
	
 		$selectDealer = $conn->query("SELECT * FROM `tbl_dealers` WHERE id = $dealerId AND deleted = 0 ORDER BY id DESC");
		$rowDealer = $selectDealer->fetch_array();
		$currencyId = $rowDealer['currencies_id'];
		
		$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencyId AND deleted = 0 ORDER BY id DESC");
			echo "<option>Select Currency</option>";
 			while($row = $currenciesRow->fetch_array()){
					
				$id   = $row['id'];
				$name = $row['code'];
				echo "<option value='$id'>$name</option>";
			}	
?>