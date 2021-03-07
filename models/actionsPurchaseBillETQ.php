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
 		$validVendorId       = $conn->safeInput($_POST['vendorId']);
  		$validFactorNumber 	 = $conn->safeInput($_POST['factorNumber']);
 		$validBankId     	 = $conn->safeInput($_POST['bankId']);
		$validDescription    = $conn->safeInput($_POST['description']);
 		$validTotalFactorPrice   = $conn->safeInput($_POST['totalFactorPrice']);
 		$validFactorPayment  = $conn->safeInput($_POST['factorPayment']);
		
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
		$totalFee 		= $_POST['totalFee'];
		$subDescription = $_POST['subDescription'];
		$stockId		= $_POST['stockId'];
		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
 		if($validParam === "insertPurchasesETQ"){
			
			$conn->query("BEGIN");
			
			$vendorFactorqQuery = true;
			$vendorFactorDetailsQuery = true;
			$addStockBalance = true;
			$vendorPaymentQuery = true;
			$vendorStatementTotalQuery = true;
			$vendorStatementQuery = true;
			$bankStatementInsert = true;
			
			$vendorFactorSqlTitle = "INSERT INTO tbl_vendor_bill_title(date, vendors_id,factor_number, banks_id, factor_price, factor_payment, description, users_id,created_at, deleted) VALUES
															('$validDate','$validVendorId','$validFactorNumber',$validBankId ,'$validTotalFactorPrice','$validFactorPayment','$validDescription',$userId,'$currentTime',0)";
				$vendorFactorqQuery = $conn->query($vendorFactorSqlTitle);
					if(!$vendorFactorqQuery){
					$vendorFactorqQuery = false;
				}
			$selectIdTitle       =$conn->query("select id from tbl_vendor_bill_title where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
				

			for($i=0;$i<sizeof($itemId);$i++){
				if(!empty($itemId[$i])){
					$vendorFactorDetailsSql    = "INSERT INTO `tbl_vendor_bill_details`(title_bills_id,items_id,items_unit_id,amount,fee,stocks_id,total_amount,description,created_at,users_id, deleted) 
					values('$lastId','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$fee[$i]','$stockId[$i]','$totalFee[$i]','$subDescription[$i]','$currentTime',$userId, '0')";
					$vendorFactorDetailsQuery  = $conn->query($vendorFactorDetailsSql);
					 
					if(!$vendorFactorDetailsQuery){
						$vendorFactorDetailsQuery  = false;
					}
					
					$addStockBalance = $conn->changeStockAmount($itemId[$i],$stockId[$i],$amount[$i],1,$userId);
					
					//Get Last Record Id
					$lastQueryDetails = $conn->query("SELECT * FROM `tbl_vendor_bill_details` WHERE users_id = $userId AND deleted = 0 ORDER BY id DESC LIMIT 1");
					$lastIdRowDetails = $lastQueryDetails->fetch_array();
					$lastIdDetails    = $lastIdRowDetails['id'];
					
					
					
					$stockStatement = $conn->query("INSERT into tbl_stock_statement(date,place,reference,transaction_type,amount,stocks_id,items_id,description,deleted,created_at,users_id)
																			values('$validDate','خرید اجناس از فروشنده','$lastIdDetails','1','$amount[$i]','$stockId[$i]','$itemId[$i]','$subDescription[$i]','0','$currentTime','$userId')");
			
				}
			}
			
			if($validFactorPayment){
				$vendorPaymentSql  = "INSERT INTO `tbl_vendor_payment`(date,vendors_id,reference,amount,banks_id,factor_number,description,payment_type,users_id,created_at,deleted) VALUES
																		  ('$validDate','$validVendorId',$lastId,'$validFactorPayment','$validBankId','$validFactorNumber','$validDescription',1,'$userId','$currentTime','0')";
				$vendorPaymentQuery = $conn->query($vendorPaymentSql);
				if(!$vendorPaymentQuery){
				
					$vendorPaymentQuery=false;
				}
			}	
			$vendorStatementTotal ="INSERT into tbl_vendor_statement(date,place,reference,transaction_type,amount,vendors_id,deleted,description,created_at,users_id) values
																('$validDate', 'کل قیمت فاکتور خرید', '$lastId', '1','$validTotalFactorPrice',$validVendorId ,0,'$validDescription','$currentTime', $userId)";
			$vendorStatementTotalQuery = $conn->query($vendorStatementTotal);
			if(!$vendorStatementTotalQuery){
				$vendorStatementTotalQuery = false;
			}
//
			if(isset($validFactorPayment) && !empty($validFactorPayment)){
				$vendorStatementSql ="INSERT into tbl_vendor_statement(date,place,reference,transaction_type,amount,vendors_id,deleted,description,created_at,users_id)
										values('$validDate', 'پرداخت به فروشنده', '$lastId', '2','$validFactorPayment','$validVendorId',0,'$validDescription','$currentTime', $userId)";
				$vendorStatementQuery = $conn->query($vendorStatementSql);
				if(!$vendorStatementQuery){
					$vendorStatementQuery = false;
				}
				
			}
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,description,deleted,created_at,users_id)
								values('$validDate','پرداخت بیل فروشنده','$lastId','2','$validVendorId','$validFactorPayment','$validBankId','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			if(!$bankStatementInsert){
				$bankStatementInsert = false;
			}
			/* 
				echo $vendorFactorqQuery;
				echo "<br/>";
				echo $vendorFactorDetailsQuery;
				echo "<br/>";
				echo "<br/>";
				echo $stockStatement;
				echo "<br>";
				echo $addStockBalance;
				echo "<br/>";
				echo $vendorPaymentQuery;
				echo "<br/>";
				echo $vendorStatementTotalQuery;
				echo "<br/>";
				echo $vendorStatementQuery;
				echo "<br/>";
				echo $bankStatementInsert;
				die; 
			*/
       		if($vendorFactorqQuery && $vendorFactorDetailsQuery && $stockStatement && $addStockBalance && $vendorPaymentQuery && $vendorStatementTotalQuery && $vendorStatementQuery  && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/purchasesBillAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/purchasesBillAT.php?error");
				exit();
			}
			
		}elseif($validParam === "editPurchasesETQ"){
			header("location: ../view/logout.php");
			exit();
		}
	}
	

?>