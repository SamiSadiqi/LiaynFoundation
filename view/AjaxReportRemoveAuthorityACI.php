<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
  	
	$requestUserId           = $_POST['requestUserId'];
	$slectRequestDate = $conn->query("SELECT  * FROM tbl_users WHERE id = $requestUserId AND deleted = 0");
	$fetchDate = $slectRequestDate->fetch_array();
	$removeStatus = $fetchDate['remove_report'];
	if($removeStatus == 1){
   	$updateUserStatment    = $conn->query("UPDATE  tbl_users SET remove_report = 0 WHERE  id =  $requestUserId AND deleted = 0");					 
		if($updateUserStatment){
			echo "0";
		} 
	}elseif($removeStatus == 0){
		$updateUserStatment    = $conn->query("UPDATE  tbl_users SET remove_report = 1 WHERE  id =  $requestUserId AND deleted = 0");					 
			if($updateUserStatment){
				echo "1";
			} 
		
	}
 ?>
	 