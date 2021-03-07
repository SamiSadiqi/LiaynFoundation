<?php
	require_once("_header.php");
	$menu = "banksAT";
	$formHeader  = "بانک ترانزکش";
	$temp             = explode("-", $_SESSION['bank']);
	$bankId           = $temp[0];
		
	$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $bankId);
 ?>
<title><?php echo $pageTitle; ?></title>
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
			<li class="active"><i class="fa fa-list-ul"></i>بانکداری</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $formHeader.": <span style='font-weight:bold'>". $bankName."</span>"; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
							<?php   goBackward('bankHomeETQ.php');  ?>

						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
													
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">از تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="از تاریخ" autocomplete="off" id="fromDate" data-select='datepicker' name="fromDate" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="data">الی تاریخ</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تا تاریخ" autocomplete="off" id="toDate"  data-select='datepicker' name="toDate" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							
							<?php
								SearchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						<div class="row">
							<div class="form-group dontPrint"> 
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
								  <form method="post" action="excelExportBankTransactionsACI.php">
									<input type="hidden" name="bankId" class="btn btn-primary" value="<?php  echo $bankId;  ?>" />
									 <input type="submit" name="export" class="btn btn-primary" value="دانلود فایل اکسیل" />
									</form>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
								 
								 </div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
									<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
									<p class="help-block"></p>

								 </div>
							</div>
						</div>
						<?php
							if(isset($_POST['fromDate']) AND isset($_POST['toDate'])){
									$fromDate = $_POST['fromDate'];
									$toDate = $_POST['toDate'];
									listBankTransactionsList($fromDate,$toDate,$bankId);
							}else{
									listBankTransactionsList(0,0,$bankId);
							 
							}
 						?>
						
					</div> 
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
<script>

	
	$("#search").keyup(function () {
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });
});
 
	 
</script>

</body>
</html>	