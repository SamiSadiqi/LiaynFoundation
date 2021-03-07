<?php
	require_once("_header.php");
?>
<title><?php echo $pageTitle; ?></title>
<style>
@media print
	{
		.no-print, .no-print *{
			display:none !important;
		}
	}
	.left{
		text-align: justify;
		cursor:pointer;
	}
	
	#reports_left,tr,th,td{
		text-align:left;
	}
	
	@media print
	{
	  table { page-break-after:auto }
	  tr    { page-break-inside:avoid; page-break-after:auto; }
	  td    { page-break-inside:avoid; page-break-after:auto }
	  thead { display:table-header-group }
	  tfoot { display:table-footer-group }
	}
@media print {

   .dontPrint {
       display:none;
    }
	.printed{
		border:solid #000 !important;
		border-width:1px 0 0 1px !important;
		 border:solid #000 !important;
		border-width:0 1px 1px 0 !important;
	}
   }
	
	@media all{
		.page-break{display:none;}
	}
	@media print{
	.page-break{display:block;page-break-after:always;}
	.dote img {visibility: visible;}
	}
	 
@page{
   size: auto;   /* auto is the initial value */
    margin: 3mm;  /* this affects the margin in the printer settings */
 }
@media print {
    html, body {
        height: 99%;    
    }
}
 .fontM{
	border:solid #000 !important;
	border-width:1px 0 0 1px !important;
	border:solid #000 !important;
	border-width:0 1px 1px 0 !important;
 }
 .printed{
 	text-align:right;
}

</style>
</head>
<body>
<?php
		if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
			$factorRowId = decryptIt($_GET['id']);
		}else{
			$factorNmberWidthRowId = $_POST['name'];
			$factorRowIdExplode = explode("-",$factorNmberWidthRowId);
			$factorRowId = $factorRowIdExplode[0];				
 		}
		 
 		$vendorPayment = $conn->query("SELECT * FROM  tbl_vendor_payment WHERE id = $factorRowId  AND deleted = 0");
		$rowVendorPayment = $vendorPayment->fetch_array();
		$date = $rowVendorPayment['date'];
 		$factorNumber = $rowVendorPayment['factor_number'];
 		$paymentAmount = $rowVendorPayment['amount'];
 		$vendorId = $rowVendorPayment['vendors_id'];
  		$rowVendor = $conn->selectRecord ("tbl_vendors","id  =".$rowVendorPayment['vendors_id']);
		$fullName = $rowVendor['name'] ." ". $rowVendor['family'];
	 
		
?>
<!-- Page container -->
<div class="container" style='margin:0 auto;margin-top:20px;height:450px;border:1px solid black;'>

	<div class='row'>
	<table style='width:100%' dir='rtl' border='0'>
		<tr style=''>
			<td style='text-align:center;'>
				<!--- <img src ="../assets/icons/catton1.jpg" style='width:110px;height:90px;'> ---->
			</td>
			<td style='text-align:center;height:30px;line-height:20px;'>
 			<p>بنیاد لیان امیری</p>
			</td>
			<td style='text-align:center;'>
			<!--- 	<img src ="../assets/icons/catton2.png" style='width:110px;height:110px;'> ---->
			</td>
		</tr>
	</table>
		<h6 Style='margin-top:-25px;margin-left:20px;'><b>پرداختی به فروشنده گان</b></h6>
	<hr style='border:1px solid black;margin-top:-5px;'>
	<hr style='border:1px solid black;margin-top:-17px;'>
	</div>
	<?php
 		 
	 
	$selectCommingAmount  =$conn->query("select sum(amount)as comingAmount from tbl_vendor_statement where deleted='0' AND vendors_id='$vendorId' AND transaction_type='1'");
 	$rowCommingAmount = $selectCommingAmount->fetch_array();
	$commingAmount = $rowCommingAmount['comingAmount'];
	 
	$selectGoingAmount = $conn->query("select sum(amount)as goingAmount from tbl_vendor_statement where deleted='0' AND vendors_id='$vendorId' AND transaction_type='2'");
 	$rowGoingAmount = $selectGoingAmount->fetch_array();
	$goingAmount = $rowGoingAmount['goingAmount'];
 	
	 
	
	$blanceSheet  = $commingAmount - $goingAmount;
	 
	 
	?>
	<div class='row' style="height:30px;">
		 
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">نام فروشنده: &nbsp;&nbsp;<?php    echo  $fullName; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">تاریخ :<?php    echo $date; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">شماره فاکتور :<?php    echo $factorNumber; ?></div>
		
	</div>
	<div class='row'  >
		<table class='table-striped table-condensed table-bordered'  id='middleTable'     style='width:100%;border:1px solid black;'>
			 <tr>
			<th style='text-align:center;border:1px solid black;'>مقدار پرداختی</th><th  style='text-align:center;border:1px solid black;'>پرداختی به حروف </th><th  style='text-align:center;border:1px solid black;'>الباقی</th>
			</tr>	 
			<tr>
			<th  style='text-align:center;border:1px solid black;'><span class='adad'><?php  echo $paymentAmount;    ?> <span>&nbsp;</span></span></th><th  style='text-align:center;border:1px solid black;'><?php  echo convertNumberToWord($paymentAmount); ?></th><th  style='text-align:center;border:1px solid black;'><?php  echo $blanceSheet;   ?></th>
			</tr>
		</table>
		<br>
		<table class='table table-striped table-condenced'  border='1' style='width:55%;float:left;margin-top:0px;'  dir='ltr'>
			<tr>
			<td style='text-align:right;border:1px solid #FFF;'> 
			<p style='font-size:13px;font-weight:bold;'>آدرس: هرات - سرک باغ آزادی </p>
			 
			</td>
			</tr>
		</table>

 			
	</div>
</div>
<!-- /page container -->
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>
