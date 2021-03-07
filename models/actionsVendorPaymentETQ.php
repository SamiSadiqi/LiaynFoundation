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
  		$validVendorId   	= $conn->safeInput($_POST['vendorId']);
      	$validAmount  		 = $conn->safeInput($_POST['amount']);
  		$validBankId           = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
 		$validFactorNumber    = $conn->safeInput($_POST['factorNumber']);
  		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertVendorPaymentETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_vendor_payment` WHERE deleted = 0 AND date = '$validDate' AND vendors_id = '$validVendorId' AND 	banks_id = '$validBankId' AND  amount ='$validAmount' AND factor_number = 'validFactorNumber' AND  description = '$validDescription' ";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/vendorPaymentAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_vendor_payment (date,vendors_id,amount,banks_id,factor_number,description,payment_type,users_id, deleted, created_at)VALUES
			('$validDate', '$validVendorId','$validAmount', '$validBankId','$validFactorNumber','$validDescription',2,$userId, 0,'$currentTime ')"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_vendor_payment` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$vendorStatement ="INSERT into tbl_vendor_statement(date,place,reference,transaction_type,amount,vendors_id,deleted,description,created_at,users_id)values
							('$validDate', 'Vendor Payment', '$lastId', '2','$validAmount',$validVendorId ,0,'$validDescription','$currentTime', $userId)";
 			$vendorStatementQuery = $conn->query($vendorStatement);
 
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,description,deleted,created_at,users_id)
			 values('$validDate','Vendor Payment','$lastId','2','$validVendorId','$validAmount','$validBankId','$validDescription','0','$currentTime ','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
				
       		if($insertSQLQuery && $vendorStatementQuery && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/vendorPaymentAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/vendorPaymentAT.php?error");
				exit();
			}
			
		}elseif($validParam === "editVendorPaymentETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
			$validOldAmount            = decryptIt($conn->safeInput($_POST['oldAmount']));	
			$validOldBankId            = decryptIt($conn->safeInput($_POST['oldBankId']));	
			$validCurrenciesId            = decryptIt($conn->safeInput($_POST['currenciesId']));	
			
  			$editVendorPayment          = $conn->query("UPDATE `tbl_vendor_payment` SET date='$validDate',vendors_id = '$validVendorId',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId', description = '$validDescription',employee_id = '$validRreceiverId',home_amount = '$validHomeAmount',changed_at = NOW() WHERE users_id = '$userId' AND id = $validEditId");
  			$editVendorStatement        = $conn->query("UPDATE `tbl_vendor_statement` SET date='$validDate',amount = '$validAmount',vendors_id = '$validVendorId',rate = '$validRate',home_amount = '$validHomeAmount',deleted = 0,description = '$validDescription',changed_at = NOW() WHERE users_id = '$userId' AND reference = $validEditId AND place = 'پرداخت فروشنده'");
			$bankStatementQuery         =   $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = NOW() WHERE reference = $validEditId AND place = 'پرداخت فروشنده'");
  			
			//Edit Bank Balance.
			$subtractChangeBankAmount = $conn->changeBankAmount($validOldBankId,$validCurrenciesId,$validOldAmount,1,$userId);
			$addChangeBankAmount = $conn->changeBankAmount($validBankId,$validCurrenciesId,$validAmount,2,$userId);
			//E edit Bank Bal
			 
			if($editVendorPayment && $editVendorStatement && $subtractChangeBankAmount && $addChangeBankAmount && $bankStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editVendorPaymentETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editVendorPaymentETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_vendor_payment';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
	 
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_vendor_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'پرداخت فروشنده'");
			$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'پرداخت فروشنده'");
			 
			if($deleteRow && $vendorStatementQueryDelete && $bankStatementQueryDelete){
				header("location: ../view/vendorPaymentETQ.php?deleted");
			}
		}
	
	
	

?>