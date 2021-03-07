<?php
session_start();
		require_once("../config/dbConstants.php");
		require_once("../config/Database.php");
		require_once("../config/necessaryFunctions.php");
		$userId = decryptIt($_SESSION['userId']);
		$pageTitle = "Assist Consultants Incorporated | ACI - Login";
 		 
		$_SESSION['login'] = FALSE;
		unset($_SESSION['Login']);
		unset($_SESSION['username']);
		unset($_SESSION['userId']);
		unset($_SESSION['userType']);
		unset($_SESSION['last_login_timpestamp']);
		header("location:login.php");
		exit();
		die;
	 
?>