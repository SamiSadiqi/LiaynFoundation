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
		 
		if($validParam === "insertItemCategoryETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_item_categories` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addItemCategoryAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
   			$insertSQLQuery = $conn->query("INSERT INTO tbl_item_categories (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')");
			if($insertSQLQuery){
				header("location: ../view/addItemCategoryAT.php?save");
				exit();
			}else{
				header("location: ../view/addItemCategoryAT.php?error");
				exit();
			}
	
		}elseif($validParam === "editItemCategoryETQ"){
		
			$validEditId  = $conn->safeInput(decryptIt($_POST['id']));
			
			$editSQLQuery = $conn->query("UPDATE `tbl_item_categories` SET name='$validName' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editItemCategoryAT.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editItemCategoryAT.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_item_categories';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$categoryItems       = $conn->selectRecord("tbl_items","item_categories_id = " . $validDeleteId);
		if($categoryItems){
			header("location: ../view/addItemCategoryETQ.php?error");
		}else{
			$deleteRow = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
			if($deleteRow){
				header("location: ../view/addItemCategoryETQ.php?deleted");
			}
		}
	}
?>