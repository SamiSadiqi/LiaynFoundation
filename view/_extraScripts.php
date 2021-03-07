<!--bootstrap js-->
 <script src="../assets/js/jquery.min.js"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="../assets/js/plugins/css3-animate-it-plugin/css3-animate-it.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/plugins/metismenu/jquery.metisMenu.js"></script>
<!-- Select2-->
<script src="../assets/js/plugins/select2/select2.full.min.js"></script>
<!---  date Pickere --->
<script type="text/javascript" src="../assets/js/persianDatepicker.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.fd.js"></script>
<!---  Datepicker Validation --->
 <script type="text/javascript" src="../jquery.datetextentry.js"></script>
<!---  Datepicker Validation --->
<script type="text/javascript" src="../assets/js/jquery.datetextentry.js"></script>
<script type="text/javascript" src="../assets/js/jquery.validate.min"></script>

<script>
$(window).load(function() {
	// Animate loader off screen
	$(".se-pre-con").fadeOut("fast");
});
 
$(".select2").select2();
$(".select2").attr("style","width: 100%;");
$(".select2-placeholer").select2({
	allowClear: true
	
});

$('select').select2({
	dir: "rtl"
});

function readCurrencyRate(currenciesId){
	if(currenciesId != " "  && currenciesId != null){
		$.post("AjaxReadCurrenies.php",{"currenciesId":currenciesId},function(data){
			 var trimmedResponse = $.trim(data)
			$("#rate").val(trimmedResponse);
		});
	}
}
	 
	  
$(document).ready(function(){
	$("#alertId").fadeOut(6000);
});
    
function selectBanks(currenciesId){
	if(currenciesId != " "  && currenciesId != null){
		$.post("AjaxSelectSelfBankETQ.php",{"currenciesId":currenciesId},function(data){
			alert(data);
			$("#bankId:first-child").html("");
			$("#bankId:first-child").html(data);
		});
	}
}
function alphaOnly(event){
  var key = event.keyCode;
  return ((key >= 65 && key <= 90) || key == 8);
};

function isNumericKey(e)
    {
	if (window.event) { var charCode = window.event.keyCode; }
	else if (e) { var charCode = e.which; }
	else { return true; }
	if (charCode > 30 && (charCode < 46 || charCode > 57)) { return false; }
	return true;
	}
	
function verifyRemoveFunction(title,id){
	if (confirm("Are you sure you want to delete it?")) {
		 $.post("actionsRemoveACI.php",{"title":title,"id":id},function(data){
			if(data === 'done'){
				 alert("Your transaction successfully deleted");
				 $("#row-"+id).fadeOut(1000);
			}else if(data === 'error'){
				 alert("You don't have permission to delete this record");
			}else{
				alert("Technical Error");
			}
		});
	}
}
//Factors Details Functions
$(document).ready(function(){
	
	$("#addRow").click(function(){
		var temp_one = $("#form-field").val();
		var temp = parseFloat(temp_one) + parseFloat(1);
		$.ajax({
			type: "POST",
			url : "AjaxAddNewRow.php",
			data: {id:temp},
			beforeSend: function() {
				// setting a timeout
				$("#buttons").before("<img src='../assets/images/loader.gif' id='loader' style='display: block; margin: auto; width: 50px; height: 50px;' />");
			},
			success: function(data){
			 
				$("#form-field").val(temp);
				$("#loader").remove();
				$("#buttons").before(data).fadeIn();
				$(".select2").select2();
				$(".select2").attr("style","width: 100%;");
				$(".select2-placeholer").select2({
					allowClear: true
				});
			}
		});
	});
	
});
	
/* //This code is using for modals selection.
$('body').on('shown.bs.modal', '.modal', function() {
  $(this).find('select').each(function() {
	var dropdownParent = $(document.body);
	if ($(this).parents('.modal.in:first').length !== 0)
	  dropdownParent = $(this).parents('.modal.in:first');
	$(this).select2({
	  dropdownParent: dropdownParent
	  // ...
	});
  });
}); */

function delRow(rowId){
	$("#" + rowId).fadeOut();
}
function calculateTotalAmountFee(rowId){
	var row    = rowId.split("-")[1];
	var amount = $("#amount-" + row).val();
	var fee    = $("#fee-" + row).val();
	var temp   = 0;
	 
	if (typeof amount != 'undefined' && amount && typeof fee != 'undefined' && fee) {
		var temp = parseFloat(amount) * parseFloat(fee);
	}
	
	$("#totalFee-" + row).val(temp);
	sumAllRecordsFee();
}
function sumAllRecordsFee(){
	var total = 0;
	$(".totalFee").each(function(){
		if($(this).val() != ""){
			total += parseFloat($(this).val());
		}
	});
	$("#totalFactorPrice").val(total);
}
function calculateFactorRemain(){
	var factorFee     = $("#totalFactorPrice").val();
	var factorPayment = $("#factorPayment").val();
	var factorRemain  = parseFloat(factorFee - factorPayment);
	$("#factorRemain").val(factorRemain);
}

//Embed form data to modals{
$(document).on('click','.edit_data',function(){
	var edit_data_id = $(this).attr('id');
	alert(edit_data_id);
	 $.post("showEditableDataToModalAT.php",{edit_data_id:edit_data_id},function(data){
		$("#updateModalData").html(data);
		$("#editDataModal").modal('show');
	});
});

function checkDate(date){
    var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1}))");
    var dateOk=regex.test(date);
    if(!dateOk){
        alert("Please fill like this format yyyy-mm-dd");
    }
 }

 $(function () {
	//usage
	$(".usage").persianDatepicker();
	//themes
	$("#pdpDefault").persianDatepicker({ alwaysShow: true, });
	$("#date").persianDatepicker({ formatDate: "YYYY-0M-0D" });
	$("#date1").persianDatepicker({ formatDate: "YYYY-0M-0D" });
	$("#date2").persianDatepicker({ formatDate: "YYYY-0M-0D" });
});

</script>
 <!---  Datepicker Validation --->
<script src="../assets/js/functions.js"></script>