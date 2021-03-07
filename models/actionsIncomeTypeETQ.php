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
		$validIncomeCategory = $conn->safeInput($_POST['incomeCategory']);  
		$validIncome         = $conn->safeInput($_POST['name']);  
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertIncomeTypeETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_types` WHERE  deleted = 0 AND name = '$validName' AND income_categories_id = $validIncomeCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addIncomeTypeETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_income_types (income_categories_id,name,users_id, deleted, created_at) VALUES ('$validIncomeCategory','$validIncome', $userId, 0, '$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addIncomeTypeETQ.php?save");
				exit();
			}else{
				header("location: ../view/addIncomeTypeETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "insertIncomeTypeETQAJAX"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_types` WHERE deleted = 0 AND name = '$validIncome' AND income_categories_id = $validIncomeCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_income_types (income_categories_id,name,users_id, deleted, created_at) VALUES ('$validIncomeCategory','$validIncome', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  tbl_income_types  where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$incomeTypeName = $rowDate['name'];
				$incomeTypeId = $rowDate['id'];
				echo "<option value=".$incomeTypeId.">".$incomeTypeName."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
			
		}elseif($validParam === "editIncomeTypeETQ"){
		
			$validEditId  = $conn->safeInput(decryptIt($_POST['id']));
			 /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_income_types` WHERE  deleted = 0 AND name = '$validName' AND income_categories_id = $validIncomeCategory";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/editIncomeTypeETQ.php?id=" . encryptIt($validEditId) ."&duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$editSQLQuery = $conn->query("UPDATE `tbl_income_types` SET income_categories_id='$validIncomeCategory',name = '$validIncome',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editIncomeTypeETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editIncomeTypeETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_income_types';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
 		$incomes       = $conn->selectRecord("tbl_incomes","income_type_id = " . $validDeleteId);
		 
		if($incomes){
			header("location: ../view/addIncomeTypeETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");			 
			if($deleteRow){
				header("location: ../view/addIncomeTypeETQ.php?deleted");
			}
		}
	}
	
	
	

?>