<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Assist Technology Company Provides ICT Services and Consultations">
<meta name="keywords" content="ACI, MIS,ICT, Web Design, Web Development, Herat, Afghanistan">

<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='../assets/images/favicon.ico' />

<?php
    session_start();
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	require_once("../models/retrievesAT.php");
	require_once("../config/pdate.php");

 	$pageTitle = "بنیاد لیان امیری";
	$panelTitle = "بنیاد لیان امیری";
 	$companyName = "بنیاد لیان امیری";
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	isLoggedIn();
	isBannedUser($userId);
 	//checkTimeStamp();
	date_default_timezone_set('Asia/Kabul');
	//Validate Edit And Remove
	$selectValidationUserAndPasswordUser = $conn->query("SELECT * FROM tbl_users where id = $userId AND deleted = 0");
	$fetchUserValidation = $selectValidationUserAndPasswordUser->fetch_array();
	$validationCondition = $fetchUserValidation['user_type'];
	$validationEditCondition = $fetchUserValidation['edit'];
	$validationRemoveCondition = $fetchUserValidation['remove'];
	$validationAddForm = $fetchUserValidation['addForm'];
	$validationRemoveReport = $fetchUserValidation['remove_report'];
	$validationEditReport = $fetchUserValidation['edit_report'];
?>
 
<link href="../assets/css/entypo.css" rel="stylesheet">

<link href="../assets/css/bootstrap.fd.css" rel="stylesheet">
<!-- Font awesome stylesheet -->
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->
<!-- CSS3 Animate It Plugin Stylesheet -->
<link href="../assets/css/plugins/css3-animate-it-plugin/animations.css" rel="stylesheet">
<!-- /css3 animate it plugin stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="../assets/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->
 
<!-- Select2 Files -->
<link href="../assets/css/plugins/select2/select2.css" rel="stylesheet">
<!-- /Select2 Files -->

<link href="../assets/css/mouldifi-forms.css" rel="stylesheet">

<link href="../assets/css/custome.css" rel="stylesheet">

 
<link href="../assets/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../assets/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">

<!-- Date Picker Files -->
<link rel="stylesheet" href="../assets/css/persianDatepicker-default.css" />
 <link type="text/css" rel="stylesheet" href="../assets/css/vertical-responsive-menu.min.css"/>
<!-- /Date Picker Files -->

<!-- Bootstrap RTL stylesheet min version -->
<link href="../assets/css/bootstrap-rtl.min.css" rel="stylesheet">
<!-- /bootstrap rtl stylesheet min version -->

<!-- Mouldifi RTL core stylesheet -->
<link href="../assets/css/mouldifi-rtl-core.css" rel="stylesheet">
<!-- /mouldifi rtl core stylesheet -->


<script>

// On page unload
$( window ).unload(function() {
    // Send data to script
    $.post( "ajax.php", function( data ) {
        // Handle return
    });
});

</script>

<!-- Modal -->

<div class="modal fade" id="editDataModal" tabindex="-1" style="overflow:hidden;" role="dialog" aria-labelledby="editDataModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDataModal">اطلاعات قابل ویرایش</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         </button>
      </div>
	  
	  <form method="post" id="updateForm" action="" class="form-horizontal" role="form">
		  <div class="modal-body" id="updateModalData">
		  
 		  </div>
	  </form>
	   
    </div>
  </div>
</div>
	
<div class="modal fade" id="insertDataFileModal" tabindex="-1" style="overflow:hidden;" role="dialog" aria-labelledby="insertDataFileModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">اطلاعات</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         </button>
      </div>
	  
	  <form method="post" id="insertFormFile" enctype="multipart/form-data" class="form-horizontal" role="form">
		  <div class="modal-body" id="insertDataFileDiv">
		  
 		  </div>
	  </form>
	   
    </div>
  </div>
</div>
		