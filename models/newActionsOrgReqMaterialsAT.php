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
 		$validParam= decryptIt($conn->safeInput($_POST['formTable']));
		
		$validItem = $_POST['itemId'];
		$validItemUnit = $_POST['itemUnit'];
		$validQuantity = $_POST['quantity'];
		$validDescription= $_POST['description'];
	 
		if($validParam === "tbl_org_req_materials_title"){
			
				$file = $_FILES['upoladeFile']['name'];
		
				$path ="documents/".$file;
				$ext=pathinfo($path,PATHINFO_EXTENSION);
				$name=pathinfo($path,PATHINFO_FILENAME);
				
				$path1="../documents/";
				
				$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
				 move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				 
			if($validDate == "" && $validRequestNumber=="" && $validSchoolId==""){
				header("location: ../view/addOrganizationMaterialsRequestAT.php?empty");
				exit();
			}
			
            /*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_org_req_materials_title` WHERE deleted = 0 AND date = '$validDate' AND request_number='$validRequestNumber' AND schools_id ='$validSchoolId' AND construction_types_id='$validConstructionType' AND quantity='$validQuantity' AND document = '$upoladeFileName'";
			$existedQuery = $conn->query($selectExistedData);
				
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addOrganizationMaterialsRequestAT.php?empty");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			
				$insertTitleQuery = $conn->query("INSERT INTO tbl_org_req_materials_title (date, request_number,schools_id,document,users_id,deleted,created_at)
				VALUES ('$validDate','$validRequestNumber','$validSchoolId','$upoladeFileName', $userId,0,'$currentTime')");
				 
				$selectIdTitleId       =$conn->query("select id from tbl_org_req_materials_title where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
				$rowSelectIdTitleId    = $selectIdTitleId->fetch_array();
				$lastId  = $rowSelectIdTitleId['id'];

				for($i=0;$i<sizeof($validItem);$i++){
					if(!empty($validItem[$i])){
						 
					 
						$insertSQLQuery =  $conn->query("INSERT INTO tbl_org_req_materials_details (items_id,request_title_id,items_unit_id,quantity,description,users_id,deleted,created_at)VALUES
						('$validItem[$i]',$lastId, '$validItemUnit[$i]', '$validQuantity[$i]','$validDescription[$i]', $userId,0,'$currentTime')"); 
						 
					}
				}
				 
			/* 	echo $insertSQLQuery;
				echo "<BR>";
				echo $insertTitleQuery;
				die;				
					  */
				if($insertSQLQuery && $insertTitleQuery){
					$conn->query("COMMIT");
					header("location: ../view/addOrganizationMaterialsRequestAT.php?save");
					exit();
				}else{
					$conn->query("ROLLBACK");
					header("location: ../view/addOrganizationMaterialsRequestAT.php?error");
					exit();
				}
			
		}else{
				header("location: ../view/logout.php");
				exit();
			}
	}
?>