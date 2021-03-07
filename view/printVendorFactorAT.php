<?php  
	require_once("_header.php");
 	$formHeader  = "فاکتور خریداری";
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
 		$vendorTitle = $conn->query("SELECT * FROM  tbl_vendor_bill_title WHERE id = $factorRowId  AND deleted = 0");
		$rowVendorTitle = $vendorTitle->fetch_array();
		$date = $rowVendorTitle['date'];
 		$factorNumber = $rowVendorTitle['factor_number'];
 		$factorPayment = $rowVendorTitle['factor_payment'];
 		$totalFactorPrice = $rowVendorTitle['factor_price'];
		$vendorId = $rowVendorTitle['vendors_id'];
 		$rowVendor = $conn->selectRecord ("tbl_vendors","id  =".$rowVendorTitle['vendors_id']);
		$fullName = $rowVendor['name'] ." ". $rowVendor['family'];
		 
		 

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
				<p>خریداری اقلام </p>
			 
				<P></p>
				<P></p>
				
				</td>
				
				<td style='text-align:center;'>
					<img src ="../assets/icons/catton2.png" style='width:120px;height:110px;'> 
				</td>
				
			</tr>
		</table>
		<h6 Style='float:left;margin-top:-30px;'><b>فاکتور خرید</b></h6>
		<hr style='border:1px solid black;margin-top:-5px;'>
		<hr style='border:1px solid black;margin-top:-17px;'>
	</div>
	<!--- This portion has created now-->
	<div class='row' style="height:50px;">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">نام فروشنده :<?php    echo $fullName; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">تاریخ :<?php    echo $date; ?></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">شماره فاکتور :<?php    echo $factorNumber; ?></div>	 
	</div>
	<div class='row'>
		<table class='table-striped table-condensed table-bordered'  id='middleTable'     style='width:100%;border:1px solid black;border:radius:10px;' dir='RTL'>
			<thead>
				<tr>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;width:20px;'>شماره</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>نام کالا</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>واحد</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>مقدار</td>
					<td  class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>فی واحد</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>مجموعه</td>
					<td class='fontM bgcol' style='text-align:center;background-color:#f1f1f1;'>توضیحات</td>
				</tr>
			</thead>
			<tbody>
				<tbody>
				<?php
			 
				$vendorDetails = $conn->query("SELECT * FROM  tbl_vendor_bill_details WHERE deleted ='0' AND  title_bills_id = '$factorRowId'");				
				$i=0;
				while($vendorRow = $vendorDetails->fetch_array()){	
				
					$rowItems = $conn->selectRecord ("tbl_items","id  = ". $vendorRow['items_id']);
					$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $vendorRow['items_unit_id']);
					?>
						<tr>
						  <td class='fontM bgcol text-center'><?php echo  ++$i;   ?></td>						
						  <td class='fontM bgcol text-center'><?php echo  $rowItems['name']; ?></td>						
						  <td class='fontM bgcol text-center'><?php echo  $rowUnits['name']; ?></td>						
						  <td class='fontM bgcol text-center'><?php echo $vendorRow['amount'];?></td>						
						  <td class='fontM bgcol text-center'><?php echo $vendorRow['fee'];?></td>						
						  <td class='fontM bgcol text-center'><?php echo $vendorRow['total_amount'];?></td>						
						  <td class='fontM bgcol text-center'><?php echo $vendorRow['description'];?></td>						
						</tr>
					<?php	  
					}	
			?>	
		
			</tbody>
		</table>
		<br> 
	 
			<table class='table table-striped table-condenced'  border='1' style='width:50%; margin-top:-15px;'>
				<tr class='fontM'><td class='fontM' style='width:50%;text-align:center;'>کل قیمت به حروف</td><td class='fontM'  ><?php echo  convertNumberToWord($factorPayment)." ".$mainCurrencyCode;?></td></tr>
				<tr><td  class='fontM text-center'  style='width:40%;'>کل قیمت</td><td class='number fontM'  ><?php   echo number_format($totalFactorPrice,2)."&nbsp;&nbsp;&nbsp;";   ?></td></tr>
				<tr><td  class='fontM text-center'  style='width:40%;'>مقدار پرداختی</td><td class='number fontM'  ><?php    echo number_format($factorPayment,2)."&nbsp;&nbsp;&nbsp;";    ?></td></tr>
				<tr><td  class='fontM text-center'  style='width:40%;'>الباقی</td><td class='number fontM' ><?php    echo number_format($totalFactorPrice - $factorPayment,2)."&nbsp;&nbsp;&nbsp;";  ?></td></tr>
			</table>
				 
	</div>
</div>
<!-- /page container -->
<?php
	require_once("_extraScripts.php");	
?>

</body>
</html>