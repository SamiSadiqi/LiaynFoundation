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
	
		$validDate    = $conn->safeInput($_POST['date']);
 		$validSourceStocksId   = $conn->safeInput($_POST['sourceStocksId']);
		$validItemsId = $conn->safeInput($_POST['itemsId']);
		$validTransferAmount   = $conn->safeInput($_POST['transferAmount']);
		$validDestinationStocksId = $conn->safeInput($_POST['destinationStocksId']);
 		$validDescription    = $conn->safeInput($_POST['description']);
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
 		if($validParam === "transferItemETQ"){
			/*======================= Check For Duplicate =================  */
			$selectExistedData  = "SELECT * FROM `tbl_stock_transaction` WHERE deleted = 0 AND date = '$validDate' AND source_stocks_id = '$validSourceStocksId' AND items_id= '$validItemUnit' AND destination_stocks_id = '$validDestinationStocksId' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/stockTransferAT.php?duplicate");
				exit();
			}
 			/* ======================= End Check For Duplicate ================= */
  			$insertSQLQuery = $conn->query("INSERT INTO tbl_stock_transaction (date,source_stocks_id,items_id,transfer_amount,destination_stocks_id,description,users_id, deleted, created_at) VALUES 
			('$validDate', '$validSourceStocksId', '$validItemsId','$validTransferAmount', '$validDestinationStocksId','$validDescription', $userId, 0, NOW())"); 
			
			 
			$minusAmount = $conn->changeStockAmount($validItemsId,$validSourceStocksId,$validTransferAmount,2,$userId);
			$plusAmount = $conn->changeStockAmount($validItemsId,$validDestinationStocksId,$validTransferAmount,1,$userId);
			
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_stock_transaction` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			
			$sourcStockExchangeAmount = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','Stock Transfer','$lastId','2','$validTransferAmount','$validSourceStocksId','$validItemsId','$validDescription','$validDestinationStocksId','0','$currentTime','$userId')");
			
			$distinationBankExchangeAmount = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,categories_id,deleted,created_at,users_id)
			values('$validDate','Stock Transfer','$lastId','1','$validTransferAmount','$validDestinationStocksId','$validItemsId','$validDescription','$validSourceStocksId','0','$currentTime','$userId')");
			
		
			if($insertSQLQuery && $minusAmount && $plusAmount && $sourcStockExchangeAmount && $distinationBankExchangeAmount){		
				header("location: ../view/stockTransferAT.php?save");
				exit();
			}else{
				header("location: ../view/stockTransferETQ.php?error");
				exit();
			}	
		}else{
				header("location: ../view/logout.php");
			exit();
		}
	}
	
	
	

?>