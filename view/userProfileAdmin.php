<?php
	require_once("_header.php");
	$formHeader = "Approvals";
	 
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
			<span>Your Locations: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>Confrimation</li> 
			<li class="active"><strong ><i class="fa fa-user"></i><?php echo $formHeader; ?></strong></li>
		</ol>
	<?php
		if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
		
		$id = decryptIt($_GET['id']);
		$slectUserDate = $conn->query("SELECT * FROM tbl_users where id = $id AND deleted = 0");
		$fetchDateUsers = $slectUserDate->fetch_array();
		
		$positionRow = $conn->selectRecord ("tbl_positions","id  = ". $fetchDateUsers['position_id']);
		  if($fetchDateUsers['user_type'] =='1001')
			{
			  $userType = "Administrator";
			}
			elseif($fetchDateUsers["user_type"] =='1002'){
				
				 $userType = "Admin";
			}
			else
			{ 
				$userType = "User";
			} 
		 ?>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				 
			</div>
		 </div>
			
		<div class="row panel panel-primary" style="margin-top:2%;">
            <div class="panel-heading lead">
                <div class="row">
                    <div class="col-lg-8 col-md-8"><i class="fa fa-user"></i> User Profile</div>
                    <div class="col-lg-4 col-md-4 text-right">
                         
                    </div>
                </div>
            </div>
            <div class="panel-body">
                	    <div class="row">
                        <div class="col-lg-12 col-md-12">

                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <center>
                                        <span class="text-left">
                                        <img src="<?php  echo $fetchDateUsers['photo'];  ?>" style="width:200px;height:200px;" class="img-responsive img-thumbnail">

                    
										</span>
									</center>

                                    <div class="table-responsive panel">
                                        <table class="table">
                                            <tbody>
                                                        <tr>
                                                        <td class="text-center">
                                                            <span class="btn btn-primary text-success btn-block"><i class=""></i> </span>
                                                         </td>
                                                    </tr>
                                                            							
                                            </tbody>
                                        </table>
                                    </div>

                                    
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#Summery" class="text-success"><i class="fa fa-indent"></i> Summery</a></li>
                                        <li><a data-toggle="tab" href="#Contact" class="text-success"><i class="fa fa-bookmark-o"></i> Authority</a></li>
                                     </ul>

                                    <div class="tab-content">
                                        <div id="Summery" class="tab-pane fade in active">

                                            <div class="table-responsive panel">
                                                <table class="table">
                                                    <tbody>
    
 
                                                            <tr>
                                                                <td class="text-success"><i class="fa fa-user"></i> Full Name</td>
                                                                <td><?php echo $fetchDateUsers['name'].$fetchDateUsers['family'];   ?></td>
                                                            </tr>
															<tr>
                                                                <td class="text-success"><i class="fa fa-user"></i> Username</td>
                                                                <td><?php echo $fetchDateUsers['username'];  ?></td>
                                                            </tr>
															<tr>
                                                                <td class="text-success"><i class="fa fa-user"></i> Email</td>
                                                                <td><?php echo $fetchDateUsers['email'];  ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><i class="fa fa-list-ol"></i> Position</td>
                                                                <td><?php echo $positionRow['name'];   ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><i class="fa fa-book"></i> User Type</td>
                                                                <td><?php  echo $userType;  ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><i class="fa fa-group"></i> Created User</td>
                                                                <td><?php  echo date("d/m/Y - H:i:A", $fetchDateUsers["created_at"]);   ?></td>
                                                            </tr>
 
                                                             
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
 
                                        <div id="Contact" class="tab-pane fade">
                                            <div class="table-responsive panel">
                                                <table class="table">
                                                    <tbody>
    										
                                                         
                                                            <tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-pencil"></i> Remove</td>
                                                                <td>
																	<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="removeUser" onclick="authorityRemove('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['remove'] == 1){ echo "checked = checked";}   ?>>
																	<label for="removeUser">Remove</label>
																	</div>
																</td>
                                                            </tr> 
                                                             <tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-pencil"></i> Remove Report</td>
                                                                <td>
																	<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="removeReport" onclick="authorityRemoveReport('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['remove_report'] == 1){ echo "checked = checked";}   ?>>
																	<label for="removeReport">Remove Report</label>
																	</div>
																</td>
                                                            </tr> 
															<tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-edit"></i> Edit</td>
                                                                <td>
																	<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="editUser" onclick="authorityEdit('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['edit'] == 1){ echo "checked = checked";}   ?>>
																	<label for="editUser">Edit</label>
																	</div>
																</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-edit"></i> Edit Report</td>
                                                                <td>
																	<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="editReport" onclick="authorityEditReport('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['edit_report'] == 1){ echo "checked = checked";}   ?>>
																	<label for="editReport">Edit Report</label>
																	</div>
																</td>
                                                            </tr>
															<tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-tree-conifer"></i> Insert</td>
                                                                <td>
																	<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="insertUser" onclick="authorityInsert('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['addForm'] == 1){ echo "checked = checked";}   ?>>
																	<label for="insertUser">insert</label>
																	</div>
																</td>
                                                          
                                                            <tr>
                                                                <td class="text-success"><i class="glyphicon glyphicon-user"></i> Block User</td>
                                                                <td>
																<div class="checkbox checkbox-replace checkbox-success">
																	<input type="checkbox" id="blockStatus" onclick="authorityBlock('<?php echo $fetchDateUsers['id'];   ?>')" <?php if($fetchDateUsers['status'] == 1){ echo "checked = checked";}   ?>>
																	<label for="blockStatus">Block Status</label>
																	</div>
																	</td>
                                                            </tr>
                                                            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                     
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                <!-- /.table-responsive -->
                
            </div>
        </div>
			
		<?php
		} 
		?>
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
 <script>
 //Edit Toggle
  function authorityRemove(requestUserId){
	 
	  $.post("AjaxRemoveToggleAuthorityACI.php",{"requestUserId":requestUserId},function(data){
	 
			if(data == 0){
				$("#removeUser").load('userProfileAdmin.php');	
				alert("The Remove Ability of User Has Banned!");
				
			}else{
				$("#removeUser").load('userProfileAdmin.php');	
				alert("The User Find Ability to Remove Records!");
			}
		  
		});
	} 
	//Edit Toggle.
	 function authorityEdit(requestUserId){
	 
	  $.post("AjaxEditToggleAuthorityACI.php",{"requestUserId":requestUserId},function(data){
	 
			if(data == 0){
				$("#editUser").load('userProfileAdmin.php');	
				alert("The Edit Ability of User Has Banned!");
				
			}else{
				$("#editUser").load('userProfileAdmin.php');	
				alert("The User Find Ability to Edit Records!");
			}
		  
		});
	} 	
	//Insert Toggle.
	 function authorityInsert(requestUserId){
	 
	  $.post("AjaxInsertToggleUserACI.php",{"requestUserId":requestUserId},function(data){
		 
			if(data == 0){
				$("#insertUser").load('userProfileAdmin.php');	
				alert("The Insert Ability of User Has Banned!");
				
			}else{
				$("#insertUser").load('userProfileAdmin.php');	
				alert("The User Find Ability to Insert Date!");
			}
		  
		});
	} 
	//Approve Toggle.
	 function authorityApprove(requestUserId){
	 
	  $.post("AjaxApproveToggleAuthorityACI.php",{"requestUserId":requestUserId},function(data){
	 
			if(data == 0){
				$("#editUser").load('userProfileAdmin.php');	
				alert("The Approve Request payments Ability of User Has Banned!");
				
			}else{
				$("#editUser").load('userProfileAdmin.php');	
				alert("The User Find Ability to Approve Request Payments!");
			}
		  
		});
	} 
		//Super Approve Toggle.
	 function authorityApproveSuper(requestUserId){
	 
	  $.post("AjaxSuperApproveToggleAuthorityACI.php",{"requestUserId":requestUserId},function(data){
	 
			if(data == 0){
				$("#superApprove").load('userProfileAdmin.php');	
				alert("The Highest level of Approve Request payments Ability Has Banned!");
				
			}else{
				$("#superApprove").load('userProfileAdmin.php');	
				alert("The User Find Ability to Approve Request Payments In High level!");
			}
		  
		});
	} 
		//Status Approve Toggle.
	 function authorityBlock(requestUserId){
	 
	  $.post("AjaxBlockToggleAuthorityACI.php",{"requestUserId":requestUserId},function(data){
		  
			if(data == 0){
				$("#blockStatus").load('userProfileAdmin.php');	
				alert("The User Successfully Un Blocked!");
				
			}else{
				 
			  	$("#blockStatus").load('userProfileAdmin.php');	
				alert("The User Successfully Blocked!");  
			}
		  
		});
	} 
	
	
	// Remove Report
	 function authorityRemoveReport(requestUserId){
	 
	  $.post("AjaxReportRemoveAuthorityACI.php",{"requestUserId":requestUserId},function(data){
		  
			if(data == 0){
				$("#removeReport").load('userProfileAdmin.php');	
				alert("The User Successfully Unauthorized");
				
			}else{
				 
			  	$("#removeReport").load('userProfileAdmin.php');	
				alert("The User Successfully Authorized");  
			}
		  
		});
	} 
	// Remove Report
	 function authorityEditReport(requestUserId){
	 
	  $.post("AjaxEditReportAuthorizedACI.php",{"requestUserId":requestUserId},function(data){
			if(data == 0){
				$("#editReport").load('userProfileAdmin.php');	
				alert("The User Successfully Unauthorized");
				
			}else{
				 
			  	$("#editReport").load('userProfileAdmin.php');	
				alert("The User Successfully Authorized");  
			}
		  
		});
	}
 </script>
</body>
</html>
