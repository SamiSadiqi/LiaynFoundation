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
 
		 
		$file=$_FILES['photo']['name'];
		$path ="upload/".$file;
		$ext=pathinfo($path,PATHINFO_EXTENSION);
		$name=pathinfo($path,PATHINFO_FILENAME);
		
 		$path1="../uploads/";
	 
		$photoName = $path1.$name.rand(1,500).".".$ext;
		move_uploaded_file($_FILES['photo']['tmp_name'],$photoName);
		
			
 		$validPassword =  $conn->safeInput($_POST['password']);
 		$validPasswordInserted = hash('sha256',$validPassword);
		$encrypItPassword = encryptIt($validPasswordInserted);
  		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));
		 
		 if($validParam === "editUsernameETQ"){
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
		 
 
			$editSQLQuery     = $conn->query("UPDATE `tbl_users` SET name='$validName', family = '$validFamily',username = '$validUsername',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
					 header("location: ../view/editUsernameETQ.php?id=" . encryptIt($validEditId) ."&edit");
					exit();
				}else{
					 header("location: ../view/editUsernameETQ.php?id=" . encryptIt($validEditId) ."&error");
					exit();
				}
			 
		 
		}elseif($validParam === "editEmailETQ"){
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
		 
 
			$editSQLQuery     = $conn->query("UPDATE `tbl_users` SET email='$validEmail',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
					 header("location: ../view/changeEmailAci.php?id=" . encryptIt($validEditId) ."&edit");
					exit();
				}else{
					 header("location: ../view/changeEmailAci.php?id=" . encryptIt($validEditId) ."&error");
					exit();
				}
			 
		 
		}elseif($validParam === "editPhotoETQ"){
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
		 
 
			$editSQLQuery     = $conn->query("UPDATE `tbl_users` SET photo='$photoName',changed_at = '$currentTime' WHERE id = $validEditId");
			if($editSQLQuery){
					 header("location: ../view/editPhotoUsernameACI.php?id=" . encryptIt($validEditId) ."&edit");
					exit();
				}else{
					 header("location: ../view/editPhotoUsernameACI.php?id=" . encryptIt($validEditId) ."&error");
					exit();
				}
			 
		 
		}elseif($validParam === "editPaawordETQ"){
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
		 
			$validCurrentPasswrod = $conn->safeInput($_POST['currentPasswrod']);
			$validCurrrentPasswordShah256 = hash('sha256',$validCurrentPasswrod );
			
			$ValidNewPassword = $conn->safeInput($_POST['newPassword']);
			
			$selectCurrentPassword = $conn->query("SELECT * From tbl_users WHERE  id = $validEditId AND deleted = 0");
			$fetchCurrentPassword = $selectCurrentPassword->fetch_array();
			$password = decryptIt($fetchCurrentPassword['password']);
			
			if($password == $validCurrrentPasswordShah256){	
			
				
				$validNewPasswordShah256 = hash('sha256',$ValidNewPassword );
				$updateblePassword = encryptIt($validNewPasswordShah256);

					$editSQLQuery     = $conn->query("UPDATE `tbl_users` SET password = '$updateblePassword',changed_at = '$currentTime' WHERE id = $validEditId");
					if($editSQLQuery){
							 header("location: ../view/editPasswordUsernameACI.php?id=" . encryptIt($validEditId) ."&edit");
							exit();
						}else{
							 header("location: ../view/editPasswordUsernameACI.php?id=" . encryptIt($validEditId) ."&error");
							exit();
						}
			}else{
				header("location: ../view/editPasswordUsernameACI.php?id=" . encryptIt($validEditId) ."&wrongCurrentPassword");
				exit();
			}
			
		 
		}
		else{
			header("location: ../view/logout.php");
			exit();
		}
	} 
 	
	

?>