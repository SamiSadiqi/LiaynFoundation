<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$value = $_POST['value'];
    $table = $_POST['table'];
    $rowId = $_POST['id'];
	
	$defaultsSet = $conn->query("UPDATE $table SET status = $value WHERE id = $rowId");
	if($defaultsSet){
		echo "done";
		exit();
	}else{
		echo "error";
		exit();
	}
?>