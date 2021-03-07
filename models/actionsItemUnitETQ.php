<?php
ob_start();
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$validName = $conn->safeInput($_POST['name']);
		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));

		if($validParam === "insertItemUnitETQ"){
			
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_item_units` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addItemUnitAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_item_units (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0, '$currentTime ')");
			if($insertSQLQuery){
				header("location: ../view/addItemUnitAT.php?save");
				exit();
			}else{
				header("location: ../view/addItemUnitAT.php?error");
				exit();
			}	
			
		}elseif($validParam === "insertItemUnitAjaxACI"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_item_units` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_item_units (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0, '$currentTime ')");
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_item_units where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$unitName = $rowDate['name'];
				$unitId = $rowDate['id'];
				echo "<option value=".$unitId.">".$unitName."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		}else{
				header("location: ../view/logout.php");
				exit();
			}
	}
?>