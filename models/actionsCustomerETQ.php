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
  		$validContact  		 = $conn->safeInput($_POST['contact']);
 		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validAddress        = $conn->safeInput($_POST['address']);
 		$validCustomerType   = $conn->safeInput($_POST['customerType']);
 		$validHomeAmount     = $validOpeningBalance * $validRate;
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
	 
		if($validParam === "insertCustomerETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_customers` WHERE deleted = 0 AND name = '$validName' AND customer_type = '$validCustomerType' AND date = '$validDate' AND contact = '$validContact' AND opening_balance = '$validOpeningBalance' AND  currencies_id ='$validCurrenciesId' AND  rate = '$validRate' AND address = '$validAddress'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addCustomerAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO tbl_customers (date,name,contact,opening_balance,currencies_id,rate,address,customer_type,home_amount,users_id, deleted, created_at) VALUES   ('$validDate', '$validName','$validContact','$validOpeningBalance','$validCurrenciesId','$validRate','$validAddress','$validCustomerType','$validHomeAmount',$userId, 0,'$currentTime')"); 
            
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_customers` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
	 
            //Insert Record To Customer Statement 
			$customerStatementSql   = "INSERT INTO `tbl_customer_statement` (date, place, reference, transaction_type, amount, customers_id,currencies_id, rate, home_amount,description, deleted, created_at, users_id) VALUES ('$validDate', 'Customer Opening Balance', '$lastId', '2', '$validOpeningBalance', '$lastId', $validCurrenciesId, '$validRate', '$validHomeAmount','$validAddress', '0','$currentTime', $userId)";
            $customerStatementInsert= $conn->query($customerStatementSql);
			 
       		if($insertSQLQuery  && $customerStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addCustomerAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addCustomerAT.php?error");
				exit();
			}
			
		}elseif($validParam === "editCustomerETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
			$editSQLQuery           = $conn->query("UPDATE `tbl_customers` SET date='$validDate', name = '$validName',family = '$validFamily',father_name = '$validFatherName',first_contact = '$validFirstContact',second_contact='$validSecondContact', opening_balance = '$validOpeningBalance',currencies_id = '$validCurrenciesId',rate = '$validRate', address = '$validAddress' ,customer_type = '$validCustomerType' WHERE users_id = '$userId' AND id = $validEditId");
			$customerStatementQuery = $conn->query("UPDATE `tbl_customer_statement` SET  date = '$validDate',reference='$validEditId', amount='$validOpeningBalance', customers_id='$validEditId',currencies_id = '$validCurrenciesId', rate='$validRate', home_amount='$validHomeAmount',description ='$validAddress' WHERE reference = $validEditId AND place = 'بلانس افتتاحیه مشتری'");
  			 
			if($editSQLQuery && $customerStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editCustomerETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editCustomerETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_customers';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		$customerBillTitle       = $conn->selectRecord("tbl_customer_bill_title","customers_id = " . $validDeleteId);
		$customerPayment       = $conn->selectRecord("tbl_customer_payment","customers_id = " . $validDeleteId);
		
		$customerStatment  = $conn->query("SELECT * FROM tbl_customer_statement  where customers_id='$validDeleteId' AND place != 'بلانس افتتاحیه مشتری' and deleted='0' AND users_id = $userId");
		$rowVendorStatment  = $customerStatment->fetch_array();
		$customerIdCheck= $rowVendorStatment['customers_id'];

		if($customerBillTitle || $customerPayment || $customerIdCheck){
			header("location: ../view/addCustomerETQ.php?error");
		}else{
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");
 			$customerStatementQueryDelete = $conn->query("UPDATE `tbl_customer_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'بلانس افتتاحیه مشتری'");
			 
			if($deleteRow && $customerStatementQueryDelete){
				header("location: ../view/addCustomerETQ.php?deleted");
			}
		}
	}
	
	
	
	

?>