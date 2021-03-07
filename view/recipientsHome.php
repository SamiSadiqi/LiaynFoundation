<?php
	require_once("_header.php");
	$menu = "helpingAT";
	$formHeader = "حسابات کمک گیرنده";
	if(isset($_POST['name'])){
		$_SESSION['recipientsId'] = $_POST['name'];
		$temp                 = explode("-", $_SESSION['recipientsId']);
		$recipientId           = $temp[0];
		$serviceProviderName         = $temp[1];
    }else{
		$temp                 = explode("-", $_SESSION['recipientsId']);
		$recipientId           = $temp[0];
		$serviceProviderName         = $temp[1];
	}
	
	$rowRecipientsQuery    = $conn->selectRecord("tbl_recipients", "id = " . $recipientId);
	$rowInterfaceQuery    = $conn->selectRecord("tbl_interface", "id = " . $rowRecipientsQuery['interface_id']);

 ?>
<title><?php echo $pageTitle; ?></title>
<style>
 
</style>
</head>
<body>

<!-- Page container -->
<div class="page-container">

  <!-- Page Sidebar -->
  <div class="page-sidebar">
  
  <?php
  	require_once("_navigation.php");
  ?>
  				
  </div>
  <!-- /page sidebar -->
  
  <!-- Main container -->
  <div class="main-container">
  
	<!-- Main header -->
    <div class="main-header row">
    
    <?php
    	require_once("_top.php");
    ?>
    
    </div>
	<!-- /main header -->
	
	<!-- Main content -->
	<div class="main-content">
		<!-- <h1 class="page-title"></h1> -->
		<!-- Breadcrumb -->
		<ol class="breadcrumb breadcrumb-2"> 
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Service Provider Account</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title">نام کمک گیرنده&nbsp;:  &nbsp; <?php echo $serviceProviderName;?> </div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<?php
 						$selectSumHelpingAmountQuery = $conn->query("SELECT SUM(amount) as helpingAmount FROM tbl_recipients_payment where recipients_id = $recipientId AND deleted = 0");
						$totalHelpAmountRow = $selectSumHelpingAmountQuery->fetch_array();
						$totalHelpAmount = $totalHelpAmountRow['helpingAmount'];
						   
					?>
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="">
								<table  class="table table-hover"  id='table-border'>
									<tr>
										<td colspan="2" style="text-align:center;">خلاصه کمک ها</td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">نام کمک گیرنده</th>
										<td class="text-center"><?php  echo  $serviceProviderName;    ?></td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">شماره تماس</th>
										<td class="text-center"><?php  echo  $rowRecipientsQuery['contact'];    ?></td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">رابط</th>
										<td class="text-center"><?php  echo  $rowInterfaceQuery['name'];    ?></td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">درجه فقر</th>
										<td class="text-center"><?php  if($rowRecipientsQuery['poverty_degree'] == 1){ echo "شدید";}elseif($rowRecipientsQuery['poverty_degree'] == 2){ echo "متوسط";}elseif($rowRecipientsQuery['poverty_degree'] == 3){ echo "خوب";}    ?></td>
									</tr>
									<tr>
										<th class="text-center" style="width:50%">مجموعه کمک ها</th>
										<td class="text-center"><?php  echo  number_format($totalHelpAmount,0);    ?></td>
									</tr>
								 
								</table>
							</div>
						 
					 
						 
						</div>
					</div> 
					<?php
						$rowCheckData    = $conn->query("SELECT * FROM tbl_recipients_payment WHERE recipients_id = $recipientId AND  deleted = 0");
 						if($rowCheckData->num_rows > 0){
					?>	
					<div class="panel-body " id="page-content" style="overflow-x:scroll;"> 
										
						<table  class="table table-responsive table-bordered table-hover"  style="border:1px solid black;" >
						<thead>
							<tr>
							<th class="text-center table-title" colspan="15">
							<span style='font-size:bold'>  دفعات کمک </span> <span style="color:red;font-size:20px">   <?php echo $rowCeremoniesTitle['name'];  ?>   </span></b>
							</th>
							</tr>
							<tr class="table-header">
								<th class="small text-center">شماره</th>
								<th class='text-center'>تاریخ</th>
								<th class='text-center'>نام کمک گیرنده</th>
								<th class='text-center'>مقدار کمک</th>
								<th class='text-center'>بانک</th>
								<th class='text-center'>فایل</th>
								<th class='text-center'>توضیحات</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$counter2 = 0;
 								$helpingQuery    = $conn->query("SELECT * FROM tbl_recipients_payment WHERE recipients_id = $recipientId AND  deleted = 0 ORDER BY id desc");
								while($row = $helpingQuery->fetch_array()){
										$counter2++;
										$rowRecipients     = $conn->selectRecord("tbl_recipients","id = " . $row['recipients_id']);
										$rowBank    = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
										$totalHelpingAmount += $row['amount'];
							?>
							
								<tr>
									<td class="small text-center "><?php echo $counter2; ?></td>
									<td class='text-center'><?php echo $row['date']; ?></td>
									<td class='text-center'><?php echo $rowRecipients['name']; ?></td>
									<td class='text-center'><?php echo $row['amount']; ?></td>
									<td class='text-center'><?php echo $rowBank['name']; ?></td>
									<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
									<td class='text-center'><?php echo $row['description']; ?></td>
								</tr>
							<?php
								}
							?>
							<tr style="border:1px solid black;">
								<td colspan="3" class='text-center'><b> مجموعه</b></td>
								<td class='text-center'><?php  echo number_format($totalHelpingAmount,2);   ?></td>
							</tr>
							
						</tbody>
					</table>
 					</div>	
						<?php  } ?>					
				</div> 
			</div>
		</div>
		<!-- Footer -->
		<footer class="animatedParent animateOnce z-index-10"> 
		
		<?php
			require_once("_footer.php");
		?>
		
		</footer>	
		<!-- /footer -->
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<?php
	require_once("_extraScripts.php");	
?>
 
</body>
</html>