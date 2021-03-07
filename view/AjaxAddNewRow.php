 <?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	$i = $_POST['id'];
?>
<div class="form-group form-fields" id="row-<?php echo $i; ?>">
	<div class="col-lg-1 col-md-2 col-sm-2"> 
		<input type="text"  autocomplete="off" style="text-align:center" value="<?php  echo $i; ?>"  readonly class="form-control">
		<p class="help-block"></p>
	</div>
		<div class="col-lg-3 col-md-4 col-sm-5"> 
			<select class="select2 form-control" name='itemId[]' onchange='selectItemUnit(this.value,<?php  echo $i;   ?>)' autocomplete="off" id='itemId-<?php echo $i; ?>'>
				<option Value="">انتخاب اجناس</option>
				<?php
				 
				$itemsRow= $conn->query("SELECT * FROM `tbl_items` WHERE  deleted = 0 ORDER BY id DESC");
				while($row = $itemsRow->fetch_array()){
					
					$id   = $row['id'];
					$name = $row['name'];
					echo "<option value='$id'>$name</option>";
		 
				}   
			
				?>
			</select>
			<p class="help-block"></p>
		</div> 
	
		<div class="col-lg-3 col-md-4 col-sm-5"> 
			<select class="select2 form-control"  name='itemUnit[]' autocomplete="off" id='itemUnit-<?php echo $i; ?>'>
				<option Value="">انتخاب واحد</option> 
				 
			</select>
			<p class="help-block"></p>
		</div> 
		
		<div class="col-lg-2 col-md-2 col-sm-3"> 
			<input type="text" placeholder="مقدار" autocomplete="off" onkeyup="calculateTotalAmountFee(this.id)" onKeyPress="return isNumericKey(event)"  ondblclick = "getExistanceStock(<?php   echo $i; ?>)" id="amount-<?php echo $i; ?>" name="amount[]" class="form-control">
			<p class="help-block"></p>
		</div> 
		 
		<div class="col-lg-3 col-md-4 col-sm-6"> 
			<input type="text" placeholder="توضیحات" autocomplete="off" id="description-<?php echo $i; ?>"   name="description[]" class="form-control">
			<span onclick="delRow('row-<?php echo $i; ?>');" class="label label-secondary pull-right"><i class="fa fa-minus"></i></span>
			<p class="help-block"></p>
		</div>
</div>