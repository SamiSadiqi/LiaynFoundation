 <?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader = "Edit Account";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<!---Modals Form actions -->

<div id="add_data_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Insert Position Name</h4>
            </div>
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
                <form class="form-horizontal" method="post" id="insert_form">	
					<input name="formParameter" value="<?php echo encryptIt("insertActionWidthModalAT"); ?>" type="hidden"  />
					<div class="form-group"> 
						<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset col-md-offset-1 col-sm-offset-0 control-label" for="name">Position Name</label> 
						<div class="col-lg-6 col-md-8 col-sm-10"> 
							<input type="text" placeholder="Position Name" autocomplete="off" required id="name" name="name" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div> 
					<div class="form-group"> 
						<label class="col-lg-2 col-md-2 col-sm-2   col-md-offset-1 col-sm-offset-0 control-label" for="address">Description</label> 
						<div class="col-lg-6 col-md-8 col-sm-10"> 
							<textarea    placeholder = 'Description' autocomplete="off" id='description' name='description' class='form-control'></textarea>
							<p class="help-block"></p>
						 </div> 
						<div class="form-group"> 
							<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
								<button class="btn btn-success btn-outline" name="insert"   type="submit"> Add <i class="fa fa-paste"></i>  </button>
 							</div> 
						</div>
				</form>
            </div>
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
			<span>Your Current Location: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Administration</li> 
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
					<?php
					
						if(isset($_SESSION['userId'])){
							 
							$userRawSQLQuery = $conn->query("SELECT * FROM tbl_users WHERE id  = $userId AND deleted = 0");
							$userSQLQuery    = $userRawSQLQuery->fetch_array();
							extract($userSQLQuery); 

						}else{
							
							header("location: addUserETQ.php");
							exit();
							
						}
						
					?>
					
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php   
							if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["wrongCurrentPassword"])){
							?>	
								<div id='alertId' class="alert alert-danger" style='margin-right:20%;margin-left:30%'>
								  <p style='text-align:center' ><strong>Warning!</strong>Please Enter Real Password</p>
								</div>
							<?php 
							}
						?>
						<div class="blank"></div>
						 <?php  require_once('alerts.php');  ?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsEditPartialyUserETQ.php" method="POST"  enctype="multipart/form-data">
						
							<input name="formParameter" value="<?php echo encryptIt("editPaawordETQ"); ?>" type="hidden"  />
							<input name="id" value="<?php echo encryptIt($userId); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">Current Password</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="Current Password" id="currentPasswrod" autocomplete="off"  name="currentPasswrod" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">New Password</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="password" placeholder="New Password" id="newPassword" autocomplete="off"  name="newPassword" class="form-control password">
									<p class="help-block"></p>
								 </div> 
							</div> 
							 <div class="form-group"> 
								 <label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="confirmpassword">Confirm</label> 
								 <div class="col-lg-6 col-md-8 col-sm-10"> 
								   <input type="password" placeholder="Confirm" autocomplete="off" id="confirmpassword" name="confirmpassword" class="form-control password"> 
									<label id="confirmchecked" > </label>
								 </div> 
							</div>  
							
							 
							<?php
								editFormSubmissionButtons('profileUserACI.php');
							?> 
						</form>
						
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
