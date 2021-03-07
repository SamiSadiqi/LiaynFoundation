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
 		$validExpenseCategory= $conn->safeInput($_POST['expenseCategory']);
 		$validExpenseType    = $conn->safeInput($_POST['expenseType']);
    	$validAmount 		 = $conn->safeInput($_POST['amount']);
  	 	$validCurrenciesId   = $conn->safeInput($_POST['currenciesId']);
		$validRate			 = $conn->safeInput($_POST['rate']);
 		$validBankId         = $conn->safeInput($_POST['bankId']);
 		$validExpenserId     = $conn->safeInput($_POST['expenserId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
   
		$validOldDocument = $conn->safeInput($_POST['oldDocument']);
        $validHomeAmount  = $validAmount * 	$validRate;
		
		$file=$_FILES['upoladeFile']['name'];
		$path ="documents/".$file;
		$ext=pathinfo($path,PATHINFO_EXTENSION);
		$name=pathinfo($path,PATHINFO_FILENAME);
		
 		$path1="../documents/";
		
		$upoladeFileName = $path1.$name.$currentTime.rand(1,5000).".".$ext;
		move_uploaded_file($_FILES['upoladeFile']['tmp_name'],$upoladeFileName);
		 
			// Edit Profile User Photo.
		if(isset($_FILES['fileName']['name']) && ($_FILES['fileName']['name'] !="")){
			
			 
			unlink($validOldDocument);
			$file=$_FILES['fileName']['name'];
			$path ="documents/".$file;
			$ext=pathinfo($path,PATHINFO_EXTENSION);
			$name=pathinfo($path,PATHINFO_FILENAME);
			 
			
			$path1="../documents/";
		 
			$validOldDocumentName = $path1.$name.$currentTime.rand(1,500).".".$ext;
			move_uploaded_file($_FILES['fileName']['tmp_name'],$validOldDocumentName);
			 
		}else{
			
			 $validOldDocumentName = $validOldDocument;
		}
	 

 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertExpenseETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_expenses` WHERE deleted = 0 AND date = '$validDate' AND expense_category_id = '$validExpenseCategory' AND expense_type_id = '$validExpenseType' AND  amount ='$validAmount' AND currencies_id = '$validCurrenciesId' AND rate = '$validRate' AND banks_id = '$validBankId' AND  expensers_id ='$validExpenserId' AND  description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addExpenseETQ.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
			
			 
		
    		$insertSQLQuery = $conn->query("INSERT INTO tbl_expenses (date,expense_category_id, expense_type_id, amount,currencies_id,rate,banks_id,description,document,home_amount,users_id, deleted,created_at) 
    		VALUES ('$validDate', '$validExpenseCategory', '$validExpenseType', '$validAmount', '$validCurrenciesId', '$validRate', '$validBankId','$validDescription','$upoladeFileName','$validHomeAmount',$userId,0,'$currentTime')"); 
             
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_expenses` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
	 
            //Insert Record To bank Statement 
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,categories_id,sub_categories_id,home_amount,description,deleted,created_at,users_id)
			values('$validDate','Office Expenses Transaction','$lastId','2','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validExpenseCategory','$validExpenseType','$validHomeAmount','$validDescription',0,'$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			 
		 
       		if($insertSQLQuery  && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addExpenseETQ.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addExpenseETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "editExpenseETQ"){
			
			$conn->query("BEGIN");
           
		
			$validEditId            = decryptIt($conn->safeInput($_POST['id']));	
 			$editSQLQuery           = $conn->query("UPDATE `tbl_expenses` SET date='$validDate', expense_category_id = '$validExpenseCategory',expense_type_id = '$validExpenseType',amount = '$validAmount',currencies_id = '$validCurrenciesId',rate='$validRate', banks_id = '$validBankId',expensers_id = '$validExpenserId',description = '$validDescription',document = '$validOldDocumentName', home_amount = '$validHomeAmount',changed_at = '$currentTime' WHERE  id = $validEditId");
			$expenseStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validExpenseCategory',sub_categories_id='$validExpenseType', home_amount='$validHomeAmount',description ='$validDescription', banks_id = '$validBankId',changed_at = '$currentTime'  WHERE reference = $validEditId AND place = 'Office Expenses Transaction'");
 			 
			if($editSQLQuery  && $expenseStatementQuery && $requestStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editExpenseETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editExpenseETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
			 
		$table = 'tbl_expenses';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
  		
				$selectExistedData  = "SELECT * FROM `tbl_expenses` WHERE id = $validDeleteId AND approved != 0 ";
				$existedQuery = $conn->query($selectExistedData);
				if($existedQuery->num_rows> 0){
				header("location: ../view/addExpenseETQ.php?error");
				exit();
			}else{
				$bankStatementQueryDelete = $conn->query("UPDATE `tbl_bank_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Office Expenses Transaction'");
				$requestStatementDelete = $conn->query("UPDATE `tbl_request_statement` SET deleted = 1 WHERE reference = $validDeleteId AND place = 'Request Payment to Office Expenses'");
				$deleteRow  = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId");			 
				 
				if($deleteRow && $bankStatementQueryDelete && $requestStatementDelete){
							header("location: ../view/addExpenseETQ.php?deleted");
						} 
				}
		}
		
	
	

?>