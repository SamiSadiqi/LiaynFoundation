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
 		$validStockIdTitle       = $conn->safeInput($_POST['stockIdTitle']);
 		$validProductItem       = $conn->safeInput($_POST['productItem']);
  		$validItemUnitProduction   = $conn->safeInput($_POST['itemUnitProduction']);
 		$validPureAmount     = $conn->safeInput($_POST['pureAmount']);
 		$validImpureAmount 	 = $conn->safeInput($_POST['impureAmount']);
 		$validLineProductNumber     	 = $conn->safeInput($_POST['lineProductNumber']);
  		
		$stockId		= $_POST['stockId'];
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
 		$description 	= $_POST['description'];
 		 
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
 		if($validParam === "insertProducts"){
			
			$conn->query("BEGIN");
			
			$productTitleQuery = true;
 			$detailsProductionQuery = true;
			$minusRawMaterials = true;
 			
			$productTitleSql = "INSERT INTO tbl_production_title(date, items_id,items_unit_id,stocks_id,pure_amount, impure_amount,production_line,users_id,created_at, deleted) VALUES
															('$validDate','$validProductItem','$validItemUnitProduction','$validStockIdTitle','$validPureAmount','$validImpureAmount',$validLineProductNumber,$userId,'$currentTime',0)";
				$productTitleQuery = $conn->query($productTitleSql);
					if(!$productTitleQuery){
					$productTitleQuery = false;
				}

			$addProductToStock = $conn->changeStockAmount($validProductItem,$validStockIdTitle,$validPureAmount,1,$userId);
			
			
			$selectIdTitle       =$conn->query("select id from tbl_production_title where deleted= 0 and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
			
			
			$stockStatementProduceItems = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
																	values('$validDate','Produce Items','$lastId','1','$validPureAmount','$validStockIdTitle','$validProductItem','$validLineProductNumber','0','$currentTime','$userId')");
	
			

			for($i=0;$i<sizeof($itemId);$i++){
				if(!empty($itemId[$i])){
					$detailsProductions    = "INSERT INTO `tbl_production_details`(	title_productions_id,items_id,items_unit_id,amount,stocks_id,description,created_at,users_id, deleted) 
					values('$lastId','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$stockId[$i]','$description[$i]','$currentTime',$userId, '0')";
					$detailsProductionQuery  = $conn->query($detailsProductions);
					 
					if(!$detailsProductionQuery){
						$detailsProductionQuery  = false;
					}
					
					$minusRawMaterials = $conn->changeStockAmount($itemId[$i],$stockId[$i],$amount[$i],2,$userId);
					
						//Get Last Record Id
					$lastQueryDetails = $conn->query("SELECT * FROM `tbl_production_details` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRowDetails = $lastQueryDetails->fetch_array();
					$lastIdDetails    = $lastIdRowDetails['id'];
					
					
					
					$stockStatementConsumeProduction = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
																			values('$validDate','Consume Production Item','$lastIdDetails','2','$amount[$i]','$stockId[$i]','$itemId[$i]','$description[$i]','0','$currentTime','$userId')");
			
				}
			}
			
       		if($productTitleQuery && $addProductToStock && $detailsProductionQuery && $minusRawMaterials && $stockStatementConsumeProduction && $stockStatementProduceItems){
				$conn->query("COMMIT");
				header("location: ../view/factoryProductionAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/factoryProductionAT.php?error");
				exit();
			}
			
		}
	}
?>