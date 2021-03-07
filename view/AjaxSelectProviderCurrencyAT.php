<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$providerId = $_POST['providerId'];
	
 		$selectProvider = $conn->query("SELECT * FROM `tbl_service_provider` WHERE id = $providerId AND deleted = 0 ORDER BY id DESC");
		$providerQuery = $selectProvider->fetch_array();
		$currencyId = $providerQuery['currencies_id'];
		
		$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencyId AND deleted = 0 ORDER BY id DESC");
 			while($row = $currenciesRow->fetch_array()){
					
				$id   = $row['id'];
				$name = $row['code'];
				echo "<option value='$id'>$name</option>";
			}	
?>