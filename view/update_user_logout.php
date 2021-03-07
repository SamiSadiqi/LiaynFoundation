<?php
session_start();
		require_once("../config/dbConstants.php");
		require_once("../config/Database.php");
		require_once("../config/necessaryFunctions.php");
		$userId = decryptIt($_SESSION['userId']);
		$pageTitle = "Assist Consultants Incorporated | ACI - Login";
		$conn      = new Database(HOST, USERNAME, PASSWORD, DATABASE);
		$logoutTime = time();
		 
		$updateLogout =  $conn->query("UPDATE tbl_login_details SET logout_date = '$logoutTime',status = 0 WHERE users_id = $userId AND id=(SELECT id ORDER BY id DESC LIMIT 1)");
		 
		if($updateLogout){
		$_SESSION['login'] = FALSE;
		unset($_SESSION['Login']);
		unset($_SESSION['username']);
		unset($_SESSION['userId']);
		unset($_SESSION['last_login_timpestamp']);
		header("location:login.php");
		exit();
	}
?>