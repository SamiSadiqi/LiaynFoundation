<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	
	require_once '../classes/PHPExcel.php';
	require_once("../classes/PHPExcel/IOFactory.php");
 
	$objPHPExcel =  new PHPExcel();
 	$objPHPExcel = PHPExcel_IOFactory::load("../excelTemplateReports/customerLoanReports.xls");

	$table="tbl_customers";
		$i=5;
		$count=1;
	$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC";

 	$selectDataQueryRow = $conn->query($selectDate);
	while($row=$selectDataQueryRow->fetch_array()){
		
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
		$customerId = $row['id'];
		
		$selectSumCustomerTransactionn  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='1'");
		$rowCustomerTransaction = $selectSumCustomerTransactionn->fetch_array();
		$incomeCustomerTransaction = $rowCustomerTransaction['home_amountIcome'];
		$totalIncome += $incomeCustomerTransaction;
		
		$selectSumCustomerTransactionnGoing  =$conn->query("SELECT SUM(home_amount)as home_amountIcome FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='2'");
		$rowCustomerTransactionGoing = $selectSumCustomerTransactionnGoing->fetch_array();
		$outcomeCustomerTransaction = $rowCustomerTransactionGoing['home_amountIcome'];
		$totalOutcome +=  $outcomeCustomerTransaction;
	
	 
		$blanceSheet  = $outcomeCustomerTransaction - $incomeCustomerTransaction;
		
		
		//--------------------------self Currency ------------
			
		$sumIncomeCustomerTransaction  =$conn->query("SELECT SUM(amount)as totalCredit FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='1'");
		$sumIncomeCustomerFetch = $sumIncomeCustomerTransaction->fetch_array();
		$incomeCustomerData = $sumIncomeCustomerFetch['totalCredit'];
		$totalCredit += $incomeCustomerData;
		
		$sumDebitCustomerTransaction  =$conn->query("SELECT SUM(amount)as debitAmount FROM tbl_customer_statement WHERE  deleted='0' AND customers_id='$customerId' AND transaction_type='2'");
		$rowCustomerTransactionDebit = $sumDebitCustomerTransaction->fetch_array();
		$outcomeCustomerTransactionDebit = $rowCustomerTransactionDebit['debitAmount'];
		$totalDebit +=  $outcomeCustomerTransactionDebit;
		
 		$rowCustomerType = $conn->selectRecord ("tbl_customer_categories","id  = ". $row['customer_type']);
			
	 
		$blanceSheetSelfCurrency  = $totalDebit - $totalCredit;
		
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue("A$i",$count);
		$objPHPExcel->getActiveSheet()->setCellValue("B$i",$row['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$i",$rowCustomerType['name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$i",$row['contact']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$i",$rowCurrency['code']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$i",number_format($outcomeCustomerTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("G$i",number_format($incomeCustomerTransaction,2));
		$objPHPExcel->getActiveSheet()->setCellValue("H$i",number_format($blanceSheet,2));
		$objPHPExcel->getActiveSheet()->setCellValue("I$i",number_format($outcomeCustomerTransactionDebit,2));
		$objPHPExcel->getActiveSheet()->setCellValue("J$i",number_format($incomeCustomerData,2));
		$objPHPExcel->getActiveSheet()->setCellValue("K$i",number_format($blanceSheetSelfCurrency,2));
		$count++;
		$i++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="CustomerListReport.xls"');
	header('Cache-Control: max-age=0');
	
	$writter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');	
	$writter->save('php://output');
	exit;	