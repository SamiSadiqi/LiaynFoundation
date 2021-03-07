<?php
	require_once("_header.php");
	$menu = "systemManagementETQ";
	$formHeader = "ثبت کاربر";
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
                <h4 class="modal-title">ثبت وظیفه</h4>
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
					 </div>
					 <div class="form-group"> 
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
							<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه <i class="fa fa-paste"></i>  </button>
						</div> 
					</div>
				</form>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بسته</button>
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
			<span>موقعیت فعلی: </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-cog"></i>مدیریت</li> 
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
						<?php require_once('alerts.php'); ?>
						<form class="form-horizontal" action="<?php echo getRootModel(); ?>actionsUserETQ.php" method="POST" enctype="multipart/form-data"> 
						
							<input name="formParameter" value="<?php echo encryptIt("insertUserETQ"); ?>" type="hidden"  />
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام" autocomplete="off" id="name" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								 <label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="family">تخلص</label> 
								 <div class="col-lg-6 col-md-8 col-sm-10"> 
								   <input type="text" placeholder="تخلص" autocomplete="off" ="family" name="family" class="form-control"> 
								   <p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">نام کاربری</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام کاربری" autocomplete="off" id="username" name="username" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
								
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="username">ایمیل</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="email" placeholder="ایمیل" autocomplete="off" id="email" name="email" class="form-control">
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
													echo "<option   value='$id'>$name</option>";
									 
											}
											?>
									</select>
									<p class="help-block"></p>
								 </div>
							<div class="col-lg-1 col-md-2 col-sm-3">
								<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_modal" >ضافه<i class="fa fa-plus">ا</i></button>
							</div>
							
 							
							</div> 	
							<div class="form-group" id="subcontractorId"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  for="Position">نوع کاربر</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<select class="select2 form-control" name='userType' autocomplete="off" id='userType'>
									    	<option Value="">نوع کاربر</option>
									    	<option Value="1001">مدیر عمومی</option>
									    	<option Value="1002">ادمین</option>
									    	<option Value="1003">کاربر</option>
									    </select>
									<p class="help-block"></p>
								 </div> 
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="photo">آپلود عکس</label> 
								<div class="col-lg-6 col-md-8 col-sm-3"> 
									<div style="width:200px;min-height:120px">
									<label id="upload">
										<input type="file" name="photo" id="photo">
									</label>
								</div>
								<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								 <label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="password">پسورد</label> 
								 <div class="col-lg-6 col-md-8 col-sm-10"> 
								   <input type="password" placeholder="پسورد" autocomplete="off" id="password" name="password" class="form-control password">
									<p  class="help-block"></p>
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
								fetchFormSubmissionActionButtons();
							?>  
						</form>
						
						
						<div class="blank"></div>
						
						<!--<hr class="table-hr" />-->
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center table-title" colspan="11">
											لیست کاربران
										</th>
									</tr>
									<tr class="table-header"> 
										<th class="small">شماره </th>
										<th class='text-center'>عکس</th>
										<th class='text-center'>نام</th>
										<th class='text-center'>تخلص</th>
										<th class='text-center'>نام کاربری</th>
										<th class='text-center'>ایمیل</th>
										<th class='text-center'>وظیفه</th>
										<th class='text-center'>نوع کاربر</th>
										<th class='text-center'>عکس</th>
										<th class='text-center'>ویرایش</th>
										<th class="small" colspan="2">تنظیمات</th>
									</tr> 
								</thead> 
								<tbody> 
									<?php
										$table = "tbl_users";
										$userId = decryptIt($_SESSION['userId']);
										$usersRawSQLQuery    = "SELECT * FROM tbl_users WHERE  deleted = 0";
										$usersSQLQuery            = $conn->query($usersRawSQLQuery);
									   
										if($usersSQLQuery->num_rows > 0){
											
											while($row = $usersSQLQuery->fetch_array()){
												
												$rowPosition = $conn->selectRecord ("tbl_positions","id  = ". $row['position_id']);
												 
												++$counter;
												
										?>
										<tr id='row-<?php echo $row['id']; ?>'> 
											<td class="small"><?php echo $counter; ?></td>
											<td class='text-center'><a href=""  download ><img src="<?php echo $row['photo'];?>" class="img-circle" style="width:50px;height:50px;"alt="No Photo"></a></td>
											<td class='text-center'><?php echo $row['name']; ?></td>
											<td class='text-center'><?php echo $row['family']; ?></td>
											<td class='text-center'><?php echo $row['username']; ?></td>
											<td class='text-center'><?php echo $row['email']; ?></td>
											<td class='text-center'><?php echo $rowPosition['name']; ?></td>
											<td class='text-center'><?php if($row['user_type'] =='1001'){echo "Administrator";}elseif($row["user_type"] =='1002'){echo "Admin";}elseif($row["user_type"] =='1003'){echo "User";}?></td>
											<td class="small text-center"><a title="User Profile" href="userProfileAdmin.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-user btn btn-blue btn-outline"></i></a></td>
											<td class="small text-center"><a title="Edit Record" href="editUserETQ.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-edit btn btn-blue btn-outline"></i></a></td>
					                    	<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
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

	if($("#password").val() == $("#confirmpassword").val()){
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
	"fileExt"		: ["png","jpg"],
	"fileSize_min"	: 0,
	"fileSize_max"	: 2
});

</script>
 </body>
</html>
