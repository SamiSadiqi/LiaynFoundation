<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	$currenciesId = $_POST['currenciesId'];
   	
	$selectBankId = $conn->query("SELECT * FROM tbl_banks WHERE currencies_id ='$currenciesId' AND deleted = 0");
	echo "<option value=''>انتخاب بانک</option>";

	while($totalBankRow = $selectBankId ->fetch_array()){;
		$name = $totalBankRow['name'];
		$id = $totalBankRow['id'];
		echo "<option value='$id'>$name</option>";
	}
	exit();
 ?>