<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader = "Responsible Users";
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
			<li class="active"><i class="fa fa-cog"></i>Administration</li> 
			<li class="active"><strong ><i class="fa fa-user-plus"></i><?php echo $formHeader; ?></strong></li> 
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
							<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center table-title" colspan="14">
											Responsility of Users
										</th>
									</tr>
									<tr class="table-header"> 
										<th class="small">No.</th>
										<th class='text-center'>photo</th>
										<th class='text-center'>Name</th>
										<th class='text-center'>last Name</th>
 										<th class='text-center'>Position</th>
 										<th class='text-center'>Authorized to Remove</th>
 										<th class='text-center'>Authorized to Insert</th>
 										<th class='text-center'>Authorized to Edit</th>
 										<th class='text-center'>Persmession to Logins</th>
 										<th class='text-center'>Setting</th>
 									</tr> 
								</thead> 
								<tbody> 
									<?php
										
										$userId = decryptIt($_SESSION['userId']);
										$usersRawSQLQuery    = "SELECT * FROM tbl_users WHERE  deleted = 0";
										$usersSQLQuery            = $conn->query($usersRawSQLQuery);
									   
										if($usersSQLQuery->num_rows > 0){
											
											while($row = $usersSQLQuery->fetch_array()){
												
												$rowPosition = $conn->selectRecord ("tbl_positions","id  = ". $row['position_id']);
												echo $rowPosition['name'];
												++$counter;
												
										?>
										<tr>
											<td class="small"><?php echo $counter; ?></td>
											<td class='text-center'><a href=""  download ><img src="<?php echo $row['photo'];?>" class="img-circle" style="width:50px;height:50px;"alt="No Photo"></a></td>
											<td class='text-center'><?php echo $row['name']; ?></td>
											<td class='text-center'><?php echo $row['family']; ?></td>
  											<td class='text-center'><?php echo $rowPosition['name']; ?></td>
  											<td class='text-center'><?php if($row['remove']==1){ echo "<i class='icon-check icon-larger green-color'></i>";}else{ echo "<i class='icon-cancel icon-larger red-color'></i>";} ?></td>
  											<td class='text-center'><?php if($row['addForm']==1){ echo "<i class='icon-check icon-larger green-color'></i>";}else{ echo "<i class='icon-cancel icon-larger red-color'></i>";} ?></td>
  											<td class='text-center'><?php if($row['edit']==1){ echo "<i class='icon-check icon-larger green-color'></i>";}else{ echo "<i class='icon-cancel icon-larger red-color'></i>";} ?></td>
  											<td class='text-center'><?php if($row['status']==0){ echo "<i class='icon-check icon-larger green-color'></i>";}else{ echo "<i class='icon-cancel icon-larger red-color'></i>";} ?></td>
 											<td class="small text-center"><a title="User Profile" target="_" href="userProfileAdmin.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-user btn btn-blue btn-outline"></i></a></td>

										 </tr>
										<?php
												
											}
											
										}
									
									?>
								</tbody> 
							</table>
						</div>
						
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
 
</body>
</html>