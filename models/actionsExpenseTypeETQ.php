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
		$validExpenseCategory = $conn->safeInput($_POST['expenseCategory']);  
		$validExpense        = $conn->safeInput($_POST['name']);  
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertExpenseTypeETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_expense_types` WHERE deleted = 0 AND name = '$validName' AND expense_categories_id = $validExpenseCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addExpenseTypeETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_expense_types (expense_categories_id,name,users_id, deleted, created_at) VALUES ('$validExpenseCategory','$validExpense', $userId, 0, '$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addExpenseTypeETQ.php?save");
				exit();
			}else{
				header("location: ../view/addExpenseTypeETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "insertExpenseTypeETQAJAX"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_expense_types` WHERE deleted = 0 AND name = '$validName' AND expense_categories_id = $validExpenseCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_expense_types (expense_categories_id,name,users_id, deleted,created_at) VALUES ('$validExpenseCategory','$validExpense', $userId,0,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_expense_types  where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$expenseTypeName = $rowDate['name'];
				$expenseTypeId = $rowDate['id'];
				echo "<option value=".$expenseTypeId.">".$expenseTypeName."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
			
		}elseif($validParam === "editExpenseTypeETQ"){
		
			$validEditId  = $conn->safeInput(decryptIt($_POST['id']));
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_expense_types` WHERE deleted = 0 AND name = '$validName' AND expense_categories_id = $validExpenseCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editExpenseTypeETQ.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$editSQLQuery = $conn->query("UPDATE `tbl_expense_types` SET expense_categories_id='$validExpenseCategory',name = '$validExpense',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editExpenseTypeETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editExpenseTypeETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}
	
	
	

?>