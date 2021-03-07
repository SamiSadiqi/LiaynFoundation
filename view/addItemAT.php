<?php
	require_once("_header.php");
	$menu = "definationAT";
	$formHeader  = "اضافه کردن اجناس";
?>
<title><?php echo $pageTitle; ?></title>
</head>
<body>
<!---Modals Form Income Category -->
<div id="add_data_unit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="unit_form"  method="POST">
						<input name="table" value="<?php echo encryptIt("tbl_item_units"); ?>" type="hidden"  />

						<div class="form-group"> 
							<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">ثبت واحد</label> 
							<div class="col-lg-6 col-md-8 col-sm-10"> 
								<input type="text" placeholder="واحد جنس" autocomplete="off" id="itemUnitId" name="name" class="form-control">
								<p class="help-block"></p>
							 </div> 
						</div> 
						<div class="form-group"> 
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
							<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه کردن <i class="fa fa-paste"></i>  </button>
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
<!-- Item Category category_form -->
<div id="add_data_category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="category_form"  method="POST">
						<input name="table" value="<?php echo encryptIt("tbl_item_categories"); ?>" type="hidden"  />

						<div class="form-group"> 
							<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">کتگوری اجناس</label> 
							<div class="col-lg-6 col-md-8 col-sm-10"> 
								<input type="text" placeholder="کتگوری اجناس" autocomplete="off" id="categoryName" name="name" class="form-control">
								<p class="help-block"></p>
							 </div> 
						</div> 
						<div class="form-group"> 
							<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
								<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه کردن <i class="fa fa-paste"></i>  </button>
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
<!-- Item Category category_form -->
<div id="add_data_invnentory" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
			<div id='feedback' style="margin:0 auto;text-align:center;width:50%;height:30px;border-radius:5px;margin-bottom:10px;padding-top:5px;color:black"></div>
				 
				<form class="form-horizontal" id="inventory_form"  method="POST">
						<input name="table" value="<?php echo encryptIt("tbl_stocks"); ?>" type="hidden"  />

						<div class="form-group"> 
							<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">گدام</label> 
							<div class="col-lg-6 col-md-8 col-sm-10"> 
								<input type="text" placeholder="گدام" autocomplete="off" required id="inventoryId2" name="name" class="form-control">
								<p class="help-block"></p>
							 </div> 
						</div> 
							
						<div class="form-group"> 
							<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
							<div class="col-lg-6 col-md-8 col-sm-10"> 
								<textarea    placeholder = 'توضیحات' autocomplete="off" id='description' name='description' class='form-control'></textarea>
								<p class="help-block"></p>
							 </div> 
						</div>
						<div class="form-group"> 
							<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
								<button class="btn btn-success btn-outline" name="insert"   type="submit"> اضافه کردن <i class="fa fa-paste"></i>  </button>
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
			<span>موقعیت فعلی : </span>
			<!-- <li><a href="index.php"><i class="fa fa-home"></i>صفحه اصلی</a></li>  -->
			<li class="active"><i class="fa fa-list-ul"></i>تعریف</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
		</ol>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 animatedParent animateOnce z-index-50"> 
				<div class="panel panel-primary animated fadeInUp">
					<div class="panel-heading clearfix"> 
						<div class="panel-title"><?php echo $panelTitle . " - " . $formHeader;; ?></div> 
						<ul class="panel-tool-options"> 
							<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
						</ul> 
					</div> 
					<!-- panel body --> 
					<div class="panel-body" id="page-content"> 
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal" id="insertForm"  method="POST">
						 <form class="form-horizontal"  id="insertForm" method="POST" action="<?php echo getRootModel(); ?>newActionsSupportCeremoniesRequestAT.php" enctype="multipart/form-data">

							<input name="formTable" value="<?php echo encryptIt("tbl_items"); ?>" type="hidden"  />
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label"  for="data">تاریخ<span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="تاریخ" autocomplete="off" data-select='datepicker' onkeyup="checkDate(this.value)" name="date" id="date" required class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">جنس <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="جنس" autocomplete="off" id="name" name="name" required class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="itemUnit">واحد جنس <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7">
									<div id="itemUnitDiv">
										<select id="itemUnit" name="itemUnit" autocomplete="off" required class="select2 form-control">
											<option value="">انتخاب و احد جنس</option>
											<?php
												$itemUnitRow= $conn->query("SELECT * FROM `tbl_item_units` WHERE deleted = 0 ORDER BY id DESC");
												while($row = $itemUnitRow->fetch_array()){
													
													$id   = $row['id'];
													$name = $row['name'];
													echo "<option  value='$id'>$name</option>";
										 
												}   
											?>
										</select>
									</div>
									<p class="help-block"></p>
								 </div> 
								 <div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_unit" >اضافه<i class="fa fa-plus"></i></button>
								</div>
							</div>
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="itemCategory">کتگوری اجناس <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
								<div  id="itemCategoryDiv" >
									<select id="itemCategory" name="itemCategory" autocomplete="off" required class="select2 form-control">
										<option value="">انتخاب کتگوری اجناس</option>
										<?php
											 
 											$itemCategoryRow= $conn->query("SELECT * FROM `tbl_item_categories` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $itemCategoryRow->fetch_array()){
											
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option  value='$id'>$name</option>";
									 
											}   
										
										?>
									</select>
								</div>
									<p class="help-block"></p>
								 </div>
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_category" >اضافه<i class="fa fa-plus"></i></button>
								</div>								 
							</div>
							
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="openingBalance">بلانس افتتاحیه</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="بلانس افتتاحیه" autocomplete="off" id="openingBalance" name="openingBalance" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>
							
							
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="stock">گدام <span class="text-danger" style="font-size:20px;"> * </span></label> 
								<div class="col-lg-5 col-md-6 col-sm-7"> 
								<div id="stockIdDiv">
									<select id="stockId" name="stockId" autocomplete="off"  required class="select2 form-control">
										<option value="">انتخاب گدام</option>
										<?php
											 
 											$stockRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
											while($row = $stockRow->fetch_array()){
												
												$id   = $row['id'];
												$name = $row['name'];
												echo "<option  value='$id'>$name</option>";
											
											}   
										
										?>
									</select>
								</div>
									<p class="help-block"></p>
								</div> 
								<div class="col-lg-1 col-md-2 col-sm-3">
									<button type="button"  class='btn btn-primary' name="add" id="add" data-toggle="modal" data-target="#add_data_invnentory" > اضافه<i class="fa fa-plus"></i></button>
								</div>
							</div>
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="upoladeFile"> عکس </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
										<input type="file" placeholder="بارگزاری عکس" autocomplete="off" id="upoladeFile" name="upoladeFile"  class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div>	 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="address">توضیحات</label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'></textarea>
 									<p class="help-block"></p>
								 </div> 
							</div>
							<?php
								fetchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
						
						<?php
							}
							listItems('addItemAT.php',$validationEditCondition,$validationRemoveCondition);
						
						?>
						
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
 
//insert form by this function.
$(document).on('click','#insertId',function(){
	var date = $("#date").val();
	var name = $("#name").val();
	var itemUnit =  $("#itemUnit").val();
	var itemCategory =  $("#itemCategory").val();
	var stockId =  $("#stockId").val();

	if (date ==""){
        $("#date").addClass("c-error");
	}else if(name == ""){
		$("#name").addClass("c-error");
	}else if(itemUnit == ""){
		$("#itemUnitDiv").addClass("c-error");
	}else if(itemCategory == ""){
		$("#itemCategoryDiv").addClass("c-error");
	}else if(stockId == ""){
		$("#stockIdDiv").addClass("c-error");
	}else{
		
		$("#date").removeClass("c-error");
 		$("#name").removeClass("c-error");
 		$("#itemUnitDiv").removeClass("c-error");
 		$("#itemCategoryDiv").removeClass("c-error");
 		$("#stockIdDiv").removeClass("c-error");
		
		var href = document.location.href;
		var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
		$.post("insertDataAT.php",$('#insertForm').serialize(),function(data){
			//alert(data);
			 
			if(data == 'error'){
				 
				$('#error').removeClass('hide').fadeIn(1000).fadeOut(2000)

			}else if(data == 'duplicate2'){
				
				$('#duplicate2').removeClass('hide').fadeIn(1000).fadeOut(2000)

			}else if(data == 'saved'){
				
				$('#saved').removeClass('hide').fadeIn(1000).fadeOut(2000)
				$(".table-responsive").load(lastPathSegment + " .table-responsive > *");
				document.getElementById("insertForm").reset();
				 
			}else{
				
				 alert(data);
			}
		});
	}
});
//Update form data
$(document).on('click','#update',function(){ 
alert();
	var date = $("#date").val();
	var name = $("#name").val();
	var itemUnit =  $("#itemUnit").val();
	var itemCategory =  $("#itemCategory").val();
	var stockId =  $("#stockId").val();

	if (date ==""){
        $("#date").addClass("c-error");
	}else if(name == ""){
		$("#name").addClass("c-error");
	}else if(itemUnit == ""){
		$("#itemUnitDiv").addClass("c-error");
	}else if(itemCategory == ""){
		$("#itemCategoryDiv").addClass("c-error");
	}else if(stockId == ""){
		$("#stockIdDiv").addClass("c-error");
	}else{
		
		$("#date").removeClass("c-error");
 		$("#name").removeClass("c-error");
 		$("#itemUnitDiv").removeClass("c-error");
 		$("#itemCategoryDiv").removeClass("c-error");
 		$("#stockIdDiv").removeClass("c-error");
		
		var href = document.location.href;
		var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
		$.post("updateDataAT.php",$('#updateForm').serialize(),function(data){
			alert(data);
				if(data == 'done'){
				alert("مؤفقانه ویرایش گردید.");
				setTimeout(function() {
				   $("#editDataModal").modal('hide');
				}, 500);
				$(".table-responsive").load(lastPathSegment + " .table-responsive > *");
			}else if(data == 'error'){
				alert("متأسفانه ویرایش نشد!");
			}else if(data == 'duplicate2'){
				alert("اطلاعات وارده موجود است!");
			}else{
				alert("دوباره تلاش نمایید!");
			}
		});
	}
}); 

//Insert unit
$(document).ready(function(){
	$("#unit_form").on('submit',function(){
		event.preventDefault();
		if($('#itemUnitId').val()==''){
			alert("Please fill the action name");
		} 
	 
		else{
			$.post("AjaxAddPlusFormACI.php",$('#unit_form').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#itemUnit").append(data);
					$("#feedback").css("background-color", "green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_unit').fadeOut(1000,function(){
						$('#add_data_unit').modal('hide');
					});
					$("#itemUnitId").val('');
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
//Insert Item Category
$(document).ready(function(){
	$("#category_form").on('submit',function(){
		event.preventDefault();
		if($('#categoryName').val()==''){
			alert("Please fill the action name");
		} 
	 
		else{
			$.post("AjaxAddPlusFormACI.php",$('#category_form').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#itemCategory").append(data);
					$("#feedback").css("background-color", "green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_category').fadeOut(1000,function(){
						$('#add_data_category').modal('hide');
					});
					$("#categoryName").val('');
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
//Insert Item Inventory
$(document).ready(function(){
	$("#inventory_form").on('submit',function(){
		event.preventDefault();
		if($('#inventoryId2').val()==''){
			alert("Please fill the action name");
		} 
		else{
			$.post("AjaxAddPlusFormACI.php",$('#inventory_form').serialize(),function(data){
				alert(data);
			  if(data != "duplicated"){
					$("#stockId").append(data);
					$("#feedback").css("background-color","green");
					$("#feedback").html("Your Data Has Inserted"); 
					$('#add_data_invnentory').fadeOut(1000,function(){
						$('#add_data_invnentory').modal('hide');
					});
					$("#inventoryId2").val('');
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

</script>
</body>
</html>