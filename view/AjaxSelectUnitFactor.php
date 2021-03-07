<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$itemId = $_POST['itemId'];
	
	$selectItems = $conn->query("SELECT * FROM tbl_items WHERE id = $itemId AND deleted = 0");
	$queryItems = $selectItems->fetch_array();
	$itemUnitId = $queryItems['item_units_id'];
				
		echo "<option>انتخاب واحد</option>";
		$selectDate = $conn->query("SELECT * FROM tbl_item_units WHERE id ='$itemUnitId'  AND deleted = 0");
 		while($totalRow = $selectDate ->fetch_array()){
			$name = $totalRow['name'];
			$id = $totalRow['id'];
			echo "<option value='$id'>$name</option>";
		}
 	 
  	
 	
?>