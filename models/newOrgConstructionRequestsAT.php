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
		$validSchoolId = $conn->safeInput($_POST['schoolId']);
		$validConstructionType = $conn->safeInput($_POST['constructionType']);
		$validQuantity = $conn->safeInput($_POST['quantity']);
		$validDescription = $conn->safeInput($_POST['description']);
		
 		$validParam= decryptIt($conn->safeInput($_POST['formTable']));
	 
		if($validParam === "tbl_org_construction_requests"){
			
				$file = $_FILES['upoladeFile']['name'];
		
				$path ="documents/".$file;
				$ext=pathinfo($path,PATHINFO_EXTENSION);
				$name=pathinfo($path,PATHINFO_FILENAME);
				
				$path1="../documents/";
				
				$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
				// move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				
				 
			if($validDate == "" && $validRequestNumber=="" && $validSchoolId==""){
				header("location: ../view/addOrgConstructionsRequestAT.php?empty");
				exit();
			}
            /*======================= Check For Duplicate ================= */
												 
			$selectExistedData  = "SELECT * FROM `tbl_org_construction_requests` WHERE deleted = 0 AND date = '$validDate' AND request_number='$validRequestNumber' AND schools_id ='$validSchoolId' AND construction_types_id='$validConstructionType' AND quantity='$validQuantity' AND document = '$upoladeFileName'";
			$existedQuery = $conn->query($selectExistedData);
				
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addOrgConstructionsRequestAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$insertSQLQuery = $conn->query("INSERT INTO tbl_org_construction_requests (date, request_number,schools_id,construction_types_id,quantity,description,document,users_id,deleted,created_at)
			VALUES ('$validDate','$validRequestNumber','$validSchoolId','$validConstructionType','$validQuantity','$validDescription','$upoladeFileName', $userId,0,'$currentTime')");
				
			 
			if($insertSQLQuery){
				header("location: ../view/addOrgConstructionsRequestAT.php?save");
				exit();
			}else{
				header("location: ../view/addOrgConstructionsRequestAT.php?error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}
	
	
	

?>


