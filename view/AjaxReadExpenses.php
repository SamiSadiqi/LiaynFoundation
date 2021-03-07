<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$categoryId = $_POST['categoryId'];
  	$selectDate = $conn->query("SELECT * FROM tbl_expense_types WHERE expense_categories_id ='$categoryId' AND deleted = 0");
	while($totalRow = $selectDate ->fetch_array()){
	$name = $totalRow['name'];
	$id = $totalRow['id'];
	echo "<option value='$id'>$name</option>";
	}
 	 
  	
 	
?>