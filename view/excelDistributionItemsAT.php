<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/excelDistributionItemsAT.xls");

	$table="tbl_donations_materials_title";
		$i=5;
		$count=1;
 	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		 
		$rowMaterialsBanks = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
		$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
		$titleId = $row['id'];
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowSchools['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$rowMaterialsBanks['name']);
  		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$row['factor_price']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",$row['request_number']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",$row['description']);
		$objPHPExcel->getActiveSheet()->setCellValue("HJ$i",$row['address']);
		 
		$i++;
		$count++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="distributionMaterialsList.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	