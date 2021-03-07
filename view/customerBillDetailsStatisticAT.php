<?php
	require_once("_header.php");
	$menu = "reportsAT";
 	$formHeader  = "Customer's Loan Reports";
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
  
<div id="myModal" class="modal modal-lg fade col-lg-offset-2  col-md-offset-1"  >
	    <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body" id='myModalData'>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			 </div>
		</div>
	</div>
</div>
	
<!-- Page container -->
<div class="page-container">

	<!-- Main container -->
	<div class="main-container">
  
	
		<!-- Main content -->
		<div class="main-content">
			
			<div class="row">
			
				<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
					<h1 class="text-center"><?php echo $companyName; ?></h1>
				
					<h3 class="text-center">Customer's Invoice Details</h3>
				
 				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						if(isset($_GET['type'])){
						$statusMovement = $_GET['type'];
						$table      = "tbl_customer_bill_title";       
						$targetPage = "customerBillDetailsStatisticAT.php";    
						$limit      = 40;  
						 
						$rowCountSQL  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE  deleted = 0 AND status_movement = $statusMovement ORDER BY id DESC");
						$rowCountSQL  = $rowCountSQL->fetch_array();
						$totalPages   = $rowCountSQL['totalRows'];
						
						$stages = 3;
				    	$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
	                	$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
						
						//Get Page Data
						
 						$customersSQLQuery            = $conn->query("SELECT * FROM $table WHERE deleted = 0 AND status_movement = $statusMovement ORDER BY id DESC LIMIT $start, $limit");
						if ($customersSQLQuery->num_rows > 0) {
							
					
					?>
					<div class="panel-body table-responsive" id="page-content"> 
    				 
						<table  class="table table-bordered table-hover" id ="example" >
							<thead>
								<tr>
									<th class="text-center table-title" colspan="13">
										Customer's Invoice	
									</th>
								</tr>
								<tr class="table-header">
									<th class='text-center'>No</th>
									<th class='text-center'>Date</th>
									<th class='text-center'>Customer</th>
									<th class='text-center'>Currency</th>
									<th class='text-center'>Factor Price</th>
									<th class='text-center'>Payment Amount</th>
									<th class='text-center'>Due Date</th>
 									<th class='text-center'>Factor Number</th>
									<th class='text-center'>Invoice Status</th>
									<th class='text-center'>Details</th>
									<th class='text-center'>Change Status</th>
  								</tr>
							</thead>
							<tbody>
							<?php
							$counter = $start;
								while($row = $customersSQLQuery->fetch_array()){
									++$counter;
										$rowCustomer = $conn->selectRecord ("tbl_customers","id  = ". $row['customers_id']);
										$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
										$type = $row['status_movement'];
										if($type == 1){
											$statusMovementText = "On Hand";
										}elseif($type == 2){
											$statusMovementText = "Shipment";
										}else{
											$statusMovementText = "Deilivered";
										}
										 ?>
									<tr>
										<td class="small text-center"><?php echo $counter; ?></td>
										<td class='text-center'><?php echo $row['date']; ?></td>
										<td class='text-center'><?php  echo $rowCustomer['name']; ?></td>
										<td class='text-center'><?php  echo $rowCurrency['code']; ?></td>
										<td class='text-center'><?php  echo $row['factor_price']; ?></td>
										<td class='text-center'><?php  echo $row['factor_payment']; ?></td>
										<td class='text-center'><?php  echo $row['due_date']; ?></td>
										<td class='text-center'><?php  echo $row['factor_number']; ?></td>
										<td class='text-center'><?php  echo $statusMovementText; ?></td>
 										<td class="small text-center"><button title="Details" class="fa fa-edit btn btn-blue btn-outline" onclick="detailsData('<?php echo $row['id']; ?>')" ></button></td>
										<td class='text-center'>
										<?php 
											if($statusMovement !=3){
										?>
										 
											<select class="select2 form-control" name='movementStatus' onchange="changeType('tbl_customer_bill_title',this.value,<?php echo $row['id'];  ?>)"  autocomplete="off">
												<option Value="">Select type of Status</option>
												<option <?php  if($statusMovement == 1){ echo "selected"; }   ?> Value="1">On Hand</option>
												<option <?php  if($statusMovement == 2){ echo "selected"; }   ?> Value="2">Shipment</option>
												<option <?php  if($statusMovement == 3){ echo "selected"; }   ?>  Value="3">Delivered</option>
											</select>
										<?php
											}else{
										?>
											<select class="select2 form-control" name='movementStatus'readonly    autocomplete="off">
   												<option <?php  if($statusMovement == 3){ echo "selected"; }   ?>  Value="3">Delivered</option>
											</select>
					
										<?php
											}
										?>
										</td>

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
					<?php  
						}
						}

					?>
				
				</div>
					
			</div>
			
			<!-- Footer -->
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
			
					<?php  require_once('_footer.php');  ?>
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
function changeType(table,value,id){
 	$.post("AaxChangeStatusMovementTypeCustomerAT.php",{"table":table,"value":value,"id":id},function(data){
		if(data == 'done'){
			alert("Successfully done");
			 $('.page-container').load('customerBillDetailsStatisticAT.php');
			 
		}else if(data == 'error'){
			alert("Error Occurred!");
		}
	});
}
function detailsData(id){
  	$.post("AjaxDetailsCustomerInvoiceAT.php",{"id":id},function(data){
		 $("#myModal").modal('show');
		 $('#myModalData').html(data);
	});
}
</script>
</body>
</html>