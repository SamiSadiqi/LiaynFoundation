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
				
		$validDate = $conn->safeInput($_POST['date']);
		$validName           = $conn->safeInput($_POST['name']);
 		$validItemUnit       = $conn->safeInput($_POST['itemUnit']);
		$validOpeningBalance = $conn->safeInput($_POST['openingBalance']);
		$validItemCategory   = $conn->safeInput($_POST['itemCategory']);
		$validStockId        = $conn->safeInput($_POST['stockId']);
		$validMinimum        = $conn->safeInput($_POST['minimum']);
		$validItemType        = $conn->safeInput($_POST['itemType']);
		$validDescription    = $conn->safeInput($_POST['description']);
		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
		if($validParam === "insertItemETQ"){
			/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `tbl_items` WHERE deleted = 0 AND name = '$validName' AND data = $validDate AND item_units_id= '$validItemUnit'  AND item_type = '$validItemType' AND stocks_id = '$validStockId' AND item_categories_id = '$validItemCategory' AND minimum = '$validMinimum' AND opening_balance = '$validOpeningBalance' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
			
			if($existedQuery->num_rows> 0 ){
				header("location: ../view/addItemAT.php?duplicate");
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			
			$conn->query("BEGIN");
  			$insertSQLQuery = $conn->query("INSERT INTO tbl_items (date,name,item_units_id,stocks_id,item_type,item_categories_id,minimum,opening_balance,description,users_id, deleted, created_at) VALUES ('$validDate','$validName','$validItemUnit', '$validStockId','$validItemType','$validItemCategory', '$validMinimum', '$validOpeningBalance', '$validDescription', $userId, 0, NOW())"); 
			
			 //Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $itemId    = $lastIdRow['id'];
			
			//Get Last Record Id
            $lastQuery = $conn->query("SELECT * FROM `tbl_items` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
            $lastIdRow = $lastQuery->fetch_array();
            $lastId    = $lastIdRow['id'];
			
			$stockStatementSql ="INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
			values('$validDate','Opening Balance Item','$lastId','1','$validOpeningBalance','$validStockId','$lastId','$validDescription','0','$currentTime','$userId')";
			$stockStatementInsert = $conn->query($stockStatementSql);
		 
			$increaseStockAmount = $conn->changeStockAmount($itemId,$validStockId,$validOpeningBalance,1,$userId);
			
			if($insertSQLQuery && $increaseStockAmount && $stockStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addItemAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addItemAT.php?error");
				exit();
			}	
		}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addItemAT.php?error");
				exit();
		}
	
	}

?>