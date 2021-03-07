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
		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validProviderId   	= $conn->safeInput($_POST['providerId']);
     	$validAmount  		 = $conn->safeInput($_POST['amount']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId           = $conn->safeInput($_POST['bankId']);
  		$validDescription    = $conn->safeInput($_POST['description']);
 		$validPaymentNumber    = $conn->safeInput($_POST['paymentNumber']);
  		$validHomeAmount     = $validAmount * $validRate;
  		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertServicePaymentAT"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_service_payment` WHERE deleted = 0 AND date = '$validDate' AND service_provider_id = '$validProviderId' AND banks_id = '$validBankId' AND  amount ='$validAmount' AND currencies_id = '$validCurrenciesId' AND rate = '$validRate' AND factor_number = '$validPaymentNumber' AND  description = '$validDescription' ";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/servicesPaymentToProviderAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_service_payment (date,service_provider_id,currencies_id, amount,rate,banks_id,factor_number,description,payment_type,home_amount,users_id, deleted, created_at)VALUES
			('$validDate', '$validProviderId', '$validCurrenciesId', '$validAmount','$validRate', '$validBankId','$validPaymentNumber','$validDescription',2,'$validHomeAmount',$userId, 0, '$currentTime' )"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_service_payment` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$customerStatement ="INSERT into tbl_service_provider_statement(date,place,reference,transaction_type,amount,service_provider_id,currencies_id,rate,home_amount,deleted,description,created_at,users_id)values 
																				('$validDate', 'Services Provider Payment','$lastId',1,'$validAmount','$validProviderId' ,'$validCurrenciesId','$validRate','$validHomeAmount',0,'$validDescription','$currentTime', $userId)";
			$customerStatementQuery = $conn->query($customerStatement);
 
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)values
			('$validDate','Services Provider Payment','$lastId','2','$validProviderId','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
		 
			 
       		if($insertSQLQuery && $customerStatementQuery && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/servicesPaymentToProviderAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/servicesPaymentToProviderAT.php?error");
				exit();
			}
			
		}elseif($validParam === "editCustomerPaymentETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
			$validOldAmount            = decryptIt($conn->safeInput($_POST['oldAmount']));	
			$validOldBankId            = decryptIt($conn->safeInput($_POST['oldBankId']));	
			$validCurrenciesId            = decryptIt($conn->safeInput($_POST['currenciesId']));	
			
  			$editCustomerPayment          = $conn->query("UPDATE `tbl_customer_payment` SET date='$validDate',customers_id = '$validCustomerId',amount = '$validAmount',rate = '$validRate',banks_id='$validBankId', description = '$validDescription',employee_id = '$validRreceiverId',home_amount = '$validHomeAmount',changed_at = NOW() WHERE users_id = '$userId' AND id = $validEditId");
  			$editCustomerStatement        = $conn->query("UPDATE `tbl_customer_statement` SET date='$validDate',amount = '$validAmount',customers_id = '$validCustomerId',rate = '$validRate',home_amount = '$validHomeAmount',deleted = 0,description = '$validDescription',changed_at = NOW() WHERE users_id = '$userId' AND reference = $validEditId AND place = 'پرداخت مشتری'");
			$bankStatementQuery         =   $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',rate='$validRate', home_amount='$validHomeAmount',description ='$validDescription',changed_at = NOW() WHERE reference = $validEditId AND place = 'پرداخت مشتری'");
  			
			//Edit Bank Balance.
			$subtractChangeBankAmount = $conn->changeBankAmount($validOldBankId,$validCurrenciesId,$validOldAmount,2,$userId);
			$addChangeBankAmount = $conn->changeBankAmount($validBankId,$validCurrenciesId,$validAmount,1,$userId);
			//E edit Bank Bal
			 
			if($editCustomerPayment && $editCustomerStatement && $subtractChangeBankAmount && $addChangeBankAmount && $bankStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editCustomerPaymentETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editCustomerPaymentETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_customer_payment';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
	 
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_customer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'پرداخت مشتری'");
			$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'پرداخت مشتری'");
			 
			if($deleteRow && $vendorStatementQueryDelete && $bankStatementQueryDelete){
				header("location: ../view/customerPaymentETQ.php?deleted");
			}
		}
	  

?>