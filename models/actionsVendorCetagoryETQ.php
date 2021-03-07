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
  		if($validParam === "insertVendorCategoryETQ"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_vendor_categories` WHERE deleted = 0 AND name = '$validCategory'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addVendorCategoryAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery = $conn->query("INSERT INTO tbl_vendor_categories (name, users_id, deleted, created_at) VALUES ('$validCategory', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				header("location: ../view/addVendorCategoryAT.php?save");
				exit();
			}else{
				header("location: ../view/addVendorCategoryAT.php?error");
				exit();
			}	
		
		}elseif($validParam === "editVendorCategoryETQ"){
		
			$validEditId  = decryptIt($conn->safeInput($_POST['id']));
			$editSQLQuery = $conn->query("UPDATE `tbl_vendor_categories` SET name = '$validCategory' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editVendorCategoryAT.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editVendorCategoryAT.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_vendor_categories';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$vendors       = $conn->selectRecord("tbl_vendors","vendor_type = " . $validDeleteId);
		if($vendors){
			header("location: ../view/addVendorCategoryETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");			 
			if($deleteRow){
				header("location: ../view/addVendorCategoryETQ.php?deleted");
			}
		}
	}
	
	
	

?>