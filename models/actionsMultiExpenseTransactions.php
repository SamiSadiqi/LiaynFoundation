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
		
		$validDate           = $_POST['date'];
		$validExpenseCategory= $_POST['category'];
 		$validExpenseType    = $_POST['expenseType'];
  		$validAmount  		 = $_POST['amount'] ;
  		$validBankId         = $_POST['bankId'];
 		$validExpenserId     = $_POST['expenserId'];
 		$validDescription    = $_POST['description'];
 		$validRequestType    = $_POST['requestType'];
  		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertMultitransactions"){
		 
			$conn->query("BEGIN");
			$insertSQLQuery  = true;
			$bankStatementInsert = true;
 			$uploadFileDocument = true;
			 
			for($i=0;$i<sizeof($validExpenseCategory);$i++){
				if(!empty($validExpenseCategory[$i])){
					$validHomeAmount     = $validAmount[$i] * $validRate[$i];
					
					$file=$_FILES['upoladeFile']['name'][$i];
					 
					$path ="documents/".$file;
					 
					$ext=pathinfo($path,PATHINFO_EXTENSION);
					$name=pathinfo($path,PATHINFO_FILENAME);
					
					$path1="../documents/";
					
					$upoladeFileName = $path1.$currentTime.$name.rand(1,500).".".$ext;
					
					$moved =  move_uploaded_file($_FILES['upoladeFile']['tmp_name'][$i],$upoladeFileName);
					 
					if(!$moved){
						$uploadFileDocument =  false;
					}	
 
					$insertSQLQuery = $conn->query("INSERT INTO tbl_expenses (date,expense_category_id, expense_type_id, amount,banks_id,description,document,users_id,created_at)VALUES 
					('$validDate[$i]','$validExpenseCategory[$i]','$validExpenseType[$i]', '$validAmount[$i]', '$validBankId[$i]','$validDescription[$i]','$upoladeFileName',$userId,'$currentTime')"); 

					if(!$insertSQLQuery){
						$insertSQLQuery  = false;
					}
					//Get Last Record Id
					$lastQuery = $conn->query("SELECT * FROM `tbl_expenses` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRow = $lastQuery->fetch_array();
					$lastId    = $lastIdRow['id'];
			 
					//Insert Record To bank Statement 
					$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,categories_id,sub_categories_id,description,created_at,users_id)
					values('$validDate[$i]','Office Expenses Transaction','$lastId','2','$validAmount[$i]','$validBankId[$i]','$validExpenseCategory[$i]','$validExpenseType[$i]','$validDescription[$i]','$currentTime','$userId')";
					$bankStatementInsert = $conn->query($bankStatementSql);
					if(!$bankStatementInsert){
						$bankStatementInsert  = false;	
					}
				 }
			}
			/* echo $insertSQLQuery;
			echo "<BR>";
			echo $bankStatementInsert;
			die; */
       		if($insertSQLQuery  && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addMultiExpensesACI.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addMultiExpensesACI.php?error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}
	
	

?>