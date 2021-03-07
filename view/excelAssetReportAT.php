<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/assetListReport.xls");

	$table="tbl_assets";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$assetRow            = $conn->selectRecord("tbl_asset_types", "id = " . $row['asset_types_id']);
		$rowCurrency         = $conn->selectRecord("tbl_currencies", "id = " . $row['currencies_id']);
		$rowBank        	 = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
	
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['date']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$assetRow['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$row['rate']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",$row['cost']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",$row['home_amount']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",$rowBank['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",$row['useful_age']);
		$objPHPExcel->getActiveSheet()->setCellValue("J$i",$row['description']);
  		$count++;
		$i++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="assetListReport.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	