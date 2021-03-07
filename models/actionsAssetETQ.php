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
	
		$validDate          = $conn->safeInput($_POST['date']);
 		$validAssetType     = $conn->safeInput($_POST['assetType']);
 		$validCheckCash     = $conn->safeInput($_POST['checkCash']);
 		$validAmount        = $conn->safeInput($_POST['cost']);
 		$validCurrenciesId  = $conn->safeInput($_POST['currenciesId']);
 		$validRate          = $conn->safeInput($_POST['rate']);
 		$validBankId        = $conn->safeInput($_POST['bankId']);
 		$validUsefulAge     = $conn->safeInput($_POST['usefulAge']);
 		$validDescription   = $conn->safeInput($_POST['description']);
  		$validHomeAmount    = $validAmount * $validRate;
		
		$validParam= decryptIt($conn->safeInput($_POST['formParameter']));

 		if($validParam === "insertAssetETQ"){	
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_assets` WHERE  deleted = 0 AND date = '$validDate' AND asset_types_id = '$validAssetType' AND cost = '$validAmount' AND  currencies_id = '$validCurrenciesId' AND  rate = '$validRate' AND banks_id = '$validBank' AND useful_age = '$validUsefulAge' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addAssetETQ.php?duplicate");
				exit();
			}
		
 			/*======================= End Check For Duplicate ================= */
			
		    $conn->query("BEGIN");
			$insertSQLQuery    = $conn->query("INSERT INTO tbl_assets(date,asset_types_id,cost,currencies_id,rate,banks_id,useful_age,description,home_amount,users_id,deleted,created_at) VALUES
			('$validDate', '$validAssetType','$validAmount','$validCurrenciesId','$validRate','$validBankId','$validUsefulAge','$validDescription','$validHomeAmount',$userId,0,$currentTime)"); 
				
			 //Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_assets` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,amount,banks_id,currencies_id,rate,categories_id,home_amount,description,deleted,created_at,users_id)
			values('$validDate','Procurement Assets','$lastId','2','$validAmount','$validBankId','$validCurrenciesId','$validRate','$validAssetType','$validHomeAmount','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			
		     
       		if($insertSQLQuery  && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addAssetETQ.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addAssetETQ.php?error");
				exit();
			}
			
		}elseif($validParam === "editAssetETQ"){
			
			$conn->query("BEGIN");

			$validEditId            = decryptIt($conn->safeInput($_POST['id']));
			$editSQLQuery           = $conn->query("UPDATE `tbl_assets` SET date='$validDate', asset_types_id = '$validAssetType',check_cash='$validCheckCash',cost = '$validAmount',currencies_id = '$validCurrenciesId',rate = '$validRate',banks_id='$validBankId',useful_age='$validUsefulAge', description = '$validDescription',home_amount = '$validHomeAmount' WHERE id = $validEditId");
   			$expenseStatementQuery = $conn->query("UPDATE `tbl_bank_statement` SET  date = '$validDate',amount='$validAmount',currencies_id = '$validCurrenciesId', rate='$validRate',categories_id='$validAssetType',check_cash='$validCheckCash', home_amount='$validHomeAmount',description ='$validDescription', banks_id = '$validBankId',changed_at = '$currentTime' WHERE reference = $validEditId AND place = 'Procurement Assets'");
 			 
	
			if($editSQLQuery  && $expenseStatementQuery && $requestStatementQuery){
				$conn->query("COMMIT");
				header("location: ../view/editAssetsETQ.php?id=" . encryptIt($validEditId) ."&edit");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/editAssetsETQ.php?id=" . encryptIt($validEditId) ."&error");
				exit();
			}
		 
		 
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}else{
		$table = 'tbl_assets';
 		$validDeleteId  = $conn->safeInput(decryptIt($_GET['id']));
		 
			$deleteRow            = $conn->query("UPDATE $table SET deleted = 1 WHERE id = $validDeleteId AND users_id = $userId");			 
			if($deleteRow){
				header("location: ../view/addAssetETQ.php?deleted");
			}
		}

?>