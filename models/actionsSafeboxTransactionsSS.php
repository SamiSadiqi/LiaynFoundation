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
		
        $validDate           = $conn->safeInput($_POST['date']);
 		$validType           = $conn->safeInput($_POST['type']);
		$validAmount  		 = $conn->safeInput($_POST['amount']);
  		$validSafebox           = $conn->safeInput($_POST['safeBoxId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));

		 
 		if($validParam === "insertSafeBoxTransactoin"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_safe_box_statement` WHERE deleted = 0 AND date = '$validDate' AND safe_box_id = '$validSafebox' AND  amount ='$validAmount' AND transaction_type	 = '$validType' AND  description = '$validDescription' ";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addSafeboxTransactionSS.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query ("INSERT INTO tbl_safe_box_statement (date,safe_box_id,amount,transaction_type,description,users_id,deleted,created_at)VALUES
			('$validDate','$validSafebox', '$validAmount','$validType','$validDescription',$userId,0,'$currentTime')"); 
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_safe_box_statement` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $id    = $lastIdRow['id'];
        
            $email_send = new phpmailer2();
            $emails =   $email_send->sendMail2('tbl_safe_box_statement',$id);

       		if($insertSQLQuery && $emails ){
				$conn->query("COMMIT");
				header("location: ../view/addSafeboxTransactionSS.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addSafeboxTransactionSS.php?error");
				exit();
			}
			
		}elseif($validParam === "editSafeBoxTransactoin"){
			
			$conn->query("BEGIN");

			$validEditId           	 = decryptIt($conn->safeInput($_POST['id']));	
			
  			$editDealerPayment          = $conn->query("UPDATE `tbl_safe_box_statement` SET date='$validDate',safe_box_id = '$validSafebox',transaction_type = '$validType',amount = '$validAmount',description = '$validDescription',changed_at = '$currentTime' WHERE id = $validEditId");
			 
  		
			if($editDealerPayment){
				$conn->query("COMMIT");
				header("location: ../view/editSafeboxTransactionACI.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editSafeboxTransactionACI.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_safe_box_statement';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));

			 
			$dealerStatementDelete = $conn->query("UPDATE `tbl_safe_box_statement` SET deleted = 1 WHERE id = $validDeleteId");

			if($dealerStatementDelete){
						header("location: ../view/paymentToSubContractorACI.php?deleted");
					} 
			}

		
	
	 
?>