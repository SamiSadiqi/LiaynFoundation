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
 		$validCustomerId       = $conn->safeInput($_POST['customerId']);
  		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validFactorNumber 	 = $conn->safeInput($_POST['factorNumber']);
 		$validBankId     	 = $conn->safeInput($_POST['bankId']);
		$validDescription    = $conn->safeInput($_POST['factorDescription']);
 		$validTotalFactorPrice   = $conn->safeInput($_POST['totalFactorPrice']);
 		$validFactorPayment  = $conn->safeInput($_POST['factorPayment']);
 		$validMovementStatus  = $conn->safeInput($_POST['movementStatus']);
 		$validDueDate  = $conn->safeInput($_POST['dueDate']);
		
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
		$totalFee 		= $_POST['totalFee'];
		$stockId 		= $_POST['stockId'];
		$subDescription = $_POST['subDescription'];
		
		
 		$validHomeAmount     = $validFactorPayment * $validRate;
 		$validHomeAmountTotal     = $validTotalFactorPrice * $validRate;
		
		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
	 
 		if($validParam === "insertCustomerFactorETQ"){
	 
			$conn->query("BEGIN");
			
			$customerFactorqQuery = true;
			$customerFactorDetailsQuery = true;
			$addStockBalance = true;
			$customerPaymentQuery = true;
			$customerStatementTotalQuery = true;
			$customerStatementQuery = true;
			$bankStatementInsert = true;
			
			$customerFactorSqlTitle = "INSERT INTO tbl_customer_bill_title(date, customers_id, currencies_id, rate, factor_number, banks_id, factor_price, factor_payment,due_date,status_movement,home_amount_total_factor_price,home_amount, description, users_id,created_at, deleted) VALUES
															('$validDate','$validCustomerId','$validCurrenciesId','$validRate','$validFactorNumber',$validBankId ,'$validTotalFactorPrice','$validFactorPayment','$validDueDate','$validMovementStatus','$validHomeAmountTotal','$validHomeAmount','$validDescription',$userId,'$currentTime',0)";
				$customerFactorqQuery = $conn->query($customerFactorSqlTitle);
					if(!$customerFactorqQuery){
					$customerFactorqQuery = false;
				}

			 
			$selectIdTitle       =$conn->query("select id from tbl_customer_bill_title where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
				

				for($i=0;$i<sizeof($itemId);$i++){
					if(!empty($itemId[$i])){
						$customerFactorDetailsSql    = "INSERT INTO `tbl_customer_bill_details`(title_bills_id,items_id,items_unit_id,amount,fee,stocks_id,total_amount,description,created_at,users_id, deleted) 
						values('$lastId','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$fee[$i]','$stockId[$i]','$totalFee[$i]','$subDescription[$i]','$currentTime',$userId, '0')";
						$customerFactorDetailsQuery  = $conn->query($customerFactorDetailsSql);
						 
						if(!$customerFactorDetailsQuery){
							$customerFactorDetailsQuery  = false;
						}
						$subtractStockBalance = $conn->changeStockAmount($itemId[$i],$stockId[$i],$amount[$i],2,$userId);
						
						//Get Last Record Id
						$lastQueryDetails = $conn->query("SELECT * FROM `tbl_customer_bill_details` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
						$lastIdRowDetails = $lastQueryDetails->fetch_array();
						$lastIdDetails    = $lastIdRowDetails['id'];
						 												
						$stockStatement = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
																			values('$validDate','Sell Customer Items','$lastIdDetails','2','$amount[$i]','$stockId[$i]','$itemId[$i]','$subDescription[$i]','0','$currentTime','$userId')");
			

						
 					}
				}
				 
				if($validFactorPayment){
					 $customerPaymentSql  = "INSERT INTO `tbl_customer_payment` (date,customers_id,currencies_id,reference_id,amount,rate,banks_id,factor_number,description,payment_type,home_amount,users_id,created_at,deleted) VALUES
															                  ('$validDate','$validCustomerId','$validCurrenciesId','$lastId','$validFactorPayment','$validRate','$validBankId','$validFactorNumber','$validDescription',1,'$validHomeAmount','$userId','$currentTime','0')";
 					$customerPaymentQuery = $conn->query($customerPaymentSql);
					if(!$customerPaymentQuery){
					
						$customerPaymentQuery=false;
					}
				}	
 				$customerStatementTotal ="INSERT into tbl_customer_statement(date,place,reference,transaction_type,amount,customers_id,currencies_id,rate,home_amount,deleted,description,created_at,users_id) values
																	('$validDate', 'Total Customer Factor Amount','$lastId', '2','$validTotalFactorPrice',$validCustomerId ,$validCurrenciesId, '$validRate', '$validHomeAmountTotal',0,'$validDescription','$currentTime', $userId)";
				$customerStatementTotalQuery = $conn->query($customerStatementTotal);
				if(!$customerStatementTotalQuery){
					$customerStatementTotalQuery = false;
				}
//
				if(isset($validFactorPayment) && !empty($validFactorPayment)){
					$customerStatementSql ="INSERT into tbl_customer_statement(date,place,reference,transaction_type,amount,customers_id,currencies_id,rate,home_amount,deleted,description,created_at,users_id)
											values('$validDate', 'Customer Payment', '$lastId', '1','$validFactorPayment','$validCustomerId', $validCurrenciesId, '$validRate', '$validHomeAmount',0,'$validDescription','$currentTime', $userId)";
				 
					$customerStatementQuery = $conn->query($customerStatementSql);
					if(!$customerStatementQuery){
						$customerStatementQuery = false;
					}
					
				}
				$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)
									values('$validDate','Customer Payment Invoice','$lastId','1','$validCustomerId','$validFactorPayment','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
				$bankStatementInsert = $conn->query($bankStatementSql);
					if(!$bankStatementInsert){
						$bankStatementInsert = false;
					}

			/*  echo $customerFactorqQuery;
			 echo "<BR>";
			echo $customerFactorDetailsQuery;
			echo "<BR>";
			echo $addStockBalance;
			echo "<BR>";
			echo $customerPaymentQuery;
			echo "<BR>";
			echo $customerStatementTotalQuery;
			echo "<BR>";
			echo $customerStatementQuery;
			echo "<BR>";
			echo $bankStatementInsert;
			die;  */
       		if($customerFactorqQuery && $customerFactorDetailsQuery && $addStockBalance && $customerPaymentQuery && $customerStatementTotalQuery && $customerStatementQuery  && $bankStatementInsert && $subtractStockBalance && $stockStatement){
				$conn->query("COMMIT");
				header("location: ../view/sellsFactorAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/sellsFactorAT.php?error");
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