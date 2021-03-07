<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/bankTransactionDebitedReport.xls");

	$table="tbl_bank_statement";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE deleted = 0 AND transaction_type = 2 AND place='Bank Transaction' ORDER BY id DESC ";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
		
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$row['place']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$row['amount']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$rowBank['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",$row['rate']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",$row['home_amount']);
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",$row['description']);
  		$count++;
		$i++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="bankTransactionCredited.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	