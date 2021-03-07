<?php
	require_once("_header.php");
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
						
			<h1 class="text-center"><?php echo $companyName; ?></h1>
			<div class="row panel-body">
			
				<div class="row">
    	            <div class="form-group dontPrint"> 
    					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
						<!--
							<form method="post" action="exportExcelSheetProjects.php">
    						 <input type="submit" name="export" class="btn btn-primary" value="Export" />
    					    </form>
						-->
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
					listCustomersReport('customerListReportETQ.php');
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
