<?php
ob_start();
session_start();
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$validCategory = $conn->safeInput($_POST['name']);  
		$validParam    = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertIncomeCategoryETQ"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_categories` WHERE deleted = 0 AND name = '$validCategory'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addIncomeCategoryETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery = $conn->query("INSERT INTO tbl_income_categories (name, users_id, deleted, created_at) VALUES ('$validCategory', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addIncomeCategoryETQ.php?save");
				exit();
			}else{
				header("location: ../view/addIncomeCategoryETQ.php?error");
				exit();
			}	
		
		}elseif($validParam === "insertIncomeCategoryETQAJAX"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_categories` WHERE   deleted = 0 AND name = '$validCategory'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			$insertSQLQuery = $conn->query("INSERT INTO tbl_income_categories (name, users_id, deleted, created_at) VALUES ('$validCategory', $userId, 0, '$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_income_categories  where deleted = 0 and users_id = $userId  ORDER BY id DESC");
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
		}elseif($validParam === "editIncomeCategoryETQ"){
		
			$validEditId  = decryptIt($conn->safeInput($_POST['id']));
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_categories` WHERE deleted = 0 AND name = '$validCategory'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editIncomeCategoryETQ.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$editSQLQuery = $conn->query("UPDATE `tbl_income_categories` SET name = '$validCategory',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editIncomeCategoryETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editIncomeCategoryETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_income_categories';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$incomeType       = $conn->selectRecord("tbl_income_types","income_categories_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","income_category_id = " . $validDeleteId);
		 
		if($incomeType || $incomes){
			header("location: ../view/addIncomeCategoryETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");			 
			if($deleteRow){
				header("location: ../view/addIncomeCategoryETQ.php?deleted");
			}
		}
	}
	
	
	

?>