<?php
session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();
	$validUpdateId = decryptIt($conn->safeInput($_POST['id']));
	$table = decryptIt($conn->safeInput($_POST['formTable']));

  if($table === "tbl_support_ceremonies_requests"){
			 
			$validDenotionDate= $conn->safeInput($_POST['denotionDate']);
			$validAmount = $conn->safeInput($_POST['amount']);
 			$validCurrenciesId = $conn->safeInput($_POST['currenciesId']);
			$validBankId = $conn->safeInput($_POST['bankId']);
			$validRate = $conn->safeInput($_POST['rate']);
 			$validDescription = $conn->safeInput($_POST['description']);
			$validHomeAmount = $validAmount * $validRate;
				$file = $_FILES['upoladeFile']['name'];
		
				$path ="documents/".$file;
				$ext=pathinfo($path,PATHINFO_EXTENSION);
				$name=pathinfo($path,PATHINFO_FILENAME);
				
				$path1="../documents/";
				
				$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
 				move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				
				move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
				 
			 
			
				//Check for empty FROM
				if($validDenotionDate == "" && $validAmount=="" && $validCurrenciesId=="" && $validBankId == "" && $validRate == ""){
					echo "empty";
					exit();
				}elseif(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$validDenotionDate)){
					echo "dateFormatError";
					exit();
				}else{
					 
					 /*======================= Check For duplicate2 ================= */
					$selectExistenDate  = "SELECT * FROM `tbl_org_statement` WHERE  date = '$validDenotionDate' AND place = 'Support Ceremonies' AND reference = '$validUpdateId'  AND amount = '$validAmount' AND banks_id = '$validBankId' AND  currencies_id ='$validCurrenciesId' AND description = '$validDescription' AND deleted = 0";	
					$existenQuery = $conn->query($selectExistenDate);
					if($existenQuery->num_rows> 0 ){
						echo "duplicate2";
						exit();
					}
					/*======================= End Check For duplicate2 ================= */
				 
						  
					$conn->query("BEGIN");
					
					$orgStatementSql = $conn->query("INSERT into tbl_org_statement(date,place,reference,transaction_type,amount,banks_id,document,currencies_id,rate,home_amount,description,created_at,users_id)values
					('$validDenotionDate','Support Ceremonies','$validUpdateId','2','$validAmount','$validBankId','$upoladeFileName','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','$currentTime','$userId')");

					 
					$bankStatementSql =$conn->query("INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,home_amount,description,deleted,created_at,users_id)values
					('$validDenotionDate','Support Ceremonies','$validUpdateId','2','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validHomeAmount','$validDescription','0','$currentTime','$userId')");
 				
				if($orgStatementSql && $bankStatementSql){
					$conn->query("COMMIT");
					echo "saved";
					exit();
				}else{
					$conn->query("ROLLBACk");
					echo "error";	
					exit();
				}
			}
	 	
	}

?>