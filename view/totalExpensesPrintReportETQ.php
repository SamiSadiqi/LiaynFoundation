<?php
	require_once("_header.php");
 	$formHeader  = "Expense Reports";
	$categoryId = $_POST['categoryId'];
	$expenseId = $_POST['expenesId'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    
    
    	$rowExpenseCategory = $conn->selectRecord ("tbl_expense_categories","id  = ".$categoryId);
		$rowExpenseType = $conn->selectRecord ("tbl_expense_types","id  = ".$expenseId);
		if($categoryId == 'all'){
		     $title = "All Expense Categories with thier Types";
		     
		}elseif($categoryId !='all' && $expenseId == 'all'  &&  !empty($fromDate)  && !empty($toDate)){
		    
		        $title = " <b> ".$rowExpenseCategory['name'] ."</b> همراه <b> ".$rowExpenseType['name']."type</b>";
		      
 		}elseif($categoryId !='all' && $expenseId == 'all'  && empty($fromDate) && empty($toDate) ){
 		  
				$title = "  <b>".$rowExpenseCategory['name'] ."</b> همراه تمامی سب کتگوری هایش";
		          
 		}elseif($categoryId !='all' && $expenseId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
 		    
				$title = "  <b>".$rowExpenseCategory['name'] ."</b> همراه <b>".$rowExpenseType['name']." </b> از تاریخ <b> ".$fromDate." </b>تا تاریخ<b> ".$toDate." </b>";
			  
 		}elseif($categoryId !='all' && $expenseId != 'all'  && empty($fromDate) && empty($toDate)){
 		    
				$title = "  <b>".$rowExpenseCategory['name']."</b>  همراه  <b> ".$rowExpenseType['name']."</b> نوع مصرف";
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
				 
				<div class="col-lg-12 col-md-12 col-sm-12 invoke">
				
					<?php
						 
						$table      = "tbl_expenses";       
						$targetPage = "totalExpensesPrintReportETQ.php";    
						$limit      = 400000;   
						 
					   
						if($categoryId == 'all'){
						     
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE deleted = 0 ORDER BY id DESC");
						}elseif($categoryId !='all' && $expenseId == 'all'  &&  !empty($fromDate)  && !empty($toDate)){
						    
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE expense_category_id = '$categoryId' AND deleted = 0 AND  date between '$fromDate' AND '$toDate' ORDER BY id DESC");
						}elseif($categoryId !='all' && $expenseId == 'all'  && empty($fromDate) && empty($toDate) ){
						   
							$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE expense_category_id = '$categoryId' AND deleted = 0 ORDER BY id DESC");
						}elseif($categoryId !='all' && $expenseId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
        					 
    						$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE expense_category_id = '$categoryId' AND expense_type_id = '$expenseId' AND deleted = 0 AND  date between '$fromDate' AND '$toDate'  ORDER BY id DESC");
						}elseif($categoryId !='all' && $expenseId != 'all'  && empty($fromDate) && empty($toDate)){
						           
						    $row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE expense_category_id = '$categoryId' AND expense_type_id = '$expenseId' AND deleted = 0 ORDER BY id DESC");
						}
						 
                        $row_count_row  = $row_count_sql->fetch_array();
                        $totalPages    = $row_count_row['totalRows'];
						
						$stages = 3;
				    	$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
	                	$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		
						
						//Get Page Data
						if($categoryId == 'all'){
						    
						     $expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
							
						}elseif($categoryId !='all' && $expenseId == 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
						     $expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND expense_category_id = '$categoryId' AND date between '$fromDate' AND '$toDate' ORDER BY id DESC LIMIT $start, $limit";
						
						}elseif($categoryId !='all' && $expenseId == 'all' && empty($fromDate) && empty($toDate)){
						    
							$expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND expense_category_id = '$categoryId' ORDER BY date DESC LIMIT $start, $limit";
						
						}elseif($categoryId !='all' && $expenseId != 'all' &&  !empty($fromDate)  && !empty($toDate)){
						    
							$expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND expense_category_id = '$categoryId' AND expense_type_id = '$expenseId'  AND  date between '$fromDate' AND '$toDate' ORDER BY id DESC LIMIT $start, $limit";

						}elseif($categoryId !='all' && $expenseId != 'all'  && empty($fromDate) && empty($toDate) ){
						    
						  	$expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND expense_category_id = '$categoryId' AND expense_type_id = '$expenseId' ORDER BY id DESC LIMIT $start, $limit";
						}
					
						$expensesSQLQuery       = $conn->query($expensesRawSQLQuery);
						
						if ($expensesSQLQuery->num_rows > 0) {
					?>
				 
					<div class="panel-body" id="page-content"> 
						<div class="form-group dontPrint"> 
    						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
							  <form method="post" action="excelExpenseReports.php">
        						 <input type="submit" name="export" class="btn btn-primary" value="Export" />
        					    </form>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
								<input type="text" placeholder="Search" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
 
							 </div>
						</div>
						 
						<table class="table table-bordered table-responsive table-hover">
							<thead>
								<tr>
									<th class="text-center table-title" colspan="15">
										Performed Expenses List
									</th>
								</tr>
								<tr class="table-header">
									<th class='text-center'>NO.</th>
									<th class='text-center'>Serial Number</th>
									<th class='text-center'>Date</th>
									<th class='text-center'>Category</th>
									<th class='text-center'>Expense Type</th>
									<th class='text-center'>Bank</th>
									<th class='text-center'>Currency</th>
 									<th class='text-center'>Amount</th>
									<th class='text-center'>Rate</th>
									<th class='text-center'>Amount <span   style='text-transform:lowercase;color:red;' >(Usd)</span></th>
 									<th class='text-center'>Description</th>
									<?php if($validationEditReport == 1 || $validationRemoveReport == 1){   ?> 
             						<th class="small text-center dontPrint" colspan="2">Operations</th>
            						<?php   } ?>
 								</tr>
							</thead>
							<tbody>
							<?php
								$counter = $start;
									while($row = $expensesSQLQuery->fetch_array()){
										++$counter;
										$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
										$rowExpenseCategory = $conn->selectRecord ("tbl_expense_categories","id  = ". $row['expense_category_id']);
										$rowExpenseType = $conn->selectRecord ("tbl_expense_types","id  = ". $row['expense_type_id']);
										$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
 										$totalAmount += $row['home_amount']; 
											 ?>
										<tr  id='row-<?php echo $row['id']; ?>'>
											<td class="small text-center"><?php echo $counter; ?></td>
											<td class='text-center'><?php echo $row['id']; ?></td>
											<td class='text-center'><?php echo $row['date']; ?></td>
											<td class='text-center'><?php  echo $rowExpenseCategory['name']; ?></td>
											<td class='text-center'><?php  echo $rowExpenseType['name']; ?></td>
											<td class='text-center'><?php  echo $rowBank['name']; ?></td>
											<td class='text-center'><?php  echo $rowCurrency['code']; ?></td>
 											<td class='text-center'><?php  echo $row['amount']; ?></td>
											<td class='text-centerr'><?php echo $row['rate']; ?></td>
											<td class='text-center'><?php  echo $row['home_amount']; ?></td>
 											<td class='text-center'><?php  echo $row['description']; ?></td>
											<?php if($validationEditReport == 1){   ?>
												<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
                    					 	<?php }if($validationRemoveReport == 1){ ?>
                    						<td class="small text-center dontPrint"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
                    						<?php   } ?>
										</tr>
								<?php 
									}
								?>
								<tr>
									<td class='text-center' colspan='9' >Total Expenses</td>
									<td  class='text-center number' colspan='1'><b><?php  echo number_format($totalAmount,2);  ?></b> USD</td>
									<td  class='text-center number' colspan='2'></td>
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
			<footer class="animatedParent animateOnce z-index-10 dontPrint"> 
			<?php   require_once("_footer.php");  ?>
			</footer>	
			<!-- /footer -->
		
		</div>
		<!-- /main content -->
	  
	</div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<!--bootstrap js-->
 <script src="../assets/js/jquery.min.js"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="../assets/js/bootstrap.min.js"></script>
 
<script>
//Embed form data to modals{
$(document).on('click','.edit_data',function(){
	var edit_data_id = $(this).attr('id');
	 $.post("showEditableDataToModalAT.php",{edit_data_id:edit_data_id},function(data){
		$("#updateModalData").html(data);
		$("#editDataModal").modal('show');
	});
}); 
//Update form data
$(document).on('click','#update',function(){ 
	var href = document.location.href;
	var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
	$.post("updateDataAT.php",$('#updateForm').serialize(),function(data){
		alert(data);
			if(data == 'done'){
			alert("Record Update Successfully");
			setTimeout(function() {
			   $("#editDataModal").modal('hide');
			}, 500);
		}else if(data == 'error'){
			alert("Error Occurred!");
		}else{
			alert("Try Again!");
		}
	});
}); 

$("#search").keyup(function (){
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

function verifyRemoveFunction(title,id){
	if (confirm("Are you sure you want to delete it?")) {
		 $.post("actionsRemoveACI.php",{"title":title,"id":id},function(data){
		 alert(data);
			if(data === 'done'){
				 alert("Your transaction successfully deleted");
				 $("#row-"+id).fadeOut(1000);
			}else if(data === 'error'){
				 alert("You don't have permission to delete this record");
			}else{
				alert("Technical Error");
			}
		});
	}
}
</script>
</body>
</html>