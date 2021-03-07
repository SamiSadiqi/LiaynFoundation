<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader = "User Status and  Messages";
  
	 
?>
 
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<!---Modals Form actions -->
<div id="send_data_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
             
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
                 <form class="form-horizontal" method="post" id="insert_form">	
					<input name="formParameter" value="<?php echo encryptIt("insertMessagesACI"); ?>" type="hidden"  />
					 
					<div class="form-group"> 
 						<div class="col-lg-9 col-md-10 col-sm-10 col-lg-offset-2 col-sm-offset-1 col-md-offset-1"> 
							<input type="text" placeholder="Subject" autocomplete="off" required id="subject" name="subject" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div> 
					<div class="form-group"> 
 						<div class="col-lg-9  col-md-10  col-md-offset-1  col-sm-offset-1 col-sm-10 col-lg-offset-2"> 
							<textarea    placeholder = 'Write Your Message' autocomplete="off" id='message' name='message' class='form-control'></textarea>
							<p class="help-block"></p>
						 </div> 
					</div>
					<div class="form-group"> 
							<div class="col-lg-8 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-4 col-sm-offset-5"> 
								<button class="btn btn-success btn-outline" name="insert"   type="submit"> Send <i class="fa fa-paste"></i>  </button>
 							</div> 
					</div>
				</form>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
        </div>
    </div>
</div>
</div>
<!---Modals Form actions -->

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
			<span>Your Locations: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Message</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php  echo $formHeader; ?></strong></li>
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
									 
									<tr class="table-header"> 
 										<th class='text-center'>Photo</th>
										<th class='text-center'>Full Name</th>
										<th class='text-center'>Position</th>
										<th class='text-center'>Status</th>
										<th class='text-center'>Working Time</th>
										<th class='text-center'>Became Member</th>

 									</tr> 
								</thead> 
								<tbody> 
									<?php
										
										$userId = decryptIt($_SESSION['userId']);
										$usersRawSQLQuery    = "SELECT * FROM tbl_users WHERE  deleted = 0";
										$usersSQLQuery            = $conn->query($usersRawSQLQuery);
									   
										if($usersSQLQuery->num_rows > 0){
											
											while($row = $usersSQLQuery->fetch_array()){
										 
											  
												$formatted_datetime = date("d/m/Y - H:i:A", $row["created_at"]);
												 

												$rowPosition = $conn->selectRecord ("tbl_positions","id  = ". $row['position_id']);
 												$rowLoginDetails = $conn->query("SELECT * FROM tbl_login_details where users_id =". $row['id']." ORDER BY id DESC LIMIT 1");
												$fetchDate = $rowLoginDetails->fetch_array();
												echo $loginDate = $fetchDate['login_date'];
											 
												
												$lastSeenVisit =  $fetchDate['last_seen_visit'];
										
												$curentTime = time(); 
											 
										 
												 
												$durationLogin = $lastSeenVisit - $loginDate;
												
												 
												$lastSeenVist = $curentTime - $lastSeenVisit;
 												if($lastSeenVist < 80	){
													 $lastSeenTime = "Online";
													 $checkDurationOnline = "Progressing";
												}else{
													$lastSeenTime = onlineOffline($lastSeenVist);
													$checkDurationOnline = durationWroking($durationLogin);

												}
												
										?>
										<tr>
 											<td class='text-center'><a href=""  download ><img src="<?php echo $row['photo'];?>" class="avatar img-circle" style="width:50px;height:50px;"alt="No Photo"></a></td>
 											<td class='text-center'><?php echo $row['name']." ".$row['family']; ?></td>
 											<td class='text-center lowecase'><span class="badge badge-info"><?php if($row['user_type'] =='1001'){echo "Administrator";}elseif($row["user_type"] =='1002'){echo "Admin";}else{ echo "User";} ?></span></td>
 											<td class='text-center'><span class="badge badge-info"><?php echo $lastSeenTime;    ?></span></td>
 											<td class='text-center'><span class="badge badge-info"><?php echo $checkDurationOnline;    ?></span></td>
 											<td class='text-center'><spans><?php echo $formatted_datetime;    ?></span></td>
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
