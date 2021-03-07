<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader = "ویرایش کاربری";
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
                <h4 class="modal-title">وظیفه</h4>
            </div>
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
                <form class="form-horizontal" method="post" id="insert_form">	
					<input name="formParameter" value="<?php echo encryptIt("insertActionWidthModalAT"); ?>" type="hidden"  />
					<div class="form-group"> 
						<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset col-md-offset-1 col-sm-offset-0 control-label" for="name">وظیفه</label> 
						<div class="col-lg-6 col-md-8 col-sm-10"> 
							<input type="text" placeholder="وظیفه" autocomplete="off" required id="name" name="name" class="form-control">
							<p class="help-block"></p>
						 </div> 
					</div> 
					<div class="form-group"> 
						<label class="col-lg-2 col-md-2 col-sm-2   col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
						<div class="col-lg-6 col-md-8 col-sm-10"> 
							<textarea    placeholder = 'توضیحات' autocomplete="off" id='description' name='description' class='form-control'></textarea>
							<p class="help-block"></p>
						 </div> 
						<div class="form-group"> 
							<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
								<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه <i class="fa fa-paste"></i>  </button>
 							</div> 
						</div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
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
			<span>موقعیت فعلی </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>مدیریت</li> 
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
					
						if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
							
							$id = decryptIt($_GET['id']);
							$userRawSQLQuery = $conn->query("SELECT * FROM tbl_users WHERE id  = $id AND deleted = 0");
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
								  <p style='text-align:center' ><strong>هشدار!</strong>لطفا پسورد درست وارد کنید</p>
								</div>
							<?php 
							}
						?>
						<div class="blank"></div>
						
						<div class="table-responsive">
							<table class="table table-bordered border">
								<thead>
									<tr>
										<th class="text-center table-title" colspan="10">ویرایش اطلاعات</th>
									</tr>

									<tr class="table-header">
 										<th class='text-center'>نام </th>
 										<th class='text-center'>تخلص</th>
 										<th class='text-center'>نام کاربری</th>
 										<th class='text-center'>عکس</th>
									</tr> 
								</thead> 
								<tbody> 
									<tr class='active'>
 										<td class='text-center' style="padding-top:20px;"><?php  echo $name; ?></td>
 										<td class='text-center' style="padding-top:20px;"><?php  echo $family; ?></td>
 										<td class='text-center' style="padding-top:20px;"><?php  echo $username; ?></td>
 										<td class='text-center' ><img src="<?php  echo $photo; ?>" style="width:50px; height:50px;" class='img-circle'> </td>
									</tr> 
								</tbody> 
							</table>
						</div>
						
						<div class="blank"></div>
								<?php  require_once('alerts.php');  ?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsUserETQ.php" method="POST"  enctype="multipart/form-data">
						
							<input name="formParameter" value="<?php echo encryptIt("editUserETQ"); ?>" type="hidden"  />
							<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
							<input name="oldNamePhoto" value="<?php echo $photo; ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام" id="name" autocomplete="off" name="name" value="<?php  echo $name;   ?>" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="family">تخلص</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تخلص" id="family" autocomplete="off" value="<?PHp   echo $family;  ?>" name="family" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">نام کاربری</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام کاربری" id="username" autocomplete="off" value="<?PHP echo $username;   ?>" name="username" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
								
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">ایمیل</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="email" placeholder="ایمیل" autocomplete="off" id="email" name="email" value="<?php echo $email;   ?>" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-offset-0  col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label pull-left" for="Position">وظیفه</label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
										<select class="select2 form-control" name='position' autocomplete="off" id='position'>
									    	<option Value="">انتخاب وظیفه</option>
											<?php
											 
 											$positionRow= $conn->query("SELECT * FROM `tbl_positions` WHERE deleted = 0 ORDER BY id DESC");
											While($row = $positionRow->fetch_array()){
													$id = $row['id'];
													$name = $row['name'];
													if($position_id == $id){
														echo "<option   value='$id' selected>$name</option>";
													}else{
														echo "<option   value='$id'>$name</option>";
													}
											}
											?>
									</select>
									<p class="help-block"></p>
								 </div>
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal" >اضافه<i class="fa fa-plus"></i></button>
								</div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="Position">User Type</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<select class="select2 form-control" name='userType' autocomplete="off" id='userType'>
									    	<option Value="">نوع کاربر</option>
									    	<option Value="1001" <?php if($user_type == 1001){echo "selected";}   ?> >مدیر عمومی</option>
									    	<option Value="1002" <?php if($user_type == 1002){echo "selected";}   ?>>ادمین</option>
									    	<option Value="1003" <?php if($user_type == 1003){echo "selected";}   ?>>کاربر</option>
						
 											 
									</select>
									<p class="help-block"></p>
								 </div> 
							</div> 
							<?php    if($user_type == 1004){  ?>
							<div class="form-group attachments"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="Position">Sub Contractor Name</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<select class="select2 form-control"   name='SBCId' autocomplete="off" >
											<option Value="">Select SBC</option>
											<?php
										   
												$bankRow= $conn->query( "SELECT * FROM `tbl_subcontractors` WHERE  deleted = 0  AND verified = 1");
												While($row = $bankRow->fetch_array()){
													
													$id = $row['id'];
													$name = $row['name'];
													
													if($id == $subcontractors_id){
														echo "<option value='$id' selected>$name</option>";
													}else{
														echo "<option value='$id'>$name</option>";
													}
										 
												}   
										 
											?>
										</select>
									<p class="help-block"></p>
								 </div> 
							</div> 
							<?php  } ?>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="profilePhoto">آپلود عکس</label> 
								<div class="col-lg-6 col-md-8 col-sm-3"> 
									<div style="width:200px;min-height:120px">
									<label id="upload">
										<input type="file" name="profilePhoto" value=<?Php echo $photo;   ?> id="profilePhoto" >
 									</label>
								</div>
								<p class="help-block"></p>
								 </div> 
							</div> 
														
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">پسورد جدید</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="password" placeholder="پسورد جدید" id="newPassword" autocomplete="off"  name="newPassword" class="form-control password">
									<p class="help-block"></p>
								 </div> 
							</div> 
							 <div class="form-group"> 
								 <label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="confirmpassword">تایید پسورد</label> 
								 <div class="col-lg-6 col-md-8 col-sm-10"> 
								   <input type="password" placeholder="تایید پسورد" autocomplete="off" id="confirmpassword" name="confirmpassword" class="form-control password"> 
									<label id="confirmchecked" > </label>
								 </div> 
							</div>  
							
							<?php
								editFormSubmissionButtons('addUserETQ.php');
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

 <script>
		$(document).ready(function(){
		$("#insert_form").on('submit',function(){
		event.preventDefault();
			if($('#name').val()==''){
				alert("Please fill the action name");
			} 
			else{
				$.post("../models/actionsPositionAT.php",$('#insert_form').serialize(),function(data){
					 
					if(data != "duplicated"){
						$("#position").append(data);
						$("#feedback").css("background-color", "green");
						$("#feedback").html("Your Data Has Inserted"); 
						$('#add_data_modal').fadeOut(1000,function(){
							$('#add_data_modal').modal('hide');
						});
						$("#name").val('');
						$("#description").val('');
						$("#feedback").fadeOut(1000); 

					 }
					else{
						$("#feedback").css("background-color", "red");
						$("#feedback").html("Your Data is duplicated");
					}
				 
				});
			}
		});
		});
	
//password check match
	$(".password").keyup(function(){

		if($("#newPassword").val() == $("#confirmpassword").val()){
 			$("#confirmchecked").css({color:'green'});
			$("#confirmchecked").html("Your Password matched");
 			 
		}else{
 			$("#confirmchecked").css({color:'red'});
			$("#confirmchecked").html("Your password didn't match");
  		}
	})

//uload plugin calling.
	$('#upload').loadImg({
		"text"			: "Upload Picture here ...",
		"fileExt"		: ["png","jpg","Jpeg"],
		"fileSize_min"	: 0,
		"fileSize_max"	: 2
	});
</script>
</body>
</html>
