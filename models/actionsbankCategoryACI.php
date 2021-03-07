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
		
		$validCategory = $conn->safeInput($_POST['name']);  
		$validParam    = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertBankCategory"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_banks_category` WHERE deleted = 0 AND name = '$validCategory'";
			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addBankCategory.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery = $conn->query("INSERT INTO tbl_banks_category (name, users_id, deleted, created_at) VALUES ('$validCategory', $userId, 0, '$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addBankCategory.php?save");
				exit();
			}else{
				header("location: ../view/addBankCategory.php?error");
				exit();
			}	
		
		}elseif($validParam === "insertBankCategoryETQAJAX"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_banks_category` WHERE   deleted = 0 AND name = '$validCategory'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_banks_category (name, users_id, deleted,verified, created_at) VALUES ('$validCategory', $userId, 0,1,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_banks_category where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$expenseName = $rowDate['name'];
				$expenseId = $rowDate['id'];
				echo "<option value=".$expenseId.">".$expenseName."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		}elseif($validParam === "editBankCategoryETQ"){
			
			$validEditId  = decryptIt($conn->safeInput($_POST['id']));
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_banks_category` WHERE users_id = $userId AND deleted = 0 AND name = '$validCategory'";
			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editBankCategoryACI.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$editSQLQuery = $conn->query("UPDATE `tbl_banks_category` SET name = '$validCategory' WHERE  id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editBankCategoryACI.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editBankCategoryACI.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		
		}else{
			header("location: ../view/logout.php");
			exit();
		}
		 
	}else{
		$table = 'tbl_banks_category';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$bankCheck       = $conn->selectRecord("tbl_banks","category_id = " . $validDeleteId);
 		 
		if($bankCheck){
				header("location: ../view/addBankCategory.php?error");
		}else{
			$deleteRow   = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addBankCategory.php?deleted");
			}
		}
	}
?>