<?php
	require_once("_header.php");
 	$formHeader  = "Banks Balance Sheet";
	require_once("../config/pdate.php");
	
?>
<title><?php echo $pageTitle; ?></title>

<style type="text/css">

    .bs-example{
    	margin: 20px;
    }
	
	@media print {
		.dontPrint {
			display:none;
		}
    }
	
	@media all{
		.page-break{display:none;}
	}
	
	@media print{
		.page-break{display:block;page-break-after:always;}
		.dote img {visibility: visible;}
	}
 
	@page {
		size: auto;   /* auto is the initial value */
		margin: 3mm;  /* this affects the margin in the printer settings */
	}
	
	@media print {
		html, body {
			height: 99%;    
		}
	} 
</style>
 
</head>


<body>
  
<!-- Page container -->
<div class="page-container">

	<!-- Main container -->
	<div class="main-container">
  
	
		<!-- Main content -->
		<div class="main-content">
			
			<div class="row">
			 
						<?php
							$bankId  = $conn->safeInput(decryptIt($_POST['bankId']));
						 
							if(isset($_POST['fromDate']) AND isset($_POST['toDate']) AND isset($_POST['bankId'])){
									$fromDate = $_POST['fromDate'];
									$toDate = $_POST['toDate'];
									listBalanceSheetBanks($fromDate,$toDate,$bankId);
							}else{
									listBalanceSheetBanks(0,0,$bankId);
							 
							}
 						?>
			</div>
			<!-- Footer -->
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
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
