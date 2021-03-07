<?php
	require_once("_header.php");
 	$formHeader  = "All Stock Outdated";
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
			
				<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
					<h1 class="text-center"><?php echo $companyName; ?></h1>
				
					<h3 class="text-center"> All Oudated Requested</h3>
					<h4 class="text-center"> <?php  echo date("d-M-Y");   ?></h4>
				</div>
				 
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
					$itemsId = $_GET['id'];
					$table  = "tbl_stock_balance";       
					$targetPage = "viewAllStockBalamceOutdatedAT.php";    
					$limit      = 35;  
				 
					$row_count_sql  = $conn->query("SELECT * FROM tbl_stock_balance  ORDER BY id DESC");
					 
					$row_count_row  = $row_count_sql->fetch_array();
					$totalPages    = $row_count_row['totalRows'];
					
					$stages = 3;

					$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
					$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
	 
					//Get Page Data
					$requestRawSQLQuery    = "SELECT * FROM tbl_stock_balance ORDER BY id DESC LIMIT $start, $limit";
					$requestSQLQuery       = $conn->query($requestRawSQLQuery);
					
					if ($requestSQLQuery->num_rows > 0) {
					?>
					<div class="panel-body" id="page-content"> 
						<div class="form-group dontPrint"> 
							<label class="col-lg-8 col-md-6 col-sm-4control-label" for="search"></label> 
							<div class="col-lg-4 col-md-6 col-sm-8"> 
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
 
							 </div> 
						</div>
						<table  class="table table-striped table-bordered" id ="example" >
							<thead>
								<tr>
									<th class="small text-center">No</th>
									<th class='text-center'>Name</th>
									<th class='text-center'>Unit</th>
									<th class='text-center'>Category</th>
									<th class='text-center'>Total Amount In All Stock</th>
									<th class='text-center'>Minimum</th>
									<th class='text-center'>Description</th>
									<th class='text-center'>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$counter = $start;
									while($row = $requestSQLQuery->fetch_array()){
										++$counter;
 										$rowItems = $conn->query("SELECT * from tbl_items where deleted = 0 AND id = ".$row['items_id']);
										$fetchSumAmount = $rowItems->fetch_array();
										
										$minimum  = $fetchSumAmount['minimum']; 

										$unitName     = $conn->selectRecord("tbl_item_units","id = " . $fetchSumAmount['item_units_id']);
										$categoryName = $conn->selectRecord("tbl_item_categories", "id = " . $fetchSumAmount['item_categories_id']);
										
										?>
										<tr <?php if($row['amount']  < $minimum){ echo "style='color:red;'"; }  ?>>
 											<td class="small text-center "><?php echo $counter; ?></td>
											<td class='text-center'><?php echo $fetchSumAmount['name']; ?></td>
											<td class='text-center'><?php echo $unitName['name']; ?></td>
											<td class='text-center'><?php echo $categoryName['name']; ?></td>
											<td class='text-center'><?php echo $row['amount']; ?></td>
											<td class='text-center '><?php echo $fetchSumAmount['minimum']; ?></td>
											<td class='text-center'><?php echo $fetchSumAmount['description']; ?></td>
											<td class='text-center'><?php if($row['amount']  < $minimum){ echo "<span class='text-danger' style='text-decoration:underline'> <b> Red Zone </b> </span>";}else { echo "<span class='text-success'>Green Zone</span>"; }?></td>
 										 </tr>
								<?php 
									}
								?>
							</tbody>
							 
							<?php
							// Initial page num setup
							if ($page == 0){
								$page = 1;
							}

							$prev     = $page - 1;  
							$next     = $page + 1;                          
							$lastpage = ceil($totalPages/$limit);      
							$LastPagem1 = $lastpage - 1;                    
							
							$paginate = '';

							if($lastpage > 1){
								$paginate .= "<div class='paginate'>";
								
								// Previous
								if ($page > 1){
									$paginate.= "<a href='$targetPage?page=$prev'>قبلی</a>";
								}else{
									$paginate.= "<span class='disabled'>قبلی</span>";
								}
							   
								// Pages  
								if ($lastpage < 7 + ($stages * 2)){     // Not enough pages to breaking it up  
									for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $page){
											$paginate.= "<span class='current'>$counter</span>";
										}else{
											$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
									}
								}elseif($lastpage > 5 + ($stages * 2)){ // Enough pages to hide a few?
									// Beginning only hide later pages
									if($page < 1 + ($stages * 2))        {
										for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}

										$paginate.= "...";
										$paginate.= "<a href='$targetPage?page=$LastPagem1'>$LastPagem1</a>";
										$paginate.= "<a href='$targetPage?page=$lastpage'>$lastpage</a>";       
									}elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){ // Middle hide some front and some back
										$paginate.= "<a href='$targetPage?page=1'>1</a>";
										$paginate.= "<a href='$targetPage?page=2'>2</a>";
										$paginate.= "...";
										for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}
										$paginate.= "...";
										$paginate.= "<a href='$targetPage?page=$LastPagem1'>$LastPagem1</a>";
										$paginate.= "<a href='$targetPage?page=$lastpage'>$lastpage</a>";       
									}else{ // End only hide early pages
										$paginate.= "<a href='$targetPage?page=1'>1</a>";
										$paginate.= "<a href='$targetPage?page=2'>2</a>";
										$paginate.= "...";
										for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
											if ($counter == $page){
												$paginate.= "<span class='current'>$counter</span>";
											}else{
												$paginate.= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
										}
									}
								}
											
								// Next
								if ($page < $counter - 1){ 
									$paginate.= "<a href='$targetPage?page=$next'>بعدی</a>";
								}else{
									$paginate.= "<span class='disabled'>بعدی</span>";
								}
									
								$paginate.= "</div>";       
							}
							
							$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalPages;
							$start = ($start == 0) ? $start = ++$start : $start = $start;
						?>
						</table>
					</div>
				
					<div>
						<div class="col-md-6 col-sm-12 dontPrint" style="padding-top: 5px;color: #aaa; float: left">Showing<span class="adad"> <?php echo $start . '</span> Up to <span class="adad">' . $end; ?></span></div>
						<div class="col-md-6 col-sm-12 p-number dontPrint" id="retrieved_info" style="float: right"><span class='adad'><?php echo $paginate ?></span></div>
					</div>
					<?php   }  ?>
				
				</div>
			</div>
			<!-- Footer -->
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
					<div class="footer-main animated fadeInUp slow rtl" >  <span class="number">1.0.0</span> copyright&copy; <span class="number">2018</span> <h5 style="display: inline-block;">developed by: Abdul Sami Sadiqi</div> 			
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
