<?php
	require_once("_header.php");
 	$companyName  = "Invoice";
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
		 
 		$vendorPayment = $conn->query("SELECT * FROM  tbl_service_payment WHERE id = $factorRowId  AND deleted = 0");
		$rowVendorPayment = $vendorPayment->fetch_array();
		$date = $rowVendorPayment['date'];
 		$factorNumber = $rowVendorPayment['factor_number'];
  		$paymentAmount = $rowVendorPayment['amount'];
 		$providerId = $rowVendorPayment['service_provider_id'];
  		$rowProvider = $conn->selectRecord ("tbl_service_provider","id  =".$rowVendorPayment['service_provider_id']);
		$fullName = $rowVendor['name'];
		$currencyId = $rowVendor['currencies_id'];
		
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  =".$currencyId);
		$currencyCode = $rowCurrency['code'];
	 

?>
<!-- Page container -->
<div class="container" style='margin:0 auto;margin-top:20px;height:450px;border:1px solid black;'>

	<div class='row'>
		<table style='width:100%' dir='rtl' border='0'>
			<tr style=''>
				<td style='text-align:center;'>
					<img src ="../assets/icons/catton1.jpg" style='width:110px;height:90px;'> 
				</td>
				<td style='text-align:center;height:30px;line-height:20px;'>
				<p>تولید نخ با کیفیت با استندردهای بین المللی</p>
				<P>حساب افغانی باختر بانک : <span class='adad'> 101201100165501</span></p>
				<P>حساب دالری باختربانک : <span class='adad'> 101201200169776</span></p>
				<P>حساب دالری باختربانک : <span class='adad'> 101201200169776</span></p>
				
				</td>
				<td style='text-align:center;'>
					<img src ="../assets/icons/catton2.png" style='width:110px;height:110px;'> 
				</td>
			</tr>
		</table>
			<h6 Style='margin-top:-25px;margin-left:20px;'><b>Service's Payment</b></h6>

		<hr style='border:1px solid black;margin-top:-5px;'>
		<hr style='border:1px solid black;margin-top:-17px;'>
	</div>
	<?php
	$selectCommingAmount  =$conn->query("select sum(amount)as comingAmount from tbl_service_provider_statement where deleted='0' AND service_provider_id ='$providerId' AND transaction_type='1'");
 	$rowCommingAmount = $selectCommingAmount->fetch_array();
	$commingAmount = $rowCommingAmount['comingAmount'];
	 
	$selectGoingAmount = $conn->query("select sum(amount)as goingAmount from tbl_service_provider_statement where deleted='0' AND service_provider_id ='$providerId' AND transaction_type='2'");
 	$rowGoingAmount = $selectGoingAmount->fetch_array();
	$goingAmount = $rowGoingAmount['goingAmount'];
	
	$blanceSheet  = $commingAmount - $goingAmount;
	?>
	<div class='row' style="height:50px;">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Serice Provider Name :<?php    echo $fullName; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Date :<?php    echo $date; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Factor Number :<?php    echo $factorNumber; ?></div>	 
	</div>
	<div class='row'>
		<table class='table-striped table-condensed table-bordered'  id='middleTable'     style='width:100%;border:1px solid black;'>
			 <tr>
			<th style='text-align:center;border:1px solid black;'>Payment Amount</th><th  style='text-align:center;border:1px solid black;'>Payment Amount In letters</th><th  style='text-align:center;border:1px solid black;'>Remain Amount</th>
			</tr>	 
			<tr>
			<th  style='text-align:center;border:1px solid black;'><span class='adad'><?php  echo $paymentAmount;    ?> <span>&nbsp;<?php echo $currencyCode;    ?></span></span></th><th  style='text-align:center;border:1px solid black;'><?php  echo convertNumberToWord($paymentAmount); ?></th><th  style='text-align:center;border:1px solid black;'><?php  echo $blanceSheet;   ?></th>
			</tr>
		</table>
		<br>
		<table class='table table-striped table-condenced'  border='1' style='width:55%;float:left;margin-top:0px;'  dir='ltr'>
			<tr>
			<td style='text-align:right;border:1px solid #FFF;'> 
			<p style='font-size:13px;font-weight:bold;'>آدرس هرات شهرک صنعتی</p>
			<P>شماره های تماس: <span class='adad' style='font-size:14px;'>0700402026 - 0799070444 - 0774313171</span></p>
			<p>  <span style='font-size:10px;'>جنس فروخته شده واپس گرفته نمیشود</span> Email: Rana.shahab@gmail.com  </p>
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
