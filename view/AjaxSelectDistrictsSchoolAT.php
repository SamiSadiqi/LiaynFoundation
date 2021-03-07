<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$itemId = $_POST['itemId'];
	
	$selectUnitId = $conn->query("SELECT * FROM tbl_items WHERE id = $itemId AND deleted = 0");
	$queryUnitId = $selectUnitId->fetch_array();
	$unitId = $queryUnitId['item_units_id'];
				
		echo "<option>Select Unit</option>";
		$selectDate = $conn->query("SELECT * FROM tbl_item_units WHERE id ='$unitId'  AND deleted = 0");
 		while($totalRow = $selectDate ->fetch_array()){
			$name = $totalRow['name'];
			$id = $totalRow['id'];
			echo "<option value='$id'>$name</option>";
		}
 	 
  	
 	
?>