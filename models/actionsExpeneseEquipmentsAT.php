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
 
		$validDate       = $_POST['date'];
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
		$totalFee 		= $_POST['totalFee'];
		$subDescription = $_POST['subDescription'];
		$stockId		= $_POST['stockId'];
 		
	 
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
 		if($validParam === "expenseEquipmentsAT"){
			
			$conn->query("BEGIN");
			
			$vendorFactorDetailsQuery = true;
		 
			for($i=0;$i<sizeof($itemId);$i++){
				if(!empty($itemId[$i])){
					$vendorFactorDetailsSql    = "INSERT INTO `tbl_expense_equipments`(date,items_id,items_unit_id,amount,fee,stocks_id,total_amount,description,created_at,users_id, deleted) 
					values('$validDate[$i]','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$fee[$i]','$stockId[$i]','$totalFee[$i]','$subDescription[$i]','$currentTime',$userId, '0')";
					$vendorFactorDetailsQuery  = $conn->query($vendorFactorDetailsSql);
					 
					if(!$vendorFactorDetailsQuery){
						$vendorFactorDetailsQuery  = false;
					}
					
					$addStockBalance = $conn->changeStockAmount($itemId[$i],$stockId[$i],$amount[$i],2,$userId);
					
					
					//Get Last Record Id
					$lastQuery = $conn->query("SELECT * FROM `tbl_expense_equipments` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRow = $lastQuery->fetch_array();
					$lastId    = $lastIdRow['id'];
					
					
					
					$stockStatement = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
					values('$validDate[$i]','Expense Equipments','$lastId','2','$amount[$i]','$stockId[$i]','$itemId[$i]','$subDescription[$i]','0','$currentTime','$userId')");
			
				}
			}
       		if($addStockBalance && $vendorFactorDetailsQuery && $stockStatement){
				$conn->query("COMMIT");
				header("location: ../view/expenseEquipmentAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/expenseEquipmentAT.php?error");
				exit();
			}
			
		}
	}

?>