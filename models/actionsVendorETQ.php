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
  		$validContact  			 = $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
   		$validVendorType     = $conn->safeInput($_POST['vendorType']);
 		$validAddress        = $conn->safeInput($_POST['address']);
  		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		 
		if($validParam === "insertVendorETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_vendors` WHERE deleted = 0 AND name = '$validName' AND vendor_type = '$validVendorType' AND date = '$validDate' AND contact = '$validContact'  AND opening_balance = '$validOpeningBalance' AND address = '$validAddress'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addVendorAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			$insertSQLQuery = $conn->query("INSERT INTO tbl_vendors (date,name,contact,opening_balance,vendor_type,address,users_id, deleted, created_at)	VALUES 
																	('$validDate', '$validName','$validContact', '$validOpeningBalance','$validVendorType','$validAddress',$userId, 0,'$currentTime')"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_vendors` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
		
            //Insert Record To Vendor Statement 
			$vendorStatementSql   = "INSERT INTO `tbl_vendor_statement` (date, place, reference, transaction_type, amount, vendors_id,description, deleted, created_at, users_id) VALUES 
																		('$validDate', 'حساب افتتاحیه فروشنده', '$lastId', '1', '$validOpeningBalance', '$lastId','$validAddress', '0','$currentTime', $userId)";
            $vendorStatementInsert= $conn->query($vendorStatementSql);
 			 
			if($insertSQLQuery && $vendorStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addVendorAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addVendorAT.php?error");
				exit();
			}
													
		}elseif($validParam === "editVendorETQ"){
			
			$conn->query("BEGIN");
			$validEditId          = decryptIt($conn->safeInput($_POST['id']));
			$editSQLQuery         = $conn->query("UPDATE `tbl_vendors` SET date='$validDate',vendor_type = '$validVendorType', name = '$validName',contact = '$validContact',opening_balance = '$validOpeningBalance',currencies_id = '$validCurrneny',rate = '$validRate',address = '$validAddress' WHERE users_id = '$userId' AND id = $validEditId");
			$vendorStatementQuery = $conn->query("UPDATE `tbl_vendor_statement` SET  date = '$validDate', reference='$validEditId', amount='$validOpeningBalance', vendors_id='$validEditId',currencies_id = '$validCurrneny', rate='$validRate', home_amount='$validHomeAmount',description ='$validAddress' WHERE reference = $validEditId AND place = 'حساب افتتاحیه فروشنده'");
  			 
			if($editSQLQuery && $vendorStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editVendorETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editVendorETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
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