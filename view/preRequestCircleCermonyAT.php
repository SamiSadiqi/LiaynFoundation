<?php
	require_once("_header.php");
 	$formHeader  = "درخواست های تعمیراتی اجراء نشده";
	
	$categoryId = $_GET['categoryId'];
	 
	
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
					<h3 class="text-center"> <?php echo $title; ?></h3>
 				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				
					<?php
						 
 						$table  = "tbl_support_ceremonies_requests";       
						$targetPage = "preRequestCircleCermonyAT.php";    
						$limit      = 400000;  
					
						 
						$row_count_sql  = $conn->query("SELECT COUNT(*) AS totalRows FROM $table WHERE status = 0 AND deleted = 0 ORDER BY id DESC");
						$row_count_row  = $row_count_sql->fetch_array();
						$totalPages    = $row_count_row['totalRows'];
						
						$stages = 3;

						$page  = (isset($_GET['page']) ? $page = validate($connection,$_GET['page'],'صفحه',0,"number",false) : $page = 0);
						$start = ($page ? $start = (($page - 1) * $limit) : $start = 0); 
						
						//Get Page Data
						$incomesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND status = 0 ORDER BY id DESC LIMIT $start, $limit";
						
						
						$incomesSQLQuery       = $conn->query($incomesRawSQLQuery);
						
						if ($incomesSQLQuery->num_rows > 0) {
					?>
				 
					<div class="panel-body" id="page-content" style="overflow-x:scroll"> 
						<div class="form-group dontPrint"> 
    						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
							<!--
							  <form method="post" action="excelIncomeReportAT.php">
        						 <input type="submit" name="export" class="btn btn-primary" value="Export" />
        					    </form>
								--->
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"> 
							 
							 </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7"> 
								<input type="text" placeholder="جستجو" autocomplete="off" id="search" class="form-control">
								<p class="help-block"></p>
 
							 </div>
						</div>
						 
						<table  class="table table-bordered table-hover" id ="example" >
							<thead>
								<tr>
								<th class="text-center table-title" colspan="15">
									درخواستی تمویل محافل
								</th>
								</tr>
								<tr class="table-header">
									<th class="small text-center">شماره</th>
									<th class="text-center">تاریخ</th>
									<th class="text-center">شماره درخواستی</th>
									<th class="text-center">نام محفل</th>
									<th class="text-center">نوع سازمان</th>
									<th class="text-center">مکتب / سازمان</th>
									<th class="text-center">فایل</th>
									<th class="text-center">توضیحات</th>
 								</tr>
							</thead>
							<tbody>
							<?php
								$counter = $start;
									while($row = $incomesSQLQuery->fetch_array()){
										++$counter;
											$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
											$rowConstructions = $conn->selectRecord ("tbl_constructions_type","id  = ". $row['construction_types_id']);
											if($row['organizations_type'] == 1){
												
												$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
											
											}elseif($row['organizations_type'] == 2){
												
												$rowSchools = $conn->selectRecord ("tbl_organizations","id  = ". $row['organizations_id']);
											}
											 ?>
									<tr>
										<td class="small text-center"><?php echo $counter; ?></td>
										<td class='text-center'><?php echo $row['date']; ?></td>
										<td class='text-center'><?php echo $row['request_number']; ?></td>
										<td class='text-center'><?php echo $row['name']; ?></td>
										<td class='text-center'><?php if($row['organizations_type'] == 1){ echo "مکتب";}else{ echo "سازمان";} ?></td>
										<td class='text-center'><?php echo $rowSchools['name']; ?></td>
										<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
										<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
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
						<div class="col-md-6 col-sm-12 dontPrint" style="padding-top: 5px;color: #aaa; float: left">Showing <span class="adad"> <?php echo $start . '</span> From <span class="adad">' . $end; ?></span></div>
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



<!--bootstrap js-->
 <script src="../assets/js/jquery.min.js"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="../assets/js/bootstrap.min.js"></script>
 
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
