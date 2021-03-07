<?php
	session_start();
	require_once("../config/dbConstants.php");
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$validDate          	= $conn->safeInput($_POST['date']);
 		$validRrecipientId        = $conn->safeInput($_POST['recipientId']);
  		$validAmount          = $conn->safeInput($_POST['amount']);
   		$validBankId          = $conn->safeInput($_POST['bankId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
  		$validParam = decryptIt($conn->safeInput($_POST['formTable']));
		
		if($validParam === "tbl_recipients_payment"){

		
			$file = $_FILES['upoladeFile']['name'];
		
			$path ="documents/".$file;
			$ext=pathinfo($path,PATHINFO_EXTENSION);
			$name=pathinfo($path,PATHINFO_FILENAME);
			
			$path1="../documents/";
			
			$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
			// move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
			move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
			
		
			//Check for empty FROM
			if($validDate == "" && $validRrecipientId=="" && $validExpenseCategory=="" && $validAmount == "" && $validBankId==""){
				echo "empty";
				exit();
			}else{
				/*======================= Check For duplicate2 ================= */
				$selectExistedData  = "SELECT * FROM `tbl_recipients_payment` WHERE deleted = 0 AND date = '$validDate' AND recipients_Id='$validRrecipientId' AND amount='$validAmount' AND banks_id='$validBankId' AND description='$validDescription'";
				$existedQuery = $conn->query($selectExistedData);
				
				if($existedQuery->num_rows> 0 ){
					header("location: ../view/recipentPaymentAidAT.php?empty");
					exit();
				}
				/*======================= End Check For duplicate2 ================= */
				 
				
				$conn->query("BEGIN");
				 
				$insertSQLQuery = $conn->query("INSERT INTO tbl_recipients_payment (date,recipients_Id,document, amount,banks_id,description,users_id, deleted, created_at)VALUES
										('$validDate','$validRrecipientId','$upoladeFileName','$validAmount','$validBankId','$validDescription',$userId, 0, '$currentTime' )"); 
				
				//Get Last Record Id
				$lastQuery = $conn->query("SELECT * FROM `tbl_recipients_payment` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
				$lastIdRow = $lastQuery->fetch_array();
				$lastId    = $lastIdRow['id'];
				 
				$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,description,deleted,created_at,users_id)values
				('$validDate','پرداخت کمک به کمک گیرنده گان','$lastId','2','$validRrecipientId','$validAmount','$validBankId','$validDescription','0','$currentTime','$userId')";
				$bankStatementInsert = $conn->query($bankStatementSql);
				 
				if($insertSQLQuery && $bankStatementInsert){
					$conn->query("COMMIT");
					header("location: ../view/recipentPaymentAidAT.php?save");
					exit();
				}else{
					$conn->query("ROLLBACK");
					header("location: ../view/recipentPaymentAidAT.php?error");
					exit();
				}
				 
			}
	}else{
			header("location: ../view/logout.php");
			exit();
		}
	}

	?>
