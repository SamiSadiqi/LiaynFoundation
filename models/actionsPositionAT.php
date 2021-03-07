<?php
ob_start();
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime = time();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
  		$validName           = $conn->safeInput($_POST['name']); 
 		$validDescription 			 = $conn->safeInput($_POST['description']); 
  		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertPositionAT"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_positions` WHERE  name = '$validName'  AND description ='$validDescription' AND deleted = 0";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addPositionAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			$insertSQLQuery =  $conn->query("INSERT INTO tbl_positions (name,description,users_id, deleted, created_at) VALUES ('$validName','$validDescription',$userId, 0, '$currentTime')"); 
 			if($insertSQLQuery){
				$conn->query("COMMIT");
				header("location: ../view/addPositionAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addPositionAT.php?error");
				exit();
			}
			
		}elseif($validParam === "insertActionWidthModalAT"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_positions` WHERE  name = '$validName'   AND deleted = 0 AND users_id = '$userId'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo "duplicated";	
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			 
			$insertSQLQuery =  $conn->query("INSERT INTO tbl_positions (name,description,users_id, deleted, created_at) VALUES ('$validName','$validDescription',$userId, 0, '$currentTime')"); 
 			if($insertSQLQuery){
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_positions  where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$positionName = $rowDate['name'];
				$positionId = $rowDate['id'];
				echo "<option value=".$positionId.">".$positionName."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
			
		}elseif($validParam === "editPositionAT"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_positions` WHERE  name = '$validName'  AND description ='$validDescription' AND deleted = 0";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editPositionAT.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
						
			$editSQLQuery           =  $conn->query("UPDATE `tbl_positions` SET name = '$validName',description = '$validDescription',changed_at = '$currentTime'  WHERE users_id = '$userId' AND id = $validEditId");
  			if($editSQLQuery){
				$conn->query("COMMIT");
				header("location: ../view/editPositionAT.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editPositionAT.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_positions';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
 		$validPositionId       = $conn->selectRecord("tbl_users","position_id = " . $validDeleteId);
 		
	 
		
		if($validPositionId){
			header("location: ../view/addPositionAT.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addPositionAT.php?deleted");
			}
		}
	}
	
	
	
	

?>