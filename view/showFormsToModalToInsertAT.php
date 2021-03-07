 <?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	require_once("../config/pdate.php");

	$genralId = $_POST['insert_data_file'];
 		$exploadeData = explode("+",$genralId);
		$id = $exploadeData[0];
 		$table = $exploadeData[1];
 	  
	?>
	<style>
	.modal-form{
		text-align:center !important; 
	}
	</style>
	<?php
		require_once('alerts.php'); 

	?>
	<?php
	if($table == "tbl_support_ceremonies_requests"){
		 ?>
		 
		 <input name="formTable" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="denotionDate">تاریخ تمویل</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="تاریخ تمویل" autocomplete="off" id="date" required data-select='datepicker' Value="<?php echo date("Y-m-d");  ?>" name="denotionDate" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="amount">مقدار</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="مقدار" autocomplete="off" id="amount" onKeyPress="return isNumericKey(event)"  name="amount" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="currenciesId">واحد پولی</label> 
				<div class="col-sm-9"> 
						<select class="select2 form-control" name='currenciesId' autocomplete="off" onchange="readCurrencyRate(this.value),selectBanks(this.value)"  id='currenciesId'>
							<option Value="">واحد پولی</option>
							<?php
						 
							$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
							while($row = $currenciesRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['code'];
								echo "<option value='$id'>$name</option>";
					 
							}   
						
						?>
						</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="bankId">بانک</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId'  autocomplete="off" id='bankId'>
							<option Value="">انتخاب بانک</option>
							<?php
						   
							 
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="rate">نرخ</label> 
				<div class="col-sm-9" > 
					<input type="text" placeholder="نرخ" autocomplete="off" id="rate" onKeyPress="return isNumericKey(event)"  name="rate" value="<?php echo $rate;     ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label"  for="upoladeFile"> فایل </label> 
				<div class="col-sm-9"> 
						<input type="file" placeholder="آپلود فایل" autocomplete="off" id="upoladeFile" name="upoladeFile"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>	 
			<div class="form-group"> 
				<label  class="col-sm-2  modal-form control-label" for="description">توضیحات</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = "توضیحات" autocomplete="off" name="description" name="description" class="form-control"></textarea>
					<p class="help-block"></p>
				 </div> 
			</div>	
		<?php 
			}
		?>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-success btn-outline" id="insertFileFormData" type="button"> ذخیره  <i class="fa fa-paste"></i>  </button>
			<button type="button"  id="btn" type="submit"class="btn btn-danger btn-outline" data-dismiss="modal"> لغو </button>    
			</div>
		  </div>