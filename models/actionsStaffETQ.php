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
	
		$validDate    = $conn->safeInput($_POST['date']);
 		$validName    = $conn->safeInput($_POST['name']);
 		$validFamily  = $conn->safeInput($_POST['family']);
 		$validSsn     = $conn->safeInput($_POST['ssn']);
 		$validContact = $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validUnit    = $conn->safeInput($_POST['unit']);
 		$validRate    = $conn->safeInput($_POST['rate']);
 		$validJobType = $conn->safeInput($_POST['jobType']);
 		$validAddress = $conn->safeInput($_POST['address']);
 		$validHomeAmount = $validOpeningBalance * $validRate;
	 
 		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertStaffETQ"){
			
			$insertSQLQuery  = $conn->query("INSERT INTO tbl_staff (date,name,family,ssn,contact,unit,rate,job_type,opening_balance,address,home_amount,users_id, deleted, created_at) VALUES('$validDate','$validName', '$validFamily', '$validSsn', '$validContact', '$validUnit','$validRate','$validJobType','$validOpeningBalance','$validAddress','$validHomeAmount',$userId, 0, '$currentTime')"); 
			
       		if($insertSQLQuery){
				header("location: ../view/addStaffETQ.php?save");
				exit();
			}else{
				header("location: ../view/addStaffETQ.php?error");
				exit();
			}
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_staff';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
	 
		$expenses       = $conn->selectRecord("tbl_expenses","expensers_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","incomers_id = " . $validDeleteId);
		if($expenses || $incomes  ){
			header("location: ../view/addStaffETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
			if($deleteRow){
				header("location: ../view/addStaffETQ.php?deleted");
			}
		}
	}
	
	
	

?>