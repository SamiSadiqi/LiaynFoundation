<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/vendorLoanReports.xls");

	$table="tbl_vendors";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
		$vendorId = $row['id'];
		$selectSumVendorTransactionn  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='1'");
		$rowVendorTransaction = $selectSumVendorTransactionn->fetch_array();
		$incomeVendorTransaction = $rowVendorTransaction['home_amountIcome'];
		$totalIncome += $incomeVendorTransaction;
		
		$selectSumVendorTransactionnGoing  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='2'");
		$rowVendorTransactionGoing = $selectSumVendorTransactionnGoing->fetch_array();
		$outcomeVendorTransaction = $rowVendorTransactionGoing['home_amountIcome'];
		$totalOutcome +=  $outcomeVendorTransaction;
	 
		$blanceSheet  = $incomeVendorTransaction - $outcomeVendorTransaction;
		//self Currency 
		$selfVendorsQurey  = $conn->query("SELECT SUM(amount)as creditAmount FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='1'");
		$selfVendorFetch = $selfVendorsQurey->fetch_array();
		$selfVendorFetchTransaction = $selfVendorFetch['creditAmount'];
		$totalCreditSelf += $selfVendorFetchTransaction;
		
		$selfVendorsQueryDebit  = $conn->query("SELECT SUM(amount)as amountDebit FROM tbl_vendor_statement WHERE  deleted='0' AND vendors_id='$vendorId' AND transaction_type='2'");
		$selfVendorsDebitFetch = $selfVendorsQueryDebit->fetch_array();
		$vendorDebitTransaction = $selfVendorsDebitFetch['amountDebit'];
		$totalDebit +=  $vendorDebitTransaction;
	 
		$blanceSheetSelf  = $selfVendorFetchTransaction - $vendorDebitTransaction;
		
		$rowVendorType = $conn->selectRecord ("tbl_vendor_categories","id  = ". $row['vendor_type']);
		
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowCustomerType['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$row['contact']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",number_format($outcomeVendorTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",number_format($incomeVendorTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",number_format($blanceSheet,2));
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",number_format($vendorDebitTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("J$i",number_format($selfVendorFetchTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("K$i",number_format($blanceSheetSelf,2));
		$count++;
		$i++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="vendorLoanReports.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	