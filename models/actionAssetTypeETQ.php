<?php
	session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	
  		$validName = $conn->safeInput($_POST['name']);
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertAssetTypeETQ"){
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_asset_types` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addAssetTypeETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_asset_types( name, users_id, deleted, created_at)VALUES ('$validName',$userId, 0, NOW())");
			
			if($insertSQLQuery){
				header("location: ../view/addAssetTypeETQ.php?save");
				exit();
			}else{
				header("location: ../view/addAssetTypeETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "editAssetTypeETQ"){
		
			$validEditId  = $conn->safeInput(decryptIt($_POST['id']));
			
			$editSQLQuery = $conn->query("UPDATE `tbl_asset_types` SET name='$validName' WHERE id = $validEditId");
			if($editSQLQuery){
				header("location: ../view/editAssetTypeETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				header("location: ../view/editAssetTypeETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_asset_types';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$assetsType       = $conn->selectRecord("tbl_assets","asset_types_id = " . $validDeleteId);
 		 
		if($assetsType){
			header("location: ../view/addAssetTypeETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addAssetTypeETQ.php?deleted");
			}
		}
	}
	
	
	

?>


