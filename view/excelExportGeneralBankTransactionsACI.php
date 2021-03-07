<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/bankBalanceTransactionsReport.xls");

	$table="tbl_bank_statement";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$categoryId = $row['categories_id'];
		$subCategoryId = $row['sub_categories_id'];
		 
	if($row['place'] == 'Opening Balance'){
 							
		$targetCategory  = "Opening Balance";
		$targetSubCategory = "";
	 
	}elseif($row['place'] == 'Vendor Payment Bill'){
		
		$rowTargetCategory  = $conn->selectRecord ("tbl_vendors","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Vendor Payment from Bill";
	 
	}elseif($row['place'] == 'Vendor Payment'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_vendors","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Vendor Payment Transaction";
	 
	}elseif($row['place'] == 'Customer Payment Invoice'){
		
		$rowTargetCategory  = $conn->selectRecord ("tbl_customers","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Customer Payment from Invoice";
	 
	}elseif($row['place'] == 'Customer Payment'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_customers","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Customer Payment Transaction";
	 
	}elseif($row['place'] == 'Payment to Service Provider'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_service_provider","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Payment to Service Provider";
	 
	}elseif($row['place'] == 'Services Provider Payment'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_service_provider","id  = ". $categoryId);
		$targetCategory = $rowTargetCategory['name'];
		$targetSubCategory  = "Payment to Service Provider";
	 
	}elseif($row['place'] == 'Bank Transaction'){
	 
		$targetCategory  = 'Bank Transaction';
		$targetSubCategory  = "";
	 
	}elseif($row['place'] == 'Bank Transfer'){
		 
		$targetCategory  = 'Bank Transfer Between Account';
		$targetSubCategory  = "";
		
	}elseif($row['place'] == 'Office Expenses Transaction'){
		
		$rowTargetCategory  = $conn->selectRecord ("tbl_expense_categories","id  = ". $categoryId);
		$rowSubTargetCategory  = $conn->selectRecord ("tbl_expense_types","id  = ". $subCategoryId);

		$targetCategory  = $rowTargetCategory['name'];
		$targetSubCategory  = $rowSubTargetCategory['name'];
		
	}elseif($row['place'] == 'Incomes Transaction'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_income_categories","id  = ". $categoryId);
		$rowSubTargetCategory  = $conn->selectRecord ("tbl_income_types","id  = ". $subCategoryId);

		$targetCategory  = $rowTargetCategory['name'];
		$targetSubCategory  = $rowSubTargetCategory['name'];
		
	}elseif($row['place'] == 'Customer Payment Invoice'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_income_categories","id  = ". $categoryId);
		$rowSubTargetCategory  = $conn->selectRecord ("tbl_income_types","id  = ". $subCategoryId);

		$targetCategory  = $rowTargetCategory['name'];
		$targetSubCategory  = $rowSubTargetCategory['name'];
		
	}
	elseif($row['place'] == 'Dealer Transaction'){
		  
		$rowTargetCategory  = $conn->selectRecord ("tbl_dealers","id  = ". $categoryId);

		$targetCategory  = $rowTargetCategory['name'];
		$targetSubCategory  = "Dealer Transaction";
		
	}elseif($row['place'] == 'Procurement Assets'){
		 
		$rowTargetCategory  = $conn->selectRecord ("tbl_asset_types","id  = ". $categoryId);

		$targetCategory  = $rowTargetCategory['name'];
		$targetSubCategory  = "Procurement Assets";
		
	}
	$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
	$transactionType = $row['transaction_type'];
	$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
		
 	$objPHPExcel->getActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
	$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
 	$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowBank['name']);
 	$objPHPExcel->getActiveSheet()->setCellValue("D$i", ($transactionType == 1) ? 'Credit' : 'Debit');
	$objPHPExcel->getActiveSheet()->setCellValue("E$i",$rowCurrency['code']);
	$objPHPExcel->getActiveSheet()->setCellValue("F$i",$row['amount']);
	$objPHPExcel->getActiveSheet()->setCellValue("G$i",$row['rate']);
	$objPHPExcel->getActiveSheet()->setCellValue("H$i",$row['home_amount']);
	$objPHPExcel->getActiveSheet()->setCellValue("I$i",$row['place']);
	$objPHPExcel->getActiveSheet()->setCellValue("J$i",$targetCategory);
	$objPHPExcel->getActiveSheet()->setCellValue("K$i",$targetSubCategory);
 	$objPHPExcel->getActiveSheet()->setCellValue("L$i",$row['description']);
	
	
 	$count++;
	$i++;
	}
 


	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="All_Bank_Balance_reports.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	