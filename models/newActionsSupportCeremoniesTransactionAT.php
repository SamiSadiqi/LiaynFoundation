<?php
	session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$validDenotionDate= $conn->safeInput($_POST['date']);
		$validCermoniesId= $conn->safeInput($_POST['cermoniesId']);
		$validAmount = $conn->safeInput($_POST['amount']);
 		$validBankId = $conn->safeInput($_POST['bankId']);
 		$validDescription = $conn->safeInput($_POST['description']);
 		$validParam= decryptIt($conn->safeInput($_POST['formTable']));
		
		if($validParam === "tbl_support_ceremonies_response_tran"){

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
				header("location: ../view/addSupportCeremoniesTransactions.php?empty");
				exit();
			}else{
				 
				 /*======================= Check For duplicate2 ================= */
				$selectExistenDate  = "SELECT * FROM `tbl_support_ceremonies_response_tran` WHERE  date = '$validDenotionDate' AND ceremonies_id = '$validCermoniesId'  AND amount = '$validAmount' AND banks_id = '$validBankId' AND description = '$validDescription' AND deleted = 0";	
				$existenQuery = $conn->query($selectExistenDate);
				if($existenQuery->num_rows> 0 ){
				header("location: ../view/addSupportCeremoniesTransactions.php?duplicate");
					exit();
				}
				/*======================= End Check For duplicate2 ================= */
			 
					  
				$conn->query("BEGIN");
				
				$orgStatementSql = $conn->query("INSERT into tbl_support_ceremonies_response_tran(date,ceremonies_id,amount,banks_id,document,description,created_at,users_id)values
				('$validDenotionDate','$validCermoniesId','$validAmount','$validBankId','$upoladeFileName','$validDescription','$currentTime','$userId')");

				 
				$bankStatementSql =$conn->query("INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,description,deleted,created_at,users_id)values
				('$validDenotionDate','Support Ceremonies','$validUpdateId','2','$validAmount','$validBankId','$validDescription','0','$currentTime','$userId')");
			
			if($orgStatementSql && $bankStatementSql){
				$conn->query("COMMIT");
				header("location: ../view/addSupportCeremoniesTransactions.php?save");
				exit();
			}else{
				$conn->query("ROLLBACk");
				header("location: ../view/addSupportCeremoniesTransactions.php?error");
				exit();
			}
		}
	
	}else{
			header("location: ../view/logout.php");
			exit();
		}
}

	?>
