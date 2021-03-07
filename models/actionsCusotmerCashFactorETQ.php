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
 		$validCustomerName       = $conn->safeInput($_POST['customerName']);
 		$validStockId        = $conn->safeInput($_POST['stockId']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
		$validFactorNumber 	 = $conn->safeInput($_POST['factorNumber']);
  		$validBankId     	 = $conn->safeInput($_POST['bankId']);
 		$validFactorDescription    = $conn->safeInput($_POST['factorDescription']);
  		$validFactorPayment  = $conn->safeInput($_POST['factorPayment']);
		
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
		$totalFee 		= $_POST['totalFee'];
		$subDescription = $_POST['subDescription'];
		
		
 		$validHomeAmount     = $validFactorPayment * $validRate;
 		
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
  		if($validParam === "insertCustomerCashFactorETQ"){
			
			 
			$conn->query("BEGIN");
			
			$customerFactorqQuery = true;
			$customerFactorDetailsQuery = true;
			$addStockBalance = true;
			$bankStatementInsert = true; 
			
			$customerFactorSqlTitle = "INSERT INTO tbl_cash_factor(date, stocks_id,customer_name,currencies_id,rate, banks_id, factor_payment,factor_number, description,home_amount, users_id, deleted,created_at) VALUES
															('$validDate','$validStockId','$validCustomerName','$validCurrenciesId','$validRate','$validBankId','$validFactorPayment','$validFactorNumber','$validFactorDescription','$validHomeAmount',$userId,0,'$currentTime')";
				$customerFactorqQuery = $conn->query($customerFactorSqlTitle);
					if(!$customerFactorqQuery){
					$customerFactorqQuery = false;
				}

 			
			$selectIdTitle       =$conn->query("select id from tbl_cash_factor where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
				

				for($i=0;$i<sizeof($itemId);$i++){
					if(!empty($itemId[$i])){
						$customerFactorDetailsSql    = "INSERT INTO `tbl_cash_factor_details`(title_bills_id,items_id,items_unit_id,amount,fee,total_amount,description,created_at,users_id, deleted) 
						values('$lastId','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$fee[$i]','$totalFee[$i]','$subDescription[$i]','$currentTime',$userId, '0')";
						$customerFactorDetailsQuery  = $conn->query($customerFactorDetailsSql);
						 
						if(!$customerFactorDetailsQuery){
							$customerFactorDetailsQuery  = false;
						}
						
 					}
				}
			 
			 
				$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)
									values('$validDate','Cash Invoice Payment Type','$lastId','1','$validFactorPayment','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
				$bankStatementInsert = $conn->query($bankStatementSql);
					if(!$bankStatementInsert){
						$bankStatementInsert = false;
					}
					
			 /*  	echo $customerFactorqQuery;
				echo "<br>";
				echo $customerFactorDetailsQuery;
						echo "<br>";
				echo $addStockBalance;
						echo "<br>";
				echo $bankStatementInsert;
			 
			die; */
			  
       		if($customerFactorqQuery && $customerFactorDetailsQuery && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/sellsCashFactorAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/sellsCashFactorAT.php?error");
				exit();
			}
			
		}elseif($validParam === "editCustomerETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));			
			$editSQLQuery           = $conn->query("UPDATE `tbl_customers` SET date='$validDate', name = '$validName',family = '$validFamily',father_name = '$validFatherName',first_contact = '$validFirstContact',second_contact='$validSecondContact', opening_balance = '$validOpeningBalance',currencies_id = '$validCurrenciesId',rate = '$validRate', address = '$validAddress' WHERE users_id = '$userId' AND id = $validEditId");
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
	}
	
	
	

?>