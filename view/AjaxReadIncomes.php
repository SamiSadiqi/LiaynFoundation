<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$categoryId = $_POST['categoryId'];
	echo "<option value=''>Income Type</option>";
  	$selectDate = $conn->query("SELECT * FROM tbl_income_types WHERE income_categories_id ='$categoryId' AND deleted = 0");
	while($totalRow = $selectDate ->fetch_array()){
	$name = $totalRow['name'];
	$id = $totalRow['id'];
	echo "<option value='$id'>$name</option>";
	}
 	 
  	
 	
?>