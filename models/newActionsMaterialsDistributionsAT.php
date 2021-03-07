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
 		$validSchoolId       = $conn->safeInput($_POST['schoolId']);
   		$validFactorNumber 	 = $conn->safeInput($_POST['requestNumber']);
 		$validBankId     	 = $conn->safeInput($_POST['bankId']);
		$validDescription    = $conn->safeInput($_POST['description']);
 		$validTotalFactorPrice   = $conn->safeInput($_POST['totalFactorPrice']);
 		
		
		$stockId		= $_POST['stockId'];
		$itemId          = $_POST['itemId'];
		$itemUnit        = $_POST['itemUnit'];
		$amount          = $_POST['amount'];
		$fee             = $_POST['fee'];
		$totalFee 		= $_POST['totalFee'];
		$subDescription = $_POST['subDescription'];
 		
 		$validParam          = decryptIt($conn->safeInput($_POST['formParameter']));
		
 		if($validParam === "tbl_donations_materials_title"){
			
			$conn->query("BEGIN");
			
			$materialsDistributionsQuery = true;
			$materialsDistSql = true;
			$bankStatementInsert = true;
			
			$materialsDistributionsSql = "INSERT INTO tbl_donations_materials_title(date,schools_id,request_number, banks_id, factor_price, description, users_id,created_at, deleted) VALUES
															('$validDate','$validSchoolId','$validFactorNumber',$validBankId ,'$validTotalFactorPrice','$validDescription',$userId,'$currentTime',0)";
				$materialsDistributionsQuery = $conn->query($materialsDistributionsSql);
					if(!$materialsDistributionsQuery){
					$materialsDistributionsQuery = false;
				}
			$selectIdTitle       =$conn->query("select id from tbl_donations_materials_title where deleted='0' and users_id='$userId' ORDER BY id DESC LIMIT 1");
 			$rowSelectIdTitle    = $selectIdTitle->fetch_array();
			$lastId  = $rowSelectIdTitle['id'];
				

			for($i=0;$i<sizeof($itemId);$i++){
				if(!empty($itemId[$i])){
					$materialsDistDetailsQuery    = "INSERT INTO `tbl_donations_materials_details`(titles_id,items_id,items_unit_id,amount,fee,stocks_id,total_amount,description,created_at,users_id, deleted) 
					values('$lastId','$itemId[$i]','$itemUnit[$i]','$amount[$i]','$fee[$i]','$stockId[$i]','$totalFee[$i]','$subDescription[$i]','$currentTime',$userId, '0')";
					$materialsDistSql  = $conn->query($materialsDistDetailsQuery);
					 
					if(!$materialsDistSql){
						$materialsDistSql  = false;
					}
					
					$addStockBalance = $conn->changeStockAmount($itemId[$i],$stockId[$i],$amount[$i],2,$userId);
					
				}
			}
				
			
			$bankStatementSql ="INSERT into tbl_bank_statement(date,place,reference,transaction_type,categories_id,amount,banks_id,description,deleted,created_at,users_id)
								values('$validDate','Materials Distribution','$lastId','2','$validSchoolId','$validTotalFactorPrice','$validBankId','$validDescription','0','$currentTime','$userId')";
			$bankStatementInsert = $conn->query($bankStatementSql);
			if(!$bankStatementInsert){
				$bankStatementInsert = false;
			}
		 
		 /* 	 
			echo $materialsDistributionsQuery;
			echo "<br/>";
			echo $materialsDistSql;
			echo "<br/>";
			echo $bankStatementInsert;
			die;  */
	 
			
       		if($materialsDistributionsQuery && $materialsDistSql && $bankStatementInsert){
				$conn->query("COMMIT");
				header("location: ../view/addMaterialsDistributionsAT.php?save");
				exit();
			}else{
				$conn->query("ROLLBACK");
				header("location: ../view/addMaterialsDistributionsAT.php?error");
				exit();
			}
			
		}else{
			header("location: ../view/logout.php");
			exit();
		}
	}
	

?>