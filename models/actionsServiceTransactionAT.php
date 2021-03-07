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
 		$validProviderId     = $conn->safeInput($_POST['provider']);
 		$validAmount      	 = $conn->safeInput($_POST['amount']);
 		$validPaymentAmount  = $conn->safeInput($_POST['paymentAmount']);
 		$validRate           = $conn->safeInput($_POST['rate']);
 		$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
  		$validBankId     	 = $conn->safeInput($_POST['bankId']);
		$validDescription    = $conn->safeInput($_POST['description']);
  		$validSupervisorId   = $conn->safeInput($_POST['supervisorId']);
		
 		$validHomeAmount     = $validPaymentAmount * $validRate;
 		$validHomeAmountTotal     = $validAmount * $validRate;
		
		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
 		if($validParam === "insertServiceTransaction"){
	 
			$conn->query("BEGIN");
			
			$serviceTransactionQuery = true;
			$servicePaymentQurey = true;
			$serviceStatementTotalQuery = true;
			$servicePaymentQuery = true;
			$bankStatementInsert = true;
  			

				$serviceTransactionSql    = "INSERT INTO `tbl_service_transaction`(date,service_provider_id,banks_id,rate,currencies_id,amount,payment_amount,description,home_amount,employee_id,created_at,users_id,deleted) 
				values('$validDate','$validProviderId','$validBankId','$validRate','$validCurrenciesId','$validAmount','$validPaymentAmount','$validDescription','$validHomeAmountTotal','$validSupervisorId','$currentTime',$userId, '0')";
				$serviceTransactionQuery  = $conn->query($serviceTransactionSql);
				 
				if(!$serviceTransactionQuery){
					$serviceTransactionQuery  = false;
				}
				
				$selectIdTitle       =$conn->query("select id from tbl_service_transaction where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
				$rowSelectIdTitle    = $selectIdTitle->fetch_array();
				$lastId  = $rowSelectIdTitle['id'];
					
				
				if(isset($validPaymentAmount) && !empty($validPaymentAmount)){ 
 					 $servicePaymentSql = "INSERT INTO `tbl_service_payment`(date,service_provider_id,service_transactions_id,currencies_id,amount,rate,banks_id,factor_number,description,payment_type,home_amount,users_id,created_at,deleted) VALUES
															                  ('$validDate','$validProviderId','$lastId','$validCurrenciesId','$validPaymentAmount','$validRate','$validBankId','Cash','$validDescription',1,'$validHomeAmount','$userId','$currentTime','0')";
 					$servicePaymentQurey = $conn->query($servicePaymentSql);
					if(!$servicePaymentQurey){
					
						$servicePaymentQurey=false;
					}
				}	
 				$serviceStatementTotal ="INSERT into tbl_service_provider_statement(date,place,reference,transaction_type,amount,service_provider_id,currencies_id,rate,home_amount,deleted,description,created_at,users_id) values
																	('$validDate', 'Total Service Amount','$lastId', '1','$validAmount',$validProviderId ,$validCurrenciesId, '$validRate', '$validHomeAmountTotal',0,'$validDescription','$currentTime', $userId)";
				$serviceStatementTotalQuery = $conn->query($serviceStatementTotal);
				if(!$serviceStatementTotalQuery){
					$serviceStatementTotalQuery = false;
				}
//
				if(isset($validPaymentAmount) && !empty($validPaymentAmount)){
					$servicePaymentStatementSql ="INSERT into tbl_service_provider_statement(date,place,reference,transaction_type,amount,service_provider_id,currencies_id,rate,home_amount,deleted,description,created_at,users_id)
											values('$validDate', 'Service Payment', '$lastId', '2','$validPaymentAmount','$validProviderId', $validCurrenciesId, '$validRate', '$validHomeAmount',0,'$validDescription','$currentTime', $userId)";
				 
					$servicePaymentQuery = $conn->query($servicePaymentStatementSql);
					if(!$servicePaymentQuery){
						$servicePaymentQuery = false;
					}
					
			
				$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)
									values('$validDate','Payment to Service Provider','$lastId','2','$validProviderId','$validPaymentAmount','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
				$bankStatementInsert = $conn->query($bankStatementSql);
					if(!$bankStatementInsert){
						$bankStatementInsert = false;
					}
				}
			
		/* 	echo $serviceTransactionQuery;
			echo "<BR>";
			echo $servicePaymentQurey;
			echo "<BR >";
			echo $serviceStatementTotalQuery;
			echo "<BR>";
			echo $servicePaymentQuery;
			echo "<BR>";
			echo $bankStatementInsert;
		   die; */
		   
       		if($serviceTransactionQuery && $servicePaymentQurey && $serviceStatementTotalQuery && $servicePaymentQuery && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addServiceTransactionAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addServiceTransactionAT.php?error");
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