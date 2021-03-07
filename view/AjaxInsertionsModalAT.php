<?php
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();

	$validUpdateId = decryptIt($conn->safeInput($_POST['id']));
	$table = decryptIt($conn->safeInput($_POST['formTable']));
 	
	if($table === "tbl_constructions_type"){
			$validName = $conn->safeInput($_POST['name']);
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE   deleted = 0 AND name = '$validName'";
			$existedQuery = $conn->query($selectExistedData);
			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO $table (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
	}elseif($table === "tbl_organizations"){
			$validName = $conn->safeInput($_POST['name']);
			$validDistrictId = $conn->safeInput($_POST['districtId']);
			$validDescription = $conn->safeInput($_POST['description']);
		
			/*======================= Check For Duplicate ================= */
			$selectExistenDate  = "SELECT * FROM `tbl_organizations` WHERE  name = '$validName' AND districts_id = '$validDistrictId' AND description = '$validDescription'";
			$existenQuery = $conn->query($selectExistenDate);
 			if($existenQuery->num_rows> 0 ){
				echo "duplicate";
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
 			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_organizations (name,districts_id,description,users_id,created_at) VALUES 
														('$validName','$validDistrictId','$validDescription',$userId,'$currentTime')"); 
			if($insertSQLQuery){
 				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
 				echo "error";
				exit();
			}
	}/* elseif($table === "tbl_school_managers"){
		
		$validDate = $conn->safeInput($_POST['date']);
		$validName = $conn->safeInput($_POST['name']);
		$validContact = $conn->safeInput($_POST['contact']);
		$validExperience = $conn->safeInput($_POST['experience']);
		$validSchoolId = $conn->safeInput($_POST['schoolId']);
 		$validDescription = $conn->safeInput($_POST['description']);
		
 			$selectExistenDate  = "SELECT * FROM `tbl_school_managers` WHERE  date = '$validDate' AND name = '$validName' AND contact = '$validContact' AND experience = '$validExperience' AND schools_id = '$validSchoolId' AND description = '$validDescription'";
			$existenQuery = $conn->query($selectExistenDate);
 			if($existenQuery->num_rows> 0 ){
				echo "duplicate";
				exit();
			}
  
		$insertSQLQuery = $conn->query("INSERT INTO tbl_school_managers (date,name,contact,experience,schools_id,description,users_id,created_at) VALUES 
														('$validDate', '$validName','$validContact','$validExperience','$validSchoolId','$validDescription',$userId,'$currentTime')"); 
		if($insertSQLQuery){
			echo "save";
			exit();
		}else{
			echo "error";	
			exit();
		}

		 
	} */
	 
?>