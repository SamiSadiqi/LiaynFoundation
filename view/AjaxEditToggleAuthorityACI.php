<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
  	
	$requestUserId           = $_POST['requestUserId'];
	$slectRequestDate = $conn->query("SELECT  * FROM tbl_users WHERE id = $requestUserId AND deleted = 0");
	$fetchDate = $slectRequestDate->fetch_array();
	$editStatus = $fetchDate['edit'];
	if($editStatus == 1){
   	$updateUserStatment    = $conn->query("UPDATE  tbl_users SET edit = 0 WHERE  id =  $requestUserId AND deleted = 0");					 
		if($updateUserStatment){
			echo "0";
		} 
	}elseif($editStatus == 0){
		$updateUserStatment    = $conn->query("UPDATE  tbl_users SET edit = 1 WHERE  id =  $requestUserId AND deleted = 0");					 
			if($updateUserStatment){
				echo "1";
			} 
		
	}
 ?>
	 