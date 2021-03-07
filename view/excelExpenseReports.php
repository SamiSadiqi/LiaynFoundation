<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../Classes/PHPExcel.php';
	require_once("../Classes/PHPExcel/IOFactory.php");
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/expenseReportsExcel.xls");

	$table="tbl_expenses";
		$i=5;
		$count=1;
		
	 
	
	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC";
 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
	
	$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
	$rowExpenseCategory = $conn->selectRecord ("tbl_expense_categories","id  = ". $row['expense_category_id']);
	$rowExpenseType = $conn->selectRecord ("tbl_expense_types","id  = ". $row['expense_type_id']);
	$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
	$rowExpenser = $conn->selectRecord ("tbl_staff","id  = ". $row['expensers_id']);
		
 	$objPHPExcel->getActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
	$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
	$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowExpenseCategory['name']);
	$objPHPExcel->getActiveSheet()->setCellValue("D$i",$rowExpenseType['name']);
	$objPHPExcel->getActiveSheet()->setCellValue("E$i",$row['amount']);
 	$objPHPExcel->getActiveSheet()->setCellValue("F$i",$rowCurrency['code']);
	$objPHPExcel->getActiveSheet()->setCellValue("G$i",$row['rate']);
	$objPHPExcel->getActiveSheet()->setCellValue("H$i",$rowBank['name']);
	$objPHPExcel->getActiveSheet()->setCellValue("I$i",$row['home_amount']);
	$objPHPExcel->getActiveSheet()->setCellValue("J$i",$row['description']);
	
	
 	$count++;
	$i++;
	}
 


	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="expenseReportsExcel.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	