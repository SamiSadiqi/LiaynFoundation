<?php
	require_once("_header.php");
 	$formHeader  = "راپور بلانس گدام ها ";
	$stockId = $_POST['stockId'];
 	$itemId = $_POST['itemId'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
 
    
    	$rowStock = $conn->selectRecord ("tbl_stocks","id  = ".$stockId);
		$rowItems = $conn->selectRecord ("tbl_items","id  = ".$itemId); 
		if($stockId == 'all' && $itemId == 'all' &&  empty($fromDate)  && empty($toDate)){
				$title = "موجودی کل اجناس به کل گدام ها ";
				
		}elseif($stockId == 'all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
				$title = "همه <b> ".$rowItems['name'] ."</b>  به تما گدام ها <b> ".$fromDate." </b>الی<b> ".$toDate." </b>";
		     
		}elseif($stockId == 'all' && $itemId != 'all' &&  empty($fromDate)  && empty($toDate)){
				$title = "همه <b> ".$rowItems['name'] ."</b>   به کل گدام ها";
		     
		}elseif($stockId !='all' && $itemId == 'all'  &&  !empty($fromDate)  && !empty($toDate)){

		            $title = "کل اجناس به <b> ".$rowStock['name'] ."</b> از  <b> ".$fromDate." </b> الی <b> ".$toDate." </b>";
		      
 		}elseif($stockId !='all' && $itemId == 'all'  && empty($fromDate) && empty($toDate) ){
 		  
		            $title = "کل موجودی اجناس به <b> ".$rowStock['name'] ."</b>";
					
 		}elseif($stockId !='all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
 		    
			  $title = "کل <b>".$rowItems['name'] ."</b> به <b>".$rowStock['name']." </b>  از <b> ".$fromDate." </b> الی <b> ".$toDate." </b>";
			  
 		}elseif($stockId !='all' && $itemId != 'all'  && empty($fromDate) && empty($toDate)){
 		    
			  $title = "کل <b>".$rowItems['name'] ."</b> به <b>".$rowStock['name']." </b>";
 		}
	 
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
				
					<h3 class="text-center"><?php  echo $title;  ?></h3>
				
					
				
 				</div>
				 
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						 
						$table      = "tbl_stock_statement";       
						$targetPage = "stockWarehouseBalanceSheetRotationAT.php";    
						$limit      = 400000;   
						 
					   
						if($stockId == 'all' && $itemId == 'all' &&  empty($fromDate)  && empty($toDate)){
						     
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE deleted = 0 ORDER BY id DESC");
							
						}elseif($stockId == 'all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE items_id = '$itemId' AND deleted = 0 AND  date between '$fromDate' AND '$toDate' ORDER BY id DESC");
						}elseif($stockId == 'all' && $itemId != 'all' &&  empty($fromDate)  && empty($toDate)){
						    
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE items_id = '$itemId' AND deleted = 0  ORDER BY id DESC");
						}elseif($stockId !='all' && $itemId == 'all'  &&  !empty($fromDate)  && !empty($toDate)){
						    
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE stocks_id = '$stockId' AND deleted = 0 AND  date between '$fromDate' AND '$toDate' ORDER BY id DESC");
						}elseif($stockId !='all' && $itemId == 'all'  && empty($fromDate) && empty($toDate) ){
						   
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE stocks_id = '$stockId' AND deleted = 0 ORDER BY id DESC");
						}elseif($stockId !='all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
        					 
    						$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE stocks_id = '$stockId' AND items_id = '$itemId' AND deleted = 0 AND  date between '$fromDate' AND '$toDate'  ORDER BY id DESC");
						}elseif($stockId !='all' && $itemId != 'all'  && empty($fromDate) && empty($toDate)){
						           
						    $row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE stocks_id = '$stockId' AND items_id = '$itemId' AND deleted = 0 ORDER BY id DESC");
						}
						
			 					
						
                        $row_count_row  = $row_count_sql->fetch_array();
                        $totalPages    = $row_count_row['totalRows'];
						
						$stages = 3;
				    	$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
	                	$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
						
						//Get Page Data
						if($stockId == 'all' && $itemId == 'all' &&  empty($fromDate)  && empty($toDate)){
						    
						     $stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
							
						}elseif($stockId == 'all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
						     $stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND items_id = '$itemId' AND date between '$fromDate' AND '$toDate' ORDER BY id DESC LIMIT $start, $limit";
						
						}elseif($stockId == 'all' && $itemId != 'all' &&  empty($fromDate)  && empty($toDate)){
						    
							$stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND items_id = '$itemId' ORDER BY id DESC LIMIT $start, $limit";
						
						}elseif($stockId !='all' && $itemId == 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
						   $stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND stocks_id = '$stockId' AND date between '$fromDate' AND '$toDate' ORDER BY id DESC LIMIT $start, $limit";
						
						}elseif($stockId !='all' && $itemId == 'all' && empty($fromDate) && empty($toDate)){
						    
							$stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND stocks_id = '$stockId' ORDER BY date DESC LIMIT $start, $limit";
						
						}elseif($stockId !='all' && $itemId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
							$stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND stocks_id = '$stockId' AND items_id = '$itemId'  AND  date between '$fromDate' AND '$toDate' ORDER BY id DESC LIMIT $start, $limit";

						}elseif($stockId !='all' && $itemId != 'all'  && empty($fromDate) && empty($toDate) ){
						    
							$stocksBalanceSheetQuery    = "SELECT * FROM $table WHERE deleted = 0 AND stocks_id = '$stockId' AND items_id = '$itemId' ORDER BY id DESC LIMIT $start, $limit";
						}
					 
						$stockBalanceSheetRow       = $conn->query($stocksBalanceSheetQuery);
						
						if ($stockBalanceSheetRow->num_rows > 0) {
					?>
				 
					<div class="panel-body table-responsive " id="page-content"> 
						<div class="form-group dontPrint"> 
    						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
							<!--
							  <form method="post" action="excelExpenseReports.php">
        						 <input type="submit" name="export" class="btn btn-primary" value="Export" />
        					    </form>
								
							--->
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
 
							 </div>
						</div>
						 
						<table  class="table table-bordered table-hover" id ="example" >
							<thead>
								<tr>
									<th class="text-center table-title" colspan="15">
										بلانس گدام ها 
									</th>
								</tr>
								<tr class="table-header">
									<th class='text-center'>شماره</th>
									<th class='text-center'>تاریخ</th>
									<th class='text-center'>مسیر</th>
									<th class='text-center'>گدام</th>
									<th class='text-center'>کالا</th>
									<th class='text-center'>واحد کالا</th>
									<th class='text-center'>توضیحات</th>
									<th class='text-center'>دیبت</th>
									<th class='text-center'>کریدیت</th>
									<th class='text-center'>موجودی فعلی</th>
 								</tr>
							</thead>
							<tbody>
							<?php
								$counter    = 0;
									$total      = 0;
									$recievable = 0;
									$payable    = 0;
									while($row = $stockBalanceSheetRow->fetch_array()){
										++$counter;
										$amount = $row['amount'];
										$type   = $row['transaction_type'];
										
										if($type == 2){
											$total -= $amount;
											$payable  += $amount;
										}else if($type == 1){
											$total += $amount;
											$recievable += $amount;
										}
						
										$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']	);
										$rowStocks = $conn->selectRecord ("tbl_stocks","id  = ". $row['stocks_id']	);
										$rowItemUnit = $conn->selectRecord ("tbl_item_units","id  = ". $rowItems['item_units_id']	);
										
										?>
										<tr> 
											<td class="small text-center "><?php echo $counter; ?></td>
											<td class='text-center '><?php echo $row['date']; ?></td>
											<td class='text-center '><?php echo $row['place']; ?></td>
											<td class='text-center '><?php echo $rowStocks['name']; ?></td>
											<td class='text-center '><?php echo $rowItems['name']; ?></td>
											<td class='text-center '><?php echo $rowItemUnit['name']; ?></td>
											<td class='text-center '><?php echo $row['description']; ?></td>
											<td class='text-center '><?php echo ($type == 2 ? $amount : "") ?></td>
											<td class='text-center '><?php echo ($type == 1 ? $amount : "") ?></td>
											<td class='text-center '><?php echo $total; ?></td>
										</tr>
								<?php 
									}
								?>
								<tr  style="background-color: #aaa;"> 
									<td class='text-center ' colspan='7'> مجموعه </td>
									<td class='text-center '><?php echo number_format($payable,2);?></td>
									<td class='text-center '><?php echo number_format($recievable,2);?></td>
									<td class='text-center '><?php echo number_format($recievable - $payable,2);  ?></td>
								</tr>
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
									$paginate.= "<a href='$targetPage?page=$prev'>Previous</a>";
								}else{
									$paginate.= "<span class='disabled'>Previous</span>";
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
									$paginate.= "<a href='$targetPage?page=$next'>Next</a>";
								}else{
									$paginate.= "<span class='disabled'>Next</span>";
								}
									
								$paginate.= "</div>";       
							}
							
							$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalPages;
							$start = ($start == 0) ? $start = ++$start : $start = $start;
						?>
						</table>
					</div>
				
					<div>
						<div class="col-md-6 col-sm-12 dontPrint" style="padding-top: 5px;color: #aaa; float: left">Showing<span class="adad"> <?php echo $start . '</span> From <span class="adad">' . $end; ?></span></div>
						<div class="col-md-6 col-sm-12 p-number dontPrint" id="retrieved_info" style="float: right"><span class='adad'><?php echo $paginate ?></span></div>
					</div>
					<?php   }  ?>
				
				</div>
				
			</div>
			
			<!-- Footer -->
			<?php  require_once("_footer.php");  ?>	
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
