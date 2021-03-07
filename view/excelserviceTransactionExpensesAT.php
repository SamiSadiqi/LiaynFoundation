<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/serviceTransactionExpensesReport.xls");

	$table="tbl_service_provider";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE deleted = 0 AND transaction_type = 1 ORDER BY id DESC ";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$serviceProviderId = $row['id'];
		
		$serviceProviderAssests = $conn->query("select * from tbl_service_payment  WHERE deleted = 0 AND service_provider_id = $serviceProviderId");
		while($serviceProviderRow = $serviceProviderAssests->fetch_array()){
				
		$rowProvider = $conn->selectRecord ("tbl_service_provider","id  = ". $serviceProviderRow['service_provider_id']);
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $serviceProviderRow['currencies_id']);
		$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $serviceProviderRow['banks_id']	);
		$totalUsd += $serviceProviderRow['home_amount'];	
		
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$serviceProviderRow['date']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowProvider['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$serviceProviderRow['factor_number']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",$serviceProviderRow['amount']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",$serviceProviderRow['rate']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",$rowBank['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",$serviceProviderRow['home_amount']);
		$objPHPExcel->getActiveSheet()->setCellValue("J$i",$serviceProviderRow['description']);
  		$count++;
		$i++;
	}
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="serviceTransactionExpenseReports.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	