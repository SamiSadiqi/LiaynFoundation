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
			$validName        = $conn->safeInput($_POST['name']);
			$validDescription = $conn->safeInput($_POST['description']);
			$validParam       = decryptIt($conn->safeInput($_POST['formParameter']));
		
		if($validParam === "insertStockETQ"){
			
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_stocks` WHERE deleted = 0 AND name = '$validName' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addStockAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery  = $conn->query("INSERT INTO tbl_stocks (name,description, users_id, deleted, created_at) VALUES ('$validName','$validDescription', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addStockAT.php?save");
				exit();
			}else{
				header("location: ../view/addStockAT.php?error");
				exit();
			}	
			
		}elseif($validParam === "editStockETQ"){
		
			$validEditId  = decryptIt($conn->safeInput($_POST['id']));
			
			$editSQLQuery = $conn->query("UPDATE `tbl_stocks` SET name='$validName', description = '$validDescription' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editStockETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editStockETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_stocks';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$cashFactorItems  = $conn->query("SELECT * FROM  tbl_customer_bill_title WHERE stocks_id = $validDeleteId AND users_id = $userId AND deleted = 0");
		$billCashCustomerItems  = $conn->query("SELECT * FROM  tbl_cash_factor WHERE stocks_id = $validDeleteId AND users_id = $userId AND deleted = 0");
		$stockVendorItems  = $conn->query("SELECT * FROM  tbl_vendor_bill_title WHERE stocks_id = $validDeleteId AND users_id = $userId AND deleted = 0");
		$ItemsStock  = $conn->query("SELECT * FROM  tbl_items WHERE stocks_id = $validDeleteId AND users_id = $userId AND deleted = 0");
		 
		if($cashFactorItems->num_rows> 0  ||    $billCashCustomerItems->num_rows > 0    ||   $stockVendorItems->num_rows>0  || $ItemsStock->num_rows>0){
			header("location: ../view/addStockETQ.php?error");
		}else{
			 
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
			if($deleteRow){
				header("location: ../view/addStockETQ.php?deleted");
			}
		}
		die;
	}
	
?>