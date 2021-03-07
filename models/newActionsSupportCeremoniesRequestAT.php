<?php
	session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	
  		$validDate = $conn->safeInput($_POST['date']);
		$validRequestNumber = $conn->safeInput($_POST['requestNumber']);
		$validName = $conn->safeInput($_POST['name']);
		$validOrganizationType = $conn->safeInput($_POST['organizationType']);
		$validOrganization = $conn->safeInput($_POST['organization']);
		$validSchoolId = $conn->safeInput($_POST['schoolId']);
		$validDescription = $conn->safeInput($_POST['description']);
		
 		$validParam= decryptIt($conn->safeInput($_POST['formTable']));
	 
		if($validParam === "tbl_support_ceremonies_requests"){
			
				$file = $_FILES['upoladeFile']['name'];
		
				$path ="documents/".$file;
				$ext=pathinfo($path,PATHINFO_EXTENSION);
				$name=pathinfo($path,PATHINFO_FILENAME);
				
				$path1="../documents/";
				
				$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
				 move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				 
			if($validDate == "" && $validRequestNumber=="" && $validOrganizationType==""){
				header("location: ../view/addSupportCeremoniesRequestAT.php?empty");
				exit();
			}
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_support_ceremonies_requests` WHERE deleted = 0 AND name= '$validName' AND  date = '$validDate' AND request_number='$validRequestNumber' AND schools_id ='$validSchoolId' AND description='$validDescription'";
			$existedQuery = $conn->query($selectExistedData);
				
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addSupportCeremoniesRequestAT.php?empty");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery = $conn->query("INSERT INTO tbl_support_ceremonies_requests (date,name, request_number,schools_id,description,document,users_id,deleted,created_at)
			VALUES ('$validDate','$validName','$validRequestNumber','$validSchoolId','$validDescription','$upoladeFileName', $userId,0,'$currentTime')");
				
			if($insertSQLQuery){
				header("location: ../view/addSupportCeremoniesRequestAT.php?save");
				exit();
			}else{
				header("location: ../view/addSupportCeremoniesRequestAT.php?error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}
	
	
	

?>


