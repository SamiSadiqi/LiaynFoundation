<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$schoolId = $_POST['schoolId'];
	
	$selectDistrcits = $conn->query("SELECT * FROM tbl_schools WHERE id = $schoolId AND deleted = 0");
	$queryDistricts = $selectDistrcits->fetch_array();
	$distictsId = $queryDistricts['districts_id'];
				
		echo "<option>انتخاب ولسوالی/ ناحیه</option>";
		$selectDate = $conn->query("SELECT * FROM tbl_districts WHERE id ='$distictsId'  AND deleted = 0");
 		while($totalRow = $selectDate ->fetch_array()){
			$name = $totalRow['name'];
			$id = $totalRow['id'];
			echo "<option value='$id'>$name</option>";
		}
 	 
  	
 	
?>