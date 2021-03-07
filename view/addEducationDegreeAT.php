<?php
	require_once("_header.php");
	$menu = "helpingAT";
	$formHeader  = "ثبت رشته تحصیلی";
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
    //	require_once("_top.php");
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
			<li class="active"><i class="fa fa-list-ul"></i>تعریف</li> 
			<li class="active"><strong ><i class="fa fa-plus"></i><?php echo $formHeader; ?></strong></li>
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
						<?php  
							require_once('alerts.php'); 
							if($validationAddForm == 1){
						?>
						<form class="form-horizontal"  id="insertForm" method="post">
							
							<input name="formTable" value="<?php echo encryptIt("tbl_degree"); ?>" type="hidden"  />
							 
							<div class="form-group"> 
								<label class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 control-label" for="name">نام </label> 
								<div class="col-lg-6 col-md-8 col-sm-10"> 
									<input type="text" placeholder="نام" autocomplete="off" id="name" name="name" class="form-control">
									<p class="help-block"></p>
								 </div> 
							</div> 
	 					
							<?php
								fetchFormSubmissionButtons();
							?> 
						</form>
						
						<div class="blank"></div>
				
						<?php
							}educationDegree('addEducationDegreeAT.php',$validationEditCondition,$validationRemoveCondition);
						
						?>
						
					</div> 
				</div> 
			</div>
		</div>
		<!-- Footer -->
		<footer class="animatedParent animateOnce z-index-10"> 
		
		<?php
			//require_once("_footer.php");
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
 	var name = $("#name").val();
  
	if (name ==""){
        $("#name").addClass("c-error");
	}else{
		
  		$("#name").removeClass("c-error");
 		
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
</script>
</body>
</html>