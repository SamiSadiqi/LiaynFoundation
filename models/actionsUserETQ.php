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
	
 		$validName   = $conn->safeInput($_POST['name']);
		$validFamily = $conn->safeInput($_POST['family']);
 		$validUsername = $conn->safeInput($_POST['username']);
 		$validPosition = $conn->safeInput($_POST['position']);
  		$validUserType = $conn->safeInput($_POST['userType']);
  		$validEmail = $conn->safeInput($_POST['email']);
  		$validProjectId = $conn->safeInput($_POST['projectId']);
		
  		$validOldNamePhoto = $conn->safeInput($_POST['oldNamePhoto']);

		 
		$file=$_FILES['photo']['name'];
		$path ="upload/".$file;
		$ext=pathinfo($path,PATHINFO_EXTENSION);
		$name=pathinfo($path,PATHINFO_FILENAME);
		
 		$path1="../uploads/";
	 
		$photoName = $path1.$name.rand(1,500).".".$ext;
		
		move_uploaded_file($_FILES['photo']['tmp_name'],$photoName);
		
		// Edit Profile User Photo.
		if(isset($_FILES['profilePhoto']['name']) && ($_FILES['profilePhoto']['name'] !="")){
			unlink("../uploads/$validOldNamePhoto");
			
			$file=$_FILES['profilePhoto']['name'];
			$path ="upload/".$file;
			$ext=pathinfo($path,PATHINFO_EXTENSION);
			$name=pathinfo($path,PATHINFO_FILENAME);
			
			$path1="../uploads/";
		 
			$photoProfileName = $path1.$name.rand(1,500).".".$ext;
			move_uploaded_file($_FILES['profilePhoto']['tmp_name'],$photoProfileName);
			 
		}else{
			
			$photoProfileName = $validOldNamePhoto;
		}
	 
			
 		$validPassword =  $conn->safeInput($_POST['password']);
 		$validPasswordInserted = hash('sha256',$validPassword);
		$encrypItPassword = encryptIt($validPasswordInserted);
  		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertUserETQ"){
		
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_users` WHERE  name = '$validName' AND email = '$validEmail' AND user_type = '$validUserType' AND position_id = '$validPosition' AND family = '$validFamily' AND password = '$encrypItPassword' AND username = '$validUsername' AND deleted = 0";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addUserETQ.php?duplicate");
				exit();
			}
			
			$selectExistedDataUnique  = "SELECT * FROM `tbl_users` WHERE username = '$validUsername' AND deleted = 0";
 			$existedQueryUnique = $conn->query($selectExistedDataUnique);
 			if($existedQueryUnique->num_rows> 0 ){
				header("location: ../view/addUserETQ.php?duplicate");
				exit();
			}
			
 			/*======================= End Check For Duplicate ================= */
			$insertSQLQuery = $conn->query("INSERT INTO	tbl_users (name,family,username,email,password,user_type,position_id,photo,deleted, created_at) VALUES ('$validName', '$validFamily','$validUsername','$validEmail','$encrypItPassword','$validUserType','$validPosition','$photoName' ,0,'$currentTime')"); 
			
 			if($insertSQLQuery){
				header("location: ../view/addUserETQ.php?save");
				exit();
			}else{
				header("location: ../view/addUserETQ.php?error");
				exit();
			}	
		
		}elseif($validParam === "editUserETQ"){
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
		 
			$validCurrentPasswrod = $conn->safeInput($_POST['currentPasswrod']);
			$validCurrrentPasswordShah256 = hash('sha256',$validCurrentPasswrod );
			
			$ValidNewPassword = $conn->safeInput($_POST['newPassword']);
			
			$selectCurrentPassword = $conn->query("SELECT * From tbl_users WHERE  id = $validEditId AND deleted = 0");
			$fetchCurrentPassword = $selectCurrentPassword->fetch_array();
			$password = decryptIt($fetchCurrentPassword['password']);
			
			//if($password == $validCurrrentPasswordShah256){	
			
				
				$validNewPasswordShah256 = hash('sha256',$ValidNewPassword );
				$updateblePassword = encryptIt($validNewPasswordShah256);

					$editSQLQuery     = $conn->query("UPDATE `tbl_users` SET name='$validName', family = '$validFamily',username = '$validUsername',email = '$validEmail',password = '$updateblePassword',user_type='$validUserType',position_id='$validPosition',photo='$photoProfileName',changed_at = '$currentTime' WHERE id = $validEditId");
					if($editSQLQuery){
							 header("location: ../view/editUserETQ.php?id=" . encryptIt($validEditId) ."&edit");
							exit();
						}else{
							 header("location: ../view/editUserETQ.php?id=" . encryptIt($validEditId) ."&error");
							exit();
						}
			/* }else{
				header("location: ../view/editUserETQ.php?id=" . encryptIt($validEditId) ."&wrongCurrentPassword");
				exit();
			}
			 */
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_users';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
 		$exchange2       = $conn->selectRecord("tbl_bank_exchange","users_id = " . $validDeleteId);
 		$dealerTransaction       = $conn->selectRecord("tbl_dealer_transaction","users_id = " . $validDeleteId);
		$incomes       = $conn->selectRecord("tbl_incomes","users_id = " . $validDeleteId);
		$expenses       = $conn->selectRecord("tbl_expenses","users_id = " . $validDeleteId);
  		 

		if($exchange2 ||  $dealerTransaction || $incomes || $expenses){
			header("location: ../view/addUserETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
 			if($deleteRow){
				header("location: ../view/addUserETQ.php?deleted");
			}
		}
	}
 	
	

?>