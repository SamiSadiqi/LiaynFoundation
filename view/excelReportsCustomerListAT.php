<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/customerListReports.xls");

	$table="tbl_customers";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
		$rowCustomerType = $conn->selectRecord ("tbl_customer_categories","id  = ". $row['customer_type']);
			
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowCustomerType['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$row['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$row['contact']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",$row['opening_balance']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",$row['rate']);
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",$row['address']);
		$count++;
		$i++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="CustomerListReport.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	