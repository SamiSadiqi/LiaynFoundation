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
 		$validName           = $conn->safeInput($_POST['name']);
		$validServiceType    = $conn->safeInput($_POST['serviceType']);
  		$validContact  		 = $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrneny       = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validTransactionType = $conn->safeInput($_POST['transactionType']);
 		$validAddress        = $conn->safeInput($_POST['address']);
 		$validHomeAmount     = $validOpeningBalance * $validRate;
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertServiceProviderAT"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_service_provider` WHERE deleted = 0 AND transaction_type = '$validTransactionType' AND date = '$validDate' AND name = '$validName' AND service_provider_type_id = '$validServiceType' AND contact = '$validContact'  AND opening_balance = '$validOpeningBalance' AND  currencies_id ='$validCurrneny' AND  rate = '$validRate' AND address = '$validAddress'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addServiceProviderAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			$insertSQLQuery = $conn->query("INSERT INTO tbl_service_provider (date,name,service_provider_type_id,contact,opening_balance,currencies_id,rate,address,transaction_type,home_amount,users_id, deleted, created_at)	VALUES 
																	('$validDate', '$validName','$validServiceType','$validContact', '$validOpeningBalance','$validCurrneny','$validRate','$validAddress','$validTransactionType','$validHomeAmount',$userId, 0,'$currentTime')"); 
 
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_service_provider` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
		
            //Insert Record To Vendor Statement 
			$serviceStatementSql   = "INSERT INTO `tbl_service_provider_statement` (date, place, reference, transaction_type, amount, service_provider_id,currencies_id, rate, home_amount,description, deleted, created_at, users_id) VALUES 
																		('$validDate', 'Opening Balance of Service Provider', '$lastId', '1', '$validOpeningBalance', '$lastId', $validCurrneny, '$validRate', '$validHomeAmount','$validAddress', '0','$currentTime', $userId)";
            $serviceStatementInsert= $conn->query($serviceStatementSql);
 			
			 
			if($insertSQLQuery && $serviceStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addServiceProviderAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addServiceProviderAT.php?error");
				exit();
			}
													
		}
	}else{
		$table = 'tbl_vendors';
		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$vendorBillTitle       = $conn->selectRecord("tbl_vendor_bill_title","vendors_id = " . $validDeleteId);
		$vendorPayment       = $conn->selectRecord("tbl_vendor_payment","vendors_id = " . $validDeleteId);
		
		$vendorStatment  = $conn->query("SELECT * FROM tbl_vendor_statement  where vendors_id='$validDeleteId' AND place != 'بلانس افتتاحیه فروشنده' and deleted='0' AND users_id = $userId");
		$rowVendorStatment  = $vendorStatment->fetch_array();
		$vendorsIdCheck= $rowVendorStatment['vendors_id'];

		if($vendorBillTitle || $vendorPayment || $vendorsIdCheck){
			header("location: ../view/addVendorETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
 			$vendorStatementQueryDelete = $conn->query("UPDATE `tbl_vendor_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'بلانس افتتاحیه فروشنده'");
			 
			if($deleteRow && $vendorStatementQueryDelete){
				header("location: ../view/addVendorETQ.php?deleted");
			}
		}
	}
	
	
	

?>