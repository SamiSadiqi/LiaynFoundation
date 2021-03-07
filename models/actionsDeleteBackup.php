<?php
ob_start();
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	 
		$table = 'tbl_backup';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
	 
		$deleteRow   = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
		if($deleteRow){
			header("location: ../view/givenBackupACI.php?deleted");
		}
 
	 
?>