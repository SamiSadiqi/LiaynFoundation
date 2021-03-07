<?php  
	require_once("_header.php");
 	$formHeader  = "Bill";
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
 		$customerTitle = $conn->query("SELECT * FROM  tbl_customer_bill_title WHERE id = $factorRowId  AND deleted = 0");
		$rowCustomerTitle = $customerTitle->fetch_array();
		$date = $rowCustomerTitle['date'];
 		$factorNumber = $rowCustomerTitle['factor_number'];
		$customerId = $rowCustomerTitle['customers_id'];
		$factorPayment = $rowCustomerTitle['factor_payment'];
		$factorPrice   = $rowCustomerTitle['factor_price'];
		
 		$rowCustomer = $conn->selectRecord ("tbl_customers","id  =".$rowCustomerTitle['customers_id']);
		$fullName = $rowCustomer['name'] ." ". $rowCustomer['family'];
		$currencyId  = $rowCustomer['currencies_id'];
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  =".$currencyId);
		$currencyCode = $rowCurrency['code'];
		 
 
?>
<!-- Page container -->
<div class="container" style="margin-top:20px;">
	<div class='row'>
		<table style='width:100%' dir='ltr' border='0'>
			<tr style=''>
				<td style='text-align:center;'>
					<img src ="../assets/icons/catton1.jpg" style='width:120px;height:110px;padding-bottom:10px;'> 
				</td>
				
				<td style='text-align:center;height:30px;line-height:20px;'>
				<P style='font-weight:30px;font-weight:bold;font-size:30px;font-height:4px;'><?php  echo $companyName;   ?></P>
				<p>تولید کننده با کیفیت ترین نخ افغانستان در هرات </p>
				<p>صادر کننده نخ به کشورهای نظیر چین و ترکمنس</P>
				<P>حساب افغانی باختر بانک : <span class='adad'> 101201100165501</span></p>
				<P>حساب دالری باختربانک : <span class='adad'> 101201200169776</span></p>
				
				</td>
				
				<td style='text-align:center;'>
					<img src ="../assets/icons/catton2.png" style='width:120px;height:110px;'> 
				</td>
				
			</tr>
		</table>
		<h6 Style='float:left;margin-top:-30px;'><b>Invoice</b></h6>
		<hr style='border:1px solid black;margin-top:-5px;'>
		<hr style='border:1px solid black;margin-top:-17px;'>
	</div>
	<!--- This portion has created now-->
	<div class='row' style="height:50px;">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Vendor Name :<?php    echo $fullName; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Date :<?php    echo $date; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Factor Number :<?php    echo $factorNumber; ?></div>	 
	</div>
	<div class='row'>
		<table class='table-striped table-condensed table-bordered'  id='middleTable'     style='width:100%;border:1px solid black;border:radius:10px;' dir='ltr'>
			<thead>
				<tr>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;width:20px;'>No</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>Item</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>Unit</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>Quantity</td>
					<td  class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>Unit Price</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>Total</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>description</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$customerDetails = $conn->query("SELECT * FROM  tbl_customer_bill_details WHERE deleted ='0' AND  title_bills_id = '$factorRowId'");				
				$i=0;
				while($customerRow = $customerDetails->fetch_array()){	
				
						$rowItems = $conn->selectRecord ("tbl_items","id  = ". $customerRow['items_id']);
						$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $customerRow['items_unit_id']);
				?>
			 
				<tr>
				  <td class='fontM bgcol'><?php echo  ++$i;   ?></td>						
				  <td class='fontM bgcol'><?php echo  $rowItems['name']; ?></td>						
				  <td class='fontM bgcol'><?php echo  $rowUnits['name']; ?></td>						
				  <td class='fontM bgcol'><?php echo $customerRow['amount'];?></td>						
				  <td class='fontM bgcol'><?php echo $customerRow['fee'];?></td>						
				  <td class='fontM bgcol'><?php echo $customerRow['total_amount'];?></td>						
				  <td class='fontM bgcol'><?php  echo $customerRow['description'];?></td>						
				</tr>
				<?php	  
					}	
				?>
			</tbody>
		</table>
		<br>
		<table class='table table-striped table-condenced'  border='1' style='width:50%; margin-top:-15px;'>
			<tr class='fontM'><td class='fontM' style='width:50%;text-align:center;'>Total Amount in Letters</td><td class='fontM'  ><?php echo  convertNumberToWord($factorPrice)." ".$currencyCode;?></td></tr>
			<tr><td  class='fontM'  style='width:40%;text-align:center;'>Total Amount</td><td class='number fontM'  ><?php   echo number_format($factorPrice,2)."&nbsp;&nbsp;&nbsp;";   ?></td></tr>
			<tr><td  class='fontM'  style='width:40%;text-align:center;'>Payment Amount</td><td class='number fontM'  ><?php    echo number_format($factorPayment,2)."&nbsp;&nbsp;&nbsp;";    ?></td></tr>
			<tr><td  class='fontM'  style='width:40%;text-align:center;'>Remain Amount</td><td class='number fontM' ><?php    echo number_format($factorPrice - $factorPayment,2)."&nbsp;&nbsp;&nbsp;";  ?></td></tr>
		</table>
	</div>
   
</div>
<!-- /page container -->
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>